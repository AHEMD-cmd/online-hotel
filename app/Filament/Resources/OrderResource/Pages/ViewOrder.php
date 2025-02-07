<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\OrderResource;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        TextEntry::make('order_no')
                            ->label('Order Number'),
                        TextEntry::make('transaction_id')
                            ->label('Transaction ID'),
                        TextEntry::make('user.name')
                            ->label('Customer'),
                        TextEntry::make('paid_amount')
                            ->label('Paid Amount')
                            ->money('usd'),
                        TextEntry::make('payment_method')
                            ->label('Payment Method'),
                        TextEntry::make('card_last_digit')
                            ->label('Card Last Digits')
                            ->visible(fn ($record) => $record->card_last_digit !== null),
                        TextEntry::make('booking_date')
                            ->label('Booking Date')
                            ->date(),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'confirmed' => 'success',
                                'canceled' => 'danger',
                                default => 'gray',
                            }),
                    ])->columns(2),

                Section::make('Room Bookings')
                    ->schema([
                        RepeatableEntry::make('orderDetails')
                            ->schema([
                                TextEntry::make('room.name')
                                    ->label('Room'),
                                TextEntry::make('checkin_date')
                                    ->label('Check-in Date')
                                    ->date(),
                                TextEntry::make('checkout_date')
                                    ->label('Check-out Date')
                                    ->date(),
                                TextEntry::make('adults')
                                    ->label('Adults'),
                                TextEntry::make('children')
                                    ->label('Children'),
                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->money('usd'),
                            ])
                            ->columns(3)
                    ])
            ]);
    }
}
