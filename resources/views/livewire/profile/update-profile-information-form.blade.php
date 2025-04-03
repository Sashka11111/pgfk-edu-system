<?php

use Liamtseva\PGFKEduSystem\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="profile__title">
            {{ __('Profile Information') }}
        </h2>

        <p class="login-form__label">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="login-form__form">
        <div class="login-form__field">
            <label for="name" class="login-form__label">{{ __('Name') }}</label>
            <input wire:model="name" id="name" name="name" type="text" class="login-form__input" required autofocus autocomplete="name" />
            <div class="login-form__error">
                {{ $errors->first('name') }}
            </div>
        </div>

        <div class="login-form__field">
            <label for="email" class="login-form__label">{{ __('Email') }}</label>
            <input wire:model="email" id="email" name="email" type="email" class="login-form__input" required autocomplete="username" />
            <div class="login-form__error">
                {{ $errors->first('email') }}
            </div>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="login-form__description">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="login-form__link">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="login-form__status">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="login-form__actions">
            <button type="submit" class="login-form__button login-form__button--primary">{{ __('Save') }}</button>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
