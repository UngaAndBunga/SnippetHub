<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Psr\SimpleCache\InvalidArgumentException;

trait UsesRedisCache
{
    private static string $cachedIds = 'cached_ids';
    private static string $updatedIds = 'updated_ids';

    public static function storeInRedisCache(string $key, mixed $value, int $ttl, string $compositeTag, $column): void
    {
        if (Redis::sismember('updated_ids', $value)) {
            // Invalidate cache for this query if stale.
            self::deleteFromUpdatedIdsInRedis($value);
        }
        Cache::store('redis')->tags([$compositeTag])->put($key, $value->get(), now()->addMinutes($ttl));
        if (str_contains($column, 'id')) {
            self::addToCachedIdsInRedis($value);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function getFromRedisCache(string $key): mixed
    {
        return Cache::store('redis')->get($key);
    }

    public static function deleteFromRedisCache(string $key): void
    {
        Cache::store('redis')->forget($key);
    }

    public static function setCachedIdsInRedis(array $ids): void
    {
        Cache::store('redis')->forever(self::$cachedIds, $ids);
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function getCachedIdsInRedis(): array
    {
        Cache::store('redis')->get(self::$cachedIds);
    }

    public static function addToCachedIdsInRedis(string $key): void
    {
        $cachedIds = self::getCachedIdsInRedis();
        $cachedIds[] = $key;
        self::setCachedIdsInRedis($cachedIds);
    }

    public static function deleteFromCachedIdsInRedis(string $value): void
    {
        $cachedIds = self::getCachedIdsInRedis();
        unset($cachedIds[array_search($value, $cachedIds)]);
        self::setCachedIdsInRedis($cachedIds);
    }

    public static function setUpdatedIdsInRedis(array $ids): void
    {
        Cache::store('redis')->forever(self::$updatedIds, $ids);
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function getUpdatedIdsInRedis(): array
    {
        return Cache::store('redis')->get(self::$updatedIds);
    }

    public static function addToUpdatedIdsInRedis(string $key): void
    {
        $cachedUpdatedIds = self::getUpdatedIdsInRedis();
        $cachedUpdatedIds[] = $key;
        self::setUpdatedIdsInRedis($cachedUpdatedIds);
    }

    public static function deleteFromUpdatedIdsInRedis(string $value): void
    {
        $cachedUpdatedIds = self::getUpdatedIdsInRedis();
        unset($cachedUpdatedIds[array_search($value, $cachedUpdatedIds)]);
        self::setUpdatedIdsInRedis($cachedUpdatedIds);
    }
}
