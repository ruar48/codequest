@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')
<style>
    body {
        background-color: #0d0f21;
        color: #fff;
    }

    .dashboard-header {
        text-align: center;
        color: #ffcc00;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-shadow: 0 0 10px #ffcc00;
    }

    .stats-card {
        background-color: #1a1c33;
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 0 20px rgba(255, 204, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 30px rgba(255, 204, 0, 0.4);
    }

    .stats-icon {
        font-size: 2.5rem;
        color: #ffcc00;
        margin-bottom: 0.5rem;
        text-shadow: 0 0 10px #ffcc00;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #ffcc00;
    }

    .stats-label {
        font-size: 1rem;
        color: #fff;
        opacity: 0.9;
    }

    .card {
        background-color: #1a1c33;
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(255, 204, 0, 0.1);
        color: #fff;
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(255, 204, 0, 0.3);
        font-weight: 600;
        color: #ffcc00;
        text-shadow: 0 0 10px #ffcc00;
    }

    canvas {
        background-color: transparent;
    }
</style>

<div class="container-fluid py-4">
    <h2 class="dashboard-header"><i class="fas fa-chart-line"></i> Engagement Analytics</h2>

    <!-- Overview Cards -->
    <div class="row text-center mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon"><i class="fas fa-users"></i></div>
                <div class="stats-number">{{ $totalPlayers }}</div>
                <div class="stats-label">Total Players</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon"><i class="fas fa-terminal"></i></div>
                <div class="stats-number">{{ $phpExecutions['total'] }}</div>
                <div class="stats-label">Total PHP Executions</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon"><i class="fas fa-chart-bar"></i></div>
                <div class="stats-number">{{ number_format($averagePoints, 2) }}</div>
                <div class="stats-label">Avg Points per Player</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon"><i class="fas fa-lightbulb"></i></div>
                <div class="stats-number">{{ $totalTipsUsed }}</div>
                <div class="stats-label">Tips Used</div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header"><i class="fas fa-layer-group"></i> Most Completed Levels</div>
                <div class="card-body">
                    <canvas id="levelsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header"><i class="fas fa-code"></i> PHP Execution Success vs Errors</div>
                <div class="card-body">
                    <canvas id="phpExecutionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Levels Chart
    var levelsCtx = document.getElementById('levelsChart').getContext('2d');
    new Chart(levelsCtx, {
        type: 'bar',
        data: {
            labels: @json($mostCompletedLevels->pluck('level_number')),
            datasets: [{
                label: 'Completions',
                data: @json($mostCompletedLevels->pluck('completion_count')),
                backgroundColor: 'rgba(255, 204, 0, 0.7)',
                borderColor: '#ffcc00',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { color: '#fff' } }, x: { ticks: { color: '#fff' } } },
            plugins: { legend: { labels: { color: '#ffcc00' } } }
        }
    });

    // PHP Execution Chart
    var phpExecCtx = document.getElementById('phpExecutionChart').getContext('2d');
    new Chart(phpExecCtx, {
        type: 'doughnut',
        data: {
            labels: ['Successful', 'Errors'],
            datasets: [{
                data: [{{ $phpExecutions['successful'] }}, {{ $phpExecutions['errors'] }}],
                backgroundColor: ['#ffcc00', '#ff3366']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#fff' } } }
        }
    });
});
</script>
@endsection
