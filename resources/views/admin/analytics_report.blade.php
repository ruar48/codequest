@extends('layouts.app')

@section('title', 'Leaderboard Report')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Leaderboard Report</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Overall Statistics -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
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
                <div class="small-box bg-success">
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
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($averageStars, 2) }}</h3>
                        <p>Avg Stars per Player</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts in Row -->
        <div class="row">

            <!-- Leaderboard Chart -->
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Top Players</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="leaderboardChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Level Performance Chart -->
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">Level Performance</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="levelPerformanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- PHP Execution Stats Chart -->
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title">Execution Stats</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="executionChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Leaderboard Chart
    const leaderboardCtx = document.getElementById('leaderboardChart').getContext('2d');
    new Chart(leaderboardCtx, {
        type: 'bar',
        data: {
            labels: @json($leaderboardData->pluck('username')),
            datasets: [
                {
                    label: 'Total Points',
                    data: @json($leaderboardData->pluck('total_points')),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                },
                {
                    label: 'Total Stars',
                    data: @json($leaderboardData->pluck('total_stars')),
                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                }
            ]
        },
        options: { responsive: true }
    });

    // Level Performance Chart
    const levelCtx = document.getElementById('levelPerformanceChart').getContext('2d');
    new Chart(levelCtx, {
        type: 'line',
        data: {
            labels: @json($levelPerformance->pluck('level_number')),
            datasets: [
                {
                    label: 'Avg Stars',
                    data: @json($levelPerformance->pluck('avg_stars')),
                    borderColor: 'rgba(255, 206, 86, 1)',
                    fill: false
                },
                {
                    label: 'Avg Points',
                    data: @json($levelPerformance->pluck('avg_points')),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: false
                }
            ]
        },
        options: { responsive: true }
    });

    // PHP Execution Chart
    const executionCtx = document.getElementById('executionChart').getContext('2d');
    new Chart(executionCtx, {
        type: 'pie',
        data: {
            labels: ['Successful', 'Failed'],
            datasets: [{
                data: [{{ $phpExecutions->successful }}, {{ $phpExecutions->errors }}],
                backgroundColor: ['rgba(75, 192, 192, 0.7)', 'rgba(255, 99, 132, 0.7)']
            }]
        },
        options: { responsive: true }
    });
</script>

@endsection
