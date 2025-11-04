<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sekretariat KONI Sleman</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600&family=Lato:wght@400;700&family=Questrial&display=swap" rel="stylesheet">

    {{-- Styles & Scripts --}}
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
</head>

<body>
    <header>
        <img src="{{ asset('images/koni1.png') }}" alt="KONI Sleman" style="height:48px; width:auto;">
        <nav>
            @guest
            <button class="btn" onclick="scrollToSection('home')">Beranda</button>
            @endguest

            <button class="btn" onclick="scrollToSection('tentang')">Tentang</button>
            <button class="btn" onclick="scrollToSection('privasi')">Privasi</button>
            <button class="btn" onclick="scrollToSection('informasi')">Informasi</button>

            <div>
                @auth
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-admin">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="btn btn-admin">Masuk</a>
                @endauth
            </div>
        </nav>
    </header>
    <main>
        {{-- Home Section --}}
        <section id="home">
            <img src="{{ asset('images/koni-logo.png') }}" alt="KONI Logo" class="logo">
            <h2>Sekretariat <br> KONI Sleman</h2>
            <p>
                Website resmi Sekretariat KONI Sleman adalah platform digital terbuka
                untuk umum yang memudahkan akses informasi dan layanan administrasi
                keolahragaan. Melalui situs ini, masyarakat dapat mengirim berbagai
                jenis surat atau dokumen secara daring—seperti permohonan, proposal,
                atau undangan—langsung ke Sekretariat KONI Sleman, menjadikannya
                sarana komunikasi yang praktis, transparan, dan responsif.
            </p>
            @guest
            <a href="{{ route('guest.surat.create') }}" class="btn-primary">
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Kirim Surat
            </a>
            @endguest
        </section>
        {{-- About Section --}}
        <section id="tentang">
            <h2>Tentang</h2>
            <p>
                Website ini dirancang khusus untuk memudahkan pengelolaan dokumen,
                surat-menyurat, dan administrasi KONI Sleman. Dengan sistem yang
                terintegrasi, kami memberikan solusi digital yang efisien untuk
                mendukung kinerja organisasi olahraga di Kabupaten Sleman.
            </p>
            <div class="tentang-icons">
                <div class="icon-item">
                    <img src="{{ asset('images/inbox.png') }}" alt="Inbox" class="tentang-icon">
                    <span class="icon-label">Surat Masuk</span>
                </div>
                <div class="icon-item">
                    <img src="{{ asset('images/outbox.png') }}" alt="Outbox" class="tentang-icon">
                    <span class="icon-label">Surat Keluar</span>
                </div>
            </div>
        </section>
        {{-- Privacy Section --}}
        <section id="privasi">
            <h2>Privasi & Keamanan</h2>
            <p>
                Kami berkomitmen untuk melindungi privasi dan keamanan data Anda.
                Setiap informasi yang Anda kirimkan melalui platform ini dijaga
                dengan standar keamanan tinggi dan hanya digunakan untuk keperluan
                administrasi resmi KONI Sleman.
            </p>

            <div class="privacy-cards">
                <div class="privacy-card">
                    <div class="privacy-icon">
                        <img src="{{ asset('images/lock.png') }}" alt="lock" class="card-icon">
                    </div>
                    <h3>Data Terenkripsi</h3>
                    <p>Semua data dan dokumen yang dikirim dilindungi dengan enkripsi SSL/TLS untuk mencegah akses tidak sah.</p>
                </div>

                <div class="privacy-card">
                    <div class="privacy-icon">
                        <img src="{{ asset('images/check.png') }}" alt="check" class="card-icon">
                    </div>
                    <h3>Kerahasiaan Terjaga</h3>
                    <p>Informasi pribadi Anda hanya dapat diakses oleh pihak berwenang di Sekretariat KONI Sleman.</p>
                </div>

                <div class="privacy-card">
                    <div class="privacy-icon">
                        <img src="{{ asset('images/list.png') }}" alt="list" class="card-icon">
                    </div>
                    <h3>Penggunaan Terbatas</h3>
                    <p>Data Anda hanya digunakan untuk keperluan administrasi dan tidak akan dibagikan kepada pihak ketiga tanpa izin.</p>
                </div>
            </div>
        </section>
    </main>

    {{-- ======================================
         FOOTER
         ====================================== --}}
    <footer id="informasi">
        <div class="footer-content">
            <!-- Left Section -->
            <div class="footer-left">
                <div class="footer-logo-section">
                    <img src="{{ asset('images/koni-logo.png') }}" alt="KONI Logo" class="footer-logo">
                    <div class="footer-title">
                        <h2>Komite Olahraga Nasional Indonesia Kabupaten Sleman</h2>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="footer-right">
                <div class="footer-column">
                    <h3>Informasi</h3>
                    <ul>
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#tentang">Tentang</a></li>
                        <li><a href="#privasi">Privasi</a></li>
                        <li><a href="{{ route('login') }}">Admin</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <div class="footer-contact">
                        <h3>Kontak dan Lokasi Kami</h3>
                        <p>Jl. Kepuhsari, Jenengan, Maguwoharjo, Kec. Depok, Kabupaten Sleman, DIY</p>
                        <p>koni.sleman@gmail.com</p>
                        <p>(0274) 4477164</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>Copyright © 2025 - Komite Olahraga Nasional Indonesia Kabupaten Sleman</p>
        </div>
    </footer>
</body>

</html>