@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')

<style>
/* === Small Boxes (Stats) === */
.small-box {
    border-radius: 12px;
    position: relative;
    display: block;
    box-shadow: 0 2px 10px rgba(250,204,21,0.1);
    transition: all 0.3s ease-in-out;
}

.small-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 25px rgba(250,204,21,0.25);
}

.small-box .inner h3, .small-box .inner p {
    color: #fff;
}

.small-box .icon i {
    font-size: 3rem;
    color: rgba(255,255,255,0.8);
}

/* === Cards (Charts) === */
.card {
    border-radius: 16px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(250,204,21,0.25);
    box-shadow: 0 2px 15px rgba(250,204,21,0.1);
    transition: all 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 25px rgba(250,204,21,0.25);
}

.card-header {
    font-weight: 700;
    font-size: 1.1rem;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    color: #1c1c1c;
    text-align: center;
    background: linear-gradient(90deg, #facc15, #ffea80);
    box-shadow: inset 0 -2px 5px rgba(0,0,0,0.1);
}

.card-body {
    padding: 20px;
    background: rgba(255,255,255,0.02);
}

/* === Header === */
.content-header h1 {
    font-weight: 700;
    color: #facc15;
    text-shadow: 0 0 10px rgba(250,204,21,0.5);
}

/* === Charts === */
canvas {
    width: 100% !important;
    height: 300px !important;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Engagement Analytics</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Overview Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary shadow">
                    <div class="inner">
                        <h3>{{ $totalPlayers }}</h3>
                        <p>Total Players</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success shadow">
                    <div class="inner">
                        <h3>{{ $phpExecutions['total'] }}</h3>
                        <p>Total PHP Executions</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-terminal"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning shadow">
                    <div class="inner">
                        <h3>{{ number_format($averagePoints, 2) }}</h3>
                        <p>Avg Points per Player</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger shadow">
                    <div class="inner">
                        <h3>{{ $totalTipsUsed }}</h3>
                        <p>Tips Used</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">Most Completed Levels</div>
                    <div class="card-body">
                        <canvas id="levelsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">PHP Execution Success vs Errors</div>
                    <div class="card-body">
                        <canvas id="phpExecutionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const chartTextColor = "#1f2937";

    // Levels Chart
    new Chart(document.getElementById('levelsChart'), {
        type: 'bar',
        data: {
            labels: @json($mostCompletedLevels->pluck('level_number')),
            datasets: [{
                label: 'Completions',
                data: @json($mostCompletedLevels->pluck('completion_count')),
                backgroundColor: 'rgba(250,204,21,0.7)',
                borderColor: '#facc15',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: chartTextColor, font: { weight: 'bold' } } },
                y: { ticks: { color: chartTextColor, beginAtZero: true } }
            }
        }
    });

    // PHP Execution Chart
    new Chart(document.getElementById('phpExecutionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Successful', 'Errors'],
            datasets: [{
                data: [{{ $phpExecutions['successful'] }}, {{ $phpExecutions['errors'] }}],
                backgroundColor: ['#27ae60', '#e74c3c'],
                borderColor: ['#facc15', '#facc15'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: chartTextColor, font: { weight: 'bold' } } } }
        }
    });
});
</script>

@endsection
