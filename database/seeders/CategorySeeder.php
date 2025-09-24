<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 kategori random
        Category::factory()->count(5)->create();

        // Atau bisa juga buat kategori manual:
        // Category::create(['name' => 'Technology', 'slug' => 'technology', 'description' => 'Tech news and trends']);
        // Category::create(['name' => 'Lifestyle', 'slug' => 'lifestyle', 'description' => 'Lifestyle & tips']);
    }
}
