@extends('layouts.app')

@section('title', 'User Progress')

@section('content')

<style>
/* === User Progress - White & Maroon Dashboard Theme === */
body, .content-wrapper {
  background: #ffffff !important;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

/* Header */
.content-header {
  text-align: center;
  padding: 25px 0 10px 0;
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
  padding: 15px;
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
  padding: 14px 20px;
  margin: -15px -15px 15px -15px;
}

/* Table Container */
.table-responsive {
  border-radius: 12px;
  padding: 10px 20px;
}

/* Table Styling */
.table {
  background: #fff;
  color: #333;
  text-align: center;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 0;
}
.table thead th {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
  text-align: center;
  padding: 12px;
}
.table tbody td {
  vertical-align: middle;
  padding: 10px;
}
.table tbody tr:hover {
  background: rgba(123, 45, 45, 0.05);
  transition: 0.3s ease;
}

/* --- Badges --- */
.badge-success {
  background-color: #27ae60 !important;
  color: #fff !important;
  font-weight: 600;
  border-radius: 8px;
  padding: 4px 8px;
}
.badge-light {
  background: transparent !important;
  color: #7b2d2d !important;
  font-weight: 600;
  font-size: 1rem;
}

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
  padding: 6px 10px;
}
.dataTables_wrapper .dataTables_info {
  color: #333;
  margin-top: 15px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background: transparent;
  border: 1px solid #7b2d2d;
  color: #7b2d2d !important;
  border-radius: 20px;
  padding: 4px 10px;
  margin: 0 3px;
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

/* Sidebar Active / Hover Links */
.nav-link.active,
.nav-link:hover {
  background-color: rgba(220, 160, 160, 0.25) !important;
  border-left: 3px solid #ecbbbbff;
  color: #ffffff !important;
  font-weight: 600;
  transition: all 0.2s ease;
  box-shadow: 0 6px 12px rgba(220, 160, 160, 0.35);
}

/* Responsive Fixes */
@media (max-width: 768px) {
  .card { padding: 10px; }
  .table-responsive { padding: 5px; }
}
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>User Progress</h1>
        <p>Overview of user levels, stars, and points</p>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title mb-0">Progress Overview</h3>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover table-striped" id="progressTable">
          <thead>
            <tr>
              <th>User Email</th>
              <th>Level</th>
              <th>Stars</th>
              <th>Points</th>
            </tr>
          </thead>
          <tbody>
            @foreach($progress as $entry)
            <tr>
              <td>{{ $entry->user->email ?? 'N/A' }}</td>
              <td>{{ $entry->level_number }}</td>
              <td><span class="badge badge-light">{{ str_repeat('⭐', $entry->stars) }}</span></td>
              <td><span class="badge badge-success">{{ $entry->points }} pts</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Include DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
  $('#progressTable').DataTable({
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
