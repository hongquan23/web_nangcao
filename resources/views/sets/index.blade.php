@extends('layouts.layout')

@section('title', 'Danh sách Bộ Flashcard')

@section('content')
<style>
    .flashcard-set {
        background: #f9fafb;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgb(0 0 0 / 0.1);
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .flashcard-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .flashcard-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        flex-grow: 1;
        min-width: 200px;
    }
    .flashcard-actions a,
    .flashcard-actions button {
        margin-left: 10px;
        padding: 6px 12px;
        border-radius: 7px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
    }
    .flashcard-actions a.view {
        background-color: #3b82f6; /* blue */
        color: white;
    }
    .flashcard-actions a.view:hover {
        background-color: #2563eb;
    }
    .flashcard-actions a.edit {
        background-color: #f59e0b; /* amber */
        color: white;
    }
    .flashcard-actions a.edit:hover {
        background-color: #b45309;
    }
    .flashcard-actions button.delete {
        background-color: #ef4444; /* red */
        color: white;
    }
    .flashcard-actions button.delete:hover {
        background-color: #b91c1c;
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
            <div class="flashcard-header">
                <h2 class="flashcard-title">{{ $set->title }}</h2>
                <div class="flashcard-actions">
                    <a href="{{ route('flashcards.index', $set->id) }}" class="view">🔍 Xem</a>
                    <a href="{{ route('sets.edit', $set->id) }}" class="edit">✏️ Sửa</a>
                    <form action="{{ route('sets.destroy', $set->id) }}" method="POST"
                          onsubmit="return confirm('Bạn có chắc muốn xoá bộ này?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete">🗑️ Xoá</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div style="text-align: center; margin-top: 4rem; font-size: 1.1rem; color: #6b7280; font-style: italic;">
        😕 Chưa có bộ flashcard nào. Hãy bắt đầu bằng cách tạo bộ mới!
    </div>
@endif
@endsection
