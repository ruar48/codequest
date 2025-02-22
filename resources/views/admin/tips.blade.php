@extends('layouts.app')

@section('title', 'Tips')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tips</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Add Tip Button -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tipModal">
            <i class="fas fa-plus"></i> Add Tip
        </button>

        <!-- Tips Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Tips</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tipsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tips as $tip)
                        <tr>
                            <td>{{ $tip->id }}</td>
                            <td>{{ $tip->description }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-tip" data-id="{{ $tip->id }}" data-description="{{ $tip->description }}" data-toggle="modal" data-target="#tipModal">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-tip" data-id="{{ $tip->id }}">
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
</section>

<!-- Tip Modal -->
<div class="modal fade" id="tipModal" tabindex="-1" aria-labelledby="tipModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tipModalLabel">Add tips</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tipForm">
                @csrf <!-- Add this to prevent CSRF attack -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTip">Save Tip</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#saveTip').click(function() {
            var description = $('#description').val();

            if (description.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Description cannot be empty.',
                });
                return;
            }

            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we save your tip.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('tips.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    description: description
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#tipModal').modal('hide');
                        location.reload(); // Reload the page to see the new tip
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
