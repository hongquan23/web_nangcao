@extends('layouts.layout')

@section('title', 'Study Flashcards')

@section('content')
<style>
    .container {
        max-width: 600px;
        margin: 40px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #fff;
        padding: 20px 28px;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        text-align: center;
    }

    h1 {
        font-weight: 700;
        font-size: 2rem;
        color: #222;
        margin-bottom: 30px;
    }

    .flashcard {
        perspective: 1000px;
        cursor: pointer;
        height: 260px;           /* giảm chiều cao để vừa phải */
        max-width: 460px;        /* hơi thu nhỏ chiều rộng */
        margin: 0 auto 30px;     /* căn giữa và cách dưới */
    }

    .flashcard-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.12);
        background-color: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 28px;
        font-size: 1.3rem;       /* chữ to vừa phải */
        font-weight: 700;
        user-select: none;
        text-align: center;
        line-height: 1.3;
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
        padding: 16px;
        box-sizing: border-box;
        word-break: break-word; /* để chữ xuống dòng đẹp */
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
        gap: 18px;
        margin-bottom: 30px;
    }

    button {
        background-color: #4f46e5;
        color: white;
        border: none;
        padding: 12px 26px;
        border-radius: 9px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 1rem;
        min-width: 100px;
    }

    button:disabled {
        background-color: #a5b4fc;
        cursor: not-allowed;
    }

    button:hover:not(:disabled) {
        background-color: #4338ca;
    }

    .btn-back {
        background-color: #9ca3af;
        color: #333;
        padding: 10px 25px;
        border-radius: 7px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease, color 0.3s ease;
        display: inline-block;
    }
    .btn-back:hover {
        background-color: #6b7280;
        color: white;
    }
</style>

<div class="container">
    <h1>Study Flashcards</h1>

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
            <button id="prevBtn" disabled>Previous</button>
            <button id="nextBtn">Next</button>
        </div>
    @else
        <p>Không có flashcard nào để học.</p>
    @endif

    <a href="{{ route('flashcards.index', ['set' => $set->id]) }}" class="btn-back">Back to Flashcards</a>
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

        prevBtn.disabled = (index === 0);
        nextBtn.disabled = (index === flashcards.length - 1);
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
