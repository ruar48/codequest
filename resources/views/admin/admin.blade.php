@extends('layouts.app')

@section('title', 'Admins')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admins</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Add Admin Button -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#adminModal">
            <i class="fas fa-plus"></i> Add Admin
        </button>

        <!-- Floating Card for Admins Table -->
        <div class="card shadow-lg rounded-lg border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">List of Admins</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="adminTable" class="table">
                        <thead>
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
                                <td>{{ ucfirst($admin->role) }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-admin" data-id="{{ $admin->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-admin" data-id="{{ $admin->id }}">
                                        <i class="fas fa-trash"></i> Delete
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

<!-- Admin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="adminModalLabel">Add Admin</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="adminForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAdmin">Save Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Admin Edit Modal -->
<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAdminForm">
                @csrf
                <input type="hidden" id="admin_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="admin_email">Email</label>
                        <input type="email" class="form-control" id="admin_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="admin_password">New Password (optional)</label>
                        <input type="password" class="form-control" id="admin_password" name="password">
                        <small class="form-text text-muted">Leave blank if you don’t want to change the password.</small>
                    </div>
                    <div class="form-group">
                        <label for="admin_role">Role</label>
                        <select class="form-control" id="admin_role" name="role">
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEditAdmin">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Admin Modal -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAdminModalLabel">Confirm Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this admin?
                <input type="hidden" id="delete_admin_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAdmin">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- DataTables and Script -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        let deleteAdminId = null;
        let adminData = [];

        // Delete Admin
        $(".delete-admin").click(function () {
            deleteAdminId = $(this).data("id");
            $("#deleteAdminModal").modal("show");
        });

        $("#confirmDeleteAdmin").click(function () {
            if (!deleteAdminId) return;

            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while the admin is being deleted.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: `/admin/delete/${deleteAdminId}`,
                type: "DELETE",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                success: function (response) {
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $("#deleteAdminModal").modal("hide");
                            location.reload();
                        });
                    }, 1000);
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete admin. Please try again.',
                    });
                }
            });
        });

        // Convert Table Data to JSON
        $("#adminTable tbody tr").each(function () {
            let admin = {
                id: $(this).data("id"),
                email: $(this).data("email"),
                role: $(this).data("role")
            };
            adminData.push(admin);
        });

        console.log("Admin Data as JSON:", adminData);

        // Edit Admin
        $(".edit-admin").click(function () {
            let adminId = $(this).data("id");
            let admin = adminData.find(a => a.id == adminId);

            if (admin) {
                $("#admin_id").val(admin.id);
                $("#admin_email").val(admin.email);
                $("#admin_role").val(admin.role);
                $("#editAdminModal").modal("show");
            } else {
                console.error("Admin not found!");
            }
        });

        $("#saveEditAdmin").click(function () {
            let adminId = $('#admin_id').val();
            let email = $('#admin_email').val();
            let role = $('#admin_role').val();
            let password = $('#admin_password').val();

            if (email.trim() === '' || role.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Email and role are required!',
                });
                return;
            }

            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we update the admin.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: `/admin/update/${adminId}`,
                type: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email,
                    role: role,
                    password: password ? password : null
                },
                success: function (response) {
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#editAdminModal').modal('hide');
                            location.reload();
                        });
                    }, 1000);
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong.",
                    });
                }
            });
        });

        // DataTables
        $('#adminsTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });

        // Save New Admin
        $('#saveAdmin').click(function () {
            let email = $('#email').val();
            let password = $('#password').val();

            if (email.trim() === '' || password.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'All fields are required!',
                });
                return;
            }

            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we save the admin.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "{{ route('admins.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email,
                    password: password
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#adminModal').modal('hide');
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong.",
                    });
                }
            });
        });
    });
</script>

<style>
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }

    .btn-sm {
        font-size: 0.85rem;
    }
</style>
@endsection
