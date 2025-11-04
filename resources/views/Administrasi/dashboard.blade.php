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
    <div class="dashboard-shell">
        {{-- Sidebar --}}
        <aside class="dashboard-sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/koni1.png') }}" alt="KONI Sleman" class="sidebar-logo">
                <div>
                    <span class="sidebar-role">Administrasi</span>
                    <h1 class="sidebar-title">KONI Sleman</h1>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('administrasi.dashboard') }}" class="sidebar-link active">
                    <span class="sidebar-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0 0H5a2 2 0 01-2-2v-5a2 2 0 012-2h3m4 9h3a2 2 0 002-2v-5a2 2 0 00-2-2h-3" />
                        </svg>
                    </span>
                    Dashboard
                </a>
                <a href="{{ route('administrasi.surat.index') }}" class="sidebar-link">
                    <span class="sidebar-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    Kelola Surat
                </a>
                <button class="sidebar-link" data-scroll="arsip-panel">
                    <span class="sidebar-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0h-6m-4 0H4" />
                        </svg>
                    </span>
                    Arsip Surat
                </button>
                <button class="sidebar-link" data-scroll="activity-panel">
                    <span class="sidebar-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.938 4.938a10 10 0 1114.142 14.142A10 10 0 014.938 4.938z" />
                        </svg>
                    </span>
                    Aktivitas
                </button>
            </nav>
            <div class="sidebar-footer">
                <p>Memantau penertiban, arsip, dan disposisi surat instansi</p>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="dashboard-main">
            <header class="dashboard-header">
                <div class="header-info">
                    <p class="header-label">Dashboard Administrasi Surat</p>
                    <h2 class="header-title">Selamat datang kembali, {{ auth()->user()->name }}!</h2>
                    <p class="header-subtitle">Kelola surat masuk, arsip, dan disposisi secara terpusat</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('administrasi.surat.create') }}" class="header-btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Surat
                    </a>
                    <a href="{{ route('administrasi.jenis-surat.create') }}" class="header-btn btn-outline">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        Tambah Jenis
                    </a>
                    <div class="header-profile" id="profileDropdown">
                        <button type="button" class="profile-toggle" id="profileButton">
                            <span class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                            <span class="profile-name">{{ auth()->user()->name }}</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="profile-menu" id="dropdownMenu">
                            <div class="profile-summary">
                                <p class="summary-name">{{ auth()->user()->name }}</p>
                                <p class="summary-role">Administrator</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="profile-menu-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L13 14l-4 1 1-4 8.5-8.5z" />
                                </svg>
                                Edit Profile
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="profile-menu-item profile-logout">
                                @csrf
                                <button type="submit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Stats --}}
            <section class="stats-grid">
                <article class="stat-card card-total">
                    <div>
                        <p class="stat-label">Total Surat</p>
                        <h3 class="stat-value">{{ number_format($totalSurat) }}</h3>
                        <span class="stat-caption">Semua surat terdata dalam sistem</span>
                    </div>
                    <span class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 4h8l4 4v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z" />
                        </svg>
                    </span>
                </article>
                <article class="stat-card card-incoming">
                    <div>
                        <p class="stat-label">Surat Masuk Bulan Ini</p>
                        <h3 class="stat-value">{{ number_format($suratMasukBulanIni) }}</h3>
                        <span class="stat-caption">Diterima hingga hari ini</span>
                    </div>
                    <span class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </span>
                </article>
                <article class="stat-card card-outgoing">
                    <div>
                        <p class="stat-label">Surat Keluar Bulan Ini</p>
                        <h3 class="stat-value">{{ number_format($suratKeluarBulanIni) }}</h3>
                        <span class="stat-caption">Didistribusikan melalui administrasi</span>
                    </div>
                    <span class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18m-6 6l6-6-6-6" />
                        </svg>
                    </span>
                </article>
                <article class="stat-card card-archive">
                    <div>
                        <p class="stat-label">Surat Terarsip</p>
                        <h3 class="stat-value">{{ number_format($arsipCount) }}</h3>
                        <span class="stat-caption">Dokumen yang tersimpan rapi</span>
                    </div>
                    <span class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h14a2 2 0 012 2v2H3V7z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 9h14v9a2 2 0 01-2 2H7a2 2 0 01-2-2V9z" />
                        </svg>
                    </span>
                </article>
            </section>

            {{-- Recent Letters & Timeline --}}
            <section class="dashboard-panels">
                <div class="panel-card" id="recent-panel">
                    <div class="panel-header">
                        <div>
                            <h3>Daftar Surat Terbaru</h3>
                            <p>Surat masuk dan keluar yang baru saja tercatat</p>
                        </div>
                        <div class="panel-actions">
                            <input type="text" id="recentSearch" class="panel-search" placeholder="Cari nomor, jenis, pengirim...">
                            <div class="status-toggle" data-status-group>
                                <button type="button" data-status="menunggu" class="active">Menunggu</button>
                                <button type="button" data-status="proses">Proses</button>
                                <button type="button" data-status="selesai">Selesai</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table class="recent-table">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Jenis</th>
                                    <th>Pengirim</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="recentTableBody">
                                @forelse($recentSurat as $surat)
                                    <tr data-id="{{ $surat->id }}">
                                        <td>
                                            <div class="cell-title">
                                                <span class="cell-label">{{ $surat->nomor_surat }}</span>
                                                @if($surat->is_from_guest)
                                                    <span class="cell-badge">Guest</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ optional($surat->jenis)->nama_jenis_surat ?? '-' }}</td>
                                        <td>{{ $surat->Pengirim }}</td>
                                        <td>{{ optional($surat->tanggal_masuk)?->format('d M Y') ?? '-' }}</td>
                                        <td>{{ optional($surat->tanggal_surat)?->format('d M Y') ?? '-' }}</td>
                                        <td>
                                            <div class="row-status" data-status-control="{{ $surat->id }}">
                                                <button type="button" data-value="menunggu">Menunggu</button>
                                                <button type="button" data-value="proses">Proses</button>
                                                <button type="button" data-value="selesai">Selesai</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty-state">Belum ada surat terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('administrasi.surat.index') }}" class="panel-link">Lihat semua surat</a>
                        <div class="panel-metrics">
                            <span><strong>{{ number_format($suratFromGuest) }}</strong> surat dari guest</span>
                        </div>
                    </div>
                </div>

                <aside class="panel-card" id="activity-panel">
                    <div class="panel-header">
                        <div>
                            <h3>Aktivitas Terakhir</h3>
                            <p>Jejak pembaruan surat berdasarkan waktu</p>
                        </div>
                    </div>
                    <ul class="activity-timeline">
                        @forelse($recentActivities as $activity)
                            <li>
                                <span class="timeline-dot"></span>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <h4>{{ $activity['title'] }}</h4>
                                        <time>{{ $activity['timestamp'] }}</time>
                                    </div>
                                    <p>{{ $activity['jenis'] ?? 'Jenis surat belum diatur' }} - {{ $activity['pengirim'] }}</p>
                                    <div class="timeline-meta">
                                        @if($activity['masuk'])
                                            <span>Masuk: {{ $activity['masuk'] }}</span>
                                        @endif
                                        @if($activity['keluar'])
                                            <span>Keluar: {{ $activity['keluar'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="timeline-empty">Belum ada aktivitas terbaru.</li>
                        @endforelse
                    </ul>
                </aside>
            </section>

            {{-- Archive Panel --}}
            <section class="panel-card archive-card" id="arsip-panel">
                <div class="panel-header">
                    <div>
                        <h3>Arsip Surat</h3>
                        <p>Dokumen yang telah disimpan dalam arsip digital</p>
                    </div>
                    <div class="archive-actions">
                        <button type="button" class="archive-filter active" data-archive-filter="all">Semua</button>
                        <button type="button" class="archive-filter" data-archive-filter="bulan">Bulan Ini</button>
                        <button type="button" class="archive-filter" data-archive-filter="tahun">Tahun Ini</button>
                    </div>
                </div>
                <div class="archive-grid" id="archiveGrid">
                    @forelse($archivedHighlight as $surat)
                        <article class="archive-item" data-archive-card data-created="{{ optional($surat->created_at)?->toIso8601String() }}">
                            <header>
                                <h4>{{ $surat->nomor_surat }}</h4>
                                <span>{{ optional($surat->tanggal_surat)?->format('d M Y') ?? '-' }}</span>
                            </header>
                            <p>{{ $surat->Pengirim }}</p>
                            <footer>
                                <span class="archive-tag">{{ optional($surat->jenis)->nama_jenis_surat ?? 'Tidak diketahui' }}</span>
                                <button type="button" class="archive-pin" data-pin="{{ $surat->id }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 4l4 4-8 8-4 1 1-4 8-8z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h6" />
                                    </svg>
                                </button>
                            </footer>
                        </article>
                    @empty
                        <p class="empty-state">Belum ada surat yang siap diarsipkan.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</body>
</html>
