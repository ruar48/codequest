@extends('layouts.app')

@section('title', 'Engagement Analytics')

@section('content')

<style>
/* General Theme */
body, .content-wrapper {
  background: linear-gradient(135deg, #0a0f24, #1c223a);
  color: #fff;
  font-family: 'Poppins', sans-serif;
}

/* Fix: Add breathing room below white navbar */
.content {
  padding-top: 80px !important;
  padding-bottom: 40px;
}

/* Header Section */
.content-header {
  padding-top: 30px;
  padding-bottom: 30px;
  margin-bottom: 40px;
  text-align: center;
}
.content-header h1 {
  font-weight: 700;
  color: #facc15;
  text-shadow: 0 0 12px rgba(250, 204, 21, 0.4);
}

/* Stat Cards */
.small-box {
  border-radius: 16px;
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250, 204, 21, 0.25);
  box-shadow: 0 4px 16px rgba(250, 204, 21, 0.25);
  transition: all 0.3s ease;
  margin-top: 30px;
  margin-bottom: 35px;
  text-align: center;
  padding: 20px;
}
.small-box:hover {
  transform: translateY(-6px);
  box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
}
.small-box .inner h3 {
  color: #facc15;
  font-weight: 700;
  font-size: 2rem;
}
.small-box .inner p {
  color: #ffffff;
  font-weight: 500;
}
.small-box .icon i {
  color: #facc15;
  font-size: 45px;
  margin-top: 10px;
}

/* Cards for charts */
.card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250, 204, 21, 0.25);
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(250, 204, 21, 0.25);
  transition: all 0.3s ease;
  margin-bottom: 30px;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
}
.card-header {
  font-weight: 700;
  font-size: 1.2rem;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  color: #fff;
  background: rgba(250, 204, 21, 0.1);
}

/* Chart canvas */
canvas {
  background: transparent;
  max-height: 300px;
}

/* Sidebar Highlight */
.nav-link.active, .nav-link:hover {
  background-color: rgba(250, 204, 21, 0.15);
  border-left: 3px solid #facc15;
  color: #facc15 !important;
}

/* Scrollbar */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: #111827;
}
::-webkit-scrollbar-thumb {
  background-color: #facc15;
  border-radius: 4px;
}
</style>

<div class="content-header">
  <div class="container-fluid">
    <h1>Engagement Analytics</h1>
    <p>Overview of player activity and PHP executions</p>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Overview Cards -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $totalPlayers }}</h3>
            <p>Total Players</p>
          </div>
          <div class="icon"><i class="fas fa-users"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $phpExecutions['total'] }}</h3>
            <p>Total PHP Executions</p>
          </div>
          <div class="icon"><i class="fas fa-terminal"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box">
          <div class="inner">
            <h3>{{ number_format($averagePoints, 2) }}</h3>
            <p>Avg Points per Player</p>
          </div>
          <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $totalTipsUsed }}</h3>
            <p>Tips Used</p>
          </div>
          <div class="icon"><i class="fas fa-lightbulb"></i></div>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Most Completed Levels</div>
          <div class="card-body">
            <canvas id="levelsChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
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
