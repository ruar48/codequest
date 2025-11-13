@extends('layouts.app')

@section('title', 'Leaderboards')

@section('content')

<style>
/* === Dashboard Maroon Theme (White Base) === */
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

/* ===== BUTTONS ===== */
.btn-maroon {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  font-weight: 600;
  border: none;
  border-radius: 8px;
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
  transition: all 0.3s ease;
}
.btn-outline-maroon:hover {
  background-color: #7b2d2d;
  color: #fff;
}

/* ===== CARD ===== */
.card {
  background: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.25);
  border-radius: 16px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
  padding: 20px; /* Added padding inside the card for breathing space */
}
.card:hover {
  transform: translateY(-2px);
}
.card-header {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  font-weight: 600;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  font-size: 1.05rem;
}

/* ===== TABLE ===== */
.table {
  background: #fff;
  color: #333;
  border-radius: 12px;
  overflow: hidden;
  margin-top: 15px;
}
.table thead th {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
  border: none;
  text-align: center;
}
.table tbody td {
  vertical-align: middle;
  text-align: center;
  padding: 12px;
}
.table-hover tbody tr:hover {
  background-color: rgba(123, 45, 45, 0.08);
  transition: 0.25s ease;
}

/* ===== FORM SPACING ===== */
form {
  padding: 20px;
}
.form-control, textarea, select {
  background-color: #fff;
  color: #333;
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 10px 12px;
}
.form-control:focus {
  border-color: #7b2d2d;
  box-shadow: 0 0 6px rgba(123, 45, 45, 0.3);
}

/* ===== BADGES ===== */
.badge-success { background-color: #2ecc71; }
.badge-warning { background-color: #f1c40f; color: #1c1c1c; }
.badge-danger  { background-color: #e74c3c; }

/* ===== MODAL ===== */
.modal-content {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid rgba(123, 45, 45, 0.2);
}
.modal-header {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  border-bottom: none;
  border-top-left-radius: 14px;
  border-top-right-radius: 14px;
}

/* ===== SIDEBAR ACTIVE INDICATOR ===== */
.nav-link.active,
.nav-link:hover {
  background-color: rgba(220, 160, 160, 0.15) !important; /* transparent maroon */
  border-left: 3px solid #7b2d2d; /* maroon indicator line */
  color: #7b2d2d !important;
  font-weight: 600;
  transition: all 0.2s ease;
  box-shadow: 0 2px 6px rgba(220, 160, 160, 0.25);
}

/* ===== DATATABLE PAGINATION ===== */
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
</style>

<div class="content-header">
  <h1 class="fw-bold">Leaderboards</h1>
  <p>Overview of player rankings and scores</p>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <table id="LeaderBoardsTable" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Rank</th>
          <th>Player Name</th>
          <th>Score</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>John Doe</td>
          <td>980</td>
          <td><span class="badge badge-success">Active</span></td>
        </tr>
        <tr>
          <td>2</td>
          <td>Jane Smith</td>
          <td>870</td>
          <td><span class="badge badge-warning">Pending</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- ===== DATATABLE SCRIPT ===== -->
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
