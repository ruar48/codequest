@extends('layouts.app')

@section('title', 'Dashboard')

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

/* Header Section (Optional – if you keep a header title) */
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
  margin-top: 30px; /* adds consistent top spacing */
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

/* Timeline Layout */
h3.section-title {
  color: #fff;
  font-weight: 600;
  text-shadow: 0 0 10px rgba(250, 204, 21, 0.3);
  margin-top: 50px;
  margin-bottom: 20px;
}

.timeline {
  position: relative;
  margin-left: 30px;
  margin-top: 40px;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 8px;
  top: 0;
  width: 2px;
  height: 100%;
  background-color: rgba(250, 204, 21, 0.4);
}
.timeline-item {
  position: relative;
  padding-left: 40px;
}
.timeline-point {
  position: absolute;
  left: -2px;
  top: 10px;
  width: 14px;
  height: 14px;
  border-radius: 50%;
  background-color: #facc15;
  box-shadow: 0 0 8px rgba(250, 204, 21, 0.8);
}
.timeline-content {
  background: rgba(255, 255, 255, 0.05);
  color: #fff;
  border: 1px solid rgba(250, 204, 21, 0.3);
  border-left: 4px solid #facc15;
  border-radius: 10px;
  transition: all 0.3s ease;
  backdrop-filter: blur(8px);
  margin-bottom: 25px;
  padding: 15px;
}
.timeline-content:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 14px rgba(250, 204, 21, 0.4);
}
.timeline-content h5 {
  color: #facc15;
  font-weight: 600;
}
.timeline-content p {
  color: #e4e4e4;
}
.timeline-content strong {
  color: #fff;
}

/* Sidebar Highlight */
.nav-link.active, .nav-link:hover {
  background-color: rgba(250, 204, 21, 0.15);
  border-left: 3px solid #facc15;
  color: #facc15 !important;
}

/* Scrollbar Theme */
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

<section class="content">
  <div class="container-fluid">

    <!-- Stat Cards -->
    <div class="row justify-content-center">
      <div class="col-lg-3 col-md-6 col-12">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $adminCount }}</h3>
            <p>Admins</p>
          </div>
          <div class="icon"><i class="fas fa-user-shield"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $educatorCount }}</h3>
            <p>Educators</p>
          </div>
          <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12">
        <div class="small-box">
          <div class="inner">
            <h3>{{ $playerCount }}</h3>
            <p>Players</p>
          </div>
          <div class="icon"><i class="fas fa-gamepad"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12">
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
