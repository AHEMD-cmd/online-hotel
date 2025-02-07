<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use App\Models\Testimonial;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;

class TestimonialResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Home Page';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Photo field
                Forms\Components\FileUpload::make('photo')
                    ->label('Photo')
                    ->directory('testimonials') // Store images in the "testimonials" directory
                    ->image()
                    ->required(),

                // Name field
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                // Designation field
                Forms\Components\TextInput::make('designation')
                    ->label('Designation')
                    ->required()
                    ->maxLength(255),

                // Comment field
                Forms\Components\Textarea::make('comment')
                    ->label('Comment')
                    ->required()
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

                // Name column
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                // Designation column
                TextColumn::make('designation')
                    ->label('Designation')
                    ->searchable()
                    ->sortable(),

                // Comment column
                TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50) // Limit the comment to 50 characters
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
