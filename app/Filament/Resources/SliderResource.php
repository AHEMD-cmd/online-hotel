<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Slider;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SliderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SliderResource\RelationManagers;

class SliderResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Home Page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Photo field
                Forms\Components\FileUpload::make('photo')
                    ->label('Slider Image')
                    ->directory('sliders') // Store images in the "sliders" directory
                    ->image()
                    ->required(),

                // Heading field
                Forms\Components\TextInput::make('heading')
                    ->label('Heading')
                    ->maxLength(255),

                // Text field
                Forms\Components\Textarea::make('text')
                    ->label('Text')
                    ->maxLength(65535),

                // Button Text field
                Forms\Components\TextInput::make('button_text')
                    ->label('Button Text')
                    ->maxLength(255),

                // Button URL field
                Forms\Components\TextInput::make('button_url')
                    ->label('Button URL')
                    ->url()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Photo column
                ImageColumn::make('photo')
                    ->label('Image')
                    ->disk('public'), // Use the "public" disk

                // Heading column
                TextColumn::make('heading')
                    ->label('Heading')
                    ->searchable()
                    ->sortable(),

                // Button Text column
                TextColumn::make('button_text')
                    ->label('Button Text')
                    ->searchable()
                    ->sortable(),

                // Button URL column
                TextColumn::make('button_url')
                    ->label('Button URL')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
