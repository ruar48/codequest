@extends('layouts.app')

@section('title', 'Test Bank Questions')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Test Bank Questions</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Add Question Button -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#questionModal">
            <i class="fas fa-plus"></i> Add Question
        </button>

        <!-- Floating Card for Test Bank Table -->
        <div class="card shadow-lg rounded-lg border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">List of Questions</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="questionTable" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Output</th>
                                <th>Level</th>
                                <th>Tips</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                            <tr data-id="{{ $question->id }}">
                                <td>{{ $question->id }}</td>
                                <td>{{ $question->question }}</td>
                                <td>{{ $question->output }}</td>
                                <td>
                                    <span class="badge badge-{{ $question->level == 'easy' ? 'success' : ($question->level == 'intermediate' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($question->level) }}
                                    </span>
                                </td>
                                <td>{{ $question->tips }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-question" data-id="{{ $question->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-question" data-id="{{ $question->id }}">
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

<!-- Add Question Modal -->
<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="questionModalLabel">Add Question</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="questionForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="question">Question</label>
                        <textarea class="form-control" id="question" name="question" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="output">Expected Output</label>
                        <textarea class="form-control" id="output" name="output" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" id="level" name="level" required>
                            <option value="easy">Easy</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tips">Tips</label>
                        <textarea class="form-control" id="tips" name="tips"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveQuestion">Save Question</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editQuestionModalLabel">Edit Question</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editQuestionForm">
                @csrf
                <input type="hidden" id="question_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_question">Question</label>
                        <textarea class="form-control" id="edit_question" name="question" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_output">Expected Output</label>
                        <textarea class="form-control" id="edit_output" name="output" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_level">Level</label>
                        <select class="form-control" id="edit_level" name="level" required>
                            <option value="easy">Easy</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_tips">Tips</label>
                        <textarea class="form-control" id="edit_tips" name="tips"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEditQuestion">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#questionTable').DataTable({
        responsive: true,
        autoWidth: false,
        dom: '<"row mb-3"' +
                '<"col-md-4 d-flex align-items-center"l>' +    // Show entries
                '<"col-md-4 text-center"B>' +                   // Export buttons
                '<"col-md-4 d-flex justify-content-end"f>' +    // Search box
             '>rtip',
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-sm btn-secondary me-1'
            },
            {
                extend: 'csvHtml5',
                className: 'btn btn-sm btn-info me-1',
                exportOptions: {
                    columns: ':visible',
                    stripHtml: true,
                    format: {
                        header: function (data) {
                            return data.trim();
                        }
                    }
                }
            },
            {
                extend: 'excelHtml5',
                className: 'btn btn-sm btn-success me-1',
                exportOptions: {
                    columns: ':visible',
                    stripHtml: true
                },
                customize: function (xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    // Make header bold
                    $('row:first c', sheet).attr('s', '2');

                    // Auto-width columns
                    $('col', sheet).attr('width', 25);
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-sm btn-danger me-1',
                exportOptions: {
                    columns: ':visible',
                    stripHtml: true
                },
                customize: function (doc) {
                    // Header style
                    doc.styles.tableHeader.fillColor = '#007bff';
                    doc.styles.tableHeader.color = 'white';
                    doc.styles.tableHeader.alignment = 'center';
                    doc.styles.tableHeader.fontSize = 12;

                    // Body style
                    doc.defaultStyle.fontSize = 10;

                    // Table layout
                    doc.content[1].table.widths = '*'.repeat(doc.content[1].table.body[0].length).split('');
                }
            },
            {
                extend: 'print',
                className: 'btn btn-sm btn-primary',
                exportOptions: {
                    columns: ':visible',
                    stripHtml: true
                }
            }
        ]
    });
});
</script>


<script>





$(document).ready(function () {

    // Save New Question
    $('#saveQuestion').click(function () {
        let question = $('#question').val();
        let output = $('#output').val();
        let level = $('#level').val();
        let tips = $('#tips').val();

        if (question.trim() === '' || output.trim() === '' || level.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'All fields except tips are required!',
            });
            return;
        }

        $.ajax({
            url: "{{ route('testbank.store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                question: question,
                output: output,
                level: level,
                tips: tips
            },
            success: function () {
                Swal.fire('Success!', 'Question added.', 'success').then(() => {
                    location.reload();
                });
            },
            error: function () {
                Swal.fire('Error!', 'Failed to add question.', 'error');
            }
        });
    });

    // Open Edit Question Modal
    $(document).on('click', '.edit-question', function () {
        let id = $(this).data('id');

        $.get(`/testbank/${id}/edit`, function (question) {
            $('#question_id').val(question.id);
            $('#edit_question').val(question.question);
            $('#edit_output').val(question.output);
            $('#edit_level').val(question.level);
            $('#edit_tips').val(question.tips);
            $('#editQuestionModal').modal('show');
        });
    });

    // Save Edited Question
    $('#saveEditQuestion').click(function () {
        let id = $('#question_id').val();
        let question = $('#edit_question').val();
        let output = $('#edit_output').val();
        let level = $('#edit_level').val();
        let tips = $('#edit_tips').val();

        if (question.trim() === '' || output.trim() === '' || level.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'All fields except tips are required!',
            });
            return;
        }

        $.ajax({
            url: `/testbank/${id}`,
            type: "PUT",
            data: {
                _token: "{{ csrf_token() }}",
                question: question,
                output: output,
                level: level,
                tips: tips
            },
            success: function () {
                Swal.fire('Updated!', 'Question updated successfully.', 'success').then(() => {
                    location.reload();
                });
            },
            error: function () {
                Swal.fire('Error!', 'Failed to update question.', 'error');
            }
        });
    });

    // Delete Question
    $(document).on('click', '.delete-question', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/testbank/${id}`,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function () {
                        Swal.fire('Deleted!', 'Question has been deleted.', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to delete question.', 'error');
                    }
                });
            }
        });
    });
});

</script>
@endsection
