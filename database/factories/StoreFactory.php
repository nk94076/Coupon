<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Category;
use App\Models\Store;
use App\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => SlugService::unique(Store::class, $name),
            'website_url' => fake()->url(),
            'affiliate_url' => fake()->url(),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'category_id' => Category::factory(),
            'status' => Status::Active,
            'featured' => false,
            'sort_order' => 0,
            'robots_index' => true,
            'robots_follow' => true,
        ];
    }
}
