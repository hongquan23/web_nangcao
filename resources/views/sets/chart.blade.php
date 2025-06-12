@extends('layouts.layout')

@section('title', 'Biểu đồ tiến độ học')

@section('content')
<div style="margin-bottom: 1rem;">
    <a href="{{ route('sets.index') }}" style="text-decoration: none; color: #3b82f6;">← Quay lại danh sách</a>
</div>

<h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">
    📈 Biểu đồ tiến độ học: {{ $set->title }}
</h2>

<canvas id="learningChart" width="600" height="300"></canvas>

@if($chartData->isEmpty())
    <p style="margin-top: 2rem; color: #6b7280;">😕 Bạn chưa làm bài tập nào với bộ flashcard này.</p>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('learningChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('date')) !!},
            datasets: [{
                label: 'Tỷ lệ đúng (%)',
                data: {!! json_encode($chartData->pluck('accuracy')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: 'rgba(59, 130, 246, 1)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Tỷ lệ đúng (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Thời gian'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + '%';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
