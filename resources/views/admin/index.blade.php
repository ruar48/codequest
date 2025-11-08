@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
  body::before {
  content: '✅ New Style Active';
  position: fixed;
  top: 8px;
  left: 12px;
  color: #d4b86a;
  font-weight: bold;
  z-index: 9999;
}
/* === Light Pastel Theme === */
body, .content-wrapper {
  background: linear-gradient(135deg, #f4f2ea, #eae6db);
  color: #2a2a2a;
  font-family: 'Poppins', sans-serif;
}

/* Content Spacing */
.content {
  padding-top: 80px !important;
  padding-bottom: 40px;
}

/* Header */
.content-header {
  text-align: center;
  padding: 30px 0;
  margin-bottom: 40px;
}
.content-header h1 {
  font-weight: 700;
  color: #d4b86a;
  text-shadow: 0 0 10px rgba(212, 184, 106, 0.4);
}

/* Stat Cards */
.small-box {
  border-radius: 16px;
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(212, 184, 106, 0.3);
  box-shadow: 0 4px 10px rgba(212, 184, 106, 0.25);
  transition: all 0.3s ease;
  margin-top: 30px;
  margin-bottom: 35px;
  text-align: center;
  padding: 20px;
}
.small-box:hover {
  transform: translateY(-6px);
  box-shadow: 0 0 18px rgba(212, 184, 106, 0.45);
}
.small-box .inner h3 {
  color: #d4b86a;
  font-weight: 700;
  font-size: 2rem;
}
.small-box .inner p {
  color: #333;
  font-weight: 500;
}
.small-box .icon i {
  color: #d4b86a;
  font-size: 45px;
  margin-top: 10px;
}

/* Section Titles */
h3.section-title {
  color: #2a2a2a;
  font-weight: 600;
  text-shadow: 0 0 6px rgba(212, 184, 106, 0.3);
  margin-top: 50px;
  margin-bottom: 20px;
}

/* Timeline */
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
  background-color: rgba(212, 184, 106, 0.4);
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
  background-color: #d4b86a;
  box-shadow: 0 0 8px rgba(212, 184, 106, 0.8);
}
.timeline-content {
  background: rgba(255, 255, 255, 0.9);
  color: #333;
  border: 1px solid rgba(212, 184, 106, 0.3);
  border-left: 4px solid #d4b86a;
  border-radius: 10px;
  transition: all 0.3s ease;
  backdrop-filter: blur(8px);
  margin-bottom: 25px;
  padding: 15px;
}
.timeline-content:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 14px rgba(212, 184, 106, 0.3);
}
.timeline-content h5 {
  color: #d4b86a;
  font-weight: 600;
}
.timeline-content p {
  color: #444;
}
.timeline-content strong {
  color: #000;
}

/* Sidebar Highlight */
.nav-link.active, .nav-link:hover {
  background-color: rgba(212, 184, 106, 0.15);
  border-left: 3px solid #d4b86a;
  color: #d4b86a !important;
}

/* Scrollbar */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: #f0ede5;
}
::-webkit-scrollbar-thumb {
  background-color: #d4b86a;
  border-radius: 4px;
}
</style>

<section class="content">
  <div class="container-fluid">

    <!-- Dashboard Title -->
    <div class="row">
      <div class="col-12 text-center mb-2">
        <h2 class="fw-bold" style="
          color: #d4b86a;
          text-shadow: 0 0 10px rgba(212,184,106,0.4);
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

    <!-- Timeline -->
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
        <p class="text-center text-secondary">No level progress yet.</p>
      @endforelse
    </div>

  </div>
</section>

@endsection
