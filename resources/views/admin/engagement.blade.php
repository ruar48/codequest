@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-white font-weight-bold">Engagement Analytics</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Overview Cards -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-gradient-primary shadow-lg rounded-lg text-white p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">{{ $totalPlayers }}</h3>
                        <p class="mb-0">Total Players</p>
                    </div>
                    <i class="fas fa-users fs-2 opacity-75"></i>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-gradient-success shadow-lg rounded-lg text-white p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">{{ number_format($averagePoints, 2) }}</h3>
                        <p class="mb-0">Avg Points per Player</p>
                    </div>
                    <i class="fas fa-chart-line fs-2 opacity-75"></i>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-gradient-warning shadow-lg rounded-lg text-white p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">{{ number_format($averageStars, 2) ?? 0 }}</h3>
                        <p class="mb-0">Avg Stars per Player</p>
                    </div>
                    <i class="fas fa-star fs-2 opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header bg-gradient-primary text-white font-weight-bold">
                        Top Players
                    </div>
                    <div class="card-body">
                        <canvas id="topPlayersChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header bg-gradient-success text-white font-weight-bold">
                        Level Performance
                    </div>
                    <div class="card-body">
                        <canvas id="levelPerformanceChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header bg-gradient-danger text-white font-weight-bold">
                        Execution Stats
                    </div>
                    <div class="card-body">
                        <canvas id="executionStatsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Top Players
    new Chart(document.getElementById('topPlayersChart'), {
        type: 'bar',
        data: {
            labels: @json($topPlayers->pluck('email')),
            datasets: [
                {
                    label: 'Total Points',
                    data: @json($topPlayers->pluck('points')),
                    backgroundColor: 'rgba(0, 123, 255, 0.7)',
                    borderRadius: 4
                },
                {
                    label: 'Total Stars',
                    data: @json($topPlayers->pluck('stars')),
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderRadius: 4
                }
            ]
        },
        options: {
            indexAxis: 'x',
            responsive: true,
            plugins: { legend: { labels: { color: '#000' } } },
            scales: { x: { ticks: { color: '#000' } }, y: { beginAtZero: true, ticks: { color: '#000' } } }
        }
    });

    // Level Performance
    new Chart(document.getElementById('levelPerformanceChart'), {
        type: 'line',
        data: {
            labels: @json($levels->pluck('level_number')),
            datasets: [
                {
                    label: 'Avg Stars',
                    data: @json($levels->pluck('avg_stars')),
                    borderColor: '#ffc107',
                    fill: false,
                    tension: 0.4
                },
                {
                    label: 'Avg Points',
                    data: @json($levels->pluck('avg_points')),
                    borderColor: '#007bff',
                    fill: false,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#000' } } },
            scales: { x: { ticks: { color: '#000' } }, y: { beginAtZero: true, ticks: { color: '#000' } } }
        }
    });

    // Execution Stats
    new Chart(document.getElementById('executionStatsChart'), {
        type: 'pie',
        data: {
            labels: ['Successful', 'Failed'],
            datasets: [{
                data: [{{ $phpExecutions['successful'] }}, {{ $phpExecutions['errors'] }}],
                backgroundColor: ['#20c997', '#f78fb3']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#000' } } }
        }
    });
});
</script>
@endsection
