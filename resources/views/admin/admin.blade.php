@extends('layouts.app')

@section('title', 'Admins')

@section('content')
<div class="content-header text-center py-4">
    <h1 class="fw-bold text-warning">ADMIN MANAGEMENT</h1>
    <p class="text-light">Manage your CodeQuest administrators here.</p>
    <hr class="border-warning mx-auto" style="width: 200px;">
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Add Admin Button -->
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-warning text-dark fw-bold" data-toggle="modal" data-target="#adminModal">
                <i class="fas fa-user-plus me-1"></i> Add Admin
            </button>
        </div>

        <!-- Admins Table -->
        <div class="card bg-dark text-light border-0 shadow-lg rounded-4">
            <div class="card-header bg-gradient-warning text-dark fw-bold rounded-top">
                <i class="fas fa-users-cog me-2"></i> List of Admins
            </div>
            <div class="card-body bg-dark">
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
                                    <button class="btn btn-sm btn-outline-warning edit-admin me-1" data-id="{{ $admin->id }}" data-target="#editAdminModal">
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
        <div class="modal-content bg-dark text-light border border-warning rounded-3">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="adminModalLabel">Add Admin</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form id="adminForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="email" class="fw-bold text-warning">Email</label>
                        <input type="email" class="form-control bg-dark text-light border-warning" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="fw-bold text-warning">Password</label>
                        <input type="password" class="form-control bg-dark text-light border-warning" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning text-dark fw-bold" id="saveAdmin">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light border border-warning rounded-3">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold">Edit Admin</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form id="editAdminForm">
                @csrf
                <input type="hidden" id="admin_id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="fw-bold text-warning">Email</label>
                        <input type="email" class="form-control bg-dark text-light border-warning" id="admin_email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-bold text-warning">New Password (optional)</label>
                        <input type="password" class="form-control bg-dark text-light border-warning" id="admin_password" name="password">
                        <small class="text-muted">Leave blank if unchanged.</small>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold text-warning">Role</label>
                        <select class="form-control bg-dark text-light border-warning" id="admin_role" name="role">
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning text-dark fw-bold" id="saveEditAdmin">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Admin Modal -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light border border-danger rounded-3">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Confirm Delete</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this admin?
                <input type="hidden" id="delete_admin_id">
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAdmin">Delete</button>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #0d0d1a;
        color: #f8f9fa;
    }
    .bg-gradient-warning {
        background: linear-gradient(90deg, #ffcc00, #ffdd44);
    }
    .card {
        background-color: #101020;
        color: #fff;
        border: 1px solid rgba(255, 204, 0, 0.2);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(255, 204, 0, 0.1);
        transition: 0.3s;
    }
    .btn-warning {
        box-shadow: 0 0 8px rgba(255, 204, 0, 0.5);
        transition: 0.3s;
    }
    .btn-warning:hover {
        box-shadow: 0 0 15px rgba(255, 204, 0, 0.9);
    }
</style>
@endsection
