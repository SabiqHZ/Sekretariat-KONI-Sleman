@extends('layouts.app')
@section('title','Kirim Surat')
@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Tombol Batal di Kiri Atas -->
        <div class="flex justify-start mb-6">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                Kirim Surat
            </h1>
            <p class="text-gray-600">Lengkapi form berikut untuk mengirim surat administrasi</p>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2"></div>
            
            <form action="{{ route('guest.surat.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Nomor Surat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                Nomor Surat
                            </span>
                        </label>
                        <input type="text" name="nomor_surat" 
                               class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" 
                               placeholder="Contoh: 001/ADM/2024">
                    </div>

                    <!-- Email Guest -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                                Nama Pengirim
                            </span>
                        </label>
                        <input type="text" name="guest_name" 
                               class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" 
                               placeholder="Nama lengkap Anda">
                    </div>

                    <!-- Tanggal Surat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal Surat
                            </span>
                        </label>
                        <div class="relative">
                            <input type="date" name="tanggal_surat" 
                                   class="w-full border-2 border-gray-200 rounded-xl p-3 pr-12 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 cursor-pointer bg-white">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pengirim -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Instansi Pengirim
                            </span>
                        </label>
                        <input type="text" name="pengirim" 
                               class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" 
                               placeholder="Nama instansi atau perorangan">
                    </div>

                        <!-- Jenis Surat -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a.997.997 0 01-1.414 0l-7-7A1.997 1.997 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Jenis Surat
                                </span>
                            </label>
                            <select name="jenis_surat_id" class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                                <option value="">Pilih Jenis Surat</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->nama_jenis_surat }}</option>
                                @endforeach
                            </select>
                        </div>

                    <!-- Keterangan -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Keterangan
                            </span>
                        </label>
                        <textarea name="keterangan" rows="4" 
                                  class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none" 
                                  placeholder="Deskripsi singkat tentang isi surat..."></textarea>
                    </div>

                    <!-- Upload File -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Upload PDF (wajib)
                            </span>
                        </label>
                <div class="max-w-md mx-auto">
                    <!-- File Upload dengan Drag & Drop -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Upload Dokumen <span class="text-red-500">*</span></label>
                        
                        <div class="relative" id="drop-zone">
                            <!-- Input file yang tersembunyi (required) -->
                            <input type="file" id="file-upload" name="file" accept="application/pdf"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            
                            <!-- Tampilan custom -->
                            <div class="flex items-center border border-gray-300 rounded-md bg-white hover:bg-gray-50 transition-colors">
                                <!-- Tombol -->
                                <div class="px-4 py-2 bg-gray-100 border-r border-gray-300 text-sm font-medium text-gray-700 rounded-l-md">
                                    Pilih File
                                </div>
                                
                                <!-- Nama file -->
                                <div class="px-3 py-2 text-sm text-gray-500 truncate flex-1" id="file-name-display">
                                    Tidak ada file dipilih
                                </div>
                            </div>
                        </div>
                        
                        <!-- Info format file -->
                        <p class="text-xs text-gray-500">
                            Seret file PDF ke sini atau klik untuk memilih (maks. 10MB)
                        </p>
                        
                        <!-- Preview file dengan tombol hapus -->
                        <div id="file-preview" class="hidden mt-2">
                            <div class="flex items-center justify-between p-2 bg-blue-50 rounded text-sm text-blue-800">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span id="selected-file-name"></span>
                                </div>
                                <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        <!-- Action Buttons -->
        <div class="flex justify-center mt-8 pt-6 border-t border-gray-200">
            <button type="submit" id="submit-button"
                    class="bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 px-8 rounded-xl hover:from-blue-600 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Kirim Surat
                </span>
            </button>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50/50 backdrop-blur-sm rounded-xl p-6 border border-blue-100">
            <h3 class="font-semibold text-blue-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Tips Pengisian Form
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
                <div class="flex items-start">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span>Pastikan nomor surat mengikuti format standar</span>
                </div>
                <div class="flex items-start">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span>Email akan digunakan untuk notifikasi status surat</span>
                </div>
                <div class="flex items-start">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span>File PDF harus dilampirkan sebelum mengirim</span>
                </div>
                <div class="flex items-start">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <span>Keterangan sebaiknya singkat namun informatif</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-upload');
    const dropZone = document.getElementById('drop-zone');
    const fileNameDisplay = document.getElementById('file-name-display');
    const filePreview = document.getElementById('file-preview');
    const selectedFileName = document.getElementById('selected-file-name');
    const form = document.querySelector('form');
    const submitButton = document.getElementById('submit-button');

        // Nonaktifkan validasi HTML5 default
    form.setAttribute('novalidate', '');

        // Tambahkan event listener untuk tombol hapus
    document.getElementById('remove-file').addEventListener('click', function() {
        resetFileInput();
    });

    function resetFileInput() {
        fileInput.value = '';
        fileNameDisplay.textContent = 'Tidak ada file dipilih';
        fileNameDisplay.classList.add('text-gray-500');
        fileNameDisplay.classList.remove('text-gray-700', 'font-medium');
        filePreview.classList.add('hidden');
        
        // Tampilkan notifikasi bahwa file dihapus (opsional)
        Swal.fire({
            icon: 'info',
            title: 'File dihapus',
            text: 'Anda dapat memilih file baru',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3B82F6',
            timer: 2000
        });
    }
    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            validateAndDisplayFile(e.target.files[0]);
        }
    });

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    dropZone.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            validateAndDisplayFile(files[0]);
        }
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        if (!fileInput.files.length) {
            e.preventDefault();
            showError('File wajib diupload', 'Silakan pilih file PDF sebelum mengirim');
            return;
        }

        const file = fileInput.files[0];
        if (file.type !== 'application/pdf') {
            e.preventDefault();
            showError('Format file tidak valid', 'Hanya file PDF yang diperbolehkan');
            return;
        }

        if (file.size > 10 * 1024 * 1024) { // 10MB
            e.preventDefault();
            showError('File terlalu besar', 'Ukuran file maksimal 10MB');
            return;
        }

        // Jika validasi lolos, form akan submit
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengirim...
            </span>
        `;
    });

    function validateAndDisplayFile(file) {
        // Validasi tipe file
        if (file.type !== 'application/pdf') {
            showError('Format file tidak valid', 'Hanya file PDF yang diperbolehkan');
            resetFileInput();
            return;
        }

        // Validasi ukuran file
        if (file.size > 10 * 1024 * 1024) { // 10MB
            showError('File terlalu besar', 'Ukuran file maksimal 10MB');
            resetFileInput();
            return;
        }

        // Jika validasi lolos, tampilkan file
        selectedFileName.textContent = file.name;
        fileNameDisplay.textContent = file.name;
        fileNameDisplay.classList.remove('text-gray-500');
        fileNameDisplay.classList.add('text-gray-700', 'font-medium');
        filePreview.classList.remove('hidden');
    }

    function resetFileInput() {
        fileInput.value = '';
        fileNameDisplay.textContent = 'Tidak ada file dipilih';
        fileNameDisplay.classList.add('text-gray-500');
        fileNameDisplay.classList.remove('text-gray-700', 'font-medium');
        filePreview.classList.add('hidden');
    }

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        dropZone.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50');
    }

    function unhighlight() {
        dropZone.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50');
    }

    function showError(title, text) {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#3B82F6'
        });
    }

    // Notifikasi sukses dari server
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3B82F6'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: '{!! implode('<br>', $errors->all()) !!}',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#3B82F6'
        });
    @endif
});
</script>
@endsection