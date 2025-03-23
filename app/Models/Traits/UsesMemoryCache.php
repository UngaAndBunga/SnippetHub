<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

trait UsesMemoryCache
{
    /**
     * @throws InvalidArgumentException
     */
    public static function storeInMemoryCache(string $key, mixed $value, bool $isObject = true): void
    {
        if ($isObject) {
            Cache::store('serializable_array')->set($key, $value);
            return;
        }
        Cache::store('array')->set($key, $value);
    }

    /**
     * Returns null if the key is not set
     * @param string $key
     * @return object|string|int|bool|array|null
     */
    public static function getFromMemoryCache(string $key): object|string|int|bool|array|null
    {
        return Cache::get($key);
    }
}
