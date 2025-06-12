@extends('layouts.layout')
@section('title', 'Viết lại từ vựng')
@section('content')

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .result-summary {
        margin-top: 20px;
        padding: 16px;
        background-color: #f0f9ff;
        border-left: 6px solid #3b82f6;
        border-radius: 6px;
        font-size: 1.1rem;
        color: #1e3a8a;
    }

    .result-table {
        margin-top: 20px;
        border-collapse: collapse;
        width: 100%;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .result-table th, .result-table td {
        padding: 12px 16px;
        text-align: left;
    }

    .result-table th {
        background-color: #f3f4f6;
        font-weight: 600;
    }

    .result-table tr.correct {
        background-color: #dcfce7;
    }

    .result-table tr.incorrect {
        background-color: #fee2e2;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 4px;
        display: block;
    }

    .form-control {
        padding: 10px;
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    h1 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 24px;
    }

    .button-group {
        margin-top: 24px;
    }
</style>

<div class="container">
    <h1>✍️ Viết lại từ vựng</h1>

    @if (session('results'))
        <div class="result-summary">
            ✅ Bạn đã trả lời đúng <strong>{{ session('correct') }}</strong> / {{ session('total') }} câu.
        </div>

        <table class="result-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Định nghĩa</th>
                    <th>Trả lời của bạn</th>
                    <th>Đáp án đúng</th>
                    <th>Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('results') as $i => $r)
                    <tr class="{{ $r['is_correct'] ? 'correct' : 'incorrect' }}">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $r['definition'] }}</td>
                        <td>{{ $r['user_answer'] ?: '—' }}</td>
                        <td>{{ $r['term'] }}</td>
                        <td>{!! $r['is_correct'] ? '✅ <strong>Đúng</strong>' : '❌ <strong>Sai</strong>' !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="button-group">
            <a href="{{ route('sets.showWriting', $set->id) }}" class="btn-secondary">🔁 Làm lại</a>
            <a href="{{ route('sets.index', $set->id) }}" class="btn-secondary">⬅️ Quay lại bộ từ vựng</a>
        </div>

        {{-- Hiệu ứng khi làm đúng hoặc sai nhiều --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const correct = {{ session('correct') }};
                const total = {{ session('total') }};
                const wrong = total - correct;

                if (correct === total) {
                    Swal.fire({
                        title: '🎉 Xuất sắc!',
                        text: 'Bạn đã trả lời đúng tất cả các câu hỏi!',
                        icon: 'success',
                        confirmButtonText: 'Tuyệt vời!',
                        timer: 3000
                    });
                } else if (wrong >= 1) {
                    Swal.fire({
                        title: '😥 Cần cố gắng hơn!',
                        text: `Bạn đã sai ${wrong} câu. Luyện tập thêm nhé!`,
                        icon: 'warning',
                        confirmButtonText: 'Tôi sẽ cố gắng!',
                        timer: 3500
                    });
                }
            });
        </script>
    @else
        <form method="POST" action="{{ route('sets.submitWriting', $set->id) }}">
            @csrf
            @foreach ($flashcards as $flashcard)
                <div class="mb-4">
                    <label class="form-label">{{ $flashcard->definition }}</label>
                    <input type="text" name="answers[{{ $flashcard->id }}]" class="form-control" />
                </div>
            @endforeach
            <button class="btn-primary mt-3">🚀 Nộp bài</button>
        </form>
    @endif
</div>

@endsection
