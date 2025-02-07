<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;


class UserResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit'), // Hide on edit to avoid overwriting the password
                Forms\Components\Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('photo')
                    ->image(),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('role')->sortable(),
                BooleanColumn::make('status')
                    ->label('Active')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                Filter::make('is_admin')
                    ->query(fn(Builder $query) => $query->where('role', 'admin'))
                    ->label('Admins Only'),
                Filter::make('is_active')
                    ->query(fn(Builder $query) => $query->where('status', true))
                    ->label('Active Users Only'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('toggleStatus')
                    ->label(fn(User $record) => $record->status ? 'Deactivate' : 'Activate')
                    ->color(fn(User $record) => $record->status ? 'danger' : 'success')
                    ->action(function (User $record) {
                        $record->status = !$record->status;
                        $record->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
