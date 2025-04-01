<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="login-form">
    <!-- Опис -->
    <div class="login-form__description">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="login-form__status" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="login-form__form">
        <!-- Email Address -->
        <div class="login-form__field">
            <x-input-label for="email" :value="__('Email')" class="login-form__label" />
            <x-text-input wire:model="email" id="email" class="login-form__input" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="login-form__error" />
        </div>

        <div class="login-form__actions">
            <x-primary-button class="login-form__button login-form__button--primary">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</div>
