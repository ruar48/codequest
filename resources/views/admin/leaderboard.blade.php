@extends('layouts.app')

@section('title', 'Leaderboards')

@section('content')

<style>
/* === Leaderboards Page - Maroon & White Dashboard Theme === */
body, .content-wrapper {
  background: #ffffff;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

/* Header */
.content-header {
  text-align: center;
  padding: 20px 0 5px 0;
}
.content-header h1 {
  color: #7b2d2d;
  font-weight: 700;
  font-size: 2rem;
}
.content-header p {
  color: #555;
  margin-bottom: 0;
  font-size: 1rem;
}

/* Card Styling */
.card {
  background: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.2);
  border-radius: 16px;
  box-shadow: none;
  transition: all 0.3s ease;
}
.card:hover {
  transform: translateY(-3px);
}
.card-header {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  font-weight: 600;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
}

/* Table Styling */
.table {
  background: #fff;
  color: #333;
  text-align: center;
  border-radius: 10px;
  overflow: hidden;
}
.table thead th {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
  text-align: center;
}
.table tbody td {
  vertical-align: middle;
}
.table tbody tr:hover {
  background: rgba(123, 45, 45, 0.05);
  transition: 0.3s ease;
}

/* Top 3 highlights */
.table tbody tr:nth-child(1) td { background: rgba(123, 45, 45, 0.15); font-weight: 700; }
.table tbody tr:nth-child(2) td { background: rgba(123, 45, 45, 0.1); font-weight: 600; }
.table tbody tr:nth-child(3) td { background: rgba(123, 45, 45, 0.08); font-weight: 500; }

/* --- Maroon Buttons --- */
.btn-maroon {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  border: none;
}
.btn-maroon:hover {
  background: linear-gradient(90deg, #a43e3e, #7b2d2d);
  color: #fff;
}
.btn-outline-maroon {
  border: 1px solid #7b2d2d;
  color: #7b2d2d;
  background: #ffffff;
}
.btn-outline-maroon:hover {
  background: #7b2d2d;
  color: #fff;
}

/* --- DataTables Styling --- */
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
  background-color: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.4);
  color: #333;
  border-radius: 6px;
  padding: 4px 8px;
}
.dataTables_wrapper .dataTables_info {
  color: #333;
  margin-top: 10px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background: transparent;
  border: 1px solid #7b2d2d;
  color: #7b2d2d !important;
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
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
  color: rgba(123, 45, 45, 0.4) !important;
  border-color: rgba(123, 45, 45, 0.2);
}

/* --- Responsive Container --- */
.table-responsive {
  border-radius: 16px;
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
    <div class="card">
      <div class="card-header">
        <h3 class="card-title mb-0">Top Players</h3>
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
