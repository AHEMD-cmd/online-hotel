<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\BookedRoom;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookedRoomResource\Pages;
use App\Filament\Resources\BookedRoomResource\RelationManagers;
use App\Filament\Resources\BookedRoomResource\Pages\ViewBookedRoom;

class BookedRoomResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = BookedRoom::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Bookings Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('room_id')
                    ->relationship('room', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('booking_date')
                    ->required(),
                Forms\Components\TextInput::make('order_no')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room.name')
                    ->label('Room')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('booking_date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order_no')
                    ->label('Order Number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order.user.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListBookedRooms::route('/'),
            'create' => Pages\CreateBookedRoom::route('/create'),
            'view' => ViewBookedRoom::route('/{record}'),
            'edit' => Pages\EditBookedRoom::route('/{record}/edit'),
        ];
    }
}
