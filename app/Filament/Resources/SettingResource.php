<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Setting;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SettingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SettingResource\RelationManagers;

class SettingResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Logo & Favicon')
                            ->schema([
                                FileUpload::make('logo')
                                    ->image()
                                    ->required(),
                                FileUpload::make('favicon')
                                    ->image()
                                    ->required(),
                            ])->columns(2),

                        Section::make('Top Bar Information')
                            ->schema([
                                TextInput::make('top_bar_phone')
                                    ->tel()
                                    ->label('Phone Number'),
                                TextInput::make('top_bar_email')
                                    ->email()
                                    ->label('Email Address'),
                            ])->columns(2),

                        Section::make('Footer Information')
                            ->schema([
                                TextInput::make('footer_address')
                                    ->label('Address'),
                                TextInput::make('footer_phone')
                                    ->tel()
                                    ->label('Phone'),
                                TextInput::make('footer_email')
                                    ->email()
                                    ->label('Email'),
                                TextInput::make('copyright')
                                    ->label('Copyright Text'),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Homepage Settings')
                            ->schema([
                                Select::make('home_feature_status')
                                    ->options([
                                        'Show' => 'Show',
                                        'Hide' => 'Hide',
                                    ])
                                    ->required(),
                                TextInput::make('home_room_total')
                                    ->numeric()
                                    ->required(),
                                Select::make('home_room_status')
                                    ->options([
                                        'Show' => 'Show',
                                        'Hide' => 'Hide',
                                    ])
                                    ->required(),
                                Select::make('home_testimonial_status')
                                    ->options([
                                        'Show' => 'Show',
                                        'Hide' => 'Hide',
                                    ])
                                    ->required(),
                                TextInput::make('home_latest_post_total')
                                    ->numeric()
                                    ->required(),
                                Select::make('home_latest_post_status')
                                    ->options([
                                        'Show' => 'Show',
                                        'Hide' => 'Hide',
                                    ])
                                    ->required(),
                            ]),

                        Section::make('Social Media Links')
                            ->schema([
                                TextInput::make('facebook')
                                    ->url()
                                    ->label('Facebook URL'),
                                TextInput::make('twitter')
                                    ->url()
                                    ->label('Twitter URL'),
                                TextInput::make('linkedin')
                                    ->url()
                                    ->label('LinkedIn URL'),
                                TextInput::make('pinterest')
                                    ->url()
                                    ->label('Pinterest URL'),
                            ]),

                        Section::make('Analytics')
                            ->schema([
                                TextInput::make('analytic_id')
                                    ->label('Google Analytics ID'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('top_bar_phone')
                    ->label('Phone'),
                TextColumn::make('top_bar_email')
                    ->label('Email'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Last Updated'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return !static::getModel()::exists();
    }
}
