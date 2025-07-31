@extends('layouts.app')

@section('title', 'Dashboard Administrasi')

@section('header')
<div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </div>
    <a href="{{ route('administrasi.surat.index') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
        Lihat Surat
    </a>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("Selamat datang, Administrasi!") }}
            </div>
            <div class="mt-4 bg-blue-100 p-4 rounded text-blue-800 font-semibold">
    Total Surat: {{ $totalSurat }}
            </div>
        </div>
    </div>
</div>
@endsection
