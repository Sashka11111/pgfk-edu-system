<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Автоматизована система управління навчальним процесом Природничо-гуманітарного фахового коледжу ДВНЗ «УжНУ».">
    <meta name="keywords" content="Природничо-гуманітарний коледж, УжНУ, автоматизована система, навчання">
    <meta name="author" content="Природничо-гуманітарний фаховий коледж ДВНЗ «УжНУ»">

    <meta property="og:title" content="Природничо-гуманітарний фаховий коледж ДВНЗ «УжНУ»">
    <meta property="og:description" content="Автоматизована система управління навчальним процесом коледжу.">
    <meta property="og:image" content="{{ asset('images/icon.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <title>Природничо-гуманітарний фаховий коледж ДВНЗ «УжНУ»</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="page page--welcome">
<main class="welcome">
    <div class="welcome__container">
        <h1 class="welcome__title">Ласкаво просимо!</h1>
        <p class="welcome__description">Автоматизована система управління навчальним процесом <br> Природничо-гуманітарного фахового коледжу ДВНЗ «УжНУ».
        </p>
        <a href="/login" class="welcome__button">Розпочати</a>
    </div>
</main>
</body>
</html>
