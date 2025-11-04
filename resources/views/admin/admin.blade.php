@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="content-header text-center py-2">
    <h1 class="fw-bold text-warning mb-1" style="font-size: 1.8rem;">DASHBOARD</h1>
    <p class="text-light mb-2" style="font-size: 0.95rem;">Overview of CodeQuest performance and player activity</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Stat Cards -->
    <div class="row justify-content-center mb-2">
      <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="card small-box text-center shadow-lg border border-warning rounded-4 bg-dark">
          <div class="card-body">
            <div class="icon mb-2 text-warning"><i class="fas fa-user-shield fa-2x"></i></div>
            <h3 class="fw-bold text-warning">{{ $adminCount }}</h3>
            <p class="text-light mb-0">Admins</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="card small-box text-center shadow-lg border border-warning rounded-4 bg-dark">
          <div class="card-body">
            <div class="icon mb-2 text-warning"><i class="fas fa-chalkboard-teacher fa-2x"></i></div>
            <h3 class="fw-bold text-warning">{{ $educatorCount }}</h3>
            <p class="text-light mb-0">Educators</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="card small-box text-center shadow-lg border border-warning rounded-4 bg-dark">
          <div class="card-body">
            <div class="icon mb-2 text-warning"><i class="fas fa-gamepad fa-2x"></i></div>
            <h3 class="fw-bold text-warning">{{ $playerCount }}</h3>
            <p class="text-light mb-0">Players</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="card small-box text-center shadow-lg border border-warning rounded-4 bg-dark">
          <div class="card-body">
            <div class="icon mb-2 text-warning"><i class="fas fa-users fa-2x"></i></div>
            <h3 class="fw-bold text-warning">{{ $totalUsers }}</h3>
            <p class="text-light mb-0">All Users</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Player Progress Section -->
    <h3 class="fw-bold text-warning text-center mt-3 mb-3">
      <i class="fas fa-trophy me-2"></i>Player Progress Timeline
    </h3>

    <div class="card bg-dark border border-warning shadow-lg rounded-4 p-3">
      <div class="timeline">
        @forelse($userProgress as $progress)
          <div class="timeline-item mb-3 position-relative ps-4">
            <div class="timeline-point"></div>
            <div class="timeline-content p-3 rounded-3 border border-warning bg-dark">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <div>
                  <h6 class="fw-bold text-warning mb-0">
                    <i class="fas fa-user-circle me-1"></i> {{ $progress['user_name'] }}
                  </h6>
                  <small class="text-light">{{ $progress['email'] }}</small>
                </div>
                <small class="text-secondary">{{ $progress['created_at'] }}</small>
              </div>
              <div class="text-light mt-1">
                ✅ Completed <strong>Level {{ $progress['level_number'] }}</strong><br>
                ⭐ Stars: <strong class="text-warning">{{ $progress['stars'] }}</strong> |
                💎 Points: <strong class="text-warning">{{ $progress['points'] }}</strong>
              </div>
            </div>
          </div>
        @empty
          <p class="text-center text-light mb-0">No level progress yet.</p>
        @endforelse
      </div>
    </div>

  </div>
</section>

<style>
body {
  background-color: #0d0d1a;
  color: #fff;
  font-family: 'Poppins', sans-serif;
}

.card {
  background-color: #101020;
}

.timeline {
  position: relative;
  padding-left: 15px;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 7px;
  top: 0;
  width: 2px;
  height: 100%;
  background-color: rgba(255, 204, 0, 0.3);
}
.timeline-point {
  position: absolute;
  left: 1px;
  top: 12px;
  width: 12px;
  height: 12px;
  background-color: #facc15;
  border-radius: 50%;
  box-shadow: 0 0 10px rgba(255, 204, 0, 0.8);
}
.timeline-content {
  transition: all 0.3s ease;
}
.timeline-content:hover {
  transform: translateY(-3px);
  box-shadow: 0 0 12px rgba(255, 204, 0, 0.5);
}
</style>

@endsection
