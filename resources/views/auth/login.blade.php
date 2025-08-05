<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Login') }} - Sekretariat KONI Sleman</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .back-btn {
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

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        /* Main container */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        /* Decorative elements sama seperti homepage */
        .main-container::before {
            content: '';
            position: absolute;
            top: 20%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.1));
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .main-container::after {
            content: '';
            position: absolute;
            bottom: 20%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, rgba(167, 139, 250, 0.1), rgba(196, 181, 253, 0.1));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Login form container */
        .login-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(240, 244, 248, 0.9));
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 10;
        }

        .login-title {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
        }

        /* Override Laravel component styles */
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151 !important;
            font-size: 0.95rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 1rem 1.25rem !important;
            border: 2px solid rgba(209, 213, 219, 0.8) !important;
            border-radius: 12px !important;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(10px);
            color: #374151 !important;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
            background: rgba(255, 255, 255, 0.95) !important;
            ring: none !important;
        }

        /* Checkbox styling */
        input[type="checkbox"] {
            width: 1.2rem !important;
            height: 1.2rem !important;
            accent-color: #3b82f6 !important;
            border-radius: 4px !important;
        }

        .checkbox-label {
            color: #6b7280 !important;
            font-size: 0.95rem;
            margin-left: 0.5rem;
        }

        /* Primary button override */
        .primary-btn {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
            color: white !important;
            padding: 1rem 1.5rem !important;
            border: none !important;
            border-radius: 12px !important;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: 600;
            margin-left: 0 !important;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .primary-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4) !important;
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
        }

        .primary-btn:active {
            transform: translateY(0) !important;
        }

        /* Forgot password link */
        .forgot-link {
            color: #3b82f6 !important;
            text-decoration: none !important;
            font-weight: 500;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }

        .forgot-link:hover {
            color: #2563eb !important;
            text-decoration: underline !important;
        }

        /* Error messages */
        .error-message {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #dc2626 !important;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        /* Success/Status messages */
        .status-message {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(22, 163, 74, 0.1));
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #16a34a !important;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        /* Form spacing */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .remember-section {
            margin: 1.5rem 0;
        }

        .button-section {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            header {
                padding: 1rem;
            }
            
            header h1 {
                font-size: 1.4rem;
            }
            
            .main-container {
                padding: 1rem;
            }
            
            .login-container {
                padding: 2rem 1.5rem;
            }
            
            .login-title {
                font-size: 2rem;
            }
            
            .back-btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem 1rem;
            }
            
            .login-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Sekretariat KONI Sleman</h1>
        <a href="{{ route('Beranda') }}" class="back-btn">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Kembali ke Beranda
        </a>
    </header>

    <div class="main-container">
        <div class="login-container">
            <h2 class="login-title">Login</h2>
            <p class="login-subtitle">Masuk ke sistem Sekretariat KONI Sleman</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    @if ($errors->get('email'))
                        <div class="error-message">
                            @foreach ($errors->get('email') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    @if ($errors->get('password'))
                        <div class="error-message">
                            @foreach ($errors->get('password') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="remember-section">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span class="checkbox-label">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="button-section">
                    <button type="submit" class="primary-btn">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>