<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; // Icon for the sidebar
    protected static ?string $navigationGroup = 'Content Management'; // Group in the sidebar

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Photo field
                Forms\Components\FileUpload::make('photo')
                    ->label('Photo')
                    ->directory('posts') // Store images in the "posts" directory
                    ->image()
                    ->required(),

                // Heading field
                Forms\Components\TextInput::make('heading')
                    ->label('Heading')
                    ->required()
                    ->maxLength(255),

                // Short content field
                Forms\Components\Textarea::make('short_content')
                    ->label('Short Content')
                    ->rows(10)
                    ->required()
                    ->maxLength(65535),

                // Content field
                Forms\Components\RichEditor::make('content')
                    ->label('Content')
                    ->required(),

                // Total view field
                Forms\Components\TextInput::make('total_view')
                    ->label('Total Views')
                    ->numeric()
                    ->default(0),
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

                // Heading column
                TextColumn::make('heading')
                    ->label('Heading')
                    ->searchable()
                    ->sortable(),

                // Short content column
                TextColumn::make('short_content')
                    ->label('Short Content')
                    ->limit(50) // Limit the short content to 50 characters
                    ->searchable(),

                // Total view column
                TextColumn::make('total_view')
                    ->label('Total Views')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
