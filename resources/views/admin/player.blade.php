@extends('layouts.app')

@section('title', 'Players')

@section('content')
<div class="content-header text-center py-2">
    <h1 class="fw-bold text-warning mb-1" style="font-size: 1.8rem;">PLAYER MANAGEMENT</h1>
    <p class="text-light mb-2" style="font-size: 0.95rem;">Manage CodeQuest players efficiently</p>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="card bg-dark text-light border-0 shadow-lg rounded-4 mt-2">
            <div class="card-header bg-gradient-warning text-dark fw-bold py-2 rounded-top d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2"></i> List of Players</span>
            </div>

            <div class="card-body p-3 bg-dark">
                <div class="table-responsive">
                    <table id="playersTable" class="table table-dark table-hover align-middle mb-0 rounded">
                        <thead class="table-warning text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($players as $player)
                            <tr>
                                <td>{{ $player->id }}</td>
                                <td>{{ $player->email }}</td>
                                <td class="text-capitalize">{{ $player->role }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning edit-player me-1" data-id="{{ $player->id }}" data-email="{{ $player->email }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-player" data-id="{{ $player->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
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

<!-- Player Modal -->
<div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="playerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light border border-warning rounded-3">
            <div class="modal-header bg-warning text-dark py-2">
                <h5 class="modal-title fw-bold mb-0" id="playerModalLabel">Add Player</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form id="playerForm">
                @csrf
                <div class="modal-body py-3">
                    <div class="form-group mb-2">
                        <label for="email" class="fw-bold text-warning">Email</label>
                        <input type="email" class="form-control bg-dark text-light border-warning" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password" class="fw-bold text-warning">Password</label>
                        <input type="password" class="form-control bg-dark text-light border-warning" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer border-0 py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning text-dark fw-bold btn-sm" id="savePlayer">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #0d0d1a;
    }

    .bg-gradient-warning {
        background: linear-gradient(90deg, #ffcc00, #ffdd44);
    }

    .card {
        background-color: #101020;
        border: 1px solid rgba(255, 204, 0, 0.2);
        margin-top: 10px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(255, 204, 0, 0.1);
        transition: 0.3s;
    }

    .btn-warning {
        box-shadow: 0 0 5px rgba(255, 204, 0, 0.5);
        transition: 0.3s;
    }

    .btn-warning:hover {
        box-shadow: 0 0 12px rgba(255, 204, 0, 0.9);
    }

    .dataTables_wrapper .dataTables_filter input {
        background-color: #0d0d1a;
        border: 1px solid rgba(255, 204, 0, 0.4);
        color: #fff;
        border-radius: 6px;
        padding: 4px 8px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: transparent;
        border: none;
        color: #ffcc00 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(90deg, #ffcc00, #ffdd44);
        color: #000 !important;
        border-radius: 6px;
    }

    .dataTables_wrapper .dataTables_info {
        color: #aaa;
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#playersTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            deferRender: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
        });
    });
</script>
@endsection
