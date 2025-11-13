@extends('layouts.app')

@section('title', 'PHP & MySQL Code Logs')

@section('content')

<style>
/* === FORCE PURE WHITE BACKGROUND === */
html, body, .wrapper, .content-wrapper, .content, .card, .container-fluid {
  background: #ffffff !important;
  background-color: #ffffff !important;
  box-shadow: none !important;
  color: #333 !important;
}

/* ===== HEADER ===== */
.content-header {
  text-align: center;
  padding-top: 20px;
  padding-bottom: 10px;
  margin-bottom: 15px;
  background-color: #ffffff !important;
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
  border: 1px solid rgba(123, 45, 45, 0.25);
  border-radius: 16px;
  transition: all 0.3s ease;
  margin-top: 20px;
  box-shadow: none !important;
}
.card-header {
  background: #7b2d2d;
  color: #fff;
  font-weight: 600;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  font-size: 1.1rem;
  padding: 14px 20px;
}
.card-body {
  padding: 30px !important;
  background-color: #ffffff !important;
}

/* ===== TABLE ===== */
.table {
  background: #ffffff !important;
  color: #333;
  border-radius: 10px;
  overflow: hidden;
}
.table thead th {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
  text-align: center;
  padding: 12px;
  border: none;
}
.table tbody td {
  text-align: center;
  vertical-align: middle;
  padding: 10px 14px;
  border-color: #eee;
}
.table-hover tbody tr:hover {
  background: rgba(123, 45, 45, 0.05);
  transition: 0.25s ease;
}

/* ===== CODE & OUTPUT BOXES ===== */
.code-box, .output-box {
  background: #f9f9f9;
  color: #222;
  padding: 8px 12px;
  border-radius: 8px;
  font-family: monospace;
  font-size: 13px;
  max-width: 350px;
  overflow-x: auto;
  white-space: pre-wrap;
  border: 1px solid #ddd;
}

/* ===== BADGES ===== */
.badge-success {
  background-color: #2ecc71 !important;
  color: #fff !important;
}
.badge-danger {
  background-color: #e74c3c !important;
  color: #fff !important;
}

/* ===== DATATABLE CONTROLS ===== */
.dataTables_wrapper .dataTables_filter {
  text-align: right;
  margin-bottom: 15px;
}
.dataTables_wrapper .dataTables_filter input {
  background-color: #ffffff;
  border: 1px solid #ccc;
  color: #333;
  border-radius: 6px;
  padding: 6px 10px;
  width: 100%;
  max-width: 220px;
}
.dataTables_wrapper .dataTables_length {
  text-align: left;
}
.dataTables_wrapper .dataTables_length select {
  background-color: #ffffff;
  border: 1px solid #ccc;
  color: #333;
  border-radius: 6px;
  padding: 6px;
}

/* ===== PAGINATION ===== */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background: transparent;
  border: 1px solid transparent;
  color: #7b2d2d !important;
  margin: 0 2px;
  padding: 6px 10px;
  border-radius: 8px;
  transition: all 0.2s ease;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background-color: #7b2d2d !important;
  color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background-color: #7b2d2d !important;
  color: #fff !important;
}

/* ===== EXPORT BUTTONS ===== */
.dt-buttons .btn {
  border-radius: 6px;
  font-weight: 600;
  background: #ffffff;
  border: 1px solid #7b2d2d;
  color: #7b2d2d;
  transition: all 0.3s;
  padding: 6px 10px;
}
.dt-buttons .btn:hover {
  background: #7b2d2d;
  color: #fff;
}

/* ===== TABLE INFO TEXT ===== */
.dataTables_wrapper .dataTables_info {
  color: #555;
  margin-top: 10px;
}

/* ===== SIDEBAR ACTIVE ===== */
.nav-link.active,
.nav-link:hover {
  background-color: rgba(220, 160, 160, 0.25) !important;
  border-left: 3px solid #ecbbbbff;
  color: #ffffff !important;
  font-weight: 600;
  transition: all 0.2s ease;
}
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>PHP & MySQL Code Logs</h1>
        <p>Executed code logs with output and status</p>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title mb-0">Executed Code Logs</h3>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center" id="logsTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>User Email</th>
              <th>Code</th>
              <th>Output</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $log)
            <tr>
              <td>{{ $log->id }}</td>
              <td>{{ $log->user->email ?? 'N/A' }}</td>
              <td><pre class="code-box">{{ $log->code }}</pre></td>
              <td><pre class="output-box">{{ $log->output }}</pre></td>
              <td>
                <span class="badge {{ $log->is_error ? 'badge-danger' : 'badge-success' }}">
                  {{ $log->is_error ? 'Error' : 'Success' }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- DataTables Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- DataTables Initialization -->
<script>
$(document).ready(function () {
  $('#logsTable').DataTable({
    responsive: true,
    autoWidth: false,
    dom: '<"row mb-3"' +
            '<"col-md-4 d-flex align-items-center"l>' +
            '<"col-md-4 text-center"B>' +
            '<"col-md-4 d-flex justify-content-end"f>' +
         '>rtip',
    buttons: [
      { extend: 'copy', className: 'btn btn-sm me-1' },
      { extend: 'csv', className: 'btn btn-sm me-1' },
      { extend: 'excel', className: 'btn btn-sm me-1' },
      { extend: 'pdf', className: 'btn btn-sm me-1' },
      { extend: 'print', className: 'btn btn-sm' }
    ],
    order: [[0, 'desc']],
    pagingType: "full_numbers",
    language: {
      info: "Showing _START_ to _END_ of _TOTAL_ logs",
      paginate: {
        previous: "Previous",
        next: "Next",
        first: "First",
        last: "Last"
      },
      search: "Search Logs:"
    }
  });
});
</script>

@endsection
