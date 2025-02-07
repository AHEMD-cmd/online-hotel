<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\Pages\ViewOrder;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{

    public static function canView($record): bool
    {
        return auth()->user()->role === 'admin' || $record->user_id === auth()->id();
    }



    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function canCreate(): bool
    {
        return false;
    }





    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->role === 'user') {
                    $query->where('user_id', auth()->id());
                }
            })
            ->columns([
                TextColumn::make('order_no')->sortable()->searchable(),
                TextColumn::make('transaction_id')->sortable()->searchable(),
                TextColumn::make('user.name')->label('Customer')->sortable(),
                TextColumn::make('paid_amount')->sortable(),
                TextColumn::make('payment_method')->sortable(),
                TextColumn::make('booking_date')->sortable(),
                TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->colors([
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'canceled' => 'danger',
                    ]),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(), // فقط عرض التفاصيل
            ])
            ->bulkActions([]); // لا يوجد حذف جماعي
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => ViewOrder::route('/{record}'), // صفحة عرض التفاصيل
        ];
    }
}
