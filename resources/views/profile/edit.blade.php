<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil - Sekretariat KONI Sleman</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600&family=Lato:wght@400;700&family=Questrial&display=swap" rel="stylesheet">

    @vite(['resources/css/edit-profile-admin.css', 'resources/js/edit-profile-admin.js'])
</head>
<body>
    <div class="profile-shell">
        <aside class="profile-aside">
            <div class="aside-brand">
                <img src="{{ asset('images/koni1.png') }}" alt="KONI Sleman">
                <div>
                    <p class="brand-label">Administrasi</p>
                    <h1>Sekretariat KONI Sleman</h1>
                </div>
            </div>
            <nav class="aside-nav">
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0 0H5a2 2 0 01-2-2v-5a2 2 0 012-2h3m4 9h3a2 2 0 002-2v-5a2 2 0 00-2-2h-3"/></svg>
                    Kembali ke Dashboard
                </a>
                <a href="{{ url('/') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4M3 11h18"/></svg>
                    Beranda
                </a>
            </nav>
            <div class="aside-note">
                <h2>Pembaruan Profil</h2>
                <p>Perbarui informasi akun dan kata sandi Anda untuk menjaga keamanan akses sistem administrasi surat.</p>
                <ul>
                    <li>Nama profil ditampilkan pada dashboard dan riwayat aktivitas.</li>
                    <li>Gunakan kata sandi kuat dengan kombinasi huruf dan angka.</li>
                </ul>
            </div>
        </aside>

        <main class="profile-main">
            <header class="main-header">
                <div>
                    <p class="header-label">Pengaturan Akun</p>
                    <h2>Edit Profil & Kata Sandi</h2>
                    <p class="header-desc">Semua perubahan akan tersimpan otomatis setelah disimpan.</p>
                </div>
                <div class="header-avatar">
                    <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
            </header>

            <div class="profile-grid">
                <section class="profile-card">
                    <div class="card-title">
                        <div class="card-icon card-icon-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h3>Informasi Profil</h3>
                            <p>Perbarui identitas utama akun administrasi Anda.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </section>

                <section class="profile-card">
                    <div class="card-title">
                        <div class="card-icon card-icon-accent">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"/></svg>
                        </div>
                        <div>
                            <h3>Keamanan Akun</h3>
                            <p>Atur ulang kata sandi secara berkala untuk keamanan maksimal.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.password') }}" class="profile-form">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="current_password">Password Saat Ini</label>
                            <div class="input-password">
                                <input id="current_password" name="current_password" type="password" autocomplete="current-password">
                                <button type="button" class="toggle-password" onclick="togglePassword('current_password')">
                                    <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                            @error('current_password')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <div class="input-password">
                                <input id="password" name="password" type="password" autocomplete="new-password">
                                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                    <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                            <p class="form-hint">Minimal 8 karakter dengan kombinasi angka & huruf.</p>
                            @error('password')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <div class="input-password">
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                    <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                            <div id="password-match-feedback" class="password-feedback"></div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Perbarui Password
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
