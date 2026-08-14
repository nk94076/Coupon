<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Category;
use App\Models\Store;
use App\Services\SlugService;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            [
                'name' => 'Amazon',
                'category' => 'Electronics',
                'website_url' => 'https://www.amazon.in',
                'short_description' => 'Everything from electronics to daily essentials.',
            ],
            [
                'name' => 'Flipkart',
                'category' => 'Electronics',
                'website_url' => 'https://www.flipkart.com',
                'short_description' => "India's homegrown online shopping destination.",
            ],
            [
                'name' => 'Myntra',
                'category' => 'Fashion',
                'website_url' => 'https://www.myntra.com',
                'short_description' => 'Fashion and lifestyle products from top brands.',
            ],
            [
                'name' => 'AJIO',
                'category' => 'Fashion',
                'website_url' => 'https://www.ajio.com',
                'short_description' => 'Curated fashion for men, women and kids.',
            ],
            [
                'name' => 'Nykaa',
                'category' => 'Beauty',
                'website_url' => 'https://www.nykaa.com',
                'short_description' => 'Beauty, wellness and personal care products.',
            ],
            [
                'name' => 'Hostinger India',
                'category' => 'Hosting',
                'website_url' => 'https://www.hostinger.in',
                'short_description' => 'Affordable web hosting and domains.',
            ],
        ];

        foreach ($stores as $index => $store) {
            $category = Category::where('name', $store['category'])->whereNull('parent_id')->first();

            Store::firstOrCreate(
                ['name' => $store['name']],
                [
                    'slug' => SlugService::unique(Store::class, $store['name']),
                    'website_url' => $store['website_url'],
                    'affiliate_url' => $store['website_url'],
                    'short_description' => $store['short_description'],
                    'description' => $store['short_description'].' (Demo store seeded for development.)',
                    'category_id' => $category?->id,
                    'status' => Status::Active,
                    'featured' => $index < 3,
                    'sort_order' => $index,
                    'robots_index' => true,
                    'robots_follow' => true,
                ]
            );
        }
    }
}
