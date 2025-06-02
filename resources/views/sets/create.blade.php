@extends('layouts.layout')

@section('title', 'Tạo bộ thẻ mới')

@section('content')
<style>
    form.form-create-set {
        max-width: 440px;
        margin: 50px auto;
        padding: 30px 25px;
        background: #fefefe;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        font-family: "Segoe UI", sans-serif;
        transition: box-shadow 0.3s;
    }

    form.form-create-set:hover {
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.1);
    }

    form.form-create-set h2 {
        font-size: 22px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    form.form-create-set label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    form.form-create-set input[type="text"],
    form.form-create-set textarea {
        width: 100%;
        padding: 10px 13px;
        margin-bottom: 18px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 14px;
        background-color: #fff;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    form.form-create-set input[type="text"]:focus,
    form.form-create-set textarea:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
    }

    form.form-create-set .btn-submit {
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        color: white;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
        float: right;
    }

    form.form-create-set .btn-submit:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }

    form.form-create-set .alert {
        background: #fff1f2;
        border: 1px solid #fecaca;
        padding: 12px 15px;
        border-radius: 10px;
        color: #b91c1c;
        margin-bottom: 18px;
        font-size: 13.5px;
    }

    form.form-create-set .alert ul {
        margin: 0;
        padding-left: 18px;
    }

    form.form-create-set span.required {
        color: red;
        margin-left: 4px;
    }
</style>

<form action="{{ route('sets.store') }}" method="POST" class="form-create-set">
    <h2>📝 Tạo Bộ Thẻ Mới</h2>

    @csrf

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <label for="title">Tên Bộ Thẻ <span class="required">*</span></label>
    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Nhập tên bộ thẻ">

    

    <button type="submit" class="btn-submit">➕ Tạo Bộ Thẻ</button>
</form>
@endsection
