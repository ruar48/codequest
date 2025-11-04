@extends('layouts.app')

@section('title', 'Leaderboards')

@section('content')

<style>
/* === Dashboard & Leaderboards Theme === */
body, .content-wrapper {
  background: linear-gradient(135deg, #0a0f24, #1c223a);
  color: #fff;
  font-family: 'Poppins', sans-serif;
}
.content-header {
  text-align: center;
  padding-top: 15px;
  padding-bottom: 0;
  margin-bottom: 10px;
}
.content-header h1 {
  font-weight: 700;
  color: #facc15;
  font-size: 2rem;
  text-shadow: 0 0 12px rgba(250, 204, 21, 0.5);
}
.content-header p {
  color: #e5e5e5;
  font-size: 1rem;
  margin-bottom: 0;
}
.content {
  padding-top: 40px !important;
  padding-bottom: 40px;
}
.card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250, 204, 21, 0.25);
  box-shadow: 0 4px 16px rgba(250, 204, 21, 0.25);
  border-radius: 16px;
  margin-top: 12px !important;
  transition: all 0.3s ease;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
}
.card-header {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
  font-weight: 700;
  font-size: 1.2rem;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
}
.table {
  background: transparent;
  color: #fff;
  margin-bottom: 0;
}
.table thead th {
  color: #1c1c1c;
  background-color: #facc15;
  font-weight: 600;
  text-align: center;
}
.table tbody td {
  vertical-align: middle;
}
.table tbody tr:hover {
  background: rgba(250, 204, 21, 0.1);
  transition: 0.3s;
}
/* Highlight top 3 players */
.table tbody tr:nth-child(1) td { background: rgba(250,204,21,0.25); font-weight: 700; }
.table tbody tr:nth-child(2) td { background: rgba(250,204,21,0.15); font-weight: 600; }
.table tbody tr:nth-child(3) td { background: rgba(250,204,21,0.1); font-weight: 500; }
/* DataTables styling */
.dataTables_wrapper .dataTables_filter input {
  background-color: #0a0f24;
  border: 1px solid rgba(250, 204, 21, 0.4);
  color: #fff;
  border-radius: 6px;
  padding: 4px 8px;
}
.dataTables_wrapper .dataTables_length select {
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
  margin-top: 10px;
}
.btn-primary {
  background-color: #facc15;
  color: #1c1c1c;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  transition: all 0.3s;
}
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 10px rgba(250, 204, 21, 0.8);
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
        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="card-title">Top Players</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center" id="LeaderBoardsTable">
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
        info: true,           // show "Showing 1 to X of Y entries"
        paging: true,         // enable pagination
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
        ],
        order: [[2, 'desc'], [3, 'desc']] // sort by points desc, then stars desc
    });
});
</script>
@endpush

@endsection
