<?php

namespace App\Filament\Resources\BookedRoomResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\BookedRoomResource;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ViewBookedRoom extends ViewRecord
{
    protected static string $resource = BookedRoomResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Booking Details')
                    ->schema([
                        TextEntry::make('room.name')
                            ->label('Room'),
                        TextEntry::make('booking_date')
                            ->label('Booking Date')
                            ->date(),
                        TextEntry::make('order_no')
                            ->label('Order Number'),
                        TextEntry::make('order.user.name')
                            ->label('Customer'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->columns(2)
            ]);
    }
}
