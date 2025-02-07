<?php

namespace App\Filament\Resources\BookedRoomResource\Pages;

use App\Filament\Resources\BookedRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookedRoom extends EditRecord
{
    protected static string $resource = BookedRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
