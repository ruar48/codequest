@extends('layouts.app')

@section('title', 'Players')

@section('content')

<style>
/* Match the dashboard/admin look */
body, .content-wrapper {
  background: linear-gradient(135deg, #0a0f24, #1c223a);
  color: #fff;
  font-family: 'Poppins', sans-serif;
}

/* Give breathing space below header */
.content {
  padding-top: 80px !important;
  padding-bottom: 40px;
}

/* Header Section */
.content-header {
  padding-top: 25px;
  padding-bottom: 15px;
  margin-bottom: 25px;
  text-align: center;
}
.content-header h1 {
  font-weight: 700;
  color: #facc15;
  font-size: 1.8rem;
  text-shadow: 0 0 12px rgba(250, 204, 21, 0.4);
}
.content-header p {
  color: #e5e5e5;
  font-size: 0.95rem;
}

/* Card Style - same as admin management */
.card {
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250, 204, 21, 0.25);
  box-shadow: 0 4px 16px rgba(250, 204, 21, 0.25);
  border-radius: 16px;
  transition: all 0.3s ease;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
}

/* Card Header */
.card-header {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
  font-weight: 700;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
}

/* Table */
.table-dark {
  background: transparent;
}
.table thead th {
  color: #000;
  font-weight: 600;
  background-color: #facc15;
}
.table tbody tr:hover {
  background: rgba(250, 204, 21, 0.1);
  transition: 0.3s;
}

/* Buttons */
.btn-outline-warning {
  border: 1px solid #facc15;
  color: #facc15;
  transition: 0.3s;
}
.btn-outline-warning:hover {
  background-color: #facc15;
  color: #1c1c1c;
  box-shadow: 0 0 10px rgba(250, 204, 21, 0.7);
}
.btn-outline-danger {
  border: 1px solid #e74c3c;
  color: #e74c3c;
  transition: 0.3s;
}
.btn-outline-danger:hover {
  background-color: #e74c3c;
  color: #fff;
  box-shadow: 0 0 10px rgba(231, 76, 60, 0.6);
}

/* DataTables UI */
.dataTables_wrapper .dataTables_filter input {
  background-color: #0a0f24;
  border: 1px solid rgba(250, 204, 21, 0.4);
  color: #fff;
  border-radius: 6px;
  padding: 4px 8px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background-color: transparent;
  border: none;
  color: #facc15 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #000 !important;
  border-radius: 6px;
}
.dataTables_wrapper .dataTables_info {
  color: #aaa;
}
</style>

<div class="content-header">
  <h1>PLAYER MANAGEMENT</h1>
  <p>Manage your CodeQuest players efficiently</p>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="card mt-2">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users me-2"></i> List of Players</span>
      </div>

      <div class="card-body p-3">
        <div class="table-responsive">
          <table id="playersTable" class="table table-dark table-hover align-middle mb-0 rounded">
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
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
  });
});
</script>

@endsection
