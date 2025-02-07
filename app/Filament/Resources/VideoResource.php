<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Video;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VideoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VideoResource\RelationManagers;
// use Filament\Tables\Columns\HtmlColumn;

class VideoResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera'; // Icon for the sidebar
    protected static ?string $navigationGroup = 'Content Management'; // Group in the sidebar


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Video ID field
                Forms\Components\TextInput::make('video_id')
                    ->label('Video ID')
                    ->required()
                    ->maxLength(255),

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
                // Video Column with embedded iframe
                ViewColumn::make('video_id')
                    ->label('Video')
                    ->view('filament.tables.columns.video'), // Custom Blade file
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
