@extends('layouts.layout')

@section('title', 'Create Flashcard')

@section('content')
<style>
    .container {
        max-width: 420px;
        margin: 40px auto;
        background: #fff;
        padding: 20px 24px;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1 {
        text-align: center;
        margin-bottom: 18px;
        font-weight: 700;
        color: #222;
        font-size: 1.5rem;
        letter-spacing: 0.03em;
    }

    label.form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #444;
        font-size: 0.95rem;
    }

    textarea.form-control {
        width: 100%;
        border: 1.2px solid #ccc;
        border-radius: 7px;
        padding: 9px 12px;
        font-size: 0.95rem;
        line-height: 1.3;
        resize: vertical;
        min-height: 80px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        font-family: inherit;
    }

    textarea.form-control:focus {
        border-color: #4caf50;
        box-shadow: 0 0 6px rgba(76, 175, 80, 0.3);
        outline: none;
    }

    .invalid-feedback {
        color: #e53e3e;
        font-size: 0.8rem;
        margin-top: 3px;
    }

    .mb-3 {
        margin-bottom: 14px;
    }

    .btn-success {
        background-color: #4caf50;
        border: none;
        padding: 10px 22px;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 7px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        color: white;
        min-width: 100px;
    }

    .btn-success:hover {
        background-color: #388e3c;
    }

    .btn-secondary {
        background-color: #bbb;
        color: #333;
        border: none;
        padding: 10px 22px;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 7px;
        margin-left: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        text-decoration: none;
        display: inline-block;
        line-height: 1.2;
        min-width: 100px;
        text-align: center;
    }

    .btn-secondary:hover {
        background-color: #999;
        color: #fff;
    }
</style>

<div class="container">
    <h1>Create New Flashcard</h1>

    <form action="{{ route('flashcards.store', ['set' => $set->id]) }}" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            <label for="term" class="form-label">Term</label>
            <textarea name="term" id="term" class="form-control @error('term') is-invalid @enderror" placeholder="Enter the term...">{{ old('term') }}</textarea>
            @error('term')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="definition" class="form-label">Definition</label>
            <textarea name="definition" id="definition" class="form-control @error('definition') is-invalid @enderror" placeholder="Enter the definition...">{{ old('definition') }}</textarea>
            @error('definition')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('flashcards.index', ['set' => $set->id]) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
