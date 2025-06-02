<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Flashcard App')</title>
    {{-- Tùy chọn Vite --}}
     @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <style>

    


        body {
            background-image: url('/img3.jpg'); /* nên đặt file ở public/img3.jpg */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.85);
            z-index: -1;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="text-gray-800 flex flex-col font-sans leading-relaxed min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white/90 backdrop-blur border-b shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-600 hover:text-blue-700 flex items-center gap-2 transition">
                📘 <span>Flashcard App</span>
            </a>
            <div class="flex items-center space-x-6 text-sm font-medium">
                @auth
                    <a href="{{ route('sets.index') }}" class="text-gray-700 hover:text-blue-600 transition">📁 Bộ thẻ</a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-blue-600 transition">👤 Hồ sơ</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600 transition">🚪 Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 transition">🔐 Đăng nhập</a>
                    <a href="{{ route('register') }}" class="text-green-500 hover:text-green-600 transition">📝 Đăng ký</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Nội dung chính --}}
    <main class="flex-1 max-w-5xl mx-auto w-full px-6 py-12">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white/80 backdrop-blur border-t py-6 text-center text-sm text-gray-500 shadow-inner">
        &copy; {{ date('Y') }} <span class="font-semibold text-blue-500">Flashcard App</span>. All rights reserved.
    </footer>

</body>
</html>
