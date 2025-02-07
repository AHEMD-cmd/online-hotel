<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'photo' => $this->faker->imageUrl(), // Random image URL
            'heading' => $this->faker->sentence, // Random heading
            'short_content' => $this->faker->paragraph, // Random short content
            'content' => $this->faker->text, // Random full content
            'total_view' => $this->faker->numberBetween(0, 1000), // Random total views
        ];
    }
}