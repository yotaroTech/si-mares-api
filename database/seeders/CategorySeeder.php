<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'ביקיני',
            'name_en' => 'bikini',
            'slug' => 'bikini',
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'חלק אחד',
            'name_en' => 'one-piece',
            'slug' => 'one-piece',
            'sort_order' => 2,
        ]);
    }
}
