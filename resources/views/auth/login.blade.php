<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Login') }} - Sekretariat KONI Sleman</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600&family=Lato:wght@400;700&family=Questrial&display=swap" rel="stylesheet">

    {{-- Styles & Scripts --}}
    @vite(['resources/css/login.css', 'resources/js/login.js'])
</head>

<body>
    {{-- Header --}}
    <header>
        <img src="{{ asset('images/koni1.png') }}" alt="KONI Sleman" style="height:48px; width:auto;">
        <nav>
            <a href="{{ route('Beranda') }}" class="btn-back">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Kembali ke Beranda
            </a>
        </nav>
    </header>

    {{-- Main Container --}}
    <div class="main-container">
        {{-- Decorative Elements --}}
        <div class="decoration decoration-1"></div>
        <div class="decoration decoration-2"></div>

        {{-- Login Form Container --}}
        <div class="login-container">
            <h2 class="login-title">Login</h2>
            <p class="login-subtitle">Masuk ke sistem Sekretariat KONI Sleman</p>

            {{-- Session Status --}}
            @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- name Address --}}
                <div class="form-group">
                    <label for="name">{{ __('Posisi Pengguna') }}</label>
                    <input
                        id="name"
                        type="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="username" />
                    @if ($errors->get('name'))
                    <div class="error-message">
                        @foreach ($errors->get('name') as $error)
                        {{ $error }}
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />
                    @if ($errors->get('password'))
                    <div class="error-message">
                        @foreach ($errors->get('password') as $error)
                        {{ $error }}
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Submit Button --}}
                <div class="button-section">
                    <button type="submit" class="btn-primary">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>