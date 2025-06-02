@extends('layouts.layout') {{-- kế thừa layout chung --}}

@section('content')
<style>
    .edit-container {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .edit-container h1 {
        margin-bottom: 30px;
        font-weight: 700;
        color: #333;
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1.5px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        resize: vertical;
    }
    input[type="text"]:focus,
    textarea:focus {
        border-color: #007BFF;
        outline: none;
    }

    .btn-primary {
        background-color: #007BFF;
        border: none;
        padding: 12px 25px;
        border-radius: 6px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-right: 12px;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        padding: 12px 25px;
        border-radius: 6px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
        line-height: 1.5;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        text-decoration: none;
        color: white;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c2c7;
        color: #842029;
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 25px;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
</style>

<div class="edit-container">
    <h1>Edit Flashcard Set</h1>

    {{-- Hiển thị lỗi nếu có --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sets.update', $set->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- method PUT để update --}}

        <label for="title">Set Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $set->title) }}" required>

       

        <div class="mt-4">
            <button type="submit" class="btn-primary">Update Set</button>
            <a href="{{ route('sets.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
