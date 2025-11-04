<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard Administrasi - KONI Sleman</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

        {{-- Fonts --}}
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600&family=Lato:wght@400;700&family=Questrial&display=swap"
            rel="stylesheet"
        />

        {{-- Styles --}}
        @vite([
            'resources/css/app.css',
            'resources/css/dashboard-admin.css',
            'resources/js/dashboard-admin.js',
        ])
    </head>

    @php
        $guestRatio = $totalSurat > 0 ? round(($suratFromGuest / $totalSurat) * 100) : 0;
        $attachmentRatio = $totalSurat > 0 ? round(($suratWithAttachment / $totalSurat) * 100) : 0;
        $originDataset = [
            'guest' => $suratFromGuest,
            'internal' => $suratInternal,
        ];
    @endphp

    <body class="bg-white font-body text-brand-ink">
        <div class="min-h-screen bg-brand-pale relative overflow-hidden">
            <div class="absolute inset-0 opacity-40 pointer-events-none bg-grid"></div>

            {{-- Header --}}
            <header class="sticky top-0 z-40 backdrop-blur-xl bg-white/85 border-b border-brand-light shadow-soft">
                <div class="max-w-7xl mx-auto px-6 py-4 flex flex-wrap items-center gap-4 justify-between">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary text-white flex items-center justify-center shadow-soft">
                            🏅
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-brand-ink/70">Administrasi KONI Sleman</p>
                            <h1 class="text-2xl md:text-3xl font-extrabold text-brand-ink">Dasbor Surat</h1>
                        </div>
                    </div>
                    <nav class="flex flex-wrap items-center gap-2 md:gap-3">
                        <button class="nav-pill" onclick="scrollToSection('overview')">Overview</button>
                        <button class="nav-pill" onclick="scrollToSection('insights')">Insight</button>
                        <button class="nav-pill" onclick="scrollToSection('letters')">Daftar Surat</button>
                        <button class="nav-pill" onclick="scrollToSection('actions')">Aksi Cepat</button>
                    </nav>
                    <div class="flex items-center gap-3 ml-auto">
                        <div class="relative hidden md:block">
                            <input
                                type="search"
                                class="input-search"
                                placeholder="Cari surat, jenis, atau pengirim"
                                aria-label="Pencarian"
                            />
                            <span class="search-icon">🔍</span>
                        </div>
                        <div class="relative">
                            <button id="profileButton" class="avatar-button" type="button">
                                <img
                                    src="https://i.pravatar.cc/60?img=15"
                                    alt="Profil"
                                    class="h-10 w-10 rounded-full border-2 border-brand-secondary object-cover"
                                />
                            </button>
                            <div id="dropdownMenu" class="profile-menu">
                                <a href="{{ route('profile.edit') }}" class="profile-menu__item">Kelola Profil</a>
                                <a href="{{ route('administrasi.surat.index') }}" class="profile-menu__item">Kelola Surat</a>
                                <form action="{{ route('logout') }}" method="POST" class="profile-menu__form">
                                    @csrf
                                    <button type="submit" class="profile-menu__item profile-menu__item--danger">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="relative z-10">
                <section id="overview" class="max-w-7xl mx-auto px-6 pt-10 pb-8 space-y-10">
                    <div class="grid lg:grid-cols-[1.5fr,1fr] gap-8 items-start">
                        <div class="glass-card p-8 space-y-6">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold tracking-[0.3em] uppercase text-brand-ink/70">Ringkasan Sistem</p>
                                    <h2 class="text-3xl font-black text-brand-ink leading-tight">
                                        Kelola ekosistem surat dengan cepat, akurat, dan terstruktur.
                                    </h2>
                                </div>
                                <div class="hidden md:block shrink-0">
                                    <div class="pill-indicator">Realtime • {{ now()->locale('id')->isoFormat('dddd, DD MMM Y') }}</div>
                                </div>
                            </div>
                            <p class="text-base text-brand-ink/80 max-w-3xl">
                                Pantau lalu lintas surat masuk dan internal KONI Sleman dalam satu tempat. Insight otomatis membantu menentukan prioritas tindak lanjut, sementara daftar surat terbaru memastikan tak ada dokumen yang terlewat.
                            </p>
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="stat-chip">
                                    <span class="stat-chip__label">Total surat</span>
                                    <span class="stat-chip__value">{{ number_format($totalSurat) }}</span>
                                </div>
                                <div class="stat-chip">
                                    <span class="stat-chip__label">Persentase surat guest</span>
                                    <span class="stat-chip__value">{{ $guestRatio }}%</span>
                                </div>
                                <div class="stat-chip">
                                    <span class="stat-chip__label">Lampiran tersimpan</span>
                                    <span class="stat-chip__value">{{ $attachmentRatio }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="highlight-card">
                            <p class="text-xs uppercase tracking-[0.35em] text-brand-ink/70">Fokus Mingguan</p>
                            <h3 class="text-4xl font-black text-brand-primary">{{ number_format($suratThisWeek) }}</h3>
                            <p class="text-sm text-brand-ink/75">surat diterima minggu ini</p>
                            <div class="mt-6 space-y-3">
                                <div class="progress-row">
                                    <div class="flex justify-between text-xs font-semibold text-brand-ink/80">
                                        <span>Surat guest</span>
                                        <span>{{ $guestRatio }}%</span>
                                    </div>
                                    <div class="progress-track">
                                        <span class="progress-bar" style="width: {{ $guestRatio }}%"></span>
                                    </div>
                                </div>
                                <div class="progress-row">
                                    <div class="flex justify-between text-xs font-semibold text-brand-ink/80">
                                        <span>Lampiran tersimpan</span>
                                        <span>{{ $attachmentRatio }}%</span>
                                    </div>
                                    <div class="progress-track">
                                        <span class="progress-bar progress-bar--alt" style="width: {{ $attachmentRatio }}%"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <div class="mini-card">
                                    <p class="mini-card__label">Jenis surat aktif</p>
                                    <p class="mini-card__value">{{ $jenisCount }}</p>
                                </div>
                                <div class="mini-card">
                                    <p class="mini-card__label">Lampiran tersedia</p>
                                    <p class="mini-card__value">{{ number_format($suratWithAttachment) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KPI --}}
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <article class="metric-card">
                            <div class="metric-card__icon bg-gradient-to-br from-brand-primary to-brand-secondary">📨</div>
                            <div>
                                <p class="metric-card__label">Total surat tercatat</p>
                                <p class="metric-card__value">{{ number_format($totalSurat) }}</p>
                                <p class="metric-card__desc">Akumulasi seluruh surat pada sistem</p>
                            </div>
                        </article>
                        <article class="metric-card">
                            <div class="metric-card__icon bg-brand-secondary/80 text-brand-ink">🤝</div>
                            <div>
                                <p class="metric-card__label">Surat guest</p>
                                <p class="metric-card__value">{{ number_format($suratFromGuest) }}</p>
                                <p class="metric-card__desc">Dokumen yang berasal dari tamu eksternal</p>
                            </div>
                        </article>
                        <article class="metric-card">
                            <div class="metric-card__icon bg-brand-primary/10 text-brand-primary">🏢</div>
                            <div>
                                <p class="metric-card__label">Surat internal</p>
                                <p class="metric-card__value">{{ number_format($suratInternal) }}</p>
                                <p class="metric-card__desc">Dihimpun dari unit internal KONI Sleman</p>
                            </div>
                        </article>
                        <article class="metric-card">
                            <div class="metric-card__icon bg-brand-ink/10 text-brand-ink">📎</div>
                            <div>
                                <p class="metric-card__label">Lampiran arsip</p>
                                <p class="metric-card__value">{{ number_format($suratWithAttachment) }}</p>
                                <p class="metric-card__desc">File PDF tersimpan dan siap diunduh</p>
                            </div>
                        </article>
                    </div>
                </section>

                {{-- Insights --}}
                <section id="insights" class="bg-white/80 py-10 border-y border-brand-light">
                    <div class="max-w-7xl mx-auto px-6 space-y-8">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <p class="section-eyebrow">Insight &amp; Grafik</p>
                                <h2 class="section-title">Performa surat dalam 6 bulan terakhir</h2>
                            </div>
                            <div class="pill-indicator">Data diperbarui {{ now()->locale('id')->isoFormat('DD MMM Y [pukul] HH.mm') }}</div>
                        </div>
                        <div class="grid gap-6 xl:grid-cols-3">
                            <div class="insight-card xl:col-span-2">
                                <div class="insight-card__header">
                                    <div>
                                        <h3 class="insight-card__title">Total surat per bulan</h3>
                                        <p class="insight-card__subtitle">Mengukur tren surat masuk &amp; tercatat</p>
                                    </div>
                                    <button id="refreshTrend" class="btn-ghost">Segarkan</button>
                                </div>
                                <div class="relative">
                                    <canvas id="suratTrendChart" height="160"></canvas>
                                    <div class="chart-empty" data-chart-empty hidden>Belum ada data dalam rentang ini.</div>
                                </div>
                            </div>
                            <div class="insight-card">
                                <div class="insight-card__header">
                                    <div>
                                        <h3 class="insight-card__title">Distribusi surat</h3>
                                        <p class="insight-card__subtitle">Perbandingan surat internal &amp; tamu</p>
                                    </div>
                                </div>
                                <div class="relative">
                                    <canvas id="originChart" height="210"></canvas>
                                </div>
                                <div class="mt-6 space-y-3">
                                    @foreach ($originDataset as $key => $value)
                                        <div class="flex items-center justify-between text-sm text-brand-ink/80">
                                            <span class="font-semibold capitalize">{{ $key }}</span>
                                            <span>{{ number_format($value) }} surat</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-[1.2fr,1fr]">
                            <div class="insight-card">
                                <div class="insight-card__header">
                                    <div>
                                        <h3 class="insight-card__title">Jenis surat terpopuler</h3>
                                        <p class="insight-card__subtitle">5 jenis dengan frekuensi tertinggi</p>
                                    </div>
                                </div>
                                <div class="relative">
                                    <canvas id="jenisChart" height="220"></canvas>
                                </div>
                                <ul class="mt-6 space-y-3">
                                    @foreach ($suratByJenis->take(5) as $row)
                                        <li class="flex items-center justify-between text-sm text-brand-ink/80">
                                            <span>{{ $row['jenis'] }}</span>
                                            <span class="font-semibold">{{ number_format($row['total']) }} surat</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="insight-card">
                                <div class="insight-card__header">
                                    <div>
                                        <h3 class="insight-card__title">Guest vs internal per jenis</h3>
                                        <p class="insight-card__subtitle">4 jenis dengan proporsi terbesar</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    @forelse ($suratOriginsByJenis as $row)
                                        @php
                                            $totalPerJenis = $row['guest'] + $row['internal'];
                                            $guestPct = $totalPerJenis > 0 ? round(($row['guest'] / $totalPerJenis) * 100) : 0;
                                        @endphp
                                        <div class="border border-brand-light rounded-2xl p-4 bg-white/70 shadow-soft-sm">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="font-semibold text-brand-ink">{{ $row['jenis'] }}</span>
                                                <span class="text-brand-ink/70">{{ number_format($totalPerJenis) }} surat</span>
                                            </div>
                                            <div class="progress-track mt-3 h-2">
                                                <span class="progress-bar h-2" style="width: {{ $guestPct }}%"></span>
                                            </div>
                                            <div class="flex items-center justify-between text-[13px] text-brand-ink/70 mt-2">
                                                <span>Guest {{ number_format($row['guest']) }}</span>
                                                <span>Internal {{ number_format($row['internal']) }}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-sm text-brand-ink/70">Belum ada data yang dapat ditampilkan.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Letters list --}}
                <section id="letters" class="max-w-7xl mx-auto px-6 py-12 space-y-8">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <p class="section-eyebrow">Daftar Surat Terbaru</p>
                            <h2 class="section-title">Ringkasan atribut surat terakhir</h2>
                        </div>
                        <div class="inline-flex bg-white/80 border border-brand-light rounded-full p-1 shadow-soft-sm">
                            <button class="filter-pill active" data-letter-filter="all">Semua</button>
                            <button class="filter-pill" data-letter-filter="internal">Internal</button>
                            <button class="filter-pill" data-letter-filter="guest">Guest</button>
                        </div>
                    </div>
                    <div class="glass-card p-0 overflow-hidden">
                        <div class="hidden lg:grid grid-cols-[1.2fr,1fr,1fr,1fr,120px] px-6 py-4 bg-brand-light/30 text-xs font-semibold uppercase tracking-wide text-brand-ink/80">
                            <span>Nomor &amp; Jenis</span>
                            <span>Pengirim</span>
                            <span>Tanggal Surat</span>
                            <span>Tanggal Diterima</span>
                            <span class="text-right pr-2">Status</span>
                        </div>
                        <ul class="divide-y divide-brand-light/70" data-letter-list>
                            @forelse ($recentSurat as $item)
                                <li
                                    class="letter-row"
                                    data-letter-item
                                    data-origin="{{ $item->is_from_guest ? 'guest' : 'internal' }}"
                                >
                                    <div class="letter-row__col">
                                        <p class="letter-row__title">{{ $item->nomor_surat }}</p>
                                        <p class="letter-row__meta">{{ optional($item->jenis)->nama_jenis_surat ?? 'Tidak terdata' }}</p>
                                    </div>
                                    <div class="letter-row__col">
                                        <p class="letter-row__value">{{ $item->pengirim }}</p>
                                        @if ($item->is_from_guest)
                                            <span class="letter-tag letter-tag--accent">Guest</span>
                                        @else
                                            <span class="letter-tag">Internal</span>
                                        @endif
                                    </div>
                                    <div class="letter-row__col">
                                        <p class="letter-row__value">
                                            {{ optional($item->tanggal_surat, fn ($date) => $date->locale('id')->isoFormat('DD MMM Y')) ?? '—' }}
                                        </p>
                                        <p class="letter-row__meta">Tanggal surat</p>
                                    </div>
                                    @php
                                        $receivedDate = $item->tanggal_masuk ?: $item->created_at;
                                    @endphp
                                    <div class="letter-row__col">
                                        <p class="letter-row__value">
                                            {{ optional($receivedDate, fn ($date) => $date->locale('id')->isoFormat('DD MMM Y')) }}
                                        </p>
                                        <p class="letter-row__meta">Diterima</p>
                                    </div>
                                    <div class="letter-row__actions">
                                        <a href="{{ route('administrasi.surat.edit', $item) }}" class="action-pill">Detail</a>
                                        @if ($item->file_path)
                                            <a href="{{ $item->file_url }}" target="_blank" class="action-pill action-pill--primary">Lampiran</a>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="px-6 py-10 text-center text-sm text-brand-ink/60">Belum ada surat terbaru yang dapat ditampilkan.</li>
                            @endforelse
                        </ul>
                    </div>
                </section>

                {{-- Quick Actions --}}
                <section id="actions" class="bg-white/90 border-t border-brand-light py-12">
                    <div class="max-w-7xl mx-auto px-6 space-y-8">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <p class="section-eyebrow">Aksi Cepat</p>
                                <h2 class="section-title">Navigasi aktivitas utama</h2>
                            </div>
                            <div class="pill-indicator">Tersinkron dengan modul surat</div>
                        </div>
                        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                            <a href="{{ route('administrasi.surat.index') }}" class="action-card">
                                <div>
                                    <span class="action-card__icon">📚</span>
                                    <h3 class="action-card__title">Kelola seluruh surat</h3>
                                    <p class="action-card__desc">Lihat, sortir, dan pantau status dokumen resmi</p>
                                </div>
                                <span class="action-card__chevron">→</span>
                            </a>
                            <a href="{{ route('administrasi.surat.create') }}" class="action-card action-card--primary">
                                <div>
                                    <span class="action-card__icon">⬆️</span>
                                    <h3 class="action-card__title">Unggah surat baru</h3>
                                    <p class="action-card__desc">Tambahkan surat masuk lengkap dengan atributnya</p>
                                </div>
                                <span class="action-card__chevron">→</span>
                            </a>
                            <a href="{{ route('administrasi.surat.index', ['show_guest' => 1]) }}" class="action-card">
                                <div>
                                    <span class="action-card__icon">🤝</span>
                                    <h3 class="action-card__title">Surat dari tamu</h3>
                                    <p class="action-card__desc">Fokuskan perhatian pada surat eksternal terbaru</p>
                                </div>
                                <span class="action-card__chevron">→</span>
                            </a>
                        </div>
                    </div>
                </section>
            </main>
        </div>

        <script>
            window.dashboardData = @json([
                'monthlyCounts' => $monthlyCounts,
                'suratByJenis' => $suratByJenis->take(5),
                'originDataset' => $originDataset,
            ]);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </body>
</html>
