<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Room;

class BookedRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_date',
        'order_no',
        'room_id',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_no');
    }
}
