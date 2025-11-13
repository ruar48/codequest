@extends('layouts.app')

@section('title', 'Leaderboards')

@section('content')

<style>
/* === Dashboard Maroon Theme for Leaderboards === */
body, .content-wrapper {
  background: #ffffff !important;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

/* ===== HEADER ===== */
.content-header {
  text-align: center;
  padding-top: 15px;
  padding-bottom: 5px;
  margin-bottom: 20px;
}
.content-header h1 {
  font-weight: 700;
  color: #7b2d2d;
  font-size: 1.9rem;
  letter-spacing: 0.5px;
}
.content-header p {
  color: #666;
  font-size: 0.95rem;
  margin-bottom: 0;
}

/* ===== CARD ===== */
.card {
  background: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.25);
  border-radius: 16px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
  margin-top: 12px;
}
.card:hover {
  transform: translateY(-2px);
}
.card-header {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  font-weight: 600;
  font-size: 1.1rem;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  padding: 12px 15px;
}

/* ===== TABLE ===== */
.table {
  background: #fff;
  color: #333;
  border-radius: 12px;
  overflow: hidden;
}
.table thead th {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
  text-align: center;
  border: none;
}
.table tbody td {
  text-align: center;
  vertical-align: middle;
}
.table tbody tr:hover {
  background-color: rgba(123, 45, 45, 0.08);
  transition: 0.25s ease;
}

/* Highlight top 3 players */
.table tbody tr:nth-child(1) td {
  background: rgba(123, 45, 45, 0.2);
  font-weight: 700;
  color: #7b2d2d;
}
.table tbody tr:nth-child(2) td {
  background: rgba(123, 45, 45, 0.12);
  font-weight: 600;
  color: #7b2d2d;
}
.table tbody tr:nth-child(3) td {
  background: rgba(123, 45, 45, 0.08);
  font-weight: 500;
  color: #7b2d2d;
}

/* ===== DATATABLES CONTROLS ===== */
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
  background-color: #fff;
  border: 1px solid #7b2d2d;
  color: #333;
  border-radius: 6px;
  padding: 4px 8px;
}
.dataTables_wrapper .dataTables_filter label,
.dataTables_wrapper .dataTables_length label {
  color: #333;
  font-weight: 500;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  color: #7b2d2d !important;
  border: 1px solid #7b2d2d;
  border-radius: 20px;
  padding: 3px 8px;
  margin: 0 2px;
  transition: all 0.2s ease;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: #7b2d2d !important;
  color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #7b2d2d !important;
  color: #fff !important;
  border: 1px solid #7b2d2d;
}
.dataTables_wrapper .dataTables_info {
  color: #555;
  margin-top: 10px;
}

/* ===== BUTTONS ===== */
.btn-maroon {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-maroon:hover {
  background: linear-gradient(90deg, #a43e3e, #7b2d2d);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(123, 45, 45, 0.3);
}
.btn-outline-maroon {
  border: 1px solid #7b2d2d;
  color: #7b2d2d;
  border-radius: 8px;
  transition: all 0.3s ease;
}
.btn-outline-maroon:hover {
  background: #7b2d2d;
  color: #fff;
}
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>Leaderboards</h1>
        <p>Top players based on points and stars</p>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card shadow-sm">
      <div class="card-header">
        <h3 class="card-title mb-0"><i class="fas fa-trophy me-2"></i> Top Players</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover table-striped" id="LeaderBoardsTable">
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

<!-- ===== DATATABLES ===== -->
<script>
$(document).ready(function () {
  $('#LeaderBoardsTable').DataTable({
    responsive: true,
    autoWidth: false,
    dom: '<"row mb-3"' +
            '<"col-md-4 d-flex align-items-center"l>' +
            '<"col-md-4 text-center"B>' +
            '<"col-md-4 d-flex justify-content-end"f>' +
         '>rtip',
    buttons: [
      { extend: 'copy', className: 'btn btn-sm btn-outline-maroon me-1' },
      { extend: 'csv', className: 'btn btn-sm btn-outline-maroon me-1' },
      { extend: 'excel', className: 'btn btn-sm btn-outline-maroon me-1' },
      { extend: 'pdf', className: 'btn btn-sm btn-outline-maroon me-1' },
      { extend: 'print', className: 'btn btn-sm btn-maroon' }
    ]
  });
});
</script>

@endsection
