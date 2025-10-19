@extends('layouts.app')

@section('title', 'Home Page')
@section('content')

<style>
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
    background-color: #007bff33;
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
}
.timeline-content {
    background-color: #fff;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.timeline-content:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
        <!-- Stat Cards -->
        <div class="row">
            <!-- Admins -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $adminCount }}</h3>
                        <p>Admins</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>

            <!-- Educators -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $educatorCount }}</h3>
                        <p>Educators</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </div>

            <!-- Players -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $playerCount }}</h3>
                        <p>Players</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                </div>
            </div>

            <!-- All Users -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalUsers }}</h3>
                        <p>All Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mb-3"><i class="fas fa-trophy"></i> Player Progress Timeline</h3>

<div class="timeline">
    @forelse($userProgress as $progress)
        <div class="timeline-item mb-4">
            <div class="timeline-point bg-primary"></div>
            <div class="timeline-content card shadow-sm border-0 rounded-3 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 text-primary">
                            <i class="fas fa-user-circle"></i> {{ $progress['user_name'] }}
                        </h5>
                        <p class="mb-0 text-muted small">{{ $progress['email'] }}</p>
                    </div>
                    <small class="text-secondary">{{ $progress['created_at'] }}</small>
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
        <p class="text-center text-muted">No level progress yet.</p>
    @endforelse
</div>

    </div>
</section>


    @endsection
