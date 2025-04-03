<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="profile__title">
            {{ __('Update Password') }}
        </h2>

        <p class="login-form__label">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="login-form__form">
        <div class="login-form__field">
            <label for="update_password_current_password" class="login-form__label">{{ __('Current Password') }}</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="login-form__input" autocomplete="current-password" />
            <div class="login-form__error">
                {{ $errors->first('current_password') }}
            </div>
        </div>

        <div class="login-form__field">
            <label for="update_password_password" class="login-form__label">{{ __('New Password') }}</label>
            <input wire:model="password" id="update_password_password" name="password" type="password" class="login-form__input" autocomplete="new-password" />
            <div class="login-form__error">
                {{ $errors->first('password') }}
            </div>
        </div>

        <div class="login-form__field">
            <label for="update_password_password_confirmation" class="login-form__label">{{ __('Confirm Password') }}</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="login-form__input" autocomplete="new-password" />
            <div class="login-form__error">
                {{ $errors->first('password_confirmation') }}
            </div>
        </div>

        <div class="login-form__actions">
            <button type="submit" class="login-form__button login-form__button--primary">{{ __('Save') }}</button>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
