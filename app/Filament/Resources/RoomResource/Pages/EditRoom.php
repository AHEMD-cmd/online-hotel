<?php

namespace App\Filament\Resources\RoomResource\Pages;

use Filament\Actions;
use App\Filament\Resources\RoomResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected $photos_to_save = [];

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->photos_to_save = $data['photos'] ?? []; // حفظ الصور الجديدة مؤقتًا
        unset($data['photos']); // إزالة الصور من البيانات المخزنة مباشرةً

        return $data;
    }

    protected function afterSave(): void
    {
        if (!empty($this->photos_to_save)) {
            // حذف الصور القديمة من قاعدة البيانات والتخزين إذا كانت هناك صور جديدة
            foreach ($this->record->photos as $photo) {
                Storage::disk('public')->delete($photo->photo); // حذف من التخزين
                $photo->delete(); // حذف من قاعدة البيانات
            }

            // إضافة الصور الجديدة
            foreach ($this->photos_to_save as $photo) {
                $this->record->photos()->create([
                    'photo' => $photo,
                ]);
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
