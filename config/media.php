<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Media Upload Settings
    |--------------------------------------------------------------------------
    |
    | Central configuration for the reusable media upload service used by
    | store logos, category images, coupon images and SEO OG images. Future
    | phases can extend this (video, documents, etc.) without touching the
    | service itself.
    |
    */

    'disk' => env('MEDIA_DISK', 'public'),

    'max_size_kb' => env('MEDIA_MAX_SIZE_KB', 4096),

    'allowed_mimes' => ['jpg', 'jpeg', 'png', 'webp'],

    'allowed_mime_types' => [
        'image/jpeg',
        'image/png',
        'image/webp',
    ],
];
