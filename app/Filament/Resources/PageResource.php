<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Page;
use Filament\Tables;
use App\Traits\AdminCheck;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextareaColumn;
use App\Filament\Resources\PageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Filament\Resources\PageResource\Pages\CreatePage;
use Filament\Forms\Components\RichEditor;

class PageResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function canCreate(): bool
    {
        return !static::getModel()::exists();
    }


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                RichEditor::make('about_content')->required()->label('About Content'),
                RichEditor::make('terms_content')->required()->label('Terms Content'),
                RichEditor::make('privacy_content')->required()->label('Privacy Content'),
                RichEditor::make('contact_map')->nullable()->label('Contact Map'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('about_content')->limit(50)->searchable(),
                TextColumn::make('terms_content')->limit(50)->searchable(),
                TextColumn::make('privacy_content')->limit(50)->searchable(),
                TextColumn::make('contact_map')->limit(50)->searchable(),
                TextColumn::make('created_at')->sortable(),
                TextColumn::make('updated_at')->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
