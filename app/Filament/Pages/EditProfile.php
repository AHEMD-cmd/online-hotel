<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.pages.edit-profile';

    public $name;
    public $email;
    public $phone;
    public $country;
    public $address;
    public $state;
    public $city;
    public $zip;


    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'country' => $user->country,
            'address' => $user->address,
            'state' => $user->state,
            'city' => $user->city,
            'zip' => $user->zip,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->label('Full Name'),
            TextInput::make('email')
                ->required()
                ->email()
                ->label('Email Address'),
            TextInput::make('phone')
                ->label('Phone Number'),
            TextInput::make('country')
                ->label('Country'),
            TextInput::make('address')
                ->label('Address'),
            TextInput::make('state')
                ->label('State'),
            TextInput::make('city')
                ->label('City'),
            TextInput::make('zip')
                ->label('ZIP Code'),
        ];
    }

    public function submit(): void
    {
        $user = Auth::user();

        $data = $this->form->getState();

        $user->update($data);

        Notification::make()
            ->title('Profile Updated')
            ->body('Your profile has been updated successfully.')
            ->success()
            ->send();
    }
}
