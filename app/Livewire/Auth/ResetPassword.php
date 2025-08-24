<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;

class ResetPassword extends Component
{
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $token = '';
    public $passwordReset = false;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
    ];

    protected $messages = [
        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.exists' => 'We could not find a user with that email address.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
        'password_confirmation.required' => 'Password confirmation is required.',
    ];

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $this->passwordReset = true;
        } else {
            throw ValidationException::withMessages([
                'email' => [trans($status)],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
