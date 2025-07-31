@extends('layouts.app')

@section('title', 'Dashboard Keuangan')

@section('header')
<div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </div>
    
    <!-- Profile Dropdown -->
    <div class="relative">
        <div class="flex items-center">
            <!-- Profile Button -->
            <button id="profileButton" class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-md transition duration-150 ease-in-out">
                <!-- User Icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="hidden md:block">{{ Auth::user()->name }}</span>
                <!-- Dropdown Arrow -->
                <svg class="w-4 h-4 transition-transform duration-200" id="dropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <!-- Dropdown Menu -->
        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
            <div class="py-1">
                <!-- Profile Info -->
                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 font-semibold uppercase">{{ Auth::user()->role }}</p>
                </div>
                
                <!-- Profile Link -->
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Edit Profile
                </a>
                
                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Dropdown Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileButton = document.getElementById('profileButton');
    const profileDropdown = document.getElementById('profileDropdown');
    const dropdownArrow = document.getElementById('dropdownArrow');

    // Toggle dropdown
    profileButton.addEventListener('click', function(e) {
        e.stopPropagation();
        const isHidden = profileDropdown.classList.contains('hidden');
        
        if (isHidden) {
            profileDropdown.classList.remove('hidden');
            dropdownArrow.style.transform = 'rotate(180deg)';
        } else {
            profileDropdown.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    });

    // Close dropdown when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            profileDropdown.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    });
});
</script>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("Selamat datang, Keuangan!") }}
            </div>
        </div>
    </div>
</div>
@endsection