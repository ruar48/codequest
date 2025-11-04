@extends('layouts.app')

@section('title', 'User Progress')

@section('content')

<style>
/* === Dashboard Theme === */
body, .content-wrapper {
    background: linear-gradient(135deg, #0a0f24, #1c223a);
    font-family: 'Poppins', sans-serif;
    color: #fff;
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
}

/* Card */
.card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(250, 204, 21, 0.25);
    border-radius: 16px;
    margin-top: 12px;
    box-shadow: 0 4px 16px rgba(250,204,21,0.25);
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

/* Table */
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

/* Badges */
.badge {
    font-weight: 600;
    padding: 0.4em 0.6em;
    border-radius: 12px;
}
.badge-success {
    background-color: #27ae60 !important;
    color: #fff;
}
/* Stars Badge – No background */
.badge-light {
    background-color: transparent !important; /* remove background */
    color: #facc15 !important;               /* golden/yellow stars */
    font-weight: 600;
    padding: 0;
    border-radius: 0;
    font-size: 1rem;
}

/* DataTables controls */
.dataTables_wrapper .dataTables_filter input {
    background-color: #0a0f24;
    border: 1px solid rgba(250, 204, 21, 0.4);
    color: #fff;
    border-radius: 6px;
    padding: 4px 10px;
    width: 100%;
    max-width: 200px;
}

.dataTables_wrapper .dataTables_length select {
    background-color: #0a0f24;
    border: 1px solid rgba(250, 204, 21, 0.4);
    color: #fff;
    border-radius: 6px;
    padding: 4px 6px;
}

/* Pagination buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    background-color: transparent;
    border: none;
    color: #facc15 !important;
    margin: 0 2px;
    padding: 4px 10px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(90deg, #facc15, #ffea80);
    color: #000 !important;
    border-radius: 6px;
}

/* Table info */
.dataTables_wrapper .dataTables_info {
    color: #aaa;
    margin-top: 10px;
}

/* Buttons */
.dt-buttons .btn {
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s;
}
.dt-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 10px rgba(250, 204, 21, 0.8);
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
        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="card-title">Progress Overview</h3>
            </div>
            <div class="card-body table-responsive p-3">
                <table class="table table-bordered table-hover text-center" id="progressTable">
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
                            <<td>
    <span class="badge badge-light">{{ str_repeat('⭐', $entry->stars) }}</span>
</td>
                            <td>
                                <span class="badge badge-success">{{ $entry->points }} pts</span>
                            </td>
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
            { extend: 'copy', className: 'btn btn-sm btn-primary me-1' },
            { extend: 'csv', className: 'btn btn-sm btn-success me-1' },
            { extend: 'excel', className: 'btn btn-sm btn-warning me-1' },
            { extend: 'pdf', className: 'btn btn-sm btn-danger me-1' },
            { extend: 'print', className: 'btn btn-sm btn-primary' }
        ],
        pagingType: "full_numbers",
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                previous: "Previous",
                next: "Next",
                first: "First",
                last: "Last"
            },
            search: "Search Users:"
        }
    });
});
</script>

@endsection
