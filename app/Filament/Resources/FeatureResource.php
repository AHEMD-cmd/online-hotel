<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Feature;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FeatureResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FeatureResource\RelationManagers;

class FeatureResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Feature::class;

    protected static ?string $navigationIcon = 'heroicon-o-star'; // Icon for the sidebar
    
    protected static ?string $navigationGroup = 'Home Page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Icon field
                Forms\Components\TextInput::make('icon')
                    ->label('Icon')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., fa fa-star'),

                // Heading field
                Forms\Components\TextInput::make('heading')
                    ->label('Heading')
                    ->required()
                    ->maxLength(255),

                // Text field
                Forms\Components\Textarea::make('text')
                    ->label('Text')
                    ->nullable()
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Icon column
                TextColumn::make('icon')
                    ->label('Icon')
                    ->searchable()
                    ->sortable(),

                // Heading column
                TextColumn::make('heading')
                    ->label('Heading')
                    ->searchable()
                    ->sortable(),

                // Text column
                TextColumn::make('text')
                    ->label('Text')
                    ->limit(50) // Limit the text to 50 characters
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
            'index' => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}
