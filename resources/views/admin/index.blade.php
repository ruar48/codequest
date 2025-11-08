@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
/* General Theme */
body, .content-wrapper {
  background: #ffffff; /* pure white background */
  color: #333; /* dark enough for readability */
  font-family: 'Poppins', sans-serif;
}

/* Reduce space around main content */
.content {
  padding-top: 40px !important;
  padding-bottom: 40px;
}

/* Header Section */
.content-header {
  padding-top: 5px;
  padding-bottom: 5px;
  margin-bottom: 20px;
  text-align: center;
}
.content-header h1 {
  font-weight: 700;
  color: #d4af7f;
  text-shadow: 0 0 4px rgba(212, 175, 127, 0.4);
  margin-top: 0;
  margin-bottom: 0;
}

/* Stat Cards */
.small-box {
  border-radius: 16px;
  background: #ffffff;
  border: 1px solid rgba(212, 175, 127, 0.2);
  box-shadow: 0 6px 18px rgba(212, 175, 127, 0.25), 0 4px 12px rgba(0,0,0,0.06); /* lighter shadow */
  transition: all 0.3s ease;
  margin-top: 30px;
  margin-bottom: 35px;
  text-align: center;
  padding: 20px;
}
.small-box:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 28px rgba(212, 175, 127, 0.3), 0 6px 18px rgba(0,0,0,0.08); /* lighter hover shadow */
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
/* Timeline Point Glow */
.timeline-point {
  position: absolute;
  left: -2px;
  top: 10px;
  width: 14px;
  height: 14px;
  border-radius: 50%;
  background-color: #d4af7f;
  box-shadow: 0 0 10px rgba(212, 175, 127, 0.7); /* slightly reduced glow */
}
.timeline-content {
  background: #ffffff;
  color: #333;
  border: 1px solid rgba(212, 175, 127, 0.3);
  border-left: 4px solid #d4af7f;
  border-radius: 10px;
  transition: all 0.3s ease;
  box-shadow: 0 6px 18px rgba(212, 175, 127, 0.25), 0 4px 12px rgba(0,0,0,0.06); /* lighter shadow */
  margin-bottom: 25px;
  padding: 15px;
}
.timeline-content:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(212, 175, 127, 0.3), 0 6px 18px rgba(0,0,0,0.08); /* lighter hover shadow */
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
  color: #0b3d91; /* dark blue */
  text-shadow: 0 0 10px rgba(11,61,145,0.4); /* subtle matching glow */
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
