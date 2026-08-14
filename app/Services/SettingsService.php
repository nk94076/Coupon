<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Simple key/value settings store, cached for the lifetime of the cache
 * store's default TTL policy (forever, invalidated on write). Keeps Phase 1
 * settings lightweight while leaving room for more groups/keys later.
 */
class SettingsService
{
    private const CACHE_KEY = 'settings.all';

    /**
     * @return array<string, mixed>
     */
    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return Setting::query()->pluck('value', 'key')->all();
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::all()[$key] ?? $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);

        Cache::forget(self::CACHE_KEY);
    }

    /**
     * @param  array<string, array{value: mixed, group: string}>  $values
     */
    public static function setMany(array $values): void
    {
        foreach ($values as $key => $entry) {
            Setting::updateOrCreate(['key' => $key], ['value' => $entry['value'], 'group' => $entry['group']]);
        }

        Cache::forget(self::CACHE_KEY);
    }
}
