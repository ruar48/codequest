@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')

<style>
/* === General Page === */
body, .content-wrapper {
    background: #0d1638ff;
    font-family: 'Poppins', sans-serif;
    color: #2f2f2f;
}

/* Content Header */
.content-header {
    padding: 20px 0;
    text-align: center;
}
.content-header h1 {
    color: #facc15;
    font-weight: 700;
    font-size: 2rem;
}
.content-header p {
    color: #6b7280;
    font-size: 1rem;
}

/* === Analytics Cards === */
.analytics-card {
    border-radius: 12px;
    background: #ffffff;
    color: #1f2937;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease-in-out;
}
.analytics-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(250,204,21,0.15);
}
.analytics-card h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #f59e0b;
}
.analytics-card p {
    color: #6b7280;
}
.analytics-card i {
    font-size: 2.5rem;
    color: #facc15;
    opacity: 0.8;
}

/* === Chart Cards === */
.card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    transition: all 0.3s ease-in-out;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(250,204,21,0.15);
}
.card-header {
    background: #facc15;
    color: #1f2937;
    font-weight: 700;
    font-size: 1.2rem;
    text-align: center;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.card-body {
    padding: 20px;
}
canvas {
    width: 100% !important;
    height: 300px !important;
}
</style>

<div class="content-header">
    <h1>Engagement Analytics</h1>
    <p>Insights into player performance and participation</p>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Analytics Cards -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="analytics-card">
                    <div>
                        <h3>{{ $totalPlayers }}</h3>
                        <p>Total Players</p>
                    </div>
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="analytics-card">
                    <div>
                        <h3>{{ number_format($averagePoints, 2) }}</h3>
                        <p>Avg Points per Player</p>
                    </div>
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="analytics-card">
                    <div>
                        <h3>{{ number_format($averageStars, 2) ?? 0 }}</h3>
                        <p>Avg Stars per Player</p>
                    </div>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Top Players</div>
                    <div class="card-body">
                        <canvas id="topPlayersChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Level Performance</div>
                    <div class="card-body">
                        <canvas id="levelPerformanceChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Execution Stats</div>
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
    const chartTextColor = "#1f2937"; // Dark text for charts to match cards

    // Top Players Chart
    new Chart(document.getElementById('topPlayersChart'), {
        type: 'bar',
        data: {
            labels: @json($topPlayers->pluck('email')),
            datasets: [
                {
                    label: 'Total Points',
                    data: @json($topPlayers->pluck('points')),
                    backgroundColor: 'rgba(250, 204, 21, 0.7)',
                    borderColor: '#facc15',
                    borderWidth: 1
                },
                {
                    label: 'Total Stars',
                    data: @json($topPlayers->pluck('stars')),
                    backgroundColor: 'rgba(255, 255, 255, 0.3)',
                    borderColor: '#ffea80',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                x: { ticks: { color: chartTextColor } },
                y: { beginAtZero: true, ticks: { color: chartTextColor } }
            },
            plugins: { legend: { labels: { color: chartTextColor } } }
        }
    });

    // Level Performance Chart
    new Chart(document.getElementById('levelPerformanceChart'), {
        type: 'line',
        data: {
            labels: @json($levels->pluck('level_number')),
            datasets: [
                {
                    label: 'Avg Stars',
                    data: @json($levels->pluck('avg_stars')),
                    borderColor: '#facc15',
                    backgroundColor: 'rgba(250,204,21,0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Avg Points',
                    data: @json($levels->pluck('avg_points')),
                    borderColor: '#ffea80',
                    backgroundColor: 'rgba(255,255,255,0.15)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            scales: {
                x: { ticks: { color: chartTextColor } },
                y: { beginAtZero: true, ticks: { color: chartTextColor } }
            },
            plugins: { legend: { labels: { color: chartTextColor } } }
        }
    });

    // Execution Stats Chart
    new Chart(document.getElementById('executionStatsChart'), {
        type: 'pie',
        data: {
            labels: ['Successful', 'Failed'],
            datasets: [{
                data: [{{ $phpExecutions['successful'] }}, {{ $phpExecutions['errors'] }}],
                backgroundColor: ['#27ae60', '#e74c3c'],
                borderColor: ['rgba(250,204,21,0.3)', 'rgba(255,255,255,0.1)'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: { legend: { labels: { color: chartTextColor } } }
        }
    });
});
</script>

@endsection
