<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3), // اسم الغرفة
            'description' => $this->faker->paragraph(4), // وصف الغرفة
            'price' => $this->faker->randomFloat(2, 50, 500), // سعر عشوائي بين 50 و 500
            'total_rooms' => $this->faker->numberBetween(1, 10), // عدد الغرف المتاحة
            'size' => $this->faker->randomElement([null, '30 sqm', '50 sqm', '70 sqm']), // حجم الغرفة
            'total_beds' => $this->faker->numberBetween(1, 5), // عدد الأسرة
            'total_bathrooms' => $this->faker->numberBetween(1, 3), // عدد الحمامات
            'total_balconies' => $this->faker->numberBetween(0, 2), // عدد الشرفات
            'total_guests' => $this->faker->numberBetween(1, 6), // عدد الضيوف المسموح بهم
            'featured_photo' => $this->faker->imageUrl(640, 480, 'hotel', true), // صورة مميزة
            'video_id' => $this->faker->optional()->uuid(), // فيديو اختياري
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
