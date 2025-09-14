@extends('layouts.app')

@section('title', 'Leaderboards')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Leaderboards</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Top Players</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="LeaderBoardsTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Points</th>
                            <th>Stars</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaderboardData as $index => $player)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $player->full_name }}</td>
                            <td>{{ $player->total_points }}</td>
                            <td>{{ $player->total_stars }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function () {
    $('#LeaderBoardsTable').DataTable({
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
@endsection
