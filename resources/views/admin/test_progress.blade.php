@extends('layouts.app')

@section('title', 'User Progress Report')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User Progress Report</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Test Performance Overview</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="progressTable">
                    <thead class="thead-light">
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
</section>

<!-- Include DataTables for better UI -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#progressTable').DataTable();
    });
</script>

@endsection
