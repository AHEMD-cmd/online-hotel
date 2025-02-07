<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Photo::factory()->count(10)->create(); // Create 10 photo records
    }
}
