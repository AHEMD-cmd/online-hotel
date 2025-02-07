<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::deleting(function ($photo) {
            // Delete the associated image file
            if ($photo->photo && Storage::disk('public')->exists($photo->photo)) {
                Storage::disk('public')->delete($photo->photo);
            }
        });
    }
}
