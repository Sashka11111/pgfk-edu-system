<?php

use Illuminate\Validation\Rules\Enum;
use Liamtseva\PGFKEduSystem\Enums\Gender;
use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\Student;
use Liamtseva\PGFKEduSystem\Models\Teacher;
use Liamtseva\PGFKEduSystem\Models\Worker;
use Liamtseva\PGFKEduSystem\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public Gender|string $gender = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@uzhnu.edu.ua') && !str_ends_with($value,
                            '@student.uzhnu.edu.ua')) {
                        $fail('Email-адреса повинна закінчуватися на @uzhnu.edu.ua або @student.uzhnu.edu.ua.');
                    }
                }, 'unique:'.User::class
            ],
            'gender' => ['required', new Enum(Gender::class)],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);
        $validated['role'] = str_ends_with($validated['email'],
            '@student.uzhnu.edu.ua') ? 'student' : 'teacher';
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $this->updateRoleSpecificRecord($validated['role'], $validated['email'], $user->id);

        // Викликаємо подію Registered і авторизуємо користувача
        event(new Registered($user));
        Auth::login($user);

        redirect()->route('dashboard');
    }

    private function updateRoleSpecificRecord(string $role, string $email, string $userId): void
    {
        // Визначаємо модель залежно від ролі
        $modelClass = match ($role) {
            Role::STUDENT->value => Student::class,
            Role::TEACHER->value => Teacher::class,
            Role::ADMIN->value => Worker::class,
            default => null, // Якщо роль не підтримується, нічого не робимо
        };

        if ($modelClass) {
            $record = $modelClass::where('email', $email)->first();
            if ($record) {
                $record->update(['user_id' => $userId]);
            } else {
                \Log::warning("Запис для ролі {$role} з email {$email} не знайдено.");
            }
        }
    }
}; ?>

<div class="login-form">
    <form wire:submit="register" class="login-form__form">
        <!-- Name -->
        <div class="login-form__field">
            <x-input-label for="name" :value="__('Name')" class="login-form__label"/>
            <x-text-input wire:model="name" id="name" class="login-form__input" type="text"
                          name="name" required autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="login-form__error"/>
        </div>

        <!-- Email Address -->
        <div class="login-form__field">
            <x-input-label for="email" :value="__('Email')" class="login-form__label"/>
            <x-text-input wire:model="email" id="email" class="login-form__input" type="email"
                          name="email" required autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="login-form__error"/>
        </div>

        <!-- Password -->
        <div class="login-form__field">
            <x-input-label for="password" :value="__('Password')" class="login-form__label"/>
            <x-text-input wire:model="password" id="password" class="login-form__input"
                          type="password" name="password" required autocomplete="new-password"/>
            <x-input-error :messages="$errors->get('password')" class="login-form__error"/>
        </div>

        <!-- Confirm Password -->
        <div class="login-form__field">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                           class="login-form__label"/>
            <x-text-input wire:model="password_confirmation" id="password_confirmation"
                          class="login-form__input" type="password" name="password_confirmation"
                          required autocomplete="new-password"/>
            <x-input-error :messages="$errors->get('password_confirmation')"
                           class="login-form__error"/>
        </div>
        <!-- Gender -->
        <div class="login-form__field">
            <select wire:model="gender" id="gender" name="gender" class="login-form__select"
                    required>
                <option value="">{{ __('Оберіть стать') }}</option>
                @foreach (Gender::cases() as $genderOption)
                    <option value="{{ $genderOption->value }}">
                        {{ $genderOption->getLabel() }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('gender')" class="login-form__error"/>
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
