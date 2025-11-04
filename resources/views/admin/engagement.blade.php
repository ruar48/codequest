@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-warning">Engagement Analytics</h1>
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
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Most Completed Levels</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="levelsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0">PHP Execution Success vs Errors</h5>
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
    const levelsCtx = document.getElementById('levelsChart').getContext('2d');
    new Chart(levelsCtx, {
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
                x: { ticks: { color: '#1f2937', font: { weight: 'bold' } } },
                y: { ticks: { color: '#1f2937', beginAtZero: true } }
            }
        }
    });

    // PHP Execution Chart
    const phpExecCtx = document.getElementById('phpExecutionChart').getContext('2d');
    new Chart(phpExecCtx, {
        type: 'doughnut',
        data: {
            labels: ['Successful', 'Errors'],
            datasets: [{
                data: [{{ $phpExecutions['successful'] }}, {{ $phpExecutions['errors'] }}],
                backgroundColor: ['#27ae60', '#e74c3c'],
                borderColor: ['#1f2937', '#1f2937'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: '#1f2937', font: { weight: 'bold' } } }
            }
        }
    });
});
</script>

@endsection
