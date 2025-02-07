<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    /**
     * Get the settings instance or create a default one if it doesn't exist.
     *
     * @return \App\Models\Setting
     */
    public static function getSettings(): self
    {
        $settings = self::first();

        if (!$settings) {
            $settings = self::create([
                'logo' => 'default-logo.png',
                'favicon' => 'default-favicon.png',
                'home_feature_status' => 'Show',
                'home_room_total' => '6',
                'home_room_status' => 'Show',
                'home_testimonial_status' => 'Show',
                'home_latest_post_total' => '3',
                'home_latest_post_status' => 'Show',
            ]);
        }

        return $settings;
    }

    /**
     * Check if a feature is enabled
     *
     * @param string $feature
     * @return bool
     */
    public function isEnabled(string $feature): bool
    {
        return $this->{$feature} === 'Show';
    }
}
