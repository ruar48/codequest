@extends('layouts.app')

@section('title', 'Admins')

@section('content')

<div class="content-header text-center py-3">
  <h1 class="fw-bold mb-1" 
      style="font-size: 2rem; color: #7b2d2d; text-shadow: 0 0 6px rgba(123,45,45,0.4);">
      <i class="fas fa-user-shield me-2"></i> ADMIN MANAGEMENT
  </h1>
  <p class="text-muted mb-0" style="opacity: 0.9;">Manage your CodeQuest administrators</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Admin Button -->
    <div class="d-flex justify-content-end mb-3">
      <button type="button" 
              class="btn btn-maroon text-white fw-semibold px-3 py-1 rounded-pill"
              data-toggle="modal" data-target="#adminModal" style="font-size: 0.9rem;">
        <i class="fas fa-user-plus me-1"></i> Add Admin
      </button>
    </div>

    <!-- Admins Table Card -->
    <div class="card admin-card border-0 rounded-4">
      <div class="card-header fw-bold py-2 rounded-top text-white"
           style="background: linear-gradient(90deg, #7b2d2d, #a43e3e);">
        <i class="fas fa-users-cog me-2"></i> List of Admins
      </div>
      <div class="card-body p-3 bg-white text-dark">
        <div class="table-responsive">
          <table id="adminTable" class="table table-bordered table-hover align-middle mb-0">
            <thead style="background-color: #7b2d2d; color: #fff;">
              <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($admins as $admin)
              <tr data-id="{{ $admin->id }}" data-email="{{ $admin->email }}" data-role="{{ $admin->role }}">
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->email }}</td>
                <td class="text-capitalize">{{ $admin->role }}</td>
                <td>
                  <button class="btn btn-sm btn-outline-maroon edit-admin me-1" data-id="{{ $admin->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-danger delete-admin" data-id="{{ $admin->id }}">
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

<!-- Add Admin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-white text-dark border border-maroon rounded-3">
      <div class="modal-header text-white py-2 rounded-top"
           style="background: linear-gradient(90deg, #7b2d2d, #a43e3e);">
        <h5 class="modal-title fw-bold mb-0" id="adminModalLabel">Add Admin</h5>
        <button type="button" class="btn-close" data-dismiss="modal"></button>
      </div>
      <form id="adminForm">
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
          <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-maroon text-white fw-bold btn-sm rounded-pill"
                  id="saveAdmin">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
/* --- Dashboard-Style Maroon Theme for Admins Page --- */
body, .content-wrapper {
  background: #ffffff;
  font-family: 'Poppins', sans-serif;
  color: #333;
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
.admin-card {
  background: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.2);
  border-radius: 16px;
  transition: all 0.3s ease;
}
.admin-card:hover {
  transform: translateY(-2px);
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
/* --- DataTables Maroon Theme: Pagination Buttons --- */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  color: #7b2d2d !important;       /* Text color */
  border: 1px solid #7b2d2d;       /* Border color */
  border-radius: 20px;
  padding: 3px 8px;
  margin: 0 2px;
  background: transparent;          /* Default background */
  transition: all 0.2s ease;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: #7b2d2d !important;  /* Hover background */
  color: #fff !important;          /* Hover text color */
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #7b2d2d !important;  /* Active page background */
  color: #fff !important;          /* Active page text color */
  border: 1px solid #7b2d2d;       /* Active page border */
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
  color: rgba(123, 45, 45, 0.4) !important; /* Disabled color */
  border-color: rgba(123, 45, 45, 0.2);
  cursor: not-allowed;
  background: transparent;
}
</style>

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
