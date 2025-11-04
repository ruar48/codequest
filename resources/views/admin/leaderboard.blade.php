@extends('layouts.app')

@section('title', 'Leaderboards')

@section('content')
<!-- === Dashboard-style CSS === -->
<style>
/* === Global Dashboard Theme === */
body, .content-wrapper {
  background: linear-gradient(135deg, #0a0f24, #1c223a);
  color: #fff;
  font-family: 'Poppins', sans-serif;
}

/* === Header === */
.content-header {
  text-align: center;
  padding-top: 15px;
  padding-bottom: 0;
  margin-bottom: 5px;
}

.content-header h1 {
  font-weight: 700;
  color: #facc15;
  font-size: 1.8rem;
  text-shadow: 0 0 12px rgba(250, 204, 21, 0.4);
}

.content-header p {
  color: #e5e5e5;
  font-size: 0.95rem;
  margin-bottom: 0;
}

/* === Container === */
.content {
  padding-top: 40px !important;
  padding-bottom: 40px;
}

/* === Buttons === */
.btn-warning, .btn-primary, .btn-danger, .btn-success {
  border-radius: 6px;
  font-weight: 600;
  transition: all 0.3s;
}
.btn-warning:hover, .btn-primary:hover, .btn-danger:hover, .btn-success:hover {
  transform: translateY(-2px);
}
.btn-primary {
  background-color: #facc15;
  color: #1c1c1c;
  border: none;
}
.btn-primary:hover {
  box-shadow: 0 0 10px rgba(250, 204, 21, 0.8);
}

/* === Card === */
.card {
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250, 204, 21, 0.25);
  box-shadow: 0 4px 16px rgba(250, 204, 21, 0.25);
  border-radius: 16px;
  margin-top: 8px !important;
  transition: all 0.3s ease;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
}

/* === Card Header === */
.card-header {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
  font-weight: 700;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
}

/* === Table === */
.table-dark, .table {
  background: transparent;
  color: #fff;
}
.table thead th {
  color: #000;
  background-color: #facc15;
  font-weight: 600;
}
.table tbody tr:hover {
  background: rgba(250, 204, 21, 0.1);
  transition: 0.3s;
}

/* === Badges === */
.badge-success { background-color: #27ae60; }
.badge-warning { background-color: #f1c40f; color: #1c1c1c; }
.badge-danger  { background-color: #e74c3c; }

/* === Modal === */
.modal-content {
  background-color: #101020;
  color: #fff;
  border: 1px solid rgba(250, 204, 21, 0.4);
  border-radius: 12px;
}
.modal-header {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
  border-bottom: none;
}
.form-control, textarea, select {
  background-color: #0a0f24;
  color: #fff;
  border: 1px solid rgba(250, 204, 21, 0.5);
}
.form-control:focus {
  box-shadow: 0 0 8px rgba(250, 204, 21, 0.6);
  border-color: #facc15;
}

/* === DataTables === */
.dataTables_wrapper .dataTables_filter input {
  background-color: #0a0f24;
  border: 1px solid rgba(250, 204, 21, 0.4);
  color: #fff;
  border-radius: 6px;
  padding: 4px 8px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background-color: transparent;
  border: none;
  color: #facc15 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #000 !important;
  border-radius: 6px;
}
.dataTables_wrapper .dataTables_info {
  color: #aaa;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <h1>Leaderboards</h1>
        <p>Check out the top players and their scores!</p>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Leaderboards Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Top Players</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center align-middle" id="LeaderBoardsTable">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Points</th>
                            <th>Stars</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaderboardData as $index => $player)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $player->full_name }}</td>
                            <td>{{ $player->total_points }}</td>
                            <td>{{ $player->total_stars }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(document).ready(function () {
    $('#LeaderBoardsTable').DataTable({
        responsive: true,
        autoWidth: false,
        lengthChange: true,
        pageLength: 10,
        dom: '<"row mb-3"' +
                '<"col-md-4 d-flex align-items-center"l>' +
                '<"col-md-4 text-center"B>' +
                '<"col-md-4 d-flex justify-content-end"f>' +
             '>rtip',
        buttons: [
            { extend: 'copy', className: 'btn btn-sm btn-primary me-1' },
            { extend: 'csv', className: 'btn btn-sm btn-success me-1' },
            { extend: 'excel', className: 'btn btn-sm btn-warning me-1' },
            { extend: 'pdf', className: 'btn btn-sm btn-danger me-1' },
            { extend: 'print', className: 'btn btn-sm btn-primary' }
        ]
    });
});
</script>
@endpush
@endsection
