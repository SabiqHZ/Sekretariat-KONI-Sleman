@extends('layouts.app')

@section('title', 'Profile Settings')

@section('header')
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
            <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
        </div>
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Profile Settings</h1>
            <p class="text-gray-600">Manage your account details and security</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="space-y-6 max-w-3xl mx-auto">
        <!-- Profile Information Section -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <h2 class="text-lg font-semibold">Personal Information</h2>
            </div>
            
            <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('patch')

                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                        value="{{ old('name', $user->name) }}" 
                        
                        autofocus
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-primary">
                        <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Update Section -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-lg bg-green-50 text-green-600">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </div>
                <h2 class="text-lg font-semibold">Password & Security</h2>
            </div>
            
            <form method="post" action="{{ route('profile.password') }}" class="space-y-5">
                @csrf
                @method('patch')

                <div class="space-y-1">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <div class="relative">
                        <input 
                            id="current_password" 
                            name="current_password" 
                            type="password" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10" 
                            
                            autocomplete="current-password"
                        >
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white-400 hover:text-white-600" onclick="togglePassword('current_password')">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10" 
                            
                            autocomplete="new-password"
                        >
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('password')">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        <p class="flex items-center gap-1"><i data-lucide="check" class="w-3 h-3 text-green-500"></i> Minimum 8 characters</p>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10" 
                            
                            autocomplete="new-password"
                        >
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('password_confirmation')">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div id="password-match-feedback" class="mt-1 text-sm hidden">
                        <p class="flex items-center gap-1 text-green-600"><i data-lucide="check-circle" class="w-4 h-4"></i> Passwords match</p>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-primary">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Tips Section -->
        <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
            <div class="flex items-start gap-4">
                <div class="p-2 rounded-lg bg-blue-100 text-blue-600 flex-shrink-0">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 mb-3">Security Recommendations</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0"></i>
                            <span>Use a unique password for this account</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0"></i>
                            <span>Consider using a password manager</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0"></i>
                            <span>Enable two-factor authentication if available</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize icons
        if (window.lucide) {
            lucide.createIcons();
        }

        // Toggle password visibility
        window.togglePassword = function(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            
            if (window.lucide) {
                lucide.createIcons();
            }
        };

        // Validasi password match
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const feedback = document.getElementById('password-match-feedback');

        if (passwordInput && confirmInput) {
            confirmInput.addEventListener('input', function() {
                if (passwordInput.value && confirmInput.value) {
                    feedback.classList.remove('hidden');
                    
                    if (passwordInput.value === confirmInput.value) {
                        feedback.innerHTML = `
                            <p class="flex items-center gap-1 text-green-600">
                                <i data-lucide="check-circle" class="w-4 h-4"></i> Passwords match
                            </p>
                        `;
                    } else {
                        feedback.innerHTML = `
                            <p class="flex items-center gap-1 text-red-600">
                                <i data-lucide="x-circle" class="w-4 h-4"></i> Passwords don't match
                            </p>
                        `;
                    }
                    
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                } else {
                    feedback.classList.add('hidden');
                }
            });
        }

        // Form submission dengan validasi
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');

                // Cek kolom kosong
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                        showAlert('Error', 'Please fill in all required fields!', 'error');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                // Cek konfirmasi password (jika ada)
                if (passwordInput && confirmInput && passwordInput.value !== confirmInput.value) {
                    isValid = false;
                    showAlert('Error', 'Passwords do not match!', 'error');
                }

                if (!isValid) {
                    e.preventDefault(); // Hentikan submit jika tidak valid
                    return;
                }

                // Loading state jika form valid
                const button = form.querySelector('button[type="submit"]');
                if (button) {
                    const originalHTML = button.innerHTML;
                    button.innerHTML = `
                        <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i>
                        ${button.textContent.trim()}
                    `;
                    button.disabled = true;
                    
                    if (window.lucide) {
                        lucide.createIcons();
                    }

                    // Reset setelah 5 detik jika ada error
                    setTimeout(() => {
                        button.innerHTML = originalHTML;
                        button.disabled = false;
                        if (window.lucide) {
                            lucide.createIcons();
                        }
                    }, 5000);
                }
            });
        });

        // Fungsi SweetAlert untuk notifikasi
        window.showAlert = function(title, message, type) {
            Swal.fire({
                title: title,
                text: message,
                icon: type,
                confirmButtonColor: '#3b82f6',
                confirmButtonText: 'OK'
            });
        };

        // Notifikasi sukses dari session
        @if(session('status') === 'profile-updated')
            showAlert('Success', 'Profile updated successfully!', 'success');
        @endif
        
        @if(session('status') === 'password-updated')
            showAlert('Success', 'Password updated successfully!', 'success');
        @endif

        @if($errors->any())
            showAlert('Error', '{{ $errors->first() }}', 'error');
        @endif
    });
</script>
@endpush