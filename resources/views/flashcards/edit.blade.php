@extends('layouts.layout') {{-- kế thừa layout chung --}}

@section('title', 'Edit Flashcard')

@section('content')
<style>
    /* Container */
    .container {
        max-width: 700px;
        margin: 50px auto;
        padding: 30px 35px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1 {
        font-weight: 700;
        color: #222f3e;
        margin-bottom: 40px;
        text-align: center;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    label.form-label {
        font-weight: 600;
        color: #34495e;
        display: block;
        margin-bottom: 8px;
        font-size: 1.1rem;
    }

    textarea.form-control {
        font-size: 1.05rem;
        border: 2px solid #ced4da;
        border-radius: 8px;
        padding: 14px 18px;
        resize: vertical;
        min-height: 110px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
        width: 100%;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    textarea.form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 8px rgba(52, 152, 219, 0.5);
        outline: none;
    }

    .invalid-feedback {
        font-size: 0.9rem;
        color: #e74c3c;
        margin-top: 6px;
        font-style: italic;
    }

    .btn-primary {
        background-color: #3498db;
        border: none;
        padding: 12px 32px;
        font-size: 1.15rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        color: #fff;
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.5);
        font-weight: 600;
        display: inline-block;
        min-width: 140px;
        text-align: center;
        user-select: none;
    }

    .btn-primary:hover {
        background-color: #217dbb;
        box-shadow: 0 6px 15px rgba(33, 125, 187, 0.6);
    }

    .btn-secondary {
        background-color: #7f8c8d;
        border: none;
        padding: 12px 32px;
        font-size: 1.15rem;
        border-radius: 8px;
        margin-left: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        min-width: 140px;
        text-align: center;
        user-select: none;
    }

    .btn-secondary:hover {
        background-color: #636e70;
        color: #fff;
        text-decoration: none;
    }

    .mb-3 {
        margin-bottom: 28px;
    }
</style>

<div class="container">
    <h1>Edit Flashcard</h1>

    <form action="{{ route('flashcards.update', ['set' => $set->id, 'flashcard' => $flashcard->id]) }}" method="POST" novalidate>

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="term" class="form-label">Term</label>
            <textarea name="term" id="term" rows="4" class="form-control @error('term') is-invalid @enderror">{{ old('term', $flashcard->term) }}</textarea>
            @error('term')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="definition" class="form-label">Definition</label>
            <textarea name="definition" id="definition" rows="4" class="form-control @error('definition') is-invalid @enderror">{{ old('definition', $flashcard->definition) }}</textarea>
            @error('definition')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Flashcard</button>
        <a href="{{ route('flashcards.index', ['set' => $set->id]) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
