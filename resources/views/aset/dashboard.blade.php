@extends('layouts.app')

@section('title', 'Dashboard Aset')

@section('header')
<div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </div>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __('Selamat datang, Aset dan Perlengkapan!') }}
            </div>
        </div>
    </div>
</div>
@endsection
