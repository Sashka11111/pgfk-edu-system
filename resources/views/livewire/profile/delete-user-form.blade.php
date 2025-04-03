<?php

use Liamtseva\PGFKEduSystem\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="login-form">
    <header>
        <h2 class="profile__title">
            {{ __('Delete Account') }}
        </h2>

        <p class="login-form__label">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="login-form__button login-form__button--primary"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="login-form__form">
            <h2 class="profile__title">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="login-form__description">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="login-form__field">
                <label for="password" class="login-form__label sr-only">{{ __('Password') }}</label>
                <input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="login-form__input"
                    placeholder="{{ __('Password') }}"
                />
                <div class="login-form__error">
                    {{ $errors->first('password') }}
                </div>
            </div>

            <div class="login-form__actions">
                <button type="button" x-on:click="$dispatch('close')" class="login-form__button">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" class="login-form__button login-form__button--primary">{{ __('Delete Account') }}</button>
            </div>
        </form>
    </x-modal>
</section>
