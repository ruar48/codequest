@extends('layouts.app')

@section('title', 'Admins')

@section('content')

<div class="content-header text-center py-3">
  <h1 class="fw-bold mb-1" 
      style="font-size: 2rem; color: #f4d06f; text-shadow: 0 0 8px rgba(244, 208, 111, 0.5);">
      <i class="fas fa-user-shield me-2"></i> ADMIN MANAGEMENT
  </h1>
  <p class="text-secondary mb-0" style="opacity: 0.9;">Manage your CodeQuest administrators</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Admin Button -->
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-gold text-dark fw-semibold px-3 py-1 rounded-pill shadow-glow"
              data-toggle="modal" data-target="#adminModal" style="font-size: 0.9rem;">
        <i class="fas fa-user-plus me-1"></i> Add Admin
      </button>
    </div>

    <!-- Admins Table Card -->
    <div class="card border-0 shadow-lg rounded-4 glass-card">
      <div class="card-header text-dark fw-bold py-2 rounded-top"
           style="background: linear-gradient(90deg, #f4d06f, #f7e7b3);">
        <i class="fas fa-users-cog me-2"></i> List of Admins
      </div>
      <div class="card-body p-3 bg-transparent text-dark">
        <div class="table-responsive">
          <table id="adminTable" class="table table-hover align-middle mb-0 rounded">
            <thead class="text-dark" style="background-color: #f7e7b3;">
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
                  <button class="btn btn-sm btn-outline-gold edit-admin me-1 glow-hover" data-id="{{ $admin->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-danger delete-admin glow-hover" data-id="{{ $admin->id }}">
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
    <div class="modal-content bg-light text-dark border border-gold rounded-3 shadow-glow">
      <div class="modal-header text-dark py-2 rounded-top" style="background: linear-gradient(90deg, #f4d06f, #f7e7b3);">
        <h5 class="modal-title fw-bold mb-0" id="adminModalLabel">Add Admin</h5>
        <button type="button" class="btn-close" data-dismiss="modal"></button>
      </div>
      <form id="adminForm">
        @csrf
        <div class="modal-body py-3">
          <div class="form-group mb-3">
            <label for="email" class="fw-bold" style="color: #f4d06f;">Email</label>
            <input type="email" class="form-control border-gold rounded-pill"
                   id="email" name="email" required>
          </div>
          <div class="form-group mb-2">
            <label for="password" class="fw-bold" style="color: #f4d06f;">Password</label>
            <input type="password" class="form-control border-gold rounded-pill"
                   id="password" name="password" required>
          </div>
        </div>
        <div class="modal-footer border-0 py-2">
          <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-gold text-dark fw-bold btn-sm rounded-pill shadow-glow"
                  id="saveAdmin">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
/* === Light Theme with Pastel Gold === */
body, .content-wrapper {
  background: #f8fafc;
  font-family: 'Poppins', sans-serif;
  color: #111827;
}

/* Glass Card */
.glass-card {
  background: #ffffff;
  border: 1px solid rgba(244, 208, 111, 0.3);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}
.glass-card:hover {
  box-shadow: 0 0 20px rgba(244, 208, 111, 0.3);
  transform: translateY(-3px);
}

/* Glow Shadow */
.shadow-glow {
  box-shadow: 0 0 8px rgba(244, 208, 111, 0.3);
  transition: all 0.3s ease;
}
.shadow-glow:hover {
  box-shadow: 0 0 14px rgba(244, 208, 111, 0.5);
  transform: translateY(-2px);
}

/* Custom Pastel Gold Buttons */
.btn-gold {
  background: linear-gradient(90deg, #f4d06f, #f7e7b3);
  border: none;
}
.btn-gold:hover {
  background: linear-gradient(90deg, #f7e7b3, #f4d06f);
}

/* Outline Button */
.btn-outline-gold {
  border: 1px solid #f4d06f;
  color: #f4d06f;
}
.btn-outline-gold:hover {
  background-color: #f4d06f;
  color: #111827;
}

/* Table Hover */
.table-hover tbody tr:hover {
  background-color: rgba(244, 208, 111, 0.15);
  transition: all 0.2s ease;
}

/* Form Control */
input.form-control {
  background: #fff;
  color: #111827;
}
input.form-control:focus {
  box-shadow: 0 0 8px rgba(244, 208, 111, 0.5);
  border-color: #f4d06f;
}

/* Scrollbar */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-thumb {
  background: #f4d06f;
  border-radius: 4px;
}
</style>

@push('scripts')
<script>
$(document).ready(function () {
    $('#adminTable').DataTable({
        responsive: true,
        autoWidth: false,
        lengthChange: true,
        info: true,
        paging: true,
        pageLength: 10,
        order: [[0, 'asc']],
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ admins",
            paginate: {
                previous: "Previous",
                next: "Next",
                first: "First",
                last: "Last"
            }
        }
    });
});
</script>
@endpush

@endsection
