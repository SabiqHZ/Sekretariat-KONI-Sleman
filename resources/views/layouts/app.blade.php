<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('title', config('app.name', 'Sekretariat KONI Sleman'))</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
            rel="stylesheet"
        />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: #1e3a8a;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* Header sama seperti homepage */
            header {
                background: rgba(30, 64, 175, 0.95);
                backdrop-filter: blur(10px);
                color: white;
                padding: 1rem 2rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }

            header h1 {
                font-size: 1.8rem;
                font-weight: bold;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }

            /* Navigation styling */
            nav {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            nav ul {
                display: flex;
                align-items: center;
                gap: 1rem;
                list-style: none;
                margin: 0;
                padding: 0;
            }

            nav a, nav button {
                background: linear-gradient(135deg, #3b82f6, #2563eb);
                color: white;
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 25px;
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 1rem;
                font-weight: 500;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            }

            nav a:hover, nav button:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                text-decoration: none;
            }

            /* Profile Dropdown */
            .profile-dropdown {
                position: relative;
            }

            .profile-button {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1rem;
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 25px;
                color: white;
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 0.95rem;
            }

            .profile-button:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-1px);
            }

            .dropdown-menu {
                display: none;
                position: absolute;
                right: 0;
                top: calc(100% + 0.5rem);
                min-width: 220px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-radius: 15px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                overflow: hidden;
                z-index: 1001;
            }

            .dropdown-menu.show {
                display: block;
            }

            .dropdown-header {
                padding: 1rem;
                border-bottom: 1px solid rgba(209, 213, 219, 0.3);
                background: rgba(59, 130, 246, 0.05);
            }

            .dropdown-header p {
                margin: 0;
                font-size: 0.9rem;
            }

            .dropdown-header .user-name {
                font-weight: 600;
                color: #374151;
            }

            .dropdown-header .user-email {
                color: #6b7280;
                font-size: 0.8rem;
            }

            .dropdown-header .user-role {
                color: #3b82f6;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .dropdown-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 1rem;
                color: #374151;
                text-decoration: none;
                transition: all 0.2s ease;
                font-size: 0.9rem;
            }

            .dropdown-item:hover {
                background: rgba(59, 130, 246, 0.1);
                color: #1e40af;
            }

            .dropdown-item.logout {
                color: #dc2626;
                border-top: 1px solid rgba(209, 213, 219, 0.3);
            }

            .dropdown-item.logout:hover {
                background: rgba(239, 68, 68, 0.1);
                color: #b91c1c;
            }

            /* Main content area */
            main {
                flex: 1;
                padding-top: 100px;
                position: relative;
            }

            /* Decorative elements sama seperti homepage */
            main::before {
                content: '';
                position: absolute;
                top: 10%;
                left: 5%;
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.1));
                border-radius: 50%;
                animation: float 6s ease-in-out infinite;
                z-index: 1;
            }

            main::after {
                content: '';
                position: absolute;
                bottom: 10%;
                right: 5%;
                width: 120px;
                height: 120px;
                background: linear-gradient(135deg, rgba(167, 139, 250, 0.1), rgba(196, 181, 253, 0.1));
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                animation: float 8s ease-in-out infinite reverse;
                z-index: 1;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }

            /* Content wrapper */
            .content-wrapper {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(240, 244, 248, 0.8));
                backdrop-filter: blur(10px);
                border-radius: 20px;
                margin: 2rem;
                padding: 2rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                z-index: 10;
            }

            /* Header section dalam content */
            .page-header {
                text-align: center;
                margin-bottom: 2rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid rgba(59, 130, 246, 0.2);
            }

            .page-header h2 {
                font-size: 2.5rem;
                font-weight: bold;
                margin-bottom: 0.5rem;
                background: linear-gradient(135deg, #1e40af, #3b82f6);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            }

            /* Button styling yang konsisten */
            button, .btn {
                background: linear-gradient(135deg, #3b82f6, #2563eb);
                color: white;
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 1rem;
                font-weight: 500;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            }

            button:hover, .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                text-decoration: none;
            }

            /* Table styling yang konsisten dengan design */
            table {
                width: 100%;
                border-collapse: collapse;
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            th, td {
                padding: 1rem;
                text-align: left;
                border-bottom: 1px solid rgba(209, 213, 219, 0.3);
            }

            th {
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.9), rgba(37, 99, 235, 0.9));
                color: white;
                font-weight: 600;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            }

            tr:hover {
                background: rgba(59, 130, 246, 0.05);
            }

            /* Footer styling */
            footer {
                background: linear-gradient(135deg, #1e40af, #1e3a8a);
                color: white;
                padding: 2rem;
                text-align: center;
                margin-top: auto;
            }

            footer::before,
            footer::after {
                display: none;
            }

            /* Form styling */
            input, select, textarea {
                padding: 0.75rem 1rem;
                border: 2px solid rgba(209, 213, 219, 0.8);
                border-radius: 12px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(10px);
            }

            input:focus, select:focus, textarea:focus {
                outline: none;
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                background: rgba(255, 255, 255, 0.95);
            }

            /* Responsive design */
            @media (max-width: 768px) {
                header {
                    padding: 1rem;
                    flex-direction: column;
                    gap: 1rem;
                }
                
                header h1 {
                    font-size: 1.4rem;
                }
                
                nav ul {
                    flex-wrap: wrap;
                    justify-content: center;
                }
                
                nav a, nav button {
                    padding: 0.5rem 1rem;
                    font-size: 0.9rem;
                }
                
                main {
                    padding-top: 140px;
                }
                
                .content-wrapper {
                    margin: 1rem;
                    padding: 1.5rem;
                }
                
                .page-header h2 {
                    font-size: 2rem;
                }
            }

            @media (max-width: 480px) {
                .content-wrapper {
                    margin: 0.5rem;
                    padding: 1rem;
                }
                
                .page-header h2 {
                    font-size: 1.8rem;
                }
                
                nav a, nav button {
                    padding: 0.4rem 0.8rem;
                    font-size: 0.8rem;
                }
            }
        </style>
    </head>
    @stack('scripts')
    <body>
        <header>
            <h1>{{ config('app.name', 'Sekretariat KONI SLEMAN') }}</h1>
            <nav>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    
                    @if(auth()->check())
                        {{-- Menu untuk user yang sudah login --}}
                        @if(auth()->user()->role === 'administrasi')
                            <li><a href="{{ route('administrasi.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('administrasi.surat.index') }}">Surat</a></li>
                        @elseif(auth()->user()->role === 'keuangan')
                            <li><a href="{{ route('keuangan.dashboard') }}">Dashboard</a></li>
                        @elseif(auth()->user()->role === 'aset')
                            <li><a href="{{ route('aset.dashboard') }}">Dashboard</a></li>
                        @endif
                        
                        {{-- Profile dropdown untuk user yang sudah login --}}
                        <li class="profile-dropdown">
                            <button class="profile-button" onclick="toggleDropdown()">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="hidden md:block">{{ Auth::user()->name }}</span>
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" id="dropdownArrow">
                                    <path d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div class="dropdown-menu" id="profileDropdown">
                                <div class="dropdown-header">
                                    <p class="user-name">{{ Auth::user()->name }}</p>
                                    <p class="user-email">{{ Auth::user()->email }}</p>
                                    <p class="user-role">{{ Auth::user()->role }}</p>
                                </div>
                                
                                @if(Route::has('profile.edit'))
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Edit Profile
                                    </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout" style="width: 100%; text-align: left; background: none; border: none; color: #dc2626; font-size: 0.9rem;">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    @else
                        {{-- Menu untuk guest user --}}
                        @if(Route::has('login'))
                            <li>
                                <a href="{{ route('login') }}">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Login
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </nav>
        </header>
        
        <main>
            <div class="content-wrapper">
                @hasSection('header')
                    <div class="page-header">
                        @yield('header')
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
        
        <footer>
            <p>&copy; {{ date('M, Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </footer>

        <!-- JavaScript for dropdown functionality -->
        <script>
            function toggleDropdown() {
                const dropdown = document.getElementById('profileDropdown');
                const arrow = document.getElementById('dropdownArrow');
                
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    arrow.style.transform = 'rotate(0deg)';
                } else {
                    dropdown.classList.add('show');
                    arrow.style.transform = 'rotate(180deg)';
                }
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('profileDropdown');
                const profileButton = document.querySelector('.profile-button');
                
                if (profileButton && !profileButton.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.remove('show');
                    const arrow = document.getElementById('dropdownArrow');
                    if (arrow) {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                }
            });

            // Close dropdown when pressing Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    const dropdown = document.getElementById('profileDropdown');
                    if (dropdown) {
                        dropdown.classList.remove('show');
                        const arrow = document.getElementById('dropdownArrow');
                        if (arrow) {
                            arrow.style.transform = 'rotate(0deg)';
                        }
                    }
                }
            });
        </script>
    </body>
</html>