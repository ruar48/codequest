@extends('layouts.app')

@section('title', 'Admins')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-header text-center py-3">
  <h1 class="fw-bold mb-1" style="font-size: 2rem; color: #7b2d2d; text-shadow: 0 0 6px rgba(123,45,45,0.4);">
    <i class="fas fa-user-shield me-2"></i> ADMIN MANAGEMENT
  </h1>
  <p class="text-muted mb-0" style="opacity: 0.9;">Manage your CodeQuest administrators</p>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="d-flex justify-content-end mb-3">
      <button type="button"
              class="btn btn-maroon text-white fw-semibold px-3 py-1 rounded-pill"
              data-bs-toggle="modal" data-bs-target="#adminModal"
              id="openAddModal"
              style="font-size: 0.9rem;">
        <i class="fas fa-user-plus me-1"></i> Add Admin
      </button>
    </div>

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

<!-- Add/Edit Admin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-white text-dark border border-maroon rounded-3">
      <div class="modal-header text-white py-2 rounded-top"
           style="background: linear-gradient(90deg, #7b2d2d, #a43e3e);">
        <h5 class="modal-title fw-bold" id="adminModalLabel">Add Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="adminForm">
        @csrf
        <input type="hidden" id="admin_id">
        <input type="hidden" id="_method" value="POST">

        <div class="modal-body">
          <div class="form-group mb-3">
            <label class="fw-bold text-maroon">Email</label>
            <input type="email" id="email" class="form-control border-maroon rounded-pill" required>
          </div>

          <div class="form-group mb-3">
            <label class="fw-bold text-maroon">Password</label>
            <input type="password" id="password" class="form-control border-maroon rounded-pill">
            <small class="text-muted">Leave blank when editing if you do not want to change it.</small>
          </div>

          <div class="form-group mb-3">
            <label class="fw-bold text-maroon">Role</label>
            <select id="role" class="form-control border-maroon rounded-pill">
              <option value="admin">Admin</option>
              <option value="superadmin">Superadmin</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-maroon text-white fw-bold rounded-pill" id="saveAdmin">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ====================== STYLES (your original CSS) ====================== --}}
<style>
/* --- Dashboard-Style Maroon Theme --- */
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


{{-- ====================== JS / AJAX ====================== --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {

  let adminTable = $('#adminTable').DataTable();

  // Open CREATE modal
  $('#openAddModal').on('click', function() {
    $('#adminModalLabel').text('Add Admin');
    $('#admin_id').val('');
    $('#email').val('');
    $('#password').val('');
    $('#role').val('admin');
    $('#_method').val('POST');
  });

  // Open EDIT modal
  $(document).on('click', '.edit-admin', function() {
    let row = $(this).closest('tr');
    let id = row.data('id');
    let email = row.data('email');
    let role = row.data('role');

    $('#adminModalLabel').text('Edit Admin');
    $('#admin_id').val(id);
    $('#email').val(email);
    $('#password').val('');
    $('#role').val(role);
    $('#_method').val('PUT');

    let modal = new bootstrap.Modal(document.getElementById('adminModal'));
    modal.show();
  });

  // SAVE (Create or Update)
  $('#saveAdmin').on('click', function() {
    let id = $('#admin_id').val();
    let method = $('#_method').val();

    let url =
      method === 'POST'
      ? "{{ route('admins.store') }}"
      : "/admin/update/" + id;

    $.ajax({
      url: url,
      type: "POST",
      data: {
        _method: method,
        email: $('#email').val(),
        password: $('#password').val(),
        role: $('#role').val(),
      },
      success: function(res) {
        location.reload();
      },
      error: function(err) {
        alert("Error saving admin.");
        console.log(err.responseText);
      }
    });
  });

  // DELETE
  $(document).on('click', '.delete-admin', function() {
    if (!confirm("Are you sure you want to delete this admin?")) return;

    let id = $(this).data('id');

    $.ajax({
      url: "/admin/delete/" + id,
      type: "POST",
      data: { _method: 'DELETE' },
      success: function(res) {
        location.reload();
      },
      error: function(err) {
        alert("Error deleting admin.");
        console.log(err.responseText);
      }
    });
  });

});
</script>

@endsection
<!-- libs -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
  // Ensure CSRF header is sent with every AJAX request (Laravel requires this).
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Initialize DataTable
  let adminTable = $('#adminTable').DataTable({
    responsive: true,
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    lengthMenu: [[10,25,50,-1],[10,25,50,"All"]],
  });

  // Show Add modal (reset form)
  $('#openAddModal').on('click', function() {
    $('#adminModalLabel').text('Add Admin');
    $('#admin_id').val('');
    $('#email').val('');
    $('#password').val('');
    $('#role').val('admin');
    $('#_method').val('POST');
    // show modal explicitly (data-bs-toggle should also work)
    let modal = new bootstrap.Modal(document.getElementById('adminModal'));
    modal.show();
  });

  // Open EDIT modal and populate fields
  $(document).on('click', '.edit-admin', function() {
    let row = $(this).closest('tr');
    let id = row.data('id');
    let email = row.data('email');
    let role = row.data('role');

    $('#adminModalLabel').text('Edit Admin');
    $('#admin_id').val(id);
    $('#email').val(email);
    $('#password').val('');
    $('#role').val(role);
    $('#_method').val('PUT');

    let modal = new bootstrap.Modal(document.getElementById('adminModal'));
    modal.show();
  });

  // SAVE (Create or Update)
  $('#saveAdmin').on('click', function() {
    let id = $('#admin_id').val();
    let method = $('#_method').val() || 'POST';

    // route for create
    let createUrl = "{{ route('admins.store') }}"; // -> /admins/store
    // route for update expects /admin/update/{id}
    let updateUrl = "/admin/update/" + id;

    let payload = {
      _method: method,
      email: $('#email').val(),
      password: $('#password').val(),
      role: $('#role').val()
    };

    let url = (method === 'POST') ? createUrl : updateUrl;

    $.ajax({
      url: url,
      type: 'POST', // Laravel expects POST with _method for PUT/DELETE
      data: payload,
      success: function(res) {
        console.log('SUCCESS response:', res);
        // If your controller returns success JSON, reload table or update row
        // Simple reliable approach: reload page so server-side table is fresh
        location.reload();
      },
      error: function(xhr) {
        console.error('AJAX ERROR:', xhr);
        // If validation errors (422), show the validation messages
        if (xhr.status === 422 && xhr.responseJSON) {
          let errors = xhr.responseJSON.errors || xhr.responseJSON;
          let msgs = [];
          if (typeof errors === 'object') {
            Object.values(errors).forEach(function(v) {
              if (Array.isArray(v)) msgs.push(v.join(', '));
              else msgs.push(v);
            });
          } else {
            msgs.push(JSON.stringify(errors));
          }
          alert('Validation error:\n' + msgs.join('\n'));
        } else if (xhr.status === 419) {
          alert('CSRF token mismatch or session expired. Please refresh the page and try again.');
        } else {
          // show server response text to help debugging
          let text = xhr.responseText ? xhr.responseText : xhr.statusText;
          alert('Error saving admin: ' + text);
        }
      }
    });
  });

  // DELETE admin
  $(document).on('click', '.delete-admin', function() {
    if (!confirm("Are you sure you want to delete this admin?")) return;

    let id = $(this).data('id');
    let url = "/admin/delete/" + id;

    $.ajax({
      url: url,
      type: 'POST',
      data: { _method: 'DELETE' },
      success: function(res) {
        console.log('DELETE success', res);
        location.reload();
      },
      error: function(xhr) {
        console.error('DELETE error', xhr);
        if (xhr.status === 419) {
          alert('CSRF/session issue. Refresh and try again.');
        } else {
          alert('Error deleting admin: ' + (xhr.responseText || xhr.statusText));
        }
      }
    });
  });

  // Ensure modal close buttons will hide the modal (this handles manual hide too)
  // If you ever need to programmatically hide:
  // let modal = bootstrap.Modal.getInstance(document.getElementById('adminModal')); modal.hide();

});
</script>

@endsection