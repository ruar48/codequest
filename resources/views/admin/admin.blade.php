@extends('layouts.app')

@section('title', 'Admins')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-header text-center py-3">
  <h1 class="fw-bold mb-1" style="font-size: 2rem; color: #7b2d2d;">
    <i class="fas fa-user-shield me-2"></i> ADMIN MANAGEMENT
  </h1>
  <p class="text-muted">Manage your administrators</p>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="d-flex justify-content-end mb-3">
      <button id="openAddModal" class="btn btn-maroon text-white fw-semibold rounded-pill px-3">
        <i class="fas fa-user-plus me-1"></i> Add Admin
      </button>
    </div>

    <div class="card border-0 rounded-4 admin-card">
      <div class="card-header text-white fw-bold py-2"
           style="background: linear-gradient(90deg, #7b2d2d, #a43e3e);">
        <i class="fas fa-users-cog me-2"></i> List of Admins
      </div>

      <div class="card-body bg-white">
        <div class="table-responsive">
          <table id="adminTable" class="table table-bordered table-hover align-middle">
            <thead style="background-color: #7b2d2d; color: #fff;">
              <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Role</th>
                <th width="160">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($admins as $admin)
              <tr data-id="{{ $admin->id }}" data-email="{{ $admin->email }}" data-role="{{ $admin->role }}">
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->email }}</td>
                <td class="text-capitalize">{{ $admin->role }}</td>
                <td>
                  <button class="btn btn-sm btn-outline-maroon edit-admin"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-sm btn-outline-danger delete-admin" data-id="{{ $admin->id }}"><i class="fas fa-trash"></i></button>
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

<!-- MODAL -->
<div class="modal fade" id="adminModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-maroon">

      <div class="modal-header text-white"
           style="background: linear-gradient(90deg, #7b2d2d, #a43e3e); position: relative;">
        <h5 class="modal-title fw-bold" id="adminModalLabel">Add Admin</h5>
        <!-- Close button -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" 
                style="right: 10px; position: absolute;"></button>
      </div>

      <form id="adminForm">
        @csrf
        <input type="hidden" id="admin_id">
        <input type="hidden" id="_method" value="POST">

        <div class="modal-body">

          <label class="fw-bold">Email</label>
          <input type="email" id="email" class="form-control mb-3" required>

          <label class="fw-bold">Password</label>
          <input type="password" id="password" class="form-control mb-2">
          <small class="text-muted">Leave blank to keep the current password.</small>

          <label class="fw-bold mt-3">Role</label>
          <select id="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="superadmin">Superadmin</option>
          </select>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="saveAdmin" class="btn btn-maroon text-white rounded-pill fw-bold">Save</button>
        </div>

      </form>

    </div>
  </div>
</div>

{{-- ====================== STYLES ====================== --}}
<style>
body, .content-wrapper {
  background: #ffffff;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

.btn-maroon {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  border: none;
}
.btn-maroon:hover {
  background: linear-gradient(90deg, #a43e3e, #7b2d2d);
}

.btn-outline-maroon {
  border: 1px solid #7b2d2d;
  color: #7b2d2d;
}
.btn-outline-maroon:hover {
  background: #7b2d2d;
  color: #fff;
}

.admin-card {
  background: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.2);
  border-radius: 16px;
  transition: 0.3s ease;
}
.admin-card:hover { transform: translateY(-2px); }

.text-maroon { color: #7b2d2d !important; }
.border-maroon { border-color: #7b2d2d !important; }

input.form-control:focus {
  box-shadow: 0 0 8px rgba(123, 45, 45, 0.4);
  border-color: #7b2d2d;
}
</style>

<!-- JS Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }
    });

    let adminModal = new bootstrap.Modal(document.getElementById('adminModal'));
    $('#adminTable').DataTable();

    // Open Add Modal
    $('#openAddModal').click(function () {
        $('#adminModalLabel').text('Add Admin');
        $('#admin_id').val('');
        $('#email').val('');
        $('#password').val('');
        $('#role').val('admin');
        $('#_method').val('POST');
        adminModal.show();
    });

    // Open Edit Modal
    $(document).on('click', '.edit-admin', function () {
        let row = $(this).closest('tr');
        $('#adminModalLabel').text('Edit Admin');
        $('#admin_id').val(row.data('id'));
        $('#email').val(row.data('email'));
        $('#role').val(row.data('role'));
        $('#password').val('');
        $('#_method').val('PUT');
        adminModal.show();
    });

    // Save Admin
    $('#saveAdmin').click(function () {
        let id = $('#admin_id').val();
        let method = $('#_method').val();
        let url = (method === "POST") ? "{{ route('admins.store') }}" : "/admin/update/" + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method: method,
                email: $('#email').val(),
                password: $('#password').val(),
                role: $('#role').val()
            },
            success: function() { location.reload(); },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert("Error saving admin.");
            }
        });
    });

    // Delete Admin
    $(document).on('click', '.delete-admin', function () {
        if (!confirm("Delete this admin?")) return;
        let id = $(this).data('id');
        $.ajax({
            url: "/admin/delete/" + id,
            type: "POST",
            data: { _method: "DELETE" },
            success: function() { location.reload(); },
            error: function(xhr) { console.log(xhr.responseText); alert("Error deleting admin."); }
        });
    });

});
</script>

@endsection
