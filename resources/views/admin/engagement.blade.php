@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')
<style>
    body {
        background-color: #f5f6fa;
    }

    .content-header h1 {
        font-weight: 600;
        color: #2f3640;
    }

    .analytics-card {
        border-radius: 10px;
        color: #fff;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .analytics-card h3 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .analytics-card p {
        font-size: 1rem;
        margin: 0;
    }

    .analytics-card i {
        font-size: 3rem;
        opacity: 0.8;
    }

    .bg-blue { background-color: #007bff; }
    .bg-green { background-color: #28a745; }
    .bg-yellow { background-color: #ffc107; color: #2f3640; }
    .bg-red { background-color: #dc3545; }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .card-header {
        border-radius: 10px 10px 0 0;
        font-weight: 600;
        color: #fff;
        padding: 10px 15px;
    }

    .card-body {
        background-color: #fff;
        border-radius: 0 0 10px 10px;
        padding: 20px;
    }

    .bg-header-blue { background-color: #007bff; }
    .bg-header-green { background-color: #28a745; }
    .bg-header-red { background-color: #dc3545; }

    canvas {
        width: 100% !important;
        height: 300px !important;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Engagement Analytics</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Overview Cards -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="analytics-card bg-blue">
                    <div>
                        <h3>{{ $totalPlayers }}</h3>
                        <p>Total Players</p>
                    </div>
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="analytics-card bg-green">
                    <div>
                        <h3>{{ number_format($averagePoints, 2) }}</h3>
                        <p>Avg Points per Player</p>
                    </div>
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="analytics-card bg-yellow">
                    <div>
                        <h3>{{ number_format($averageStars, 2) ?? 0 }}</h3>
                        <p>Avg Stars per Player</p>
                    </div>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-header-blue">
                        Top Players
                    </div>
                    <div class="card-body">
                        <canvas id="topPlayersChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-header-green">
                        Level Performance
                    </div>
                    <div class="card-body">
                        <canvas id="levelPerformanceChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-header-red">
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
                },
                {
                    label: 'Total Stars',
                    data: @json($topPlayers->pluck('stars')),
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                }
            ]
        },
        options: {
            indexAxis: 'x',
            scales: { x: { ticks: { color: '#000' } }, y: { beginAtZero: true, ticks: { color: '#000' } } },
            plugins: { legend: { labels: { color: '#000' } } }
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
            scales: { x: { ticks: { color: '#000' } }, y: { beginAtZero: true, ticks: { color: '#000' } } },
            plugins: { legend: { labels: { color: '#000' } } }
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
        options: { plugins: { legend: { labels: { color: '#000' } } } }
    });
});
</script>
@endsection
