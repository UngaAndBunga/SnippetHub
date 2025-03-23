<?php

namespace App\Models;

use App\Models\Traits\UsesMemoryCache;
use App\Models\Traits\UsesRedisCache;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Psr\SimpleCache\InvalidArgumentException;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MainModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MainModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MainModel query()
 * @mixin \Eloquent
 */
class MainModel extends Model
{
    use UsesMemoryCache;
    use UsesRedisCache;

    protected $attributes = [
      'id'
    ];
    public static int $ttl = 30;

    /**
     * Check cache from memory or Redis.
     * @throws InvalidArgumentException
     */
    public static function checkCache($key)
    {
        // First check your memory cache (if implemented)
        $memoryCache = self::getFromMemoryCache($key);
        if (!empty($memoryCache)) {
            return $memoryCache;
        }
        // Then check Redis cache
        $redisCache = self::getFromRedisCache($key);
        if (!empty($redisCache)) {
            return $redisCache;
        }

        return null;
    }

    /**
     * Store data in cache.
     * @throws InvalidArgumentException
     */
    protected static function storeInCache($key, $data, bool $storeInMemoryCache = false, $compositeTag = ''): void
    {
        if ($storeInMemoryCache) {
            self::storeInMemoryCache($key, $data, is_object($data));
        }
        self::storeInRedisCache($key, $data, self::$ttl, $compositeTag);
    }


    /**
     * Override the find method.
     * @throws InvalidArgumentException
     */
    public static function find($id, $columns = ['*'], bool $storeInMemoryCache = false)
    {
        // Build a predictable cache key.
        $cacheKey = static::class.':find:'.$id;

        $tableName = (new static)->getTable(); // e.g., 'posts'
        $compositeTag = $tableName . '_id_' . $id;

        // If the id has been updated, ignore any cache.
        if (Redis::sismember('updated_ids', $id)) {
           self::deleteFromRedisCache($cacheKey);
        } else {
            $cached = self::checkCache($cacheKey);
            if ($cached) {
                return $cached;
            }
        }

        $result = parent::find($id, $columns);
        if ($result) {
            // Track that this id is now cached.
            self::addToCachedIdsInRedis($id);
            self::storeInCache($cacheKey, $result, $storeInMemoryCache, $compositeTag);
        }

        return $result;
    }

    /**
     * Override the first method.
     * @throws InvalidArgumentException
     */
    public static function first(bool $storeInMemoryCache = false, ...$args)
    {
        $cacheKey = static::class.':first';
        $cached = self::checkCache($cacheKey);
        if ($cached) {
            return $cached;
        }

        $result = parent::first(...$args);
        if ($result) {
            // If the result has an id, add it to the cached_ids set.
            if (isset($result->id)) {
                Redis::sadd('cached_ids', $result->id);
            }
            self::storeInCache($cacheKey, $result, $storeInMemoryCache);
        }

        return $result;
    }

    /**
     * Override the get method.
     * @throws \JsonException|InvalidArgumentException
     */
    public function get($columns = ['*'], bool $storeInMemoryCache = false)
    {
        // Create a cache key based on the query SQL and bindings.
        $queryKey = static::class.':get:'.md5(json_encode(self::toSql().serialize(self::getBindings()), JSON_THROW_ON_ERROR));
        $cached = self::checkCache($queryKey);
        if ($cached) {
            // If cached is a collection, check each item.
            $stale = false;
            foreach ($cached as $item) {
                if (isset($item->id) && Redis::command('sismember',['updated_ids', $item->id])) {
                    $stale = true;
                    break;
                }
            }
            if (!$stale) {
                return $cached;
            } else {
                // Invalidate stale cache.
                self::deleteFromRedisCache($queryKey);
            }
        }

        $result = parent::get($columns);
        if ($result->isNotEmpty()) {
            // Add each record's id to cached_ids.
            foreach ($result as $item) {
                if (isset($item->id)) {
                    self::addToCachedIdsInRedis($item->id);
                }
            }
            self::storeInCache($queryKey, $result, $storeInMemoryCache);
        }

        return $result;
    }

    /**
     * Override the where method.
     * @throws \JsonException|InvalidArgumentException
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and', bool $storeInMemoryCache = false)
    {
        // Build a cache key using the method arguments.
        $queryKey = static::class.':where:'.md5(json_encode(func_get_args(), JSON_THROW_ON_ERROR));

        // If the column involves an _id, check if that id is in updated_ids.
        if ($value !== null && str_contains($column, '_id')) {
            if (Redis::sismember('updated_ids', $value)) {
                // Invalidate cache for this query if stale.
                self::deleteFromRedisCache($queryKey);
            }
        } else {
            // Otherwise, try to retrieve from cache.
            $cached = self::checkCache($queryKey);
            if ($cached) {
                return $cached;
            }
        }

        $result = parent::where($column, $operator, $value, $boolean);
        // If we're filtering by an _id, add it to the cached_ids set.
        if ($value !== null && str_contains($column, '_id')) {
            Redis::sadd('cached_ids', $value);
        }
        self::storeInCache($queryKey, $result, $storeInMemoryCache);
        return $result;
    }

    /**
     * Call this method when a record is updated.
     * This should be triggered in your model event (e.g., updated, deleted).
     */
    public function markAsUpdated()
    {
        // Assuming the model's primary key is 'id'.
        Redis::sadd('updated_ids', $this->id);
    }
}
