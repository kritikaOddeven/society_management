<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPassword extends Component
{
    public $email = '';
    public $emailSent = false;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    protected $messages = [
        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.exists' => 'We could not find a user with that email address.',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->emailSent = true;
            $this->reset('email');
        } else {
            throw ValidationException::withMessages([
                'email' => [trans($status)],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
