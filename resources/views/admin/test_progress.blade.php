@extends('layouts.app')

@section('title', 'User Progress Report')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-white font-weight-bold">User Progress Report</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="card shadow-lg rounded-lg">
            <div class="card-header bg-gradient-primary text-white font-weight-bold">
                Test Performance Overview
            </div>
            <div class="card-body bg-dark text-white">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="progressTable">
                        <thead class="thead-dark">
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
                                        <span class="badge bg-success">✅ Correct</span>
                                    @else
                                        <span class="badge bg-danger">❌ Incorrect</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-success">{{ $entry->points }} pts</span></td>
                                <td>{{ $entry->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
        $('#progressTable').DataTable({
            "scrollX": true,
            "pageLength": 10
        });
    });
</script>

<style>
    /* Dark theme and consistent dashboard style */
    body, .content-wrapper {
        background: linear-gradient(135deg, #0a0f24, #1c223a);
        font-family: 'Poppins', sans-serif;
        color: #fff;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .card-header {
        border-radius: 10px 10px 0 0;
    }

    .table thead th {
        color: #fff;
        background-color: #1f273e;
    }

    .table tbody td {
        color: #fff;
        vertical-align: middle;
    }

    .badge {
        font-size: 0.85rem;
    }
</style>
@endsection
