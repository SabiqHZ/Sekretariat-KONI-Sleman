@extends('layouts.app')
@section('title','Daftar Surat')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header Section - Centered -->
    <div class="w-full px-4">
        <div class="max-w-4xl mx-auto text-center mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">
                Daftar Surat
            </h1>
            <p class="text-gray-600 text-lg">Kelola dan monitor semua surat administrasi dengan mudah</p>
        </div>

        <!-- Success Alert -->
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if(session('success'))
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session('success') }}',
                            confirmButtonText: 'OK'
                        });
                    @endif
                });
            </script>
        @endpush

      <!-- Filter Section - Revisi untuk alignment yang sempurna -->
<div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 mb-8">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <!-- Header Filter -->
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-800">Filter & Pencarian</h3>
        </div>
        
        <!-- Action Buttons -->
        @if(auth()->user()->role === 'administrasi')
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="button" onclick="location.href='{{ route('administrasi.surat.create') }}'"
                class="flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-lg hover:from-emerald-600 hover:to-teal-700 transition-all text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Upload Surat
            </button>
            
            <button type="button" onclick="location.href='{{ route('administrasi.jenis-surat.create') }}'"
                class="flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-emerald-700 transition-all text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Jenis
            </button>
        </div>
        @endif
    </div>
    <!-- Form Filter - Revisi untuk alignment sempurna -->
    <form method="GET" action="{{ route('administrasi.surat.index') }}" class="space-y-4 md:space-y-0">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari pengirim/nomor surat..."
                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                </div>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sortir</label>
                <select name="sort"
                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                    <option value="">Pilih Sorting</option>
                    <option value="tanggal_surat" {{ request('sort') == 'tanggal_surat' ? 'selected' : '' }}>Tanggal Surat</option>
                    <option value="tanggal_masuk" {{ request('sort') == 'tanggal_masuk' ? 'selected' : '' }}>Tanggal Masuk</option>
                    <option value="jenis_surat_id" {{ request('sort') == 'jenis_surat_id' ? 'selected' : '' }}>Jenis Surat</option>
                    <option value="pengirim" {{ request('sort') == 'pengirim' ? 'selected' : '' }}>Pengirim</option>
                    <option value="nomor_surat" {{ request('sort') == 'nomor_surat' ? 'selected' : '' }}>Nomor Surat</option>
                </select>
            </div>

            <!-- Order -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                <select name="order"
                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Naik (A-Z)</option>
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Turun (Z-A)</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                    class="w-30 md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Terapkan
                </button>
            </div>
        </div>
    </form>
</div>
    <!-- Tabel -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-1"></div>

        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">
                            Nomor Surat
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">
                            Jenis Surat
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">
                            Pengirim
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">
                            Tanggal Surat
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">
                            Tanggal Masuk
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">
                            Keterangan
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 border-b border-gray-200">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($surat as $s)
                            <tr class="@if(isset($s->is_from_guest) && $s->is_from_guest) guest-row @endif transition-colors duration-200 hover:bg-blue-50/50">
                             <!-- Kolom-kolom tabel -->
                                <!-- Nomor Surat -->
                                <td class="px-6 py-4 text-sm font-medium {{ isset($s->is_from_guest) && $s->is_from_guest ? 'text-orange-900' : 'text-gray-900' }}">
                                    {{ $s->nomor_surat }}
                                </td>
                                
                                <!-- Jenis Surat -->
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ isset($s->is_from_guest) && $s->is_from_guest ? 'bg-orange-100 text-orange-800 border border-orange-200' : 'bg-blue-100 text-blue-800' }}">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $s->jenis->nama_jenis_surat }}
                                        @if(isset($s->is_from_guest) && $s->is_from_guest)
                                            <span class="ml-1 px-1.5 py-0.5 bg-orange-200 text-orange-900 rounded text-xs font-bold">GUEST</span>
                                        @endif
                                    </span>
                                </td>
                                
                                <!-- Pengirim -->
                                <td class="px-6 py-4 text-sm {{ isset($s->is_from_guest) && $s->is_from_guest ? 'text-orange-800 font-medium' : 'text-gray-700' }}">
                                    {{ $s->Pengirim }}
                                </td>
                                
                                <!-- Tanggal Surat -->
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @if($s->tanggal_surat)
                                        {{ $s->tanggal_surat->format('d-M-Y') }}
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                
                                <!-- Tanggal Masuk -->
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @if($s->tanggal_masuk)
                                    {{ $s->tanggal_masuk->format('d-M-Y') }}
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                
                                <!-- Keterangan -->
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">
                                    @if($s->Keterangan)
                                        @php
                                            $words = str_split($s->Keterangan, 25);
                                        @endphp
                                        @foreach($words as $word)
                                            <div>{{ $word }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <!-- Aksi -->
                                <td class="px-6 py-4 text-sm text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        @if($s->file_path)
                                            <a href="{{ Storage::url($s->file_path) }}" target="_blank"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                PDF
                                            </a>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-10 text-gray-500 rounded-lg hover:bg-gray-150 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Empty
                                            </span>
                                        @endif
                                        @if(auth()->user()->role === 'administrasi')
                                        <!-- Edit -->
                                        <a href="{{ route('administrasi.surat.edit',$s) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        
                                        <!-- PDF -->
                                        <!-- Hapus -->
                                        <form action="{{ route('administrasi.surat.destroy',$s) }}" method="POST" class="inline delete-form">
                                            @csrf @method('DELETE')
                                            <button type="button" class="delete-btn inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200"
                                                    data-surat-jenissurat="{{ $s->jenis->nama_jenis_surat }}"
                                                    data-surat-pengirim="{{ $s->Pengirim }}">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
       <div class="flex justify-between mb-4">
    <button onclick="window.location.href='{{ route('surat.export') }}'"
            class="flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-lg hover:from-emerald-600 hover:to-teal-700 transition-all text-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
        Export Excel
    </button>
</div>
        <!-- Pagination -->
        @if($surat->hasPages())
            <div class="mt-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-4">
                    {{ $surat->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            //Delete confirmation
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const form = this.closest('.delete-form');
                    const jenissurat = this.getAttribute('data-surat-jenissurat');
                    const pengirim = this.getAttribute('data-surat-pengirim');
                    
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        html: `
                            <div class="text-left">
                                <p class="mb-2"><strong>Jenis Surat:</strong> ${jenissurat}</p>
                                <p><strong>Pengirim:</strong> ${pengirim}</p>
                            </div>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush

@endsection