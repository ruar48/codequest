@extends('layouts.app')

@section('title', 'Leaderboard Report')

@section('content')
<style>
/* === White-Maroon Dashboard Theme === */
body, .content-wrapper {
  background-color: #ffffff !important;
  color: #1c1c1c;
  font-family: 'Poppins', sans-serif;
}

.content {
  padding-top: 20px !important;
  padding-bottom: 20px;
}

/* === Header === */
.content-header {
  text-align: center;
  margin-bottom: 10px;
}
.content-header h1 {
  font-weight: 700;
  color: #7b2d2d;
  text-shadow: 0 0 4px rgba(123, 45, 45, 0.2);
}

/* === Stat Boxes === */
.small-box {
  background: #fff;
  border: 1px solid #c2a5a5;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(123, 45, 45, 0.15);
  text-align: center;
  padding: 25px 20px;
  transition: all 0.3s ease;
  margin-bottom: 20px;
}
.small-box:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(123, 45, 45, 0.25);
}
.small-box .inner h3 {
  color: #7b2d2d;
  font-weight: 700;
  font-size: 1.9rem;
  margin-bottom: 5px;
}
.small-box .inner p {
  color: #333;
  font-weight: 500;
  margin-bottom: 10px;
}
.small-box .icon i {
  color: #7b2d2d;
  font-size: 28px;
  margin-top: 5px;
}

/* === Cards for Charts === */
.card {
  border-radius: 16px;
  background: #ffffff;
  border: 1px solid #c2a5a5;
  box-shadow: 0 4px 10px rgba(123, 45, 45, 0.1);
  transition: all 0.3s ease;
  margin-bottom: 20px;
}
.card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 18px rgba(123, 45, 45, 0.25);
}
.card-header {
  font-weight: 700;
  font-size: 1.1rem;
  text-align: center;
  color: #fff;
  background: linear-gradient(90deg, #7b2d2d, #a85151);
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  padding: 10px 0;
}
.card-body {
  padding: 15px;
}

/* === Charts === */
canvas {
  width: 100% !important;
  height: 230px !important;
}

/* === Sidebar Active Link === */
.nav-link.active, .nav-link:hover {
  background-color: rgba(123, 45, 45, 0.1);
  border-left: 3px solid #7b2d2d;
  color: #7b2d2d !important;
}

/* === Scrollbar === */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-thumb {
  background-color: #7b2d2d;
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
    const chartTextColor = "#1c1c1c";

    // Leaderboard Chart
    new Chart(document.getElementById('leaderboardChart'), {
        type: 'bar',
        data: {
            labels: @json($leaderboardData->pluck('username')),
            datasets: [
                { label: 'Total Points', data: @json($leaderboardData->pluck('total_points')), backgroundColor: 'rgba(123, 45, 45, 0.7)', borderColor: '#7b2d2d', borderWidth: 1 },
                { label: 'Total Stars', data: @json($leaderboardData->pluck('total_stars')), backgroundColor: 'rgba(200,150,150,0.4)', borderColor: '#a85151', borderWidth: 1 }
            ]
        },
        options: { 
            responsive: true, 
            plugins: { legend: { labels: { color: chartTextColor } } }, 
            scales: { 
                x: { ticks: { color: chartTextColor, font: { weight: 'bold' } } }, 
                y: { ticks: { color: chartTextColor, beginAtZero: true } } 
            } 
        }
    });

    // Level Performance Chart
    new Chart(document.getElementById('levelPerformanceChart'), {
        type: 'line',
        data: {
            labels: @json($levelPerformance->pluck('level_number')),
            datasets: [
                { label: 'Avg Stars', data: @json($levelPerformance->pluck('avg_stars')), borderColor: '#7b2d2d', backgroundColor: 'rgba(123,45,45,0.15)', fill: true, tension: 0.4 },
                { label: 'Avg Points', data: @json($levelPerformance->pluck('avg_points')), borderColor: '#a85151', backgroundColor: 'rgba(168,81,81,0.1)', fill: true, tension: 0.4 }
            ]
        },
        options: { 
            responsive: true, 
            plugins: { legend: { labels: { color: chartTextColor } } }, 
            scales: { 
                x: { ticks: { color: chartTextColor } }, 
                y: { ticks: { color: chartTextColor, beginAtZero: true } } 
            } 
        }
    });

    // PHP Execution Chart
    new Chart(document.getElementById('executionChart'), {
        type: 'pie',
        data: {
            labels: ['Successful', 'Failed'],
            datasets: [{
                data: [{{ $phpExecutions->successful }}, {{ $phpExecutions->errors }}],
                backgroundColor: ['#7b2d2d', '#c2a5a5'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 1
            }]
        },
        options: { plugins: { legend: { labels: { color: chartTextColor } } } }
    });
});
</script>

@endsection
