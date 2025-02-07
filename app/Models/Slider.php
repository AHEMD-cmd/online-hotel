<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::deleting(function ($slider) {
            // Delete the associated image file
            if ($slider->photo && Storage::disk('public')->exists($slider->photo)) {
                Storage::disk('public')->delete($slider->photo);
            }
        });
    }
}
