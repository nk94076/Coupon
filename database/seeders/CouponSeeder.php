<?php

namespace Database\Seeders;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\Status;
use App\Models\Coupon;
use App\Models\Store;
use App\Services\SlugService;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    private const DEMO_NOTE = ' [DEMO/TEST DATA — not a real working coupon, for development purposes only.]';

    public function run(): void
    {
        $coupons = [
            'Amazon' => [
                ['title' => '[DEMO] Amazon Flat 500 Off', 'code' => 'DEMO500', 'type' => DiscountType::Flat, 'value' => 500, 'min' => 2000],
                ['title' => '[DEMO] Amazon 10% Off Electronics', 'code' => 'DEMO10ELEC', 'type' => DiscountType::Percentage, 'value' => 10, 'max' => 1000],
            ],
            'Flipkart' => [
                ['title' => '[DEMO] Flipkart 15% Off Fashion', 'code' => 'DEMO15FASH', 'type' => DiscountType::Percentage, 'value' => 15, 'max' => 750],
            ],
            'Myntra' => [
                ['title' => '[DEMO] Myntra 20% Off', 'code' => 'DEMO20', 'type' => DiscountType::Percentage, 'value' => 20, 'max' => 1200],
            ],
            'AJIO' => [
                ['title' => '[DEMO] AJIO Buy One Get One', 'code' => 'DEMOBOGO', 'type' => DiscountType::BuyOneGetOne, 'value' => null],
            ],
            'Nykaa' => [
                ['title' => '[DEMO] Nykaa Free Shipping', 'code' => null, 'type' => DiscountType::FreeShipping, 'value' => null],
            ],
            'Hostinger India' => [
                ['title' => '[DEMO] Hostinger 78% Off Hosting', 'code' => 'DEMO78HOST', 'type' => DiscountType::Percentage, 'value' => 78, 'max' => null],
            ],
        ];

        foreach ($coupons as $storeName => $storeCoupons) {
            $store = Store::where('name', $storeName)->first();

            if (! $store) {
                continue;
            }

            foreach ($storeCoupons as $index => $coupon) {
                Coupon::firstOrCreate(
                    ['title' => $coupon['title'], 'store_id' => $store->id],
                    [
                        'slug' => SlugService::unique(Coupon::class, $coupon['title']),
                        'code' => $coupon['code'],
                        'description' => 'Sample coupon seeded for local development and demos.'.self::DEMO_NOTE,
                        'discount_type' => $coupon['type'],
                        'discount_value' => $coupon['value'] ?? null,
                        'minimum_order' => $coupon['min'] ?? null,
                        'maximum_discount' => $coupon['max'] ?? null,
                        'start_date' => now()->subDays(3),
                        'expiry_date' => now()->addDays(30),
                        'coupon_type' => CouponType::General,
                        'category_id' => $store->category_id,
                        'status' => Status::Active,
                        'featured' => $index === 0,
                        'exclusive' => false,
                        'verified' => true,
                        'sort_order' => $index,
                        'robots_index' => true,
                        'robots_follow' => true,
                    ]
                );
            }
        }
    }
}
