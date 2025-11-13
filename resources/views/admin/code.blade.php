@extends('layouts.app')

@section('title', 'PHP & MySQL Code Logs')

@section('content')

<style>
/* === Dashboard / Code Logs Light Theme === */
body, .content-wrapper {
    background-color: #ffffff !important;
    color: #7b2d2d;
    font-family: 'Poppins', sans-serif;
}

.content-header {
    text-align: center;
    padding-top: 25px;
    padding-bottom: 15px;
}

.content-header h1 {
    font-weight: 700;
    color: #7b2d2d;
    font-size: 2rem;
}

.content-header p {
    color: #555;
    font-size: 1rem;
    margin-bottom: 0;
}

.content {
    padding-top: 30px !important;
    padding-bottom: 40px;
}

/* Card Styling */
.card {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border-radius: 16px;
    margin-top: 16px !important;
    transition: all 0.3s ease;
    padding: 10px 15px;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}

.card-header {
    background: #7b2d2d;
    color: #fff;
    font-weight: 600;
    font-size: 1.2rem;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    padding: 12px 20px;
}

/* Table Styling */
.table {
    background: #ffffff;
    color: #333;
    margin-bottom: 0;
    table-layout: fixed;
    border-radius: 10px;
    overflow: hidden;
    word-wrap: break-word;
}

.table thead th {
    color: #fff;
    background-color: #7b2d2d;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

.table tbody td {
    vertical-align: middle;
    text-align: center;
    overflow-wrap: break-word;
    padding: 10px 12px;
}

.table tbody tr:hover {
    background: rgba(123, 45, 45, 0.05);
    transition: 0.3s;
}

/* Code & Output boxes */
.code-box, .output-box {
    background: #f8f8f8;
    color: #222;
    padding: 6px 10px;
    border-radius: 8px;
    font-family: monospace;
    font-size: 13px;
    max-width: 300px;
    overflow-x: auto;
    white-space: pre-wrap;
    word-wrap: break-word;
    border: 1px solid #ddd;
}

/* Status badges */
.badge-success {
    background-color: #28a745 !important;
    color: #fff !important;
}
.badge-danger {
    background-color: #dc3545 !important;
    color: #fff !important;
}

/* DataTables Controls */
.dataTables_wrapper .dataTables_filter {
    text-align: right;
    margin-bottom: 10px;
}

.dataTables_wrapper .dataTables_filter input {
    background-color: #ffffff;
    border: 1px solid #ccc;
    color: #333;
    border-radius: 6px;
    padding: 6px 10px;
    width: 100%;
    max-width: 200px;
}

.dataTables_wrapper .dataTables_length {
    text-align: left;
}

.dataTables_wrapper .dataTables_length select {
    background-color: #ffffff;
    border: 1px solid #ccc;
    color: #333;
    border-radius: 6px;
    padding: 4px 6px;
}

/* Pagination */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    background-color: transparent;
    border: none;
    color: #7b2d2d !important;
    margin: 0 2px;
    padding: 4px 10px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #7b2d2d;
    color: #fff !important;
    border-radius: 6px;
}

/* Info */
.dataTables_wrapper .dataTables_info {
    color: #555;
    margin-top: 10px;
}

/* Buttons */
.dt-buttons .btn {
    border-radius: 6px;
    font-weight: 600;
    background: #fff;
    border: 1px solid #7b2d2d;
    color: #7b2d2d;
    transition: all 0.3s;
}

.dt-buttons .btn:hover {
    background: #7b2d2d;
    color: #fff;
    box-shadow: 0 0 10px rgba(123,45,45,0.3);
}

/* Extra spacing for card body */
.card-body {
    padding: 25px 30px !important;
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
