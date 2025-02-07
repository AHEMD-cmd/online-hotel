<?php

namespace App\Filament\Resources\RoomResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\RoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    protected $photos_to_save = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $photos = $data['photos'] ?? [];
        unset($data['photos']);

        $this->photos_to_save = $photos;

        return $data;
    }

    protected function afterCreate(): void
    {
        $photos = $this->photos_to_save ?? [];

        foreach ($photos as $photo) {
            $this->record->photos()->create([
                'photo' => $photo, 
            ]);
        }
    }
}
