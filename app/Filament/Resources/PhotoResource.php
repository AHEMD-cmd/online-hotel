<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Photo;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PhotoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PhotoResource\RelationManagers;

class PhotoResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Photo::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationGroup = 'Content Management';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Photo field
                Forms\Components\FileUpload::make('photo')
                    ->label('Photo')
                    ->directory('photos') // Store images in the "photos" directory
                    ->image()
                    ->required(),

                // Caption field
                Forms\Components\Textarea::make('caption')
                    ->label('Caption')
                    ->nullable()
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Photo column
                ImageColumn::make('photo')
                    ->label('Photo')
                    ->disk('public'), // Use the "public" disk

                // Caption column
                TextColumn::make('caption')
                    ->label('Caption')
                    ->limit(50) // Limit the caption to 50 characters
                    ->searchable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Edit action
                Tables\Actions\DeleteAction::make(), // Delete action
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // Bulk delete action
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
            'index' => Pages\ListPhotos::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}
