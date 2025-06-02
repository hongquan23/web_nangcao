<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Flashcard App')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, rgba(0,0,0,0.3), rgba(0,0,0,0.3)),
                        url('/img3.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #1f2937;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
        }

        nav {
            background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        nav .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a.logo {
            font-size: 1.6rem;
            font-weight: 700;
            color: #2563eb;
            text-decoration: none;
        }

        nav .nav-links {
            display: flex;
            gap: 1.25rem;
        }

        nav .nav-links a,
        nav form.logout-button button {
            font-size: 0.95rem;
            font-weight: 500;
            color: #374151;
            background: none;
            border: none;
            cursor: pointer;
        }

        nav form.logout-button button { color: #dc2626; }
        nav form.logout-button button:hover { color: #b91c1c; }

        main {
            flex: 1; /* Đảm bảo phần main chiếm toàn bộ phần trống còn lại */
            max-width: 720px;
            margin: 2.5rem auto 4rem;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.97);
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        footer {
            text-align: center;
            padding: 1.2rem 1rem;
            font-size: 0.85rem;
            color: #6b7280;
            background-color: rgba(255,255,255,0.88);
        }

        .flashcard-set {
            background: linear-gradient(to top left, #f9fafb, #f3f4f6);
            border-left: 6px solid #6366f1;
            border-radius: 16px;
            padding: 1.75rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .flashcard-set:hover {
            border-left-color: #4f46e5;
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.25);
        }

        .flashcard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .flashcard-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
        }

        .flashcard-actions {
            display: flex;
            gap: 1.25rem;
            font-size: 0.92rem;
            font-weight: 500;
        }

        .flashcard-actions a,
        .flashcard-actions button {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
            background: none;
            border: none;
            color: inherit;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .flashcard-actions a:hover,
        .flashcard-actions button:hover {
            transform: scale(1.05);
        }

        .view { color: #2563eb; }
        .edit { color: #ca8a04; }
        .delete { color: #dc2626; }

        @media (max-width: 768px) {
            nav .container { flex-direction: column; gap: 0.8rem; text-align: center; }
            nav .nav-links { flex-direction: column; }
            main { margin: 2rem 1rem; padding: 1.5rem; }
        }
    </style>
</head>
<body>

<nav>
    <div class="container">
        <a href="{{ route('dashboard') }}" class="logo">📘 Flashcard App</a>
        <div class="nav-links">
            @auth
                <a href="{{ route('sets.index') }}">📁 Bộ thẻ</a>
                <a href="{{ route('profile.edit') }}">👤 Hồ sơ</a>
                <form action="{{ route('logout') }}" method="POST" class="logout-button">
                    @csrf
                    <button type="submit">🚪 Đăng xuất</button>
                </form>
            @else
                <a href="{{ route('login') }}">🔐 Đăng nhập</a>
                <a href="{{ route('register') }}" style="color:#16a34a;">📝 Đăng ký</a>
            @endauth
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer>
    &copy; {{ date('Y') }} <strong>Flashcard App</strong>. All rights reserved.
</footer>

</body>
</html>
