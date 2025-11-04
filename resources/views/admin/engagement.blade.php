@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')

<style>
/* === Dashboard Theme === */
body, .content-wrapper {
    background: linear-gradient(135deg, #0a0f24, #1c223a);
    font-family: 'Poppins', sans-serif;
    color: #fff;
}

/* Content Header */
.content-header {
    text-align: center;
    padding-top: 20px;
    padding-bottom: 10px;
}

.content-header h1 {
    font-weight: 700;
    color: #facc15;
    font-size: 2rem;
    text-shadow: 0 0 12px rgba(250,204,21,0.5);
}

.content-header p {
    color: #e5e5e5;
    font-size: 1rem;
}

/* Small Boxes */
.small-box {
    border-radius: 16px;
    padding: 20px;
    position: relative;
    color: #fff;
    box-shadow: 0 4px 16px rgba(250,204,21,0.2);
    transition: all 0.3s ease;
    overflow: hidden;
}

.small-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 20px rgba(250,204,21,0.4);
}

.small-box .inner h3 {
    font-size: 2rem;
    font-weight: 700;
}
.small-box .inner p {
    font-size: 1rem;
}
.small-box .icon {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 3rem;
    opacity: 0.2;
}

/* Force Gradient Backgrounds */
.small-box.primary {
    background: linear-gradient(90deg, #facc15, #ffea80) !important;
    color: #1c1c1c !important;
}

.small-box.success {
    background: linear-gradient(90deg, #27ae60, #6fcf97) !important;
}

.small-box.warning {
    background: linear-gradient(90deg, #f1c40f, #f9d463) !important;
    color: #1c1c1c !important;
}

.small-box.danger {
    background: linear-gradient(90deg, #e74c3c, #f08080) !important;
}

/* Cards */
.card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(250,204,21,0.25);
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(250,204,21,0.25);
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 20px rgba(250,204,21,0.5);
}
.card-header {
    font-weight: 700;
    font-size: 1.2rem;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
}

/* Charts */
canvas {
    background: transparent;
    max-height: 300px;
}

/* Responsive */
@media (max-width: 767px) {
    .small-box .icon { font-size: 2.5rem; top: 5px; right: 10px; }
    .small-box .inner h3 { font-size: 1.5rem; }
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Engagement Analytics</h1>
                <p>Overview of player activity and PHP executions</p>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Overview Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box primary">
                    <div class="inner">
                        <h3>{{ $totalPlayers }}</h3>
                        <p>Total Players</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box success">
                    <div class="inner">
                        <h3>{{ $phpExecutions['total'] }}</h3>
                        <p>Total PHP Executions</p>
                    </div>
                    <div class="icon"><i class="fas fa-terminal"></i></div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box warning">
                    <div class="inner">
                        <h3>{{ number_format($averagePoints, 2) }}</h3>
                        <p>Avg Points per Player</p>
                    </div>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box danger">
                    <div class="inner">
                        <h3>{{ $totalTipsUsed }}</h3>
                        <p>Tips Used</p>
                    </div>
                    <div class="icon"><i class="fas fa-lightbulb"></i></div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header primary text-dark">
                        Most Completed Levels
                    </div>
                    <div class="card-body">
                        <canvas id="levelsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header danger text-dark">
                        PHP Execution Success vs Errors
                    </div>
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
    // Levels Chart
    var levelsCtx = document.getElementById('levelsChart').getContext('2d');
    new Chart(levelsCtx, {
        type: 'bar',
        data: {
            labels: @json($mostCompletedLevels->pluck('level_number')),
            datasets: [{
                label: 'Completions',
                data: @json($mostCompletedLevels->pluck('completion_count')),
                backgroundColor: 'rgba(250, 204, 21, 0.7)',
                borderRadius: 4
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // PHP Execution Chart
    var phpExecCtx = document.getElementById('phpExecutionChart').getContext('2d');
    new Chart(phpExecCtx, {
        type: 'doughnut',
        data: {
            labels: ['Successful', 'Errors'],
            datasets: [{
                data: [{{ $phpExecutions['successful'] }}, {{ $phpExecutions['errors'] }}],
                backgroundColor: ['rgba(75, 192, 192, 0.7)', 'rgba(255, 99, 132, 0.7)']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
});
</script>

@endsection
