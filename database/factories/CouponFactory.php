<?php

namespace Database\Factories;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\Status;
use App\Models\Coupon;
use App\Models\Store;
use App\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coupon>
 */
class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition(): array
    {
        $title = '[DEMO] '.fake()->words(4, true);

        return [
            'store_id' => Store::factory(),
            'title' => ucfirst($title),
            'slug' => SlugService::unique(Coupon::class, $title),
            'code' => strtoupper(fake()->bothify('SAVE##??')),
            'description' => fake()->sentence(),
            'discount_type' => DiscountType::Percentage,
            'discount_value' => fake()->randomElement([10, 15, 20, 25, 30]),
            'start_date' => now()->subDays(5),
            'expiry_date' => now()->addDays(30),
            'coupon_type' => CouponType::General,
            'status' => Status::Active,
            'featured' => false,
            'exclusive' => false,
            'verified' => false,
            'sort_order' => 0,
            'robots_index' => true,
            'robots_follow' => true,
        ];
    }
}
