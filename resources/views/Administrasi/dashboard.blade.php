<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Administrasi - KONI Sleman</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600&family=Lato:wght@400;700&family=Questrial&display=swap" rel="stylesheet">

    {{-- Styles & Scripts --}}
    @vite([
    'resources/js/dashboard-admin.js',
    'resources/css/dashboard-admin-layout.css',
    'resources/css/dashboard-admin-components.css',
    'resources/css/dashboard-admin-responsive.css',
    ])
</head>

<body>
    <header>
        <div class="header-left">
            <img src="{{ asset('images/koni-logo.png') }}" alt="KONI Sleman" class="header-logo">
            <h1>Dashboard Administrasi</h1>
        </div>

        <nav>
            <button class="btn" onclick="scrollToSection('overview')">Overview</button>

            <div class="nav-actions">
                {{-- Upload Surat --}}
                <button
                    type="button"
                    id="openUploadCard"
                    class="btn-admin header-cta-upload">
                    Upload Surat
                </button>

                {{-- Tambah Jenis Surat --}}
                <button type="button" id="openJenisCard" class="header-cta-jenis">
                    <svg class="header-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Kelola Jenis</span>
                </button>


                {{-- Profile --}}
                <div class="profile-dropdown">
                    <button class="profile-button" id="profileButton" type="button">
                        <svg class="profile-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                            </path>
                        </svg>
                    </button>

                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            <span>Edit Profile</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="dropdown-form">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-item-danger">
                                <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        {{-- Stats --}}
        <section class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-info">
                                <h3>Total Surat</h3>
                                <p class="stat-number" id="statTotal">{{ $totalSurat ?? 0 }}</p>
                                <p class="stat-desc">Semua surat dalam sistem</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-info">
                                <h3>Surat Masuk</h3>
                                <p class="stat-number" id="statGuest">{{ $suratFromGuest ?? 0 }}</p>
                                <p class="stat-desc">Surat yang dikirim oleh guest/pengunjung</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-info">
                                <h3>Menunggu Diproses</h3>
                                <p class="stat-number" id="statPending">0</p>
                                <p class="stat-desc">Masih menunggu tindak lanjut</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Recent Letters Table --}}
        <section id="recent-letters" class="table-section">
            <div class="container">
                <div class="table-wrapper">
                    <div class="table-header">
                        <div>
                            <h3>Surat Terbaru</h3>
                            <p>Ringkasan surat yang terakhir diinput ke dalam sistem</p>
                        </div>

                        <div class="table-actions">
                            {{-- FILTER --}}
                            <div class="table-filters">
                                <div class="search-input">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z">
                                        </path>
                                    </svg>
                                    <input
                                        type="text"
                                        id="tableSearch"
                                        placeholder="Cari nomor surat / pengirim / perihal..." />
                                </div>

                                <div class="status-filter">
                                    <select id="statusFilter">
                                        <option value="">Semua status</option>
                                        <option value="menunggu">Menunggu</option>
                                        <option value="diproses">Proses</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                </div>
                            </div>

                            {{-- URUTKAN --}}
                            <div class="table-sort">
                                <select id="sortOrder">
                                    <option value="tanggal_masuk_desc">Tgl masuk: terbaru</option>
                                    <option value="tanggal_masuk_asc">Tgl masuk: terlama</option>
                                    <option value="status_asc">Status (A–Z)</option>
                                    <option value="status_desc">Status (Z–A)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="dashboard-table" id="suratTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat</th>
                                    <th>Email Pengirim</th>
                                    <th>Instansi Pengirim</th>
                                    <th>Jenis</th>
                                    <th>Tgl Surat</th>
                                    <th>Tgl Masuk</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSurat ?? [] as $surat)
                                @php
                                $status = strtolower((string)($surat->status ?? 'menunggu'));
                                $statusClass = match ($status) {
                                'diproses' => 'badge-info',
                                'selesai' => 'badge-success',
                                default => 'badge-warning',
                                };
                                @endphp

                                <tr
                                    data-id="{{ $surat->id }}"
                                    data-status="{{ $status }}"
                                    data-is-guest="{{ $surat->is_from_guest ? '1' : '0' }}"
                                    data-tanggal-masuk="{{ optional($surat->tanggal_masuk)->format('Y-m-d') }}"
                                    data-status-url="{{ route('administrasi.surat.update-status', $surat) }}">
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="text-mono">
                                        {{ $surat->nomor_surat ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $surat->is_from_guest
            ? ($surat->guest_email ?? 'Guest')
            : ($surat->guest_email ?? '-') }}
                                    </td>

                                    <td>
                                        {{ $surat->instansi_pengirim ?? '-' }}
                                    </td>

                                    <td class="text-muted">
                                        {{ optional($surat->jenis)->nama_jenis_surat ?? '-' }}
                                    </td>

                                    <td>
                                        {{ optional($surat->tanggal_surat)->format('Y-m-d') ?? '-' }}
                                    </td>

                                    <td>
                                        {{ optional($surat->tanggal_masuk)->format('Y-m-d') ?? '-' }}
                                    </td>

                                    <td>
                                        <span
                                            class="badge {{ $statusClass }} status-badge"
                                            data-status-badge="{{ $status }}">
                                            {{ $status === 'diproses' ? 'Proses' : ucfirst($status) }}
                                        </span>
                                    </td>

                                    <td class="table-actions-cell">
                                        <button
                                            type="button"
                                            class="table-detail-toggle"
                                            data-pdf-url="{{ $surat->file_path ? Storage::url($surat->file_path) : '' }}"
                                            data-has-file="{{ $surat->file_path ? '1' : '0' }}"
                                            data-update-url="{{ route('administrasi.surat.update', $surat) }}"
                                            data-delete-url="{{ route('administrasi.surat.destroy', $surat) }}"
                                            data-jenis-id="{{ $surat->jenis_surat_id }}"
                                            data-nomor="{{ $surat->nomor_surat }}"
                                            data-tanggal-surat="{{ optional($surat->tanggal_surat)->format('Y-m-d') }}"
                                            data-tanggal-masuk="{{ optional($surat->tanggal_masuk)->format('Y-m-d') }}"
                                            data-instansi-pengirim="{{ $surat->is_from_guest ? ($surat->guest_email ?? 'Guest') : ($surat->instansi_pengirim ?? '-') }}"
                                            data-keterangan="{{ e($surat->keterangan) }}">
                                            Detail
                                            <span class="table-detail-toggle-caret">▾</span>
                                        </button>
                                    </td>
                                </tr>

                                @empty
                                <tr class="table-empty-row">
                                    <td colspan="8" class="empty-state">
                                        Belum ada surat terbaru yang dapat ditampilkan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        @if($recentSurat->hasPages())
                        <div class="pagination-wrapper">
                            <div class="pagination-info">
                                Menampilkan {{ $recentSurat->firstItem() ?? 0 }} - {{ $recentSurat->lastItem() ?? 0 }}
                                dari {{ $recentSurat->total() }} surat
                            </div>

                            <div class="pagination-controls">
                                {{-- Previous Button --}}
                                @if($recentSurat->onFirstPage())
                                <button class="pagination-btn" disabled>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Sebelumnya
                                </button>
                                @else
                                <a href="{{ $recentSurat->previousPageUrl() }}" class="pagination-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Sebelumnya
                                </a>
                                @endif

                                {{-- Page Numbers --}}
                                <div class="pagination-numbers">
                                    @foreach($recentSurat->getUrlRange(1, $recentSurat->lastPage()) as $page => $url)
                                    @if($page == $recentSurat->currentPage())
                                    <span class="pagination-number active">{{ $page }}</span>
                                    @else
                                    <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                                    @endif
                                    @endforeach
                                </div>

                                {{-- Next Button --}}
                                @if($recentSurat->hasMorePages())
                                <a href="{{ $recentSurat->nextPageUrl() }}" class="pagination-btn">
                                    Selanjutnya
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                @else
                                <button class="pagination-btn" disabled>
                                    Selanjutnya
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        {{-- Tambah / Kelola Jenis Surat Modal --}}
        <div id="jenisOverlay" class="upload-overlay">
            <div class="upload-card">
                <button type="button" id="closeJenisCard" class="upload-close-btn">&times;</button>

                <div class="upload-card-inner">
                    <div class="upload-card-header">
                        <h3>Kelola Jenis Surat</h3>
                        <p>Lihat, tambah, dan hapus jenis surat tanpa meninggalkan halaman</p>
                    </div>

                    <div class="jenis-grid">
                        {{-- LIST JENIS SURAT YANG SUDAH ADA --}}
                        <div class="jenis-list">
                            <h4>Daftar Jenis Surat</h4>

                            @if($types->count())
                            <div class="jenis-list-table">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;">No</th>
                                            <th>Nama Jenis Surat</th>
                                            <th style="width: 90px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($types as $jenis)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jenis->nama_jenis_surat }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('administrasi.jenis-surat.destroy', $jenis) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus jenis surat ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-jenis-delete">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="upload-file-hint">Belum ada jenis surat yang terdaftar.</p>
                            @endif
                        </div>

                        {{-- FORM TAMBAH JENIS SURAT (TETAP ADA) --}}
                        <div class="jenis-form">
                            <h4>Tambah Jenis Baru</h4>

                            <form action="{{ route('administrasi.jenis-surat.store') }}" method="POST">
                                @csrf

                                <div class="upload-form-group full">
                                    <label for="nama_jenis_surat" class="upload-label">Jenis Surat</label>
                                    <input
                                        type="text"
                                        name="nama_jenis_surat"
                                        id="nama_jenis_surat"
                                        class="upload-input"
                                        value="{{ old('nama_jenis_surat') }}"
                                        required>
                                    @error('nama_jenis_surat')
                                    <p class="upload-error-text">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="upload-actions">
                                    <button type="button" class="upload-cancel-btn" id="cancelJenisBtn">
                                        Batal
                                    </button>
                                    <button type="submit" class="upload-submit-btn">
                                        Simpan Jenis Surat
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Dropdown global tombol Detail --}}
        <div id="detailDropdown" class="detail-dropdown">
            <button
                type="button"
                id="detailActionPdf"
                class="detail-dropdown-item">
                PDF
            </button>

            @if(optional(auth()->user())->role === 'administrasi')
            <button
                type="button"
                id="detailActionEdit"
                class="detail-dropdown-item">
                Edit
            </button>


            @endif
        </div>

        {{-- Form delete global --}}
        <form id="detailDeleteForm" method="POST" style="display:none">
            @csrf
            @method('DELETE')
        </form>

        {{-- Edit Surat Modal --}}
        <div id="editOverlay" class="upload-overlay">
            <div class="upload-card">
                <button type="button" id="closeEditCard" class="upload-close-btn">&times;</button>

                <div class="upload-card-inner">
                    <div class="upload-card-header">
                        <h3>Edit Surat</h3>
                        <p>Perbarui data surat tanpa meninggalkan halaman</p>
                    </div>

                    <form id="editSuratForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="upload-form-grid">
                            <div class="upload-form-group full">
                                <label class="upload-label">Jenis Surat</label>
                                <select name="jenis_surat_id" id="edit-jenis-surat" class="upload-input">
                                    <option value="">Pilih jenis surat</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->nama_jenis_surat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="upload-form-group">
                                <label class="upload-label">Nomor Surat</label>
                                <input type="text" name="nomor_surat" id="edit-nomor-surat" class="upload-input">
                            </div>

                            <div class="upload-form-group">
                                <label class="upload-label">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" id="edit-tanggal-surat" class="upload-input">
                            </div>

                            <div class="upload-form-group">
                                <label class="upload-label">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" id="edit-tanggal-masuk" class="upload-input">
                            </div>
                            <div class="upload-form-group">
                                <label class="upload-label">Instansi Pengirim</label>
                                <input type="text" name="instansi_pengirim" id="edit-instansi-pengirim" class="upload-input">
                            </div>

                            <div class="upload-form-group full">
                                <label class="upload-label">Keterangan</label>
                                <textarea
                                    name="keterangan"
                                    id="edit-keterangan"
                                    rows="3"
                                    class="upload-textarea"></textarea>
                            </div>

                            <div class="upload-form-group full">
                                <label class="upload-label">Ganti Lampiran PDF (opsional)</label>
                                <input
                                    type="file"
                                    name="file"
                                    accept="application/pdf"
                                    class="upload-input">
                                <p class="upload-file-hint">
                                    Kosongkan jika tidak ingin mengubah file.
                                </p>
                            </div>
                        </div>

                        <div class="upload-actions">
                            <button type="submit" class="upload-submit-btn">
                                Update Surat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Upload Surat Modal --}}
        <div id="uploadOverlay" class="upload-overlay">
            <div class="upload-card">
                <button type="button" id="closeUploadCard" class="upload-close-btn">&times;</button>

                <div class="upload-card-inner">
                    <div class="upload-card-header">
                        <h3>Tambah Surat Baru</h3>
                        <p>Isi data berikut untuk menambahkan surat ke dalam sistem</p>
                    </div>

                    <form
                        action="{{ route('administrasi.surat.store') }}"
                        method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="upload-form-grid">
                            <div class="upload-form-group full">
                                <label class="upload-label">Jenis Surat</label>
                                <select name="jenis_surat_id" class="upload-input">
                                    <option value="">Pilih jenis surat</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->nama_jenis_surat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="upload-form-group">
                                <label class="upload-label">Nomor Surat</label>
                                <input
                                    type="text"
                                    name="nomor_surat"
                                    class="upload-input"
                                    placeholder="Contoh: 001/ADM/2024"
                                    required>
                            </div>

                            <div class="upload-form-group">
                                <label class="upload-label">Tanggal Surat</label>
                                <input
                                    type="date"
                                    name="tanggal_surat"
                                    class="upload-input"
                                    required>
                            </div>

                            <div class="upload-form-group">
                                <label class="upload-label">Tanggal Masuk</label>
                                <input
                                    type="date"
                                    name="tanggal_masuk"
                                    class="upload-input"
                                    required>
                            </div>

                            <div class="upload-form-group">
                                <label class="upload-label">Instansi Pengirim</label>
                                <input
                                    type="text"
                                    name="instansi_pengirim"
                                    class="upload-input"
                                    placeholder="Nama instansi atau perorangan"
                                    required>
                            </div>

                            <div class="upload-form-group full">
                                <label class="upload-label">Keterangan</label>
                                <textarea
                                    name="keterangan"
                                    rows="3"
                                    class="upload-textarea"
                                    placeholder="Deskripsi singkat isi surat..."></textarea>
                            </div>

                            <div class="upload-form-group full">
                                <label class="upload-label">Lampiran PDF (opsional)</label>

                                <div class="upload-file-box">
                                    <input
                                        type="file"
                                        id="admin-file-upload"
                                        name="file"
                                        accept="application/pdf"
                                        class="upload-file-input">

                                    <div class="upload-file-display" id="admin-drop-zone">
                                        <span class="upload-file-button">Pilih File</span>
                                        <span class="upload-file-name" id="admin-file-name-display">
                                            Tidak ada file dipilih
                                        </span>
                                    </div>

                                    <p class="upload-file-hint">
                                        Format PDF, maksimal 10MB.
                                    </p>

                                    <div id="admin-file-preview" class="upload-file-preview">
                                        File terpilih:
                                        <span id="admin-selected-file-name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="upload-actions">
                            <button type="submit" class="upload-submit-btn">
                                Simpan Surat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>