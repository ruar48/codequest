@extends('layouts.app')

@section('title', 'PHP & MySQL Code Logs')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">PHP & MySQL Code Logs</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Executed Code Logs</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="logsTable">
                    <thead class="thead-light">
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
                            <td>
                                <pre class="code-box">{{ $log->code }}</pre>
                            </td>
                            <td>
                                <pre class="output-box">{{ $log->output }}</pre>
                            </td>
                            <td>
                                <span class="badge {{ $log->is_error ? 'bg-danger' : 'bg-success' }}">
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

<!-- Include DataTables for better UI -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#logsTable').DataTable({
        responsive: true,
        autoWidth: false,
        dom: '<"row mb-3"' +
                '<"col-md-4 d-flex align-items-center"l>' +    // Show entries
                '<"col-md-4 text-center"B>' +                   // Export buttons
                '<"col-md-4 d-flex justify-content-end"f>' +    // Search box
             '>rtip',
        buttons: [
            { extend: 'copy', className: 'btn btn-sm btn-secondary me-1' },
            { extend: 'csv', className: 'btn btn-sm btn-info me-1' },
            { extend: 'excel', className: 'btn btn-sm btn-success me-1' },
            { extend: 'pdf', className: 'btn btn-sm btn-danger me-1' },
            { extend: 'print', className: 'btn btn-sm btn-primary' }
        ]
    });
});


</script>

<!-- Custom Styles -->
<style>
    .code-box, .output-box {
        background: #f8f9fa;
        padding: 5px;
        border-radius: 5px;
        font-family: monospace;
        font-size: 14px;
        max-width: 300px;
        overflow-x: auto;
    }
</style>

@endsection
