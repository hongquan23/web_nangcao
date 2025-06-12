@extends('layouts.layout')

@section('title', 'Study Flashcards')

@section('content')
<style>
    .container {
        max-width: 620px;
        margin: 40px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f9fafb;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        text-align: center;
    }

    h1 {
        font-weight: 800;
        font-size: 2rem;
        color: #1f2937;
        margin-bottom: 24px;
    }

    .instruction {
        font-size: 0.95rem;
        color: #6b7280;
        margin-bottom: 20px;
    }

    .flashcard {
        perspective: 1000px;
        height: 260px;
        max-width: 480px;
        margin: 0 auto 32px;
    }

    .flashcard-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.6s ease-in-out;
        transform-style: preserve-3d;
        border-radius: 12px;
        background-color: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 28px;
        font-size: 1.25rem;
        font-weight: 700;
        user-select: none;
        text-align: center;
        line-height: 1.4;
        cursor: pointer;
    }

    .flipped {
        transform: rotateY(180deg);
    }

    .flashcard-front,
    .flashcard-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        word-break: break-word;
    }

    .flashcard-front {
        background-color: #3b82f6;
    }

    .flashcard-back {
        background-color: #10b981;
        transform: rotateY(180deg);
    }

    .btn-group {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    button {
        background-color: #6366f1;
        color: white;
        border: none;
        padding: 10px 22px;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        min-width: 120px;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        transition: all 0.3s ease;
    }

    button:disabled {
        background-color: #d1d5db;
        color: #888;
        cursor: not-allowed;
        box-shadow: none;
    }

    button:hover:not(:disabled) {
        background-color: #4f46e5;
        transform: scale(1.05);
    }

    .btn-back {
        background-color: #9ca3af;
        color: #111827;
        padding: 10px 24px;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #6b7280;
        color: white;
    }

    p.no-data {
        color: #6b7280;
        font-style: italic;
        margin-top: 20px;
    }
</style>

<div class="container">
    <h1>🧠 Study Flashcards</h1>
    <div class="instruction">👉 Nhấp vào thẻ để lật giữa <strong>Từ</strong> và <strong>Nghĩa của từ</strong></div>

    @php
        $flashcardsArray = $flashcards->map(function($f) {
            return [
                'term' => $f->term,
                'definition' => $f->definition,
            ];
        })->toArray();
    @endphp

    @if(count($flashcardsArray) > 0)
        <div class="flashcard" id="flashcard">
            <div class="flashcard-inner" id="flashcard-inner" tabindex="0" role="button" aria-pressed="false" aria-label="Flashcard, click to flip">
                <div class="flashcard-front" id="flashcard-front"></div>
                <div class="flashcard-back" id="flashcard-back"></div>
            </div>
        </div>

        <div class="btn-group">
            <button id="prevBtn" disabled>⬅ Trước</button>
            <button id="nextBtn">Tiếp ➡</button>
        </div>
    @else
        <p class="no-data">Không có flashcard nào để học.</p>
    @endif

    <a href="{{ route('flashcards.index', ['set' => $set->id]) }}" class="btn-back">⬅ Quay lại danh sách</a>
</div>

<script>
    const flashcards = @json($flashcardsArray);
    let currentIndex = 0;
    let flipped = false;

    const flashcardInner = document.getElementById('flashcard-inner');
    const frontEl = document.getElementById('flashcard-front');
    const backEl = document.getElementById('flashcard-back');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function renderFlashcard(index) {
        flipped = false;
        flashcardInner.classList.remove('flipped');
        frontEl.textContent = flashcards[index].term;
        backEl.textContent = flashcards[index].definition;

        prevBtn.disabled = index === 0;
        nextBtn.disabled = index === flashcards.length - 1;
    }

    flashcardInner.addEventListener('click', () => {
        flipped = !flipped;
        flashcardInner.classList.toggle('flipped', flipped);
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            renderFlashcard(currentIndex);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentIndex < flashcards.length - 1) {
            currentIndex++;
            renderFlashcard(currentIndex);
        }
    });

    if (flashcards.length > 0) {
        renderFlashcard(currentIndex);
    }
</script>
@endsection
