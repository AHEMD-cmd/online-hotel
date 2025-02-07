<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slider::create([
            'photo' => 'path/to/image1.jpg',
            'heading' => 'Welcome to Our Website',
            'text' => 'This is a sample slider text.',
            'button_text' => 'Learn More',
            'button_url' => 'https://example.com',
        ]);

        Slider::create([
            'photo' => 'path/to/image2.jpg',
            'heading' => 'Discover Our Services',
            'text' => 'Explore what we have to offer.',
            'button_text' => 'Get Started',
            'button_url' => 'https://example.com/services',
        ]); 
    }
}
