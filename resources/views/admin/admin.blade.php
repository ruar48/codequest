@extends('layouts.app')

@section('title', 'Admins')

@section('content')

<div class="content-header text-center py-3">
  <h1 class="fw-bold mb-1 text-warning" 
      style="font-size: 2rem; text-shadow: 0 0 12px rgba(250,204,21,0.8);">
      <i class="fas fa-user-shield me-2"></i> ADMIN MANAGEMENT
  </h1>
  <p class="text-light mb-0" style="opacity: 0.9;">Manage your CodeQuest administrators</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Admin Button -->
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-warning text-dark fw-semibold px-3 py-1 rounded-pill shadow-glow"
              data-toggle="modal" data-target="#adminModal" style="font-size: 0.9rem;">
        <i class="fas fa-user-plus me-1"></i> Add Admin
      </button>
    </div>

    <!-- Admins Table Card -->
    <div class="card border-0 shadow-lg rounded-4 glass-card">
      <div class="card-header text-dark fw-bold py-2 rounded-top"
           style="background: linear-gradient(90deg, #facc15, #ffe46b);">
        <i class="fas fa-users-cog me-2"></i> List of Admins
      </div>
      <div class="card-body p-3 bg-transparent text-light">
        <div class="table-responsive">
          <table id="adminTable" class="table table-dark table-hover align-middle mb-0 rounded">
            <thead class="table-warning text-dark">
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
                  <button class="btn btn-sm btn-outline-warning edit-admin me-1 glow-hover" data-id="{{ $admin->id }}">
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
    <div class="modal-content bg-dark text-light border border-warning rounded-3 shadow-glow">
      <div class="modal-header bg-gradient-warning text-dark py-2 rounded-top">
        <h5 class="modal-title fw-bold mb-0" id="adminModalLabel">Add Admin</h5>
        <button type="button" class="btn-close" data-dismiss="modal"></button>
      </div>
      <form id="adminForm">
        @csrf
        <div class="modal-body py-3">
          <div class="form-group mb-3">
            <label for="email" class="fw-bold text-warning">Email</label>
            <input type="email" class="form-control bg-dark text-light border-warning rounded-pill"
                   id="email" name="email" required>
          </div>
          <div class="form-group mb-2">
            <label for="password" class="fw-bold text-warning">Password</label>
            <input type="password" class="form-control bg-dark text-light border-warning rounded-pill"
                   id="password" name="password" required>
          </div>
        </div>
        <div class="modal-footer border-0 py-2">
          <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-warning text-dark fw-bold btn-sm rounded-pill shadow-glow"
                  id="saveAdmin">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
/* --- CodeQuest Dashboard Theming --- */
body, .content-wrapper {
  background: linear-gradient(135deg, #0a0f24, #1c223a);
  font-family: 'Poppins', sans-serif;
  color: #fff;
}

/* Glow and Glass Styles */
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(250, 204, 21, 0.2);
  backdrop-filter: blur(8px);
  box-shadow: 0 4px 16px rgba(250, 204, 21, 0.15);
  transition: all 0.3s ease;
}
.glass-card:hover {
  box-shadow: 0 0 20px rgba(250, 204, 21, 0.4);
  transform: translateY(-3px);
}
.shadow-glow {
  box-shadow: 0 0 8px rgba(250, 204, 21, 0.4);
  transition: all 0.3s ease;
}
.shadow-glow:hover {
  box-shadow: 0 0 16px rgba(250, 204, 21, 0.7);
  transform: translateY(-2px);
}

/* Buttons */
.btn-warning {
  background: linear-gradient(90deg, #facc15, #ffe46b);
  border: none;
}
.btn-warning:hover {
  background: linear-gradient(90deg, #ffe46b, #facc15);
}

/* Table */
.table-hover tbody tr:hover {
  background-color: rgba(250, 204, 21, 0.08);
  transition: all 0.2s ease;
}

/* Modal Inputs */
input.form-control:focus {
  box-shadow: 0 0 8px rgba(250, 204, 21, 0.5);
  border-color: #facc15;
}

/* Scrollbar */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-thumb {
  background: #facc15;
  border-radius: 4px;
}
</style>

@endsection
