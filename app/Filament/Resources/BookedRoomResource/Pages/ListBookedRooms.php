<?php

namespace App\Filament\Resources\BookedRoomResource\Pages;

use App\Filament\Resources\BookedRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookedRooms extends ListRecords
{
    protected static string $resource = BookedRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
