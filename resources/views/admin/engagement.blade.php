@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')

<style>
/* === Dashboard/Admin Theme === */
body, .content-wrapper {
    background: linear-gradient(135deg, #0a0f24, #1c223a);
    color: #fff;
    font-family: 'Poppins', sans-serif;
}

/* Content Header */
.content-header {
    padding-top: 30px;
    padding-bottom: 20px;
    text-align: center;
}
.content-header h1 {
    font-weight: 700;
    color: #facc15;
    text-shadow: 0 0 12px rgba(250,204,21,0.5);
}
.content-header p {
    color: #e5e5e5;
    font-size: 1rem;
}

/* Small Boxes (Cards) */
.small-box {
    border-radius: 16px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(250,204,21,0.25);
    box-shadow: 0 4px 16px rgba(250,204,21,0.25);
    transition: all 0.3s ease;
    margin-top: 20px;
    text-align: center;
    padding: 20px;
}
.small-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 0 20px rgba(250,204,21,0.5);
}
.small-box .inner h3 {
    font-weight: 700;
    font-size: 2rem;
    color: #facc15;
}
.small-box .inner p {
    font-weight: 500;
    color: #fff;
}
.small-box .icon i {
    font-size: 45px;
    margin-top: 10px;
    color: #facc15;
}

/* Custom small-box colors */
.small-box-primary { background: linear-gradient(90deg, #0d6efd, #6610f2) !important; }
.small-box-success { background: linear-gradient(90deg, #198754, #20c997) !important; }
.small-box-warning { background: linear-gradient(90deg, #ffc107, #ffcd39) !important; color: #000 !important; }
.small-box-danger { background: linear-gradient(90deg, #dc3545, #ff6b6b) !important; }

/* Cards for Charts */
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
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    font-weight: 700;
}

/* Chart Header Colors */
.card-header.bg-primary { background: linear-gradient(90deg, #0d6efd, #6610f2); color: #fff; }
.card-header.bg-danger { background: linear-gradient(90deg, #dc3545, #ff6b6b); color: #fff; }

/* Table Styling if needed in charts (optional) */
.table {
    background: transparent;
    color: #fff;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <h1>Engagement Analytics</h1>
        <p>Overview of players, PHP executions, points, and tips used</p>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Overview Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box small-box-primary">
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
                <div class="small-box small-box-success">
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
                <div class="small-box small-box-warning">
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
                <div class="small-box small-box-danger">
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
                <div class="card shadow-lg">
                    <div class="card-header bg-primary">
                        <h5 class="card-title">Most Completed Levels</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="levelsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-danger">
                        <h5 class="card-title">PHP Execution Success vs Errors</h5>
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
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: { responsive: true }
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
        options: { responsive: true }
    });
});
</script>

@endsection
