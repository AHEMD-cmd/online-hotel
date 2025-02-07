<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition()
    {
        return [
            'photo' => $this->faker->imageUrl(), // Random image URL
            'name' => $this->faker->name, // Random name
            'designation' => $this->faker->jobTitle, // Random job title
            'comment' => $this->faker->paragraph, // Random comment
        ];
    }
}