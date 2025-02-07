<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Subscriber;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use App\Mail\GlobalMessageMail;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Mail;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubscriberResource\Pages;
use App\Filament\Resources\SubscriberResource\RelationManagers;

class SubscriberResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Subscribers';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('email')
                    ->required()
                    ->rules(['required', 'email', 'max:255', 'unique:subscribers,email']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
    
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // Default delete action
    
                BulkAction::make('sendEmail')
                    ->label('Send Email') // Button label
                    ->icon('heroicon-o-envelope') // Add an icon
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->label('Message')
                            ->required(),
                    ])
                    ->action(function (array $data, $records) {
                        foreach ($records as $subscriber) {
                            // Send HTML email using the Mailable class
                            Mail::to($subscriber->email)->send(new GlobalMessageMail($data['message']));
                        }
                    })
                    ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListSubscribers::route('/'),
            'create' => Pages\CreateSubscriber::route('/create'),
            'edit' => Pages\EditSubscriber::route('/{record}/edit'),
        ];
    }
}
