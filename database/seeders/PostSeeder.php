<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 100 post published random
        Post::factory()->count(150)->published()->create();
    }
}
