<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile - Sekretariat KONI Sleman</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600&family=Lato:wght@400;700&family=Questrial&display=swap" rel="stylesheet">

    {{-- CSS --}}
    @vite(['resources/css/edit-profile-admin.css'])
</head>

<body>
    {{-- Header --}}
    <header class="main-header">
        <div class="header-left">
            <img src="{{ asset('images/koni1.png') }}" alt="KONI Sleman" class="header-logo">
        </div>
        <nav class="main-nav">
            <a href="{{ url('/') }}" class="nav-btn">Beranda</a>
            <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="nav-btn nav-btn-back">Kembali ke Dashboard</a>
        </nav>
    </header>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="container">

            {{-- Combined Profile & Password Section --}}
            <div class="profile-card profile-card-compact">
                <div class="card-header">
                    <div class="card-icon card-icon-blue">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="card-title">Edit Profile</h2>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            class="form-input"
                            value="{{ old('name', $user->name) }}"
                            required
                            autofocus>
                        @error('name')
                        <p class="error-message">
                            <svg class="icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-group">
                        <label for="current_password" class="form-label">Password Saat Ini (Kosongkan jika tidak ingin mengubah)</label>
                        <div class="password-wrapper">
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                class="form-input form-input-password"
                                autocomplete="current-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                                <svg class="icon-sm eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                        <p class="error-message">
                            <svg class="icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="password-wrapper">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-input form-input-password"
                                autocomplete="new-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <svg class="icon-sm eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="input-hint">
                            <svg class="icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Minimal 8 karakter
                        </p>
                        @error('password')
                        <p class="error-message">
                            <svg class="icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="password-wrapper">
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                class="form-input form-input-password"
                                autocomplete="new-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <svg class="icon-sm eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        <div id="password-match-feedback" class="password-feedback"></div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    @vite(['resources/js/edit-profile-admin.js'])
</body>

</html>