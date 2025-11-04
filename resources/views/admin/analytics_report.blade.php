@extends('layouts.app')

@section('title', 'Leaderboard Report')

@section('content')

<style>
/* === General Theme === */
body, .content-wrapper {
  background: linear-gradient(135deg, #0a0f24, #1c223a);
  color: #fff;
  font-family: 'Poppins', sans-serif;
}
.content {
  padding-top: 15px !important;
  padding-bottom: 20px;
}

/* === Header === */
.content-header {
  padding-top: 10px;
  padding-bottom: 0;
  text-align: center;
  margin-bottom: 5px;
}
.content-header h1 {
  font-weight: 700;
  color: #facc15;
  text-shadow: 0 0 12px rgba(250, 204, 21, 0.4);
  margin-bottom: 5px;
}

/* === Stat Boxes (Top Section) === */
.row.justify-content-center {
  display: flex;
  justify-content: center;
  gap: 40px; /* spacing between boxes */
}

.small-box {
  flex: 1;
  min-width: 250px;
  max-width: 300px;
  border-radius: 16px;
  background: rgba(255,255,255,0.04);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250,204,21,0.25);
  box-shadow: 0 4px 16px rgba(250,204,21,0.25);
  transition: all 0.3s ease;
  margin: 10px;
  text-align: center;
  padding: 25px 25px;
}
.small-box:hover {
  transform: translateY(-3px);
  box-shadow: 0 0 18px rgba(250,204,21,0.4);
}
.small-box .inner h3 {
  color: #facc15;
  font-weight: 700;
  font-size: 2rem;
  margin-bottom: 5px;
}
.small-box .inner p {
  color: #ffffff;
  font-weight: 500;
  margin-bottom: 10px;
}
.small-box .icon {
  margin-top: 10px;
}
.small-box .icon i {
  color: #facc15;
  font-size: 42px;
  margin-top: 10px;
  margin-left: 10px;
  margin-right: 10px; /* adds space between text and icon */
}

/* === Chart Cards === */
.card {
  border-radius: 16px;
  background: rgba(255,255,255,0.05);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250,204,21,0.25);
  box-shadow: 0 4px 16px rgba(250,204,21,0.15);
  transition: all 0.3s ease;
  margin-bottom: 20px;
}
.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 16px rgba(250,204,21,0.35);
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
  padding: 15px;
  background: rgba(255,255,255,0.02);
}

/* === Charts === */
canvas {
  width: 100% !important;
  height: 230px !important;
}

/* === Sidebar Active Link === */
.nav-link.active, .nav-link:hover {
  background-color: rgba(250, 204, 21, 0.15);
  border-left: 3px solid #facc15;
  color: #facc15 !important;
}

/* === Scrollbar === */
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
    <h1>Leaderboard Report</h1>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Stat Boxes -->
    <div class="row justify-content-center">
      <div class="col-lg-3 col-md-6 col-12">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $totalPlayers }}</h3>
            <p>Total Players</p>
          </div>
          <div class="icon"><i class="fas fa-users"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12">
        <div class="small-box">
          <div class="inner">
            <h3>{{ number_format($averagePoints, 2) }}</h3>
            <p>Avg Points per Player</p>
          </div>
          <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12">
        <div class="small-box">
          <div class="inner">
            <h3>{{ number_format($averageStars, 2) }}</h3>
            <p>Avg Stars per Player</p>
          </div>
          <div class="icon"><i class="fas fa-star"></i></div>
        </div>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Top Players</div>
          <div class="card-body">
            <canvas id="leaderboardChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Level Performance</div>
          <div class="card-body">
            <canvas id="levelPerformanceChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Execution Stats</div>
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
document.addEventListener("DOMContentLoaded", function () {
    const chartTextColor = "#1f2937";

    // Leaderboard Chart
    new Chart(document.getElementById('leaderboardChart'), {
        type: 'bar',
        data: {
            labels: @json($leaderboardData->pluck('username')),
            datasets: [
                { label: 'Total Points', data: @json($leaderboardData->pluck('total_points')), backgroundColor: 'rgba(250,204,21,0.7)', borderColor: '#facc15', borderWidth: 1 },
                { label: 'Total Stars', data: @json($leaderboardData->pluck('total_stars')), backgroundColor: 'rgba(255, 255, 255, 0.3)', borderColor: '#ffea80', borderWidth: 1 }
            ]
        },
        options: { responsive: true, plugins: { legend: { labels: { color: chartTextColor } } }, scales: { x: { ticks: { color: chartTextColor, font: { weight: 'bold' } } }, y: { ticks: { color: chartTextColor, beginAtZero: true } } } }
    });

    // Level Performance Chart
    new Chart(document.getElementById('levelPerformanceChart'), {
        type: 'line',
        data: {
            labels: @json($levelPerformance->pluck('level_number')),
            datasets: [
                { label: 'Avg Stars', data: @json($levelPerformance->pluck('avg_stars')), borderColor: '#facc15', backgroundColor: 'rgba(250,204,21,0.2)', fill: true, tension: 0.4 },
                { label: 'Avg Points', data: @json($levelPerformance->pluck('avg_points')), borderColor: '#ffea80', backgroundColor: 'rgba(255,255,255,0.15)', fill: true, tension: 0.4 }
            ]
        },
        options: { responsive: true, plugins: { legend: { labels: { color: chartTextColor } } }, scales: { x: { ticks: { color: chartTextColor } }, y: { ticks: { color: chartTextColor, beginAtZero: true } } } }
    });

    // PHP Execution Chart
    new Chart(document.getElementById('executionChart'), {
        type: 'pie',
        data: {
            labels: ['Successful', 'Failed'],
            datasets: [{ data: [{{ $phpExecutions->successful }}, {{ $phpExecutions->errors }}], backgroundColor: ['#27ae60', '#e74c3c'], borderColor: ['rgba(250,204,21,0.3)', 'rgba(255,255,255,0.1)'], borderWidth: 1 }]
        },
        options: { plugins: { legend: { labels: { color: chartTextColor } } } }
    });
});
</script>

@endsection
