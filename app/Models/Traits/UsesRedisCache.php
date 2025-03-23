<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait UsesRedisCache
{
    public static function storeInRedisCache(string $key, mixed $value, $ttl): void
    {
        Cache::store('redis')->put($key, $value, now()->addMinutes($ttl));
    }
    public static function getFromRedisCache(string $key): mixed
    {
        return Cache::get($key);
    }
}
