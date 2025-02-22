@extends('layouts.app')

@section('title', 'Educators')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Educators</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Add Educator Button -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#educatorModal">
            <i class="fas fa-plus"></i> Add Educator
        </button>

        <!-- Educators Table -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">List of Educators</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped " id="educatorsTable">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($educators as $educator)
                            <tr>
                                <td>{{ $educator->id }}</td>
                                <td>{{ $educator->email }}</td>
                                <td>{{ ucfirst($educator->role) }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-educator" data-id="{{ $educator->id }}" data-email="{{ $educator->email }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-educator" data-id="{{ $educator->id }}">
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

<!-- Educator Modal -->
<div class="modal fade" id="educatorModal" tabindex="-1" aria-labelledby="educatorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="educatorModalLabel">Add Educator</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="educatorForm">
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
                    <button type="button" class="btn btn-primary" id="saveEducator">Save Educator</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Educator Modal -->
<!-- Edit Educator Modal -->
<div class="modal fade" id="editEducatorModal" tabindex="-1" aria-labelledby="editEducatorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editEducatorModalLabel">Edit Educator</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEducatorForm">
                @csrf
                <input type="hidden" id="educator_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_role">Role</label>
                        <select class="form-control" id="edit_role" name="role" required>
                            <option value="educator">Educator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">New Password (Optional)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateEducator">Update Educator</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Educator Confirmation Modal -->
<div class="modal fade" id="deleteEducatorModal" tabindex="-1" aria-labelledby="deleteEducatorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteEducatorModalLabel">Confirm Deletion</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this educator?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    let educatorIdToDelete = null;

    // Open Delete Confirmation Modal
    $(".delete-educator").click(function () {
        educatorIdToDelete = $(this).data("id"); // Get educator ID
        $("#deleteEducatorModal").modal("show"); // Show modal
    });

    // Confirm Delete
    $("#confirmDelete").click(function () {
        if (!educatorIdToDelete) return;

        // Show SweetAlert2 "Processing..." before sending request
        Swal.fire({
            title: "Processing...",
            text: "Please wait while we delete the educator.",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Disable button & change text
        $("#confirmDelete").prop("disabled", true).text("Processing...");

        // Add delay before sending request
        setTimeout(() => {
            $.ajax({
                url: `/educator/delete/${educatorIdToDelete}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                success: function (response) {
                    $("#deleteEducatorModal").modal("hide");

                    setTimeout(() => {
                        Swal.fire({
                            icon: "success",
                            title: "Deleted!",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload(); // Refresh table after delay
                        });
                    }, 500);
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong.",
                    });
                },
                complete: function () {
                    $("#confirmDelete").prop("disabled", false).text("Delete");
                }
            });
        }, 1500); // Delay request by 1.5 seconds
    });
});

</script>
<script>
$(document).ready(function () {
    let editEducatorId = null;

    // Open Edit Modal & Fetch Data from Table
    $(".edit-educator").click(function () {
        let row = $(this).closest("tr"); // Get the closest row
        editEducatorId = $(this).data("id");
        let email = row.find("td:eq(1)").text().trim();
        let role = row.find("td:eq(2)").text().trim().toLowerCase();

        // Populate modal fields
        $("#educator_id").val(editEducatorId);
        $("#edit_email").val(email);
        $("#edit_role").val(role);

        // Show the modal
        $("#editEducatorModal").modal("show");
    });

    // Update Educator via AJAX
    $("#updateEducator").click(function () {
        let id = $("#educator_id").val();
        let email = $("#edit_email").val();
        let role = $("#edit_role").val();
        let password = $("#edit_password").val();

        if (email.trim() === '' || role.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Email and Role are required!',
            });
            return;
        }

        Swal.fire({
            title: 'Updating...',
            text: 'Please wait while the educator is being updated.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `/educator/update/${id}`,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            data: {
                email: email,
                role: role,
                password: password
            },
            success: function (response) {
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $("#editEducatorModal").modal("hide");
                        location.reload(); // Refresh the table
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
});


</script>
<script>
    $(document).ready(function() {
        $('#educatorsTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });

        $('#saveEducator').click(function() {
            var email = $('#email').val();
            var password = $('#password').val();

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
                text: 'Please wait while we save the educator.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('educators.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email,
                    password: password
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#educatorModal').modal('hide');
                        location.reload(); // Refresh to show new educator
                    });
                },
                error: function(xhr) {
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
@endsection
