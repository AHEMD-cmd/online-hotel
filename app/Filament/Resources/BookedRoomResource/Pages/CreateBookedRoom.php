<?php

namespace App\Filament\Resources\BookedRoomResource\Pages;

use App\Filament\Resources\BookedRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookedRoom extends CreateRecord
{
    protected static string $resource = BookedRoomResource::class;
}
