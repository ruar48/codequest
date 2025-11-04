@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
  body {
    background: radial-gradient(circle at top, #0a1128 0%, #001845 40%, #00296b 100%) !important;
    color: #f1f5f9;
    font-family: 'Poppins', sans-serif;
  }

  .content-header {
    display: none;
  }

  h1, h3, p, small, label, .breadcrumb-item a, .breadcrumb-item.active {
    color: #f8fafc !important;
  }

  /* Stat Cards */
  .small-box {
    border-radius: 15px;
    position: relative;
    overflow: hidden;
    background: rgba(15,23,42,0.85);
    border: 1px solid rgba(250,204,21,0.4);
    box-shadow: 0 0 10px rgba(250,204,21,0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 18px rgba(250,204,21,0.5);
  }

  .small-box .icon {
    opacity: 0.15;
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 70px;
    color: rgba(255,255,255,0.5);
  }

  .small-box .inner h3 {
    font-size: 2.4rem;
    font-weight: 700;
    color: #fff;
  }

  .small-box .inner p {
    font-size: 1.05rem;
    font-weight: 600;
    color: #facc15;
  }

  /* Timeline */
  .timeline {
    position: relative;
    margin-left: 25px;
    padding-left: 10px;
  }

  .timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    width: 3px;
    height: 100%;
    background: linear-gradient(180deg, #facc15, transparent);
    border-radius: 3px;
  }

  .timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 1.5rem;
  }

  .timeline-point {
    position: absolute;
    left: 3px;
    top: 15px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: radial-gradient(circle, #facc15, #fbbf24);
    box-shadow: 0 0 10px rgba(250,204,21,0.9);
  }

  .timeline-content {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(250,204,21,0.3);
    border-radius: 12px;
    padding: 1rem;
    color: #fff;
    backdrop-filter: blur(6px);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .timeline-content:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 16px rgba(250,204,21,0.4);
  }

  .timeline-content h5 {
    color: #facc15;
    font-weight: 600;
  }

  .timeline-content p, .timeline-content small {
    color: #f8fafc;
  }

  .timeline-content strong {
    color: #fde047;
  }

  /* Section Title */
  .section-title {
    color: #facc15;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 0 8px rgba(250,204,21,0.6);
  }
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
