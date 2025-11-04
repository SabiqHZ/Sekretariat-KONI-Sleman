<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrasi - KONI Sleman</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600&family=Lato:wght@400;700&family=Questrial&display=swap" rel="stylesheet">

    {{-- Styles --}}
    @vite(['resources/css/dashboard-admin.css', 'resources/js/dashboard-admin.js'])
</head>

<body>
    {{-- Header --}}
    <header>
        <div class="header-left">
            <img src="{{ asset('images/koni1.png') }}" alt="KONI Sleman" class="header-logo">
            <h1>Dashboard Administrasi</h1>
        </div>
        <nav>
            <button class="btn" onclick="scrollToSection('overview')">Overview</button>
            <button class="btn" onclick="scrollToSection('actions')">Aksi Cepat</button>
            <div>

                <!-- Profile Dropdown -->
                <div class="profile-dropdown">
                    <button class="profile-button" id="profileButton" type="button">
                        <svg class="profile-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>

                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit Profile</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="dropdown-form">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-item-danger">
                                <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    {{-- Main Content --}}
    <main>
        {{-- Welcome Section --}}
        <section id="overview" class="welcome-section">
            <div class="welcome-content">
                <h2>Selamat Datang, Administrasi!</h2>
                <p>Kelola dan monitor sistem administrasi surat dengan mudah</p>
            </div>
        </section>

        {{-- Statistics Section --}}
        <section class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    {{-- Total Surat Card --}}
                    <div class="stat-card card-blue">
                        <div class="stat-content">
                            <div class="stat-info">
                                <h3>Total Surat</h3>
                                <p class="stat-number">{{ $totalSurat }}</p>
                                <p class="stat-desc">Semua surat dalam sistem</p>
                            </div>
                            <div class="stat-icon icon-blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-footer">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>Statistik keseluruhan</span>
                        </div>
                    </div>

                    {{-- Surat Masuk Card --}}
                    <div class="stat-card card-green">
                        <div class="stat-content">
                            <div class="stat-info">
                                <h3>Surat Masuk</h3>
                                <p class="stat-number">{{ $suratFromGuest }}</p>
                                <p class="stat-desc">Surat dari guest/pengunjung</p>
                            </div>
                            <div class="stat-icon icon-green">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-footer">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Perlu ditindaklanjuti</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Quick Actions Section --}}
        <section id="actions" class="actions-section">
            <div class="container">
                <div class="section-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <h3>Aksi Cepat</h3>
                </div>

                <div class="actions-grid">
                    {{-- Lihat Surat --}}
                    <a href="{{ route('administrasi.surat.index') }}" class="action-card action-blue">
                        <div class="action-content">
                            <h4>Lihat Surat</h4>
                            <p>Kelola semua surat</p>
                        </div>
                        <div class="action-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </a>

                    {{-- Upload Surat --}}
                    <a href="{{ route('administrasi.surat.create') }}" class="action-card action-green">
                        <div class="action-content">
                            <h4>Upload Surat</h4>
                            <p>Tambah surat baru</p>
                        </div>
                        <div class="action-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                    </a>

                    {{-- Laporan --}}
                    <a href="#" class="action-card action-purple">
                        <div class="action-content">
                            <h4>Laporan</h4>
                            <p>Lihat statistik</p>
                        </div>
                        <div class="action-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>
</body>

</html>