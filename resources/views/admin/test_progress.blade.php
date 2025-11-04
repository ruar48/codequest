@extends('layouts.app')

@section('title', 'User Progress Report')

@section('content')

<style>
/* === Dashboard/Admin Theme === */
body, .content-wrapper {
    background: linear-gradient(135deg, #0a0f24, #1c223a);
    color: #fff;
    font-family: 'Poppins', sans-serif;
}

/* Content Header */
.content-header {
    padding-top: 30px;
    padding-bottom: 20px;
    text-align: center;
}
.content-header h1 {
    font-weight: 700;
    color: #facc15;
    text-shadow: 0 0 12px rgba(250,204,21,0.5);
}

/* Card */
.card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(250,204,21,0.25);
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(250,204,21,0.25);
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 20px rgba(250,204,21,0.5);
}
.card-header {
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    font-weight: 700;
    background: linear-gradient(90deg, #facc15, #ffea80);
    color: #1c1c1c;
}

/* Table */
.table {
    background: transparent;
    color: #fff;
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
.badge-danger {
    background-color: #dc3545 !important;
    color: #fff;
}

/* DataTables Controls */
.dataTables_wrapper .dataTables_filter input {
    background-color: #0a0f24;
    border: 1px solid rgba(250, 204, 21, 0.4);
    color: #fff;
    border-radius: 6px;
    padding: 4px 10px;
    width: 100%;
    max-width: 250px;
}
.dataTables_wrapper .dataTables_length select {
    background-color: #0a0f24;
    border: 1px solid rgba(250, 204, 21, 0.4);
    color: #fff;
    border-radius: 6px;
    padding: 4px 6px;
}

/* Pagination Buttons */
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

/* Table Info */
.dataTables_wrapper .dataTables_info {
    color: #aaa;
    margin-top: 10px;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <h1>User Progress Report</h1>
        <p>Detailed overview of user test performance</p>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="card-title">Test Performance Overview</h3>
            </div>
            <div class="card-body table-responsive p-3">
                <table class="table table-bordered table-hover" id="progressTable">
                    <thead>
                        <tr>
                            <th>User Email</th>
                            <th>Full Name</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Correct</th>
                            <th>Points Earned</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testPerformances as $entry)
                        <tr>
                            <td>{{ $entry->user->email ?? 'N/A' }}</td>
                            <td>{{ $entry->user->full_name ?? 'N/A' }}</td>
                            <td>{{ $entry->question->question ?? 'N/A' }}</td>
                            <td><code>{{ Str::limit($entry->answer, 50) }}</code></td>
                            <td>
                                @if($entry->is_correct)
                                    <span class="badge badge-success">✅ Correct</span>
                                @else
                                    <span class="badge badge-danger">❌ Incorrect</span>
                                @endif
                            </td>
                            <td><span class="badge badge-success">{{ $entry->points }} pts</span></td>
                            <td>{{ $entry->created_at->format('Y-m-d H:i') }}</td>
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
<script>
$(document).ready(function () {
    $('#progressTable').DataTable({
        responsive: true,
        autoWidth: false,
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
