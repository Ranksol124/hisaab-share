<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()
                ->schema([
                    Forms\Components\TextInput::make('identifier')
                        ->label('Email or Phone Number')
                        ->required()
                        ->placeholder('Enter your email or phone number'),
                    Forms\Components\TextInput::make('name')
                        ->label('Full Name')
                        ->required(),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required()
                        ->confirmed(),
                    Forms\Components\TextInput::make('password_confirmation')
                        ->password()
                        ->required(),
                ])
                ->statePath('data'),
        ];
    }

   public function handleRegistration(array $data): User
{

    if (!empty($data['email']) && User::where('email', $data['email'])->exists()) {
        throw ValidationException::withMessages([
            'email' => 'This email is already registered.',
        ]);
    }

    if (!empty($data['MobileNo']) && User::where('mobileNo', $data['MobileNo'])->exists()) {
        throw ValidationException::withMessages([
            'MobileNo' => 'This phone number is already registered.',
        ]);
    }


    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'] ?? null,
        'mobileNo' => $data['MobileNo'] ?? null,
        'password' => Hash::make($data['password']),
        'is_verified' => false,
    ]);
 if (!empty($data['email'])) {
        $user->notify(new VerifyEmail());
    }
    return $user;
}

    protected function getRedirectUrl(): string
    {
        // Redirect unverified email users to a "verify pending" page
        return '/member/verify-pending';
    }
}
