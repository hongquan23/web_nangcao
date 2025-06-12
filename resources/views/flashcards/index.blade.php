@extends('layouts.layout')

@section('title', 'Flashcards List')

@section('content')
<style>
    .container {
        max-width: 720px;
        margin: 40px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f9fafb;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
    }

    h1 {
        text-align: center;
        margin-bottom: 28px;
        font-weight: 800;
        font-size: 2rem;
        color: #1f2937;
        letter-spacing: 0.03em;
    }

    .top-buttons {
        display: flex;
        justify-content: center;
        gap: 14px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .top-buttons a.btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.95rem;
        transition: transform 0.2s ease, background-color 0.3s ease;
        display: inline-block;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .top-buttons a.btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }
    .btn-primary:hover {
        background-color: #2563eb;
    }

    .btn-study {
        background-color: #10b981;
        color: white;
    }
    .btn-study:hover {
        background-color: #059669;
    }

    .btn-secondary {
        background-color: #e5e7eb;
        color: #1f2937;
        margin-top: 30px;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        text-align: center;
        transition: background-color 0.3s ease;
    }
    .btn-secondary:hover {
        background-color: #d1d5db;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        font-size: 1rem;
        color: #374151;
    }

    thead tr th {
        text-align: left;
        padding: 12px 16px;
        background-color: #f3f4f6;
        color: #4b5563;
        font-weight: 700;
        border-bottom: 2px solid #e5e7eb;
    }

    tbody tr {
        background: white;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border-radius: 10px;
        transition: background-color 0.2s ease;
    }

    tbody tr:hover {
        background-color: #eff6ff;
    }

    tbody tr td {
        padding: 14px 16px;
        vertical-align: middle;
    }

    tbody tr td:last-child {
        white-space: nowrap;
    }

    .actions {
        display: flex;
        gap: 12px;
    }

    .actions .btn-sm {
        padding: 8px 14px;
        font-size: 0.9rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-warning {
        background-color: #fbbf24;
        color: #1f2937;
    }
    .btn-warning:hover {
        background-color: #f59e0b;
        transform: scale(1.03);
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }
    .btn-danger:hover {
        background-color: #dc2626;
        transform: scale(1.03);
    }

    form {
        margin: 0;
        display: inline-block;
    }

    p {
        font-style: italic;
        color: #6b7280;
        text-align: center;
        margin-top: 30px;
    }
</style>

<div class="container">
    <h1>{{ $set->title }}</h1>

    <div class="top-buttons">
        <a href="{{ route('flashcards.create', ['set' => $set->id]) }}" class="btn btn-primary">➕ Tạo Flashcard</a>
        <a href="{{ route('flashcards.study', ['set' => $set->id]) }}" class="btn btn-study">📖 Ôn Tập</a>
    </div>

    @if($flashcards->count())
        <table>
            <thead>
                <tr>
                    <th>Từ</th>
                    <th>Nghĩa của từ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($flashcards as $flashcard)
                <tr>
                    <td>{{ $flashcard->term }}</td>
                    <td>{{ $flashcard->definition }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('flashcards.edit', ['set' => $set->id, 'flashcard' => $flashcard->id]) }}" class="btn-sm btn-warning">✏️ Sửa</a>
                            <form action="{{ route('flashcards.destroy', ['set' => $set->id, 'flashcard' => $flashcard->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">🗑️ Xoá</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Không có flashcard nào trong bộ này.</p>
    @endif

    <a href="{{ route('sets.index') }}" class="btn-secondary">⬅ Quay lại danh sách</a>
</div>
@endsection
