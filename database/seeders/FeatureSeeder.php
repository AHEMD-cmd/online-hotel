<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run()
    {
        Feature::create([
            'icon' => 'fa fa-star',
            'heading' => 'High Quality',
            'text' => 'We provide high-quality services to our customers.',
        ]);

        Feature::create([
            'icon' => 'fa fa-clock',
            'heading' => 'Fast Delivery',
            'text' => 'Get your products delivered in record time.',
        ]);

        Feature::create([
            'icon' => 'fa fa-headset',
            'heading' => '24/7 Support',
            'text' => 'Our support team is available round the clock.',
        ]);
    }
}