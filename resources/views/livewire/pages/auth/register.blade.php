<?php

use Liamtseva\PGFKEduSystem\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));
        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="login-form">
    <form wire:submit="register" class="login-form__form">
        <!-- Name -->
        <div class="login-form__field">
            <x-input-label for="name" :value="__('Name')" class="login-form__label" />
            <x-text-input wire:model="name" id="name" class="login-form__input" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="login-form__error" />
        </div>

        <!-- Email Address -->
        <div class="login-form__field">
            <x-input-label for="email" :value="__('Email')" class="login-form__label" />
            <x-text-input wire:model="email" id="email" class="login-form__input" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="login-form__error" />
        </div>

        <!-- Password -->
        <div class="login-form__field">
            <x-input-label for="password" :value="__('Password')" class="login-form__label" />
            <x-text-input wire:model="password" id="password" class="login-form__input" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="login-form__error" />
        </div>

        <!-- Confirm Password -->
        <div class="login-form__field">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="login-form__label" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="login-form__input" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="login-form__error" />
        </div>

        <div class="login-form__actions">
            <a class="login-form__link" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="login-form__button login-form__button--primary">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
