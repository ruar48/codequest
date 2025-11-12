@extends('layouts.app')

@section('title', 'Players')

@section('content')

<div class="content-header text-center py-3">
  <h1 class="fw-bold mb-1" 
      style="font-size: 2rem; color: #7b2d2d; text-shadow: none;">
      <i class="fas fa-users me-2"></i> PLAYER MANAGEMENT
  </h1>
  <p class="text-muted mb-0" style="opacity: 0.9;">Manage your CodeQuest players efficiently</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Player Button -->
    <div class="d-flex justify-content-end mb-3">
      <button type="button" 
              class="btn btn-maroon text-white fw-semibold px-3 py-1 rounded-pill"
              data-bs-toggle="modal" data-bs-target="#playerModal" style="font-size: 0.9rem;">
        <i class="fas fa-user-plus me-1"></i> Add Player
      </button>
    </div>

    <!-- Players Table Card -->
    <div class="card player-card border-0 rounded-4">
      <div class="card-header fw-bold py-2 rounded-top text-white"
           style="background: linear-gradient(90deg, #7b2d2d, #a43e3e);">
        <i class="fas fa-users-cog me-2"></i> List of Players
      </div>
      <div class="card-body p-3 bg-white text-dark">
        <div class="table-responsive">
          <table id="playersTable" class="table table-bordered table-hover align-middle mb-0">
            <thead style="background-color: #7b2d2d; color: #fff;">
              <tr>
                <th style="width: 10%;">ID</th>
                <th style="width: 40%;">Email</th>
                <th style="width: 25%;">Role</th>
                <th style="width: 25%;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($players as $player)
              <tr>
                <td class="ps-4">{{ $player->id }}</td>
                <td class="ps-4">{{ $player->email }}</td>
                <td class="text-capitalize ps-4">{{ $player->role }}</td>
                <td class="ps-3">
                  <button class="btn btn-sm btn-outline-maroon edit-player me-1 d-inline-flex align-items-center justify-content-center" 
                          data-id="{{ $player->id }}" data-email="{{ $player->email }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-danger delete-player d-inline-flex align-items-center justify-content-center" 
                          data-id="{{ $player->id }}">
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
    <div class="modal-content bg-white text-dark border border-maroon rounded-3">
      <div class="modal-header text-white py-2 rounded-top"
           style="background: linear-gradient(90deg, #7b2d2d, #a43e3e);">
        <h5 class="modal-title fw-bold mb-0" id="playerModalLabel">Add Player</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="playerForm">
        @csrf
        <div class="modal-body py-3">
          <div class="form-group mb-3">
            <label for="email" class="fw-bold text-maroon">Email</label>
            <input type="email" class="form-control border-maroon rounded-pill"
                   id="email" name="email" required>
          </div>
          <div class="form-group mb-2">
            <label for="password" class="fw-bold text-maroon">Password</label>
            <input type="password" class="form-control border-maroon rounded-pill"
                   id="password" name="password" required>
          </div>
        </div>
        <div class="modal-footer border-0 py-2">
          <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-maroon text-white fw-bold btn-sm rounded-pill"
                  id="savePlayer">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('styles')
<style>
/* === Dashboard-Style Maroon Theme for Players Page === */
body, .content-wrapper {
  background: #ffffff;       /* Plain white background */
  font-family: 'Poppins', sans-serif;
  color: #333333;            /* Dark text color */
}

/* Custom Maroon Buttons */
.btn-maroon {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  border: none;
}
.btn-maroon:hover {
  background: linear-gradient(90deg, #a43e3e, #7b2d2d);
}

/* Outline Buttons */
.btn-outline-maroon {
  border: 1px solid #7b2d2d;
  color: #7b2d2d;
}
.btn-outline-maroon:hover {
  background: #7b2d2d;
  color: #fff;
}

/* Card Style */
.player-card {
  background: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.2);
  border-radius: 16px;
}

/* Maroon Utility Colors */
.text-maroon {
  color: #7b2d2d !important;
}
.border-maroon {
  border-color: #7b2d2d !important;
}

/* Input Focus */
input.form-control:focus {
  box-shadow: 0 0 8px rgba(123, 45, 45, 0.4);
  border-color: #7b2d2d;
}

/* Table Hover Effect */
.table-hover tbody tr:hover {
  background-color: rgba(123, 45, 45, 0.1);
  transition: all 0.2s ease;
}

/* Scrollbar */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-thumb {
  background-color: #7b2d2d;
  border-radius: 4px;
}

/* --- DataTables Maroon Theme --- */
.dataTables_wrapper .dataTables_filter input {
  border: 1px solid #7b2d2d;
  border-radius: 20px;
  padding: 4px 10px;
  outline: none;
}
.dataTables_wrapper .dataTables_filter input:focus {
  box-shadow: 0 0 6px rgba(123,45,45,0.4);
  border-color: #7b2d2d;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  color: #7b2d2d !important;
  border: 1px solid transparent;
  border-radius: 20px;
  padding: 3px 8px;
  transition: 0.2s;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: #7b2d2d !important;
  color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #7b2d2d !important;
  color: #fff !important;
  border-radius: 20px;
}

/* Remove box shadows globally */
.card, .btn, input, .modal-content {
  box-shadow: none !important;
}
</style>
@endpush

@push('scripts')
<!-- ✅ DataTables Dependencies -->
<link rel="stylesheet" 
      href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- ✅ DataTable Setup -->
<script>
$(document).ready(function () {
    $('#playersTable').DataTable({
        responsive: true,
        autoWidth: false,
        dom: '<"row mb-3"' +
                '<"col-md-6 d-flex align-items-center"l>' +
                '<"col-md-6 d-flex justify-content-end"f>' +
             '>rtip',
        pagingType: "full_numbers",
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ players",
            paginate: {
                previous: "Previous",
                next: "Next",
                first: "First",
                last: "Last"
            },
            search: "Search Players:"
        },
        pageLength: 10,
        order: [[0, 'asc']]
    });
});
</script>
@endpush

@endsection
