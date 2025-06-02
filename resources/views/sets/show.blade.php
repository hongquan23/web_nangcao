@extends('layouts.layout')

@section('title', $set->title)

@section('content')
<style>
    .container {
        max-width: 768px;
        margin: 40px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 0 20px;
    }
    h2 {
        font-weight: 700;
        font-size: 2.5rem;
        color: #1e293b; /* slate-800 */
        margin-bottom: 24px;
        text-align: center;
        letter-spacing: 0.03em;
    }
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .header-section h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #334155; /* slate-700 */
    }
    .btn-add {
        background-color: #22c55e; /* green-500 */
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 4px 10px rgb(34 197 94 / 0.3);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-add:hover {
        background-color: #16a34a; /* green-600 */
        box-shadow: 0 6px 14px rgb(22 163 74 / 0.5);
    }
    .flashcards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    .flashcard {
        background-color: #ffffff;
        padding: 20px 24px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgb(0 0 0 / 0.07);
        border-left: 6px solid #2563eb; /* blue-600 */
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        cursor: default;
    }
    .flashcard:hover {
        box-shadow: 0 12px 25px rgb(37 99 235 / 0.3);
        transform: translateY(-4px);
    }
    .flashcard h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b; /* slate-800 */
        margin-bottom: 10px;
    }
    .flashcard p {
        font-size: 1rem;
        color: #475569; /* slate-600 */
        line-height: 1.5;
    }
    .no-flashcards {
        text-align: center;
        font-style: italic;
        color: #64748b; /* slate-500 */
        margin-top: 40px;
        font-size: 1.1rem;
    }
</style>

<div class="container">
    <h2>{{ $set->title }}</h2>

    <div class="header-section">
        <h3>Từ vựng</h3>
        <a href="{{ route('flashcards.create', ['set' => $set->id]) }}" class="btn-add">
            + Thêm thẻ mới
        </a>
    </div>

    @if ($set->flashcards->count())
        <div class="flashcards-grid">
            @foreach ($set->flashcards as $flashcard)
                <div class="flashcard">
                    <h4>{{ $flashcard->term }}</h4>
                    <p>{{ $flashcard->definition }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="no-flashcards">Chưa có từ nào trong bộ thẻ này.</p>
    @endif
</div>
@endsection
