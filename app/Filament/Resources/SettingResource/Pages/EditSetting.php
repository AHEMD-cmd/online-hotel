<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SettingResource;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data = Setting::firstOrCreate([], [
            'logo' => 'default-logo.png',
            'favicon' => 'default-favicon.png',
            'home_feature_status' => 'Show',
            'home_room_total' => '6',
            'home_room_status' => 'Show',
            'home_testimonial_status' => 'Show',
            'home_latest_post_total' => '3',
            'home_latest_post_status' => 'Show',
        ])->toArray();

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
