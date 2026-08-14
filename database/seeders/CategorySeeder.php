<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            'Fashion' => ['Men', 'Women', 'Shoes'],
            'Electronics' => ['Mobiles', 'Laptops', 'Accessories'],
            'Travel' => [],
            'Food' => [],
            'Beauty' => [],
            'Hosting' => [],
            'Software' => [],
            'Grocery' => [],
            'Home & Kitchen' => [],
            'Sports' => [],
        ];

        $sort = 0;

        foreach ($tree as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['name' => $parentName, 'parent_id' => null],
                [
                    'slug' => SlugService::unique(Category::class, $parentName),
                    'status' => Status::Active,
                    'sort_order' => $sort,
                    'robots_index' => true,
                    'robots_follow' => true,
                ]
            );

            $sort++;
            $childSort = 0;

            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['name' => $childName, 'parent_id' => $parent->id],
                    [
                        'slug' => SlugService::unique(Category::class, $parentName.'-'.$childName),
                        'status' => Status::Active,
                        'sort_order' => $childSort,
                        'robots_index' => true,
                        'robots_follow' => true,
                    ]
                );
                $childSort++;
            }
        }
    }
}
