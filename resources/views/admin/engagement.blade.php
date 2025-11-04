@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')
<style>
/* === Golden Futuristic Dashboard Theme === */
body, .content-wrapper {
    background: linear-gradient(135deg, #0a0f24, #1c223a);
    font-family: 'Poppins', sans-serif;
    color: #fff;
}

.content-header {
    text-align: center;
    padding-top: 20px;
    padding-bottom: 10px;
}

.content-header h1 {
    font-weight: 700;
    color: #facc15;
    font-size: 2rem;
    text-shadow: 0 0 12px rgba(250, 204, 21, 0.5);
}

.analytics-card {
    border-radius: 16px;
    color: #fff;
    padding: 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(250,204,21,0.25);
    backdrop-filter: blur(8px);
    box-shadow: 0 0 20px rgba(250,204,21,0.15);
    transition: all 0.3s ease;
}
.analytics-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 25px rgba(250,204,21,0.4);
}

.analytics-card h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: #facc15;
    text-shadow: 0 0 8px rgba(250,204,21,0.6);
}

.analytics-card p {
    font-size: 1rem;
    color: #e5e5e5;
}

.analytics-card i {
    font-size: 3rem;
    color: #facc15;
    opacity: 0.8;
}

/* Card Container for Charts */
.card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(250,204,21,0.25);
    box-shadow: 0 0 15px rgba(250,204,21,0.2);
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 25px rgba(250,204,21,0.4);
}

.card-header {
    background: linear-gradient(90deg, #facc15, #ffea80);
    color: #1c1c1c;
    font-weight: 700;
    font-size: 1.2rem;
    text-align: center;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
}

.card-body {
    padding: 20px;
}

canvas {
    width: 100% !important;
    height: 300px !important;
}

/* Chart.js Tooltip and Text Overrides */
.chartjs-render-monitor {
    color: #fff !important;
}

</style>

<div class="content-header">
    <h1>Engagement Analytics</h1>
    <p>Insights into player performance and participation</p>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Overview Cards -->
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
                    <div class="card-header">
                        Top Players
                    </div>
                    <div class="card-body">
                        <canvas id="topPlayersChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        Level Performance
                    </div>
                    <div class="card-body">
                        <canvas id="levelPerformanceChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
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
    const chartTextColor = "#fff";

    // === Top Players ===
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
            plugins: {
                legend: { labels: { color: chartTextColor } }
            }
        }
    });

    // === Level Performance ===
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

    // === Execution Stats ===
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
