<?php

namespace App\Models;

use App\Models\Traits\UsesMemoryCache;
use App\Models\Traits\UsesRedisCache;
use Illuminate\Database\Eloquent\Model;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MainModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MainModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MainModel query()
 *
 * @mixin \Eloquent
 */
class MainModel extends Model
{
    use UsesMemoryCache;
    use UsesRedisCache;

    public static int $ttl = 30;

    public static function checkCache($key)
    {
        $memoryCache = self::getFromMemoryCache($key);
        if (! empty($memoryCache)) {
            return $memoryCache;
        }
        $redisCache = self::getFromRedisCache($key);
        if (! empty($redisCache)) {
            return $redisCache;
        }

        return null;
    }

    /**
     * Override find method to check cache first.
     *
     * @throws InvalidArgumentException
     */
    public static function find($id, $columns = ['*'])
    {
        $cacheKey = static::class.':find:'.$id;
        $cached = self::checkCache($cacheKey);

        if ($cached) {
            return $cached;
        }

        $result = parent::find($id, $columns);
        if ($result) {
            self::storeInCache($cacheKey, $result);
        }

        return $result;
    }

    /**
     * Override first method.
     *
     * @throws InvalidArgumentException
     */
    public static function first(...$args)
    {
        $cacheKey = static::class.':first';
        $cached = self::checkCache($cacheKey);

        if ($cached) {
            return $cached;
        }

        $result = parent::first(...$args);
        if ($result) {
            self::storeInCache($cacheKey, $result);
        }

        return $result;
    }

    /**
     * Override get method.
     *
     * @throws InvalidArgumentException
     * @throws \JsonException
     */
    public function get($columns = ['*'])
    {
        $queryKey = static::class.':get:'.md5(json_encode(self::toSql().serialize(self::getBindings()), JSON_THROW_ON_ERROR));
        $cached = self::checkCache($queryKey);

        if ($cached) {
            return $cached;
        }

        $result = parent::get($columns);
        if ($result->isNotEmpty()) {
            self::storeInCache($queryKey, $result);
        }

        return $result;
    }

    /**
     * Override where method to return cached results.
     * @throws \JsonException
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $queryKey = static::class.':where:'.md5(json_encode(func_get_args(), JSON_THROW_ON_ERROR));
        $cached = self::checkCache($queryKey);

        if ($cached) {
            return $cached;
        }

        return parent::where($column, $operator, $value, $boolean);
    }

    /**
     * Store results in both memory and Redis cache.
     *
     * @throws InvalidArgumentException
     */
    protected static function storeInCache($key, $data): void
    {
        self::storeInMemoryCache($key, $data, is_object($data));
        self::storeInRedisCache($key, $data, self::$ttl);
    }
}
