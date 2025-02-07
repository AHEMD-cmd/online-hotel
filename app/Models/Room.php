<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function photos()
    {
        return $this->hasMany(RoomPhoto::class);
    }
}
