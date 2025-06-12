@extends('layouts.layout')

@section('title', 'Danh sách Bộ Flashcard')

@section('content')

<!-- Lordicon (nếu dùng) -->
<script src="https://cdn.lordicon.com/lordicon.js"></script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .flashcard-set {
        background: #f9fafb;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        position: relative;
        animation: fadeInUp 0.5s ease-in-out;
        transition: box-shadow 0.3s ease;
    }

    .flashcard-set:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .flashcard-set:nth-child(even) {
        background-color: #f3f4f6;
    }

    .flashcard-left {
        flex-grow: 1;
        min-width: 250px;
    }

    .flashcard-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 6px;
        transition: color 0.3s ease;
    }

    .flashcard-title:hover {
        color: #4f46e5;
    }

    .flashcard-desc {
        font-size: 1rem;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .flashcard-meta {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .dropdown-button {
        background-color: #4b5563;
        color: white;
        padding: 8px 14px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .dropdown-button:hover {
        background-color: #374151;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 110%;
        right: 0;
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        z-index: 10;
        min-width: 180px;
        opacity: 0;
        transform: scale(0.95);
        transition: all 0.3s ease;
    }

    .dropdown-menu.show {
        display: block;
        opacity: 1;
        transform: scale(1);
    }

    .dropdown-item {
        display: block;
        padding: 10px 16px;
        font-size: 0.9rem;
        text-decoration: none;
        color: #1f2937;
        background-color: white;
        transition: background-color 0.2s ease;
        border-bottom: 1px solid #e5e7eb;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .dropdown-item:hover {
        background-color: #f3f4f6;
    }

    .dropdown-item form {
        margin: 0;
    }

    .dropdown-item button {
        background: none;
        border: none;
        padding: 0;
        width: 100%;
        text-align: left;
        font: inherit;
        color: inherit;
        cursor: pointer;
    }
</style>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <h1 style="font-size: 1.8rem; font-weight: bold; color: #1f2937;">
        📚 Danh sách Bộ Flashcard
    </h1>
    <a href="{{ route('sets.create') }}"
       style="background-color: #4f46e5; color: white; padding: 0.6rem 1.2rem; font-weight: 500; text-decoration: none; border-radius: 8px;">
        ➕ Tạo bộ mới
    </a>
</div>

@if($sets->count() > 0)
    @foreach($sets as $set)
        <div class="flashcard-set">
            <div class="flashcard-left">
                <h2 class="flashcard-title">{{ $set->title }}</h2>
                @if($set->description)
                    <p class="flashcard-desc">{{ $set->description }}</p>
                @endif
                <p class="flashcard-meta">
                    📄 {{ $set->flashcards_count }} từ vựng •
                    🧠 {{ number_format($set->avg_review, 1) }} lần ôn •
                    ✅ TB {{ number_format($set->avg_score, 0) }}%
                </p>
            </div>

            <div class="flashcard-actions" style="position: relative;">
                <button class="dropdown-button" onclick="toggleMenu(this)">⚙️ Tùy chọn</button>
                <div class="dropdown-menu">
                    <a href="{{ route('flashcards.index', $set->id) }}" class="dropdown-item">🔍 Học</a>
                    <a href="{{ route('sets.edit', $set->id) }}" class="dropdown-item">✏️ Sửa</a>
                    <a href="{{ route('sets.showWriting', $set->id) }}" class="dropdown-item">✍️ Làm bài tập</a>
                    <a href="{{ route('sets.chart', $set->id) }}" class="dropdown-item">
                        <lord-icon
                            src="https://cdn.lordicon.com/abwrkdvl.json"
                            trigger="hover"
                            style="width:20px;height:20px;display:inline-block;vertical-align:middle;margin-right:6px;">
                        </lord-icon>
                        Biểu đồ học
                    </a>
                    <div class="dropdown-item">
                        <form action="{{ route('sets.destroy', $set->id) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc muốn xoá bộ này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ Xoá</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div style="text-align: center; margin-top: 4rem; font-size: 1.1rem; color: #6b7280; font-style: italic;">
        😕 Chưa có bộ flashcard nào. Hãy bắt đầu bằng cách tạo bộ mới!
    </div>
@endif

<script>
    function toggleMenu(button) {
        const menu = button.nextElementSibling;
        const isOpen = menu.classList.contains('show');

        // Đóng tất cả menu khác
        document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));

        if (!isOpen) menu.classList.add('show');
    }

    document.addEventListener('click', function (event) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (!menu.contains(event.target) && !menu.previousElementSibling.contains(event.target)) {
                menu.classList.remove('show');
            }
        });
    });
</script>

@endsection
