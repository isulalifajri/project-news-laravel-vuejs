<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Category;
use App\Models\BackendUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'title'        => $title,
            'slug'         => Str::slug($title) . '-' . Str::random(5),
            'content'      => $this->faker->paragraphs(5, true),
            // 'thumbnail'    => 'https://picsum.photos/seed/' . Str::random(8) . '/800/400',
            'thumbnail'    => '',
            'status'       => $this->faker->randomElement(['draft', 'published', 'archived']),
            'published_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'category_id'  => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'user_id'      => BackendUser::inRandomOrder()->first()?->id ?? BackendUser::factory(),
            'is_featured'  => $this->faker->boolean(20),
            'views'        => $this->faker->numberBetween(0, 10000),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status'       => 'published',
            'published_at' => now(),
        ]);
    }
}
