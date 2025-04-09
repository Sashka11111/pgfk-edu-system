<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="guest-layout">

<!-- Основний вміст -->
<div class="profile">
    <div class="profile__container ">
        <!-- Секція: Оновлення інформації профілю -->
        <section class="profile__section">
            <div class="profile__form">
                <livewire:profile.update-profile-information-form />
            </div>
        </section>
        <!-- Секція: Оновлення пароля -->
        <section class="profile__section">
            <div class="profile__form ">
                <livewire:profile.update-password-form />
            </div>
        </section>

        <!-- Секція: Видалення користувача -->
        <section class="profile__section profile__section--danger">
            <div class="profile__form">
                <livewire:profile.delete-user-form />
            </div>
        </section>
        <section class="profile__section">
            <form method="POST" action="{{ route('logout') }}" class="header__logout-form">
                @csrf
                <button type="submit" class="login-form__button login-form__button--primary">
                    {{ __('Logout') }}
                </button>
            </form>
        </section>
    </div>
</div>
</body>
</html>
