<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use App\Models\Amenity;
use Filament\Forms\Form;
use App\Traits\AdminCheck;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use App\Filament\Resources\RoomResource\Pages;

class RoomResource extends Resource
{
    use AdminCheck;

    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-home'; // Icon for the sidebar
    protected static ?string $navigationGroup = 'Hotel Management'; // Group in the sidebar

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Featured Photo field
                Forms\Components\FileUpload::make('featured_photo')
                    ->label('Featured Photo')
                    ->directory('rooms')
                    ->image()
                    ->required(),

                // Room name field
                Forms\Components\TextInput::make('name')
                    ->label('Room Name')
                    ->required()
                    ->maxLength(255),

                // Description field
                Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    ->required(),

                // Price field
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric(),

                // Total rooms field
                Forms\Components\TextInput::make('total_rooms')
                    ->label('Total Rooms')
                    ->required()
                    ->numeric(),


                // Size field
                Forms\Components\TextInput::make('size')
                    ->label('Size (sq ft)')
                    ->nullable(),

                // Beds, bathrooms, balconies, and guests fields
                Forms\Components\TextInput::make('total_beds')
                    ->label('Total Beds')
                    ->nullable(),

                Forms\Components\TextInput::make('total_bathrooms')
                    ->label('Total Bathrooms')
                    ->nullable(),

                Forms\Components\TextInput::make('total_balconies')
                    ->label('Total Balconies')
                    ->nullable(),

                Forms\Components\TextInput::make('total_guests')
                    ->label('Total Guests')
                    ->nullable(),

                // Video ID field
                Forms\Components\TextInput::make('video_id')
                    ->label('Video ID (YouTube)')
                    ->nullable(),

                // Photos field
                Forms\Components\FileUpload::make('photos')
                    ->label('Room Photos')
                    ->multiple()
                    ->image()
                    ->directory('room_photos') // حفظ الصور في storage/app/public/room_photos
                    ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord), // منع Filament من محاولة إعادة تخزين الملفات


                // Amenities field (many-to-many relation)
                Forms\Components\MultiSelect::make('amenities')
                    ->label('Amenities')
                    ->relationship('amenities', 'name') // Relationship to amenities
                    ->multiple() // Allow multiple selections
                    ->required(), // Make it required (optional)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Featured Photo column
                ImageColumn::make('featured_photo')
                    ->label('Featured Photo')
                    ->disk('public'), // Store images in the "public" disk

                // Room Name column
                TextColumn::make('name')
                    ->label('Room Name')
                    ->searchable()
                    ->sortable(),

                // Price column
                TextColumn::make('price')
                    ->label('Price')
                    ->sortable(),

                TextColumn::make('booked_rooms')
                    ->label('Booked Rooms')
                    ->sortable(),

                // Video column (show YouTube video)
                ViewColumn::make('video_id')
                    ->label('Video')
                    ->view('filament.tables.columns.video'), // Custom Blade file

                // Photos column
                ImageColumn::make('photos')
                    ->label('Room Photos')
                    ->getStateUsing(fn($record) => $record->photos->pluck('photo')->toArray())->stacked(),

                // Amenities column (show selected amenities)
                TextColumn::make('amenities')
                    ->label('Amenities')
                    ->formatStateUsing(function ($state, $record) {
                        // Check if amenities relationship exists and is a collection
                        if ($record->amenities && $record->amenities->isNotEmpty()) {
                            return $record->amenities->pluck('name')->join(', '); // Join amenities names with commas
                        }
                        return 'No amenities'; // Default text if no amenities
                    })
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
