@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
/* General Theme */
body, .content-wrapper {
  background: #f8f4ec; /* soft warm pastel background (light cream) */
  color: #333; /* dark enough for readability */
  font-family: 'Poppins', sans-serif;
}

/* Fix: Add breathing room below white navbar */
.content {
  padding-top: 80px !important;
  padding-bottom: 40px;
}

/* Header Section */
.content-header {
  padding-top: 15px;   /* reduced from 30px */
  padding-bottom: 15px; /* reduced from 30px */
  margin-bottom: 30px;  /* slightly reduced from 40px */
  text-align: center;
}
.content-header h1 {
  font-weight: 700;
  color: #d4af7f; /* pastel gold */
  text-shadow: 0 0 6px rgba(212, 175, 127, 0.4); /* subtle glow */
  margin-top: 0; /* remove extra top margin */
  margin-bottom: 0; /* remove extra bottom margin */
}

/* Stat Cards */
.small-box {
  border-radius: 16px;
  background: rgba(255, 250, 240, 0.6); /* soft cream with slight transparency */
  backdrop-filter: blur(8px);
  border: 1px solid rgba(212, 175, 127, 0.25);
  box-shadow: 0 4px 16px rgba(212, 175, 127, 0.25);
  transition: all 0.3s ease;
  margin-top: 30px;
  margin-bottom: 35px;
  text-align: center;
  padding: 20px;
}
.small-box:hover {
  transform: translateY(-6px);
  box-shadow: 0 0 20px rgba(212, 175, 127, 0.4);
}
.small-box .inner h3 {
  color: #d4af7f;
  font-weight: 700;
  font-size: 2rem;
}
.small-box .inner p {
  color: #333;
  font-weight: 500;
}
.small-box .icon i {
  color: #d4af7f;
  font-size: 45px;
  margin-top: 10px;
}

/* Timeline Layout */
h3.section-title {
  color: #333;
  font-weight: 600;
  text-shadow: 0 0 6px rgba(212, 175, 127, 0.3);
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
  background-color: rgba(212, 175, 127, 0.4);
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
  background-color: #d4af7f;
  box-shadow: 0 0 8px rgba(212, 175, 127, 0.8);
}
.timeline-content {
  background: rgba(255, 250, 240, 0.6);
  color: #333;
  border: 1px solid rgba(212, 175, 127, 0.3);
  border-left: 4px solid #d4af7f;
  border-radius: 10px;
  transition: all 0.3s ease;
  backdrop-filter: blur(8px);
  margin-bottom: 25px;
  padding: 15px;
}
.timeline-content:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 14px rgba(212, 175, 127, 0.3);
}
.timeline-content h5 {
  color: #d4af7f;
  font-weight: 600;
}
.timeline-content p {
  color: #555;
}
.timeline-content strong {
  color: #333;
}

/* Sidebar Highlight */
.nav-link.active, .nav-link:hover {
  background-color: rgba(212, 175, 127, 0.15);
  border-left: 3px solid #d4af7f;
  color: #d4af7f !important;
}

/* Scrollbar Theme */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: #e7e3da;
}
::-webkit-scrollbar-thumb {
  background-color: #d4af7f;
  border-radius: 4px;
}
</style>

<section class="content">
  <div class="container-fluid">

    <!-- Dashboard Title -->
    <div class="row">
      <div class="col-12 text-center mb-2">
        <h2 class="fw-bold" style="
          color: #facc15;
          text-shadow: 0 0 10px rgba(250,204,21,0.6);
          margin-top: -10px;
          margin-bottom: 10px;
        ">
          <i class="fas fa-chart-line"></i> Dashboard
        </h2>
      </div>
    </div>

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

    <!-- Reduced Space -->
    <h3 class="section-title mt-2 mb-3"><i class="fas fa-trophy"></i> Player Progress Timeline</h3>

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
