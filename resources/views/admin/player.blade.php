@extends('layouts.app')

@section('title', 'Players')

@section('content')

<style>
body, .content-wrapper {
  background: #fff;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

.content-header {
  text-align: center;
  padding: 20px 0 10px 0;
}

.content-header h1 {
  color: #7b2d2d;
  font-size: 1.8rem;
  font-weight: 700;
}

.content-header p {
  color: #555;
  font-size: 0.95rem;
  margin-top: 4px;
}

/* Cards */
.card {
  background: #fff;
  border: 1px solid #7b2d2d;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(123, 45, 45, 0.1);
  margin-bottom: 16px;
}

/* Card Header */
.card-header {
  background: #7b2d2d;
  color: #fff;
  font-weight: 600;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
  display: flex;
  align-items: center;
}

/* Table */
.table {
  background: #fff;
}
.table thead th {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
}
.table tbody tr:hover {
  background-color: rgba(123, 45, 45, 0.05);
}

/* Buttons */
.btn-maroon {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
  border-radius: 20px;
  padding: 6px 14px;
}
.btn-maroon:hover {
  background-color: #a43e3e;
  color: #fff;
}

.btn-outline-maroon {
  border: 1px solid #7b2d2d;
  color: #7b2d2d;
}
.btn-outline-maroon:hover {
  background-color: #7b2d2d;
  color: #fff;
}

/* Modal */
.modal-content {
  background: #fff;
  color: #333;
  border-radius: 12px;
  border: 1px solid #7b2d2d;
}
.modal-header {
  background: #7b2d2d;
  color: #fff;
  font-weight: 600;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
}
.modal-footer .btn-maroon {
  background-color: #7b2d2d;
  color: #fff;
}
.modal-footer .btn-maroon:hover {
  background-color: #a43e3e;
  color: #fff;
}

/* DataTables */
.dataTables_wrapper .dataTables_filter input {
  border: 1px solid #7b2d2d;
  border-radius: 4px;
  padding: 4px 8px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  color: #7b2d2d !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background-color: #7b2d2d !important;
  color: #fff !important;
  border-radius: 4px;
}
.dataTables_wrapper .dataTables_info {
  color: #555;
}
</style>

<div class="content-header">
  <h1>PLAYER MANAGEMENT</h1>
  <p>Manage your CodeQuest players efficiently</p>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-maroon" data-bs-toggle="modal" data-bs-target="#playerModal">
        <i class="fas fa-user-plus me-1"></i> Add Player
      </button>
    </div>

    <div class="card">
      <div class="card-header"><i class="fas fa-users me-2"></i> List of Players</div>
      <div class="card-body p-3">
        <div class="table-responsive">
          <table id="playersTable" class="table table-bordered table-hover align-middle mb-0">
            <thead>
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
                  <button class="btn btn-outline-maroon btn-sm edit-player me-1" data-id="{{ $player->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-sm delete-player" data-id="{{ $player->id }}">
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
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="playerModalLabel">Add Player</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="playerForm">
        @csrf
        <div class="modal-body">
          <div class="mb-2">
            <label for="email" class="fw-bold">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-2">
            <label for="password" class="fw-bold">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-maroon btn-sm" id="savePlayer">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
  $('#playersTable').DataTable({
    responsive: true,
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    lengthMenu: [[10,25,50,-1],[10,25,50,"All"]],
  });
});
</script>

@endsection
