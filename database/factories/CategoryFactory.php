<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'parent_id' => null,
            'name' => ucwords($name),
            'slug' => SlugService::unique(Category::class, $name),
            'description' => fake()->sentence(),
            'status' => Status::Active,
            'featured' => false,
            'sort_order' => 0,
            'robots_index' => true,
            'robots_follow' => true,
        ];
    }
}
