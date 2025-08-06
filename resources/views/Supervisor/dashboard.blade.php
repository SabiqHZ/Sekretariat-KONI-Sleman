@extends('layouts.app')

@section('title', 'Dashboard Supervisor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Dashboard -->
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Supervisor</h1>
        <p class="text-gray-600 mt-2">Mode View-Only - Hanya dapat melihat data</p>
    </div>

    <!-- Card Navigasi -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Administrasi -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-blue-100 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Administrasi</h2>
            </div>
            <p class="text-gray-600 mb-4">Lihat data surat dan dokumen administrasi</p>
            <button onclick="window.location.href='{{ route('administrasi.surat.index') }}'" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Data
            </a>
        </div>

        <!-- Card Keuangan -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-green-100 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Keuangan</h2>
            </div>
            <p class="text-gray-600 mb-4">Lihat data surat dan dokumen Keuangan</p>
            <button onclick="window.location.href='{{ route('keuangan.dashboard') }}'" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Data
            </a>
        </div>

        <!-- Card Aset -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-purple-100 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Aset dan Perlengkapan</h2>
            </div>
            <p class="text-gray-600 mb-4">Lihat data surat dan dokumen Aset dan Perlengkapan</p>
            <button onclick="window.location.href='{{ route('aset.dashboard') }}'" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Data
            </a>
        </div>
    </div>

    <!-- Notifikasi Khusus Supervisor -->
    <div class="mt-8 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm">
                    Anda login sebagai <strong>Supervisor</strong>. Role ini hanya memiliki akses view-only.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection