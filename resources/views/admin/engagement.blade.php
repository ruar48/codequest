@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-white">Engagement Analytics</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Overview Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="card bg-gradient-primary text-white shadow-sm rounded-lg">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $totalPlayers }}</h3>
                            <p class="mb-0">Total Players</p>
                        </div>
                        <div class="icon fs-2">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="card bg-gradient-success text-white shadow-sm rounded-lg">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $phpExecutions['total'] }}</h3>
                            <p class="mb-0">Total PHP Executions</p>
                        </div>
                        <div class="icon fs-2">
                            <i class="fas fa-terminal"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="card bg-gradient-warning text-white shadow-sm rounded-lg">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ number_format($averagePoints, 2) }}</h3>
                            <p class="mb-0">Avg Points per Player</p>
                        </div>
                        <div class="icon fs-2">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="card bg-gradient-danger text-white shadow-sm rounded-lg">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $totalTipsUsed }}</h3>
                            <p class="mb-0">Tips Used</p>
                        </div>
                        <div class="icon fs-2">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="card-title mb-0">Most Completed Levels</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="levelsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header bg-gradient-danger text-white">
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
        var levelsCtx = document.getElementById('levelsChart').getContext('2d');
        new Chart(levelsCtx, {
            type: 'bar',
            data: {
                labels: @json($mostCompletedLevels->pluck('level_number')),
                datasets: [{
                    label: 'Completions',
                    data: @json($mostCompletedLevels->pluck('completion_count')),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderRadius: 4
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
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
            options: { responsive: true, maintainAspectRatio: false }
        });
    });
</script>
@endsection
