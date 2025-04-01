<?php

use Illuminate\Support\Facades\Auth;
use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="login-form">
    <!-- Session Status -->
    <x-auth-session-status class="login-form__status mb-4" :status="session('status')"/>

    <form wire:submit="login" class="login-form__form">
        <!-- Email Address -->
        <div class="login-form__field">
            <x-input-label for="email" :value="__('Email')" class="login-form__label"/>
            <x-text-input wire:model="form.email" id="email" class="login-form__input" type="email"
                          name="email" required autofocus autocomplete="username"/>
            <x-input-error :messages="$errors->get('form.email')" class="login-form__error"/>
        </div>

        <!-- Password -->
        <div class="login-form__field">
            <x-input-label for="password" :value="__('Password')" class="login-form__label"/>
            <x-text-input wire:model="form.password" id="password" class="login-form__input"
                          type="password" name="password" required autocomplete="current-password"/>
            <x-input-error :messages="$errors->get('form.password')" class="login-form__error"/>
        </div>

        <!-- Remember Me -->
        <div class="login-form__checkbox">
            <label for="remember" class="login-form__checkbox-label">
                <input wire:model="form.remember" id="remember" type="checkbox"
                       class="login-form__checkbox-input" name="remember">
                <span class="login-form__checkbox-text">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="login-form__actions">
            @if (Route::has('password.request'))
                <a class="login-form__link" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            @if (Route::has('register'))
                <a class="login-form__link" href="{{ route('register') }}" wire:navigate>
                    {{ __('auth.dont_have_account') }}
                </a>
            @endif
            <x-primary-button class="login-form__button login-form__button--primary">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
