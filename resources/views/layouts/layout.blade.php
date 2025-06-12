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
            align-items: center;
            position: relative;
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

        /* User dropdown styles */
        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-menu button {
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .user-menu button:hover {
            color: #2563eb;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 110%;
            background: white;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            min-width: 150px;
            z-index: 100;
        }

        .user-dropdown form button {
            width: 100%;
            padding: 10px 15px;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            font-weight: 500;
            color: #dc2626;
            border-radius: 0 0 6px 6px;
        }

        .user-dropdown form button:hover {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        main {
            flex: 1;
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
        <a href="{{ route('sets.index') }}" class="logo">📘 Flashcard App</a>
        <div class="nav-links">
            @auth
                <a href="{{ route('sets.index') }}">📁 Bộ thẻ</a>
                <a href="{{ route('profile.edit') }}">👤 Hồ sơ</a>

                <div class="user-menu">
                    <button id="userMenuButton" type="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} ▼
                    </button>
                    <div id="userDropdown" class="user-dropdown" role="menu" aria-labelledby="userMenuButton">
                        <form action="{{ route('logout') }}" method="POST" role="none">
                            @csrf
                            <button type="submit" role="menuitem">🚪 Đăng xuất</button>
                        </form>
                    </div>
                </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('userMenuButton');
        const dropdown = document.getElementById('userDropdown');

        if (btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isExpanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', String(!isExpanded));
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                } else {
                    dropdown.style.display = 'block';
                }
            });

            // Ẩn dropdown khi click ngoài
            document.addEventListener('click', function() {
                dropdown.style.display = 'none';
                btn.setAttribute('aria-expanded', 'false');
            });
        }
    });
</script>

</body>
</html>
