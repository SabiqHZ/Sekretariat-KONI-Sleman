<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sekretariat KONI Sleman</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
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
            color: #1e3a8a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

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

        nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn {
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
            display: inline-block;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        main {
            flex: 1;
            padding-top: 100px;
            display: flex;
            flex-direction: column;
        }

        section {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        #home {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(240, 244, 248, 0.8));
            backdrop-filter: blur(10px);
        }

        #tentang {
            background: linear-gradient(135deg, rgba(240, 244, 248, 0.9), rgba(255, 255, 255, 0.8));
            backdrop-filter: blur(10px);
        }

        section h2 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        section p {
            font-size: 1.2rem;
            line-height: 1.8;
            max-width: 600px;
            color: #374151;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
        }

        /* Decorative elements */
        section::before {
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

        section::after {
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

        /* Footer styles */
        footer {
            background: linear-gradient(135deg, #1e40af, #1e3a8a);
            color: white;
            padding: 3rem 2rem 2rem;
            text-align: center;
            margin-top: auto;
        }

        footer h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: white !important;
            background: none !important;
            -webkit-text-fill-color: white !important;
        }

        footer p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: none;
        }

        footer::before,
        footer::after {
            display: none;
        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            color: black;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            width: 200px;
            display: none;
            z-index: 1000;
        }

        .dropdown ul {
            list-style: none;
            margin: 0;
            padding: 0.5rem 0;
        }

        .dropdown ul li a {
            display: block;
            padding: 0.5rem 1rem;
            color: #1e3a8a;
            text-decoration: none;
        }

        .dropdown ul li a:hover {
            background-color: #e0e7ff;
        }

        .dropdown-container {
            position: relative;
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
            
            nav {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            section h2 {
                font-size: 2.5rem;
            }
            
            section p {
                font-size: 1.1rem;
                padding: 0 1rem;
            }
            
            main {
                padding-top: 140px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Sekretariat KONI Sleman</h1>
        <nav>
            <button class="btn" onclick="scrollToSection('home')">Home</button>
            <button class="btn" onclick="scrollToSection('tentang')">Tentang</button>
            <button class="btn" onclick="scrollToSection('informasi')">Informasi</button>
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Login</a>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main>
        <section id="home">
            <h2>Home</h2>
            <p>Selamat datang di website resmi Sekretariat KONI Sleman. Platform digital yang menyediakan informasi lengkap dan akses mudah untuk seluruh kebutuhan administrasi dan layanan KONI Sleman.</p>
        </section>
        
        <section id="tentang">
            <h2>Tentang</h2>
            <p>Website ini dirancang khusus untuk memudahkan pengelolaan dokumen, surat-menyurat, dan administrasi KONI Sleman. Dengan sistem yang terintegrasi, kami memberikan solusi digital yang efisien untuk mendukung kinerja organisasi olahraga di Kabupaten Sleman.</p>
        </section>
    </main>

    <footer id="informasi">
        <h2>Komite Olahraga Nasional Kabupaten Sleman</h2>
        <p>
            <strong>Alamat:</strong> Jl. Magelang Km. 17, Sleman, Yogyakarta<br>
            <strong>Telepon:</strong> (0274) 868xxx<br>
            <strong>Email:</strong> sekretariat@konisleman.org<br><br>
            
            <strong>Media Sosial:</strong><br>
            Facebook: KONI Sleman Official<br>
            Instagram: @koni_sleman<br>
            Twitter: @KONISleman
        </p>
    </footer>

    <script>
        function scrollToSection(id) {
            const section = document.getElementById(id);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>
</body>
</html>