<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile - Sekretariat KONI Sleman</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">

    {{-- Pakai stylesheet dashboard + stylesheet halaman tipis --}}
    @vite([
    'resources/css/dashboard-admin-components.css',
    'resources/css/edit-profile-admin.css',
    ])
</head>

<body>
    {{-- Header mengikuti dashboard --}}
    <header>
        <div class="header-left">
            <img src="{{ asset('images/koni-logo.png') }}" alt="KONI Sleman" class="header-logo">
            <h1>Edit Profile - Administrasi</h1>
        </div>

        <nav>
            <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-admin">Kembali ke Dashboard</a>
        </nav>
    </header>

    <main>
        <div class="container">
            <section class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2>Edit Profile</h2>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" id="profileForm" class="profile-form">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input id="name" name="name" type="text" class="upload-input"
                            value="{{ old('name', $user->name) }}" required autofocus>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-group">
                        <label for="current_password">Password Saat Ini <span class="muted">(opsional)</span></label>
                        <div class="password">
                            <input id="current_password" name="current_password" type="password" class="upload-input" autocomplete="current-password">
                            <button type="button" class="eye" data-toggle="current_password" aria-label="Toggle password"></button>
                        </div>
                        @error('current_password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <div class="password">
                                <input id="password" name="password" type="password" class="upload-input" autocomplete="new-password" minlength="8">
                                <button type="button" class="eye" data-toggle="password" aria-label="Toggle password"></button>
                            </div>
                            <p class="form-hint">Minimal 8 karakter</p>
                            @error('password') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <div class="password">
                                <input id="password_confirmation" name="password_confirmation" type="password" class="upload-input" autocomplete="new-password" minlength="8">
                                <button type="button" class="eye" data-toggle="password_confirmation" aria-label="Toggle password"></button>
                            </div>
                            <div id="password-match" class="match"></div>
                        </div>
                    </div>

                    <div class="profile-actions">
                        <button type="submit" class="btn btn-admin" id="submitBtn">

                            <span>Update Profile</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>

    @vite(['resources/js/edit-profile-admin.js'])
</body>

</html>