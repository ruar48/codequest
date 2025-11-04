@extends('layouts.app')

@section('title', 'Leaderboards')

@section('content')
<div class="content-header mt-3 mb-2">
    <div class="container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold text-primary">Leaderboards</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0 fw-semibold">
                    <i class="fas fa-trophy me-2"></i> Top Players
                </h3>
            </div>
            <div class="card-body bg-light rounded-bottom">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="LeaderBoardsTable">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Points</th>
                                <th>Stars</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($leaderboardData as $index => $player)
                            <tr>
                                <td><span class="badge bg-warning text-dark px-3 py-2 fs-6">{{ $index + 1 }}</span></td>
                                <td class="fw-semibold">{{ $player->full_name }}</td>
                                <td>{{ $player->total_points }}</td>
                                <td>
                                    <i class="fas fa-star text-warning"></i> {{ $player->total_stars }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

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
