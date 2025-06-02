@extends('layouts.layout')

@section('title', 'Flashcards List')

@section('content')
<style>
    .container {
        max-width: 720px;
        margin: 40px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #fff;
        padding: 20px 28px;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    h1 {
        text-align: center;
        margin-bottom: 28px;
        font-weight: 700;
        font-size: 2rem;
        color: #222;
        letter-spacing: 0.04em;
    }

    /* Nút trên đầu - Create + Study */
    .top-buttons {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 22px;
    }
    .top-buttons a.btn {
        flex: 1;
        min-width: 140px;
        text-align: center;
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 7px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        display: inline-block;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
        border: none;
    }
    .btn-primary:hover {
        background-color: #2563eb;
        color: #fff;
    }

    .btn-study {
        background-color: #10b981;
        color: white;
    }
    .btn-study:hover {
        background-color: #047857;
    }

    .btn-secondary {
        background-color: #9ca3af;
        color: #333;
        border: none;
        margin-top: 20px;
        transition: background-color 0.3s ease, color 0.3s ease;
        padding: 8px 20px;
        border-radius: 7px;
        text-decoration: none;
        display: inline-block;
        font-weight: 600;
        text-align: center;
    }
    .btn-secondary:hover {
        background-color: #6b7280;
        color: white;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        font-size: 1rem;
        color: #444;
    }

    thead tr th {
        text-align: left;
        padding: 12px 15px;
        background-color: #f3f4f6;
        color: #555;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
    }

    tbody tr {
        background: #fafafa;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }
    tbody tr:hover {
        background-color: #e0f2fe;
    }

    tbody tr td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    tbody tr td:last-child {
        white-space: nowrap;
    }

    /* Các nút Edit và Delete */
    .actions {
        display: flex;
        gap: 12px;
    }
    .actions .btn-sm {
        flex: 1;
        min-width: 60px;
        text-align: center;
        padding: 8px 0;
        font-size: 0.9rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: background-color 0.3s ease;
        user-select: none;
        display: inline-block;
    }

    .btn-warning {
        background-color: #f59e0b;
        color: white;
    }
    .btn-warning:hover {
        background-color: #b45309;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }
    .btn-danger:hover {
        background-color: #b91c1c;
    }

    form {
        display: inline-block;
        margin: 0;
        flex: 1;
    }

    p {
        font-style: italic;
        color: #666;
        text-align: center;
        margin-top: 30px;
    }
</style>

<div class="container">
    <h1>{{ $set->title }}</h1>


    <div class="top-buttons">
        <a href="{{ route('flashcards.create', ['set' => $set->id]) }}" class="btn btn-primary">Create New Flashcard</a>
        <a href="{{ route('flashcards.study', ['set' => $set->id]) }}" class="btn btn-study">Study Flashcards</a>
    </div>

    @if($flashcards->count())
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($flashcards as $flashcard)
                <tr>
                    <td>{{ $flashcard->term }}</td>
                    <td>{{ $flashcard->definition }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('flashcards.edit', ['set' => $set->id, 'flashcard' => $flashcard->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('flashcards.destroy', ['set' => $set->id, 'flashcard' => $flashcard->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No flashcards found.</p>
    @endif

    <a href="{{ route('sets.index', $set->id) }}" class="btn btn-secondary">Back to Set</a>
</div>
@endsection
