<?php

namespace App\Filament\Resources;

use App\Models\Faq;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FaqResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FaqResource\RelationManagers;

class FaqResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle'; // Icon for the sidebar
    protected static ?string $navigationGroup = 'Content Management'; // Group in the sidebar

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Question field
                Forms\Components\Textarea::make('question')
                    ->label('Question')
                    ->required()
                    ->maxLength(65535),

                // Answer field
                Forms\Components\RichEditor::make('answer')
                    ->label('Answer')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Question column
                TextColumn::make('question')
                    ->label('Question')
                    ->limit(50) // Limit the question to 50 characters
                    ->searchable(),

                // Answer column
                TextColumn::make('answer')
                    ->label('Answer')
                    ->limit(50) // Limit the answer to 50 characters
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
