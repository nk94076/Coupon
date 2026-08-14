<?php

use App\Services\SettingsService;
use Illuminate\Support\Facades\Storage;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return SettingsService::get($key, $default);
    }
}

if (! function_exists('media_url')) {
    function media_url(?string $path, ?string $disk = null): ?string
    {
        if (! $path) {
            return null;
        }

        return Storage::disk($disk ?? config('media.disk'))->url($path);
    }
}
