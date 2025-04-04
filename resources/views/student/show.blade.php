<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профіль студента - {{ $student->first_name }} {{ $student->last_name }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<!-- Header -->
<header class="header">
    <div class="header__container">
        <a href="{{ url('/') }}" class="header__logo-link">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="header__logo-image">
            <h1 class="header__title">Система управління навчальним процесом</h1>
        </a>
        @auth
            <form action="{{ route('logout') }}" method="POST" class="header__logout-form">
                @csrf
                <button type="submit" class="header__logout-button">Вийти</button>
            </form>
        @endauth
    </div>
</header>

<!-- Основний контент -->
<div class="profile">
    <div class="profile__container">
        <!-- Загальна інформація про студента -->
        <div class="profile__section">
            <h2 class="profile__title">Інформація про студента</h2>
            <div class="profile__form">
                <div class="login-form__field">
                    <label class="login-form__label">Прізвище</label>
                    <input type="text" class="login-form__input" value="{{ $student->last_name }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Ім'я</label>
                    <input type="text" class="login-form__input" value="{{ $student->first_name }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">По батькові</label>
                    <input type="text" class="login-form__input" value="{{ $student->middle_name }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Номер залікової книжки</label>
                    <input type="text" class="login-form__input" value="{{ $student->record_book_number }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Група</label>
                    <input type="text" class="login-form__input" value="{{ $student->group->name }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Спеціальність</label>
                    <input type="text" class="login-form__input" value="{{ $student->group->specialty->name }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Дата зарахування</label>
                    <input type="text" class="login-form__input" value="{{ $student->enrollment_date }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Стипендія</label>
                    <input type="text" class="login-form__input" value="{{ $student->is_scholarship_holder ? 'Так' : 'Ні' }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Дата народження</label>
                    <input type="text" class="login-form__input" value="{{ $student->birthdate }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Місце народження</label>
                    <input type="text" class="login-form__input" value="{{ $student->birthplace }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Номер телефону</label>
                    <input type="text" class="login-form__input" value="{{ $student->phone_number }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Адреса</label>
                    <input type="text" class="login-form__input" value="{{ $student->address }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Ім'я опікуна</label>
                    <input type="text" class="login-form__input" value="{{ $student->guardian_name }}" readonly>
                </div>
                <div class="login-form__field">
                    <label class="login-form__label">Телефон опікуна</label>
                    <input type="text" class="login-form__input" value="{{ $student->guardian_phone }}" readonly>
                </div>
            </div>
        </div>

        <!-- Посилання на профіль користувача -->
        @if ($student->user)
            <div class="profile__section">
                <h2 class="profile__title">Дані користувача</h2>
                <div class="profile__form">
                    <div class="login-form__field">
                        <label class="login-form__label">Ім'я користувача</label>
                        <input type="text" class="login-form__input" value="{{ $student->user->name }}" readonly>
                    </div>
                    <div class="login-form__field">
                        <label class="login-form__label">Email</label>
                        <input type="text" class="login-form__input" value="{{ $student->user->email }}" readonly>
                    </div>
                    <div class="login-form__field">
                        <a href="{{ route('profile.show') }}" class="login-form__button login-form__button--primary">Перейти до профілю</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
</body>
</html>
