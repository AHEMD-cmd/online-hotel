<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::deleting(function ($testimonial) {
            // Delete the associated image file
            if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
                Storage::disk('public')->delete($testimonial->photo);
            }
        });
    }
}
