@extends('layouts.app')

@section('title', 'Admins')

@section('content')
<div class="content-header text-center py-2">
    <h1 class="fw-bold text-warning mb-1" style="font-size: 1.8rem;">ADMIN MANAGEMENT</h1>
    <p class="text-light mb-2" style="font-size: 0.95rem;">Manage your CodeQuest administrators</p>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Add Admin Button (aligned right, less space) -->
        <div class="d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-warning text-dark fw-semibold px-3 py-1" data-toggle="modal" data-target="#adminModal" style="font-size: 0.9rem;">
                <i class="fas fa-user-plus me-1"></i> Add Admin
            </button>
        </div>

        <!-- Admins Table -->
        <div class="card bg-dark text-light border-0 shadow-lg rounded-4">
            <div class="card-header bg-gradient-warning text-dark fw-bold py-2 rounded-top">
                <i class="fas fa-users-cog me-2"></i> List of Admins
            </div>
            <div class="card-body p-3 bg-dark">
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
                                    <button class="btn btn-sm btn-outline-warning edit-admin me-1" data-id="{{ $admin->id }}">
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
            <div class="modal-header bg-warning text-dark py-2">
                <h5 class="modal-title fw-bold mb-0" id="adminModalLabel">Add Admin</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form id="adminForm">
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
                    <button type="button" class="btn btn-warning text-dark fw-bold btn-sm" id="saveAdmin">Save</button>
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
</style>
@endsection
