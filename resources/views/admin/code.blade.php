@extends('layouts.app')

@section('title', 'PHP & MySQL Code Logs')

@section('content')

<style>
/* === Dashboard / Code Logs Theme === */
body, .content-wrapper {
    background: linear-gradient(135deg, #0a0f24, #1c223a);
    color: #fff;
    font-family: 'Poppins', sans-serif;
}

.content-header {
    text-align: center;
    padding-top: 20px;
    padding-bottom: 10px;
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
    padding-top: 30px !important;
    padding-bottom: 40px;
}

/* Card styling */
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
    transform: translateY(-3px);
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

/* Table styling */
.table {
    background: transparent;
    color: #fff;
    margin-bottom: 0;
    table-layout: fixed;
    word-wrap: break-word;
}

.table thead th {
    color: #1c1c1c;
    background-color: #facc15;
    font-weight: 600;
    text-align: center;
}

.table tbody td {
    vertical-align: middle;
    text-align: center;
    overflow-wrap: break-word;
}

.table tbody tr:hover {
    background: rgba(250, 204, 21, 0.1);
    transition: 0.3s;
}

/* Code & Output boxes */
.code-box, .output-box {
    background: rgba(255, 255, 255, 0.08);
    color: #fff;
    padding: 6px 8px;
    border-radius: 8px;
    font-family: monospace;
    font-size: 13px;
    max-width: 300px;
    overflow-x: auto;
    white-space: pre-wrap;
    word-wrap: break-word;
}

/* Status badges */
.badge-success {
    background-color: #27ae60 !important;
}
.badge-danger {
    background-color: #e74c3c !important;
}

/* DataTables inputs */
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
    background-color: #0a0f24;
    border: 1px solid rgba(250, 204, 21, 0.4);
    color: #fff;
    border-radius: 6px;
    padding: 4px 8px;
}

/* DataTables pagination */
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

/* Buttons */
.btn-primary, .btn-secondary, .btn-success, .btn-info, .btn-warning, .btn-danger {
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-primary:hover, .btn-secondary:hover, .btn-success:hover, .btn-info:hover, .btn-warning:hover, .btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 10px rgba(250, 204, 21, 0.8);
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
        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="card-title">Executed Code Logs</h3>
            </div>
            <div class="card-body table-responsive p-0">
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

<!-- DataTables Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
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
            { extend: 'copy', className: 'btn btn-sm btn-secondary me-1' },
            { extend: 'csv', className: 'btn btn-sm btn-info me-1' },
            { extend: 'excel', className: 'btn btn-sm btn-success me-1' },
            { extend: 'pdf', className: 'btn btn-sm btn-danger me-1' },
            { extend: 'print', className: 'btn btn-sm btn-primary' }
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
            }
        }
    });
});
</script>

@endsection
