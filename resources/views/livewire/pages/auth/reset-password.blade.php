<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="guest-layout">
    <div >
        <form wire:submit="resetPassword" class="login-form__form">
            <!-- Статус (якщо є) -->
            @if (session('status'))
                <div class="login-form__status">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Email Address -->
            <div class="login-form__field">
                <label for="email" class="login-form__label">{{ __('Email') }}</label>
                <input wire:model="email" id="email" class="login-form__input" type="email" name="email" required autofocus autocomplete="username" />
                <div class="login-form__error">
                    {{ $errors->first('email') }}
                </div>
            </div>

            <!-- Password -->
            <div class="login-form__field">
                <label for="password" class="login-form__label">{{ __('Password') }}</label>
                <input wire:model="password" id="password" class="login-form__input" type="password" name="password" required autocomplete="new-password" />
                <div class="login-form__error">
                    {{ $errors->first('password') }}
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="login-form__field">
                <label for="password_confirmation" class="login-form__label">{{ __('Confirm Password') }}</label>
                <input wire:model="password_confirmation" id="password_confirmation" class="login-form__input" type="password" name="password_confirmation" required autocomplete="new-password" />
                <div class="login-form__error">
                    {{ $errors->first('password_confirmation') }}
                </div>
            </div>

            <!-- Кнопка -->
            <div class="login-form__actions">
                <button type="submit" class="login-form__button login-form__button--primary">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
</div>
