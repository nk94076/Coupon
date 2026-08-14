<?php

namespace Database\Seeders;

use App\Services\SettingsService;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        SettingsService::setMany([
            'site_name' => ['value' => 'Coupon CMS', 'group' => 'general'],
            'site_url' => ['value' => config('app.url'), 'group' => 'general'],
            'contact_email' => ['value' => 'support@example.com', 'group' => 'general'],
            'default_currency' => ['value' => 'USD', 'group' => 'general'],
            'default_country' => ['value' => 'United States', 'group' => 'general'],

            'default_meta_title' => ['value' => 'Coupon CMS — Verified Coupons & Deals', 'group' => 'seo'],
            'default_meta_description' => ['value' => 'Find verified coupon codes and deals from your favorite stores.', 'group' => 'seo'],

            'maintenance_mode' => ['value' => '0', 'group' => 'system'],
            'default_pagination' => ['value' => '15', 'group' => 'system'],
            'timezone' => ['value' => config('app.timezone', 'UTC'), 'group' => 'system'],
        ]);
    }
}
