@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
/* Timeline */
.timeline {
  position: relative;
  margin-left: 20px;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 8px;
  top: 0;
  width: 2px;
  height: 100%;
  background-color: rgba(0, 123, 255, 0.4);
}
.timeline-item {
  position: relative;
  padding-left: 30px;
}
.timeline-point {
  position: absolute;
  left: -2px;
  top: 10px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: #007bff;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.7);
}
.timeline-content {
  background: #ffffff;
  color: #212529;
  transition: all 0.25s ease;
  border-left: 4px solid #007bff;
}
.timeline-content:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

/* Player names and text */
.timeline-content h5 {
  color: #007bff;
  font-weight: 600;
}
.timeline-content p {
  color: #333;
  font-size: 15px;
}
.timeline-content strong {
  color: #222;
}

/* Header */
h3 i {
  color: #007bff;
}
h3 {
  color: #222;
  font-weight: 600;
  text-shadow: none;
}

/* Stat Cards */
.small-box {
  border-radius: 12px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  transition: all 0.2s ease;
}
.small-box:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}
.small-box .inner h3,
.small-box .inner p {
  color: #fff;
}
.bg-primary { background-color: #0056b3 !important; }
.bg-success { background-color: #198754 !important; }
.bg-warning { background-color: #ffb300 !important; color: #fff !important; }
.bg-danger  { background-color: #d63384 !important; color: #fff !important; }
</style>


<section class="content">
  <div class="container-fluid">

    <!-- Stat Cards -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $adminCount }}</h3>
            <p>Admins</p>
          </div>
          <div class="icon"><i class="fas fa-user-shield"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $educatorCount }}</h3>
            <p>Educators</p>
          </div>
          <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $playerCount }}</h3>
            <p>Players</p>
          </div>
          <div class="icon"><i class="fas fa-gamepad"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $totalUsers }}</h3>
            <p>All Users</p>
          </div>
          <div class="icon"><i class="fas fa-users"></i></div>
        </div>
      </div>
    </div>

    <h3 class="section-title"><i class="fas fa-trophy"></i> Player Progress Timeline</h3>

    <div class="timeline">
      @forelse($userProgress as $progress)
        <div class="timeline-item">
          <div class="timeline-point"></div>
          <div class="timeline-content">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5><i class="fas fa-user-circle"></i> {{ $progress['user_name'] }}</h5>
                <p class="small mb-0">{{ $progress['email'] }}</p>
              </div>
              <small>{{ $progress['created_at'] }}</small>
            </div>
            <div class="mt-2">
              <p class="mb-0">
                ✅ Completed <strong>Level {{ $progress['level_number'] }}</strong><br>
                ⭐ Stars: <strong>{{ $progress['stars'] }}</strong> |
                💎 Points: <strong>{{ $progress['points'] }}</strong>
              </p>
            </div>
          </div>
        </div>
      @empty
        <p class="text-center text-light">No level progress yet.</p>
      @endforelse
    </div>

  </div>
</section>

@endsection
