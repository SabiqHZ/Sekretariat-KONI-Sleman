<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kirim Surat - Sekretariat KONI Sleman</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600&family=Lato:wght@400;700&family=Questrial&display=swap" rel="stylesheet">

    {{-- CSS --}}
    @vite(['resources/css/kirim-surat.css'])
</head>

<body>
    {{-- Header --}}
    <header class="main-header">
        <img src="{{ asset('images/koni1.png') }}" alt="KONI Sleman" class="header-logo">
    </header>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="container">
            <!-- Tombol Kembali -->
            <div class="back-button-wrapper">
                <a href="{{ url('/') }}" class="back-button">
                    Kembali
                </a>
            </div>

            <!-- Header Section -->
            <div class="page-header">
                <div class="page-header-icon">
                    <svg class="icon-lg" fill="none" stroke="#eb5120" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                <h1 class="page-title">Kirim Surat</h1>
                <p class="page-subtitle">Lengkapi form berikut untuk mengirim surat administrasi</p>
            </div>

            <!-- Main Form Card -->
            <div class="form-card">
                <div class="form-card-accent"></div>

                <form action="{{ route('guest.surat.store') }}" method="POST" enctype="multipart/form-data" class="form-content">
                    @csrf

                    <div class="form-grid">
                        <!-- Nomor Surat -->
                        <div class="form-group">
                            <label class="form-label">
                                <span class="label-wrapper">
                                    <svg class="icon-xs icon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    Nomor Surat
                                </span>
                            </label>
                            <input type="text" name="nomor_surat" class="form-input" placeholder="Contoh: 001/ADM/2024">
                        </div>

                        <!-- Nama Pengirim -->
                        <div class="form-group">
                            <label class="form-label">
                                <span class="label-wrapper">
                                    <svg class="icon-xs icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                    Nama Pengirim
                                </span>
                            </label>
                            <input type="text" name="guest_name" class="form-input" placeholder="Nama lengkap Anda">
                        </div>

                        <!-- Tanggal Surat -->
                        <div class="form-group">
                            <label class="form-label">
                                <span class="label-wrapper">
                                    <svg class="icon-xs icon-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Tanggal Surat
                                </span>
                            </label>
                            <div class="date-input-wrapper">
                                <input type="date" name="tanggal_surat" class="form-input form-input-date">

                            </div>
                        </div>

                        <!-- Instansi Pengirim -->
                        <div class="form-group">
                            <label class="form-label">
                                <span class="label-wrapper">
                                    <svg class="icon-xs icon-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Instansi Pengirim
                                </span>
                            </label>
                            <input type="text" name="pengirim" class="form-input" placeholder="Nama instansi atau perorangan">
                        </div>

                        <!-- Jenis Surat -->
                        <div class="form-group form-group-full">
                            <label class="form-label">
                                <span class="label-wrapper">
                                    <svg class="icon-xs icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a.997.997 0 01-1.414 0l-7-7A1.997 1.997 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Jenis Surat
                                </span>
                            </label>
                            <select name="jenis_surat_id" class="form-select">
                                <option value="">Pilih Jenis Surat</option>
                                @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->nama_jenis_surat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group form-group-full">
                            <label class="form-label">
                                <span class="label-wrapper">
                                    <svg class="icon-xs icon-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Keterangan
                                </span>
                            </label>
                            <textarea name="keterangan" rows="4" class="form-textarea" placeholder="Deskripsi singkat tentang isi surat..."></textarea>
                        </div>

                        <!-- Upload File -->
                        <div class="form-group form-group-full">
                            <label class="form-label">
                                <span class="label-wrapper">
                                    <svg class="icon-xs icon-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Upload PDF (wajib)
                                </span>
                            </label>
                            <div class="upload-wrapper">
                                <div class="upload-container">
                                    <label class="upload-label">Upload Dokumen <span class="required">*</span></label>

                                    <div class="upload-zone" id="drop-zone">
                                        <input type="file" id="file-upload" name="file" accept="application/pdf" class="upload-input">

                                        <div class="upload-display">
                                            <div class="upload-button">Pilih File</div>
                                            <div class="upload-filename" id="file-name-display">Tidak ada file dipilih</div>
                                        </div>
                                    </div>

                                    <p class="upload-hint">Seret file PDF ke sini atau klik untuk memilih (maks. 10MB)</p>

                                    <div id="file-preview" class="file-preview">
                                        <div class="file-preview-content">
                                            <div class="file-preview-info">
                                                <svg class="icon-sm icon-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span id="selected-file-name"></span>
                                            </div>
                                            <button type="button" id="remove-file" class="file-remove-btn">
                                                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <button type="submit" id="submit-button" class="submit-button">
                            <span class="submit-button-content">
                                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim Surat
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Help Section -->
            <div class="help-section">
                <h3 class="help-title">
                    <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tips Pengisian Form
                </h3>
                <div class="help-grid">
                    <div class="help-item">
                        <span class="help-bullet"></span>
                        <span>Pastikan nomor surat mengikuti format standar</span>
                    </div>
                    <div class="help-item">
                        <span class="help-bullet"></span>
                        <span>Email akan digunakan untuk notifikasi status surat</span>
                    </div>
                    <div class="help-item">
                        <span class="help-bullet"></span>
                        <span>File PDF harus dilampirkan sebelum mengirim</span>
                    </div>
                    <div class="help-item">
                        <span class="help-bullet"></span>
                        <span>Keterangan sebaiknya singkat namun informatif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    @vite(['resources/js/kirim-surat.js'])
</body>

</html>