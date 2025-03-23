<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

trait UsesRedisCache
{
    private static string $cachedIds = 'cached_ids';
    public static function storeInRedisCache(string $key, mixed $value, int $ttl, string $compositeTag): void
    {
        Cache::store('redis')->tags([$compositeTag])->put($key, $value->get(), now()->addMinutes($ttl));
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function getFromRedisCache(string $key): mixed
    {
        return Cache::store('redis')->get($key);
    }
    public static function deleteFromRedisCache(string $key): void{
        Cache::store('redis')->forget($key);
    }

    public static function setCachedIdsInRedis(array $ids): void{
        Cache::store('redis')->forever(self::$cachedIds, $ids);
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function getCachedIdsInRedis(): array{
        Cache::store('redis')->get(self::$cachedIds);
    }

    public static function addToCachedIdsInRedis(string $key): void
    {
        $cachedIds = self::getCachedIdsInRedis();
        $cachedIds[] = $key;
        self::setCachedIdsInRedis($cachedIds);
    }

}
