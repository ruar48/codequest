@extends('layouts.app')

@section('title', 'Test Bank Questions')

@section('content')

<style>
/* === Dashboard Maroon Theme (White Base) === */
body, .content-wrapper {
  background: #ffffff !important;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

/* ===== HEADER ===== */
.content-header {
  text-align: center;
  padding-top: 15px;
  padding-bottom: 5px;
  margin-bottom: 20px;
}
.content-header h1 {
  font-weight: 700;
  color: #7b2d2d;
  font-size: 1.9rem;
  letter-spacing: 0.5px;
}
.content-header p {
  color: #666;
  font-size: 0.95rem;
  margin-bottom: 0;
}

/* ===== BUTTONS ===== */
.btn-maroon {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  transition: all 0.3s ease;
}
.btn-maroon:hover {
  background: linear-gradient(90deg, #a43e3e, #7b2d2d);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(123, 45, 45, 0.3);
}

.btn-outline-maroon {
  border: 1px solid #7b2d2d;
  color: #7b2d2d;
  transition: all 0.3s ease;
}
.btn-outline-maroon:hover {
  background-color: #7b2d2d;
  color: #fff;
}

/* ===== CARD ===== */
.card {
  background: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.25);
  border-radius: 16px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
}
.card:hover {
  transform: translateY(-2px);
}
.card-header {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  font-weight: 600;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  font-size: 1.05rem;
}

/* ===== TABLE ===== */
.table {
  background: #fff;
  color: #333;
  border-radius: 12px;
  overflow: hidden;
}
.table thead th {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
  border: none;
  text-align: center;
}
.table tbody td {
  vertical-align: middle;
}
.table-hover tbody tr:hover {
  background-color: rgba(123, 45, 45, 0.08);
  transition: 0.25s ease;
}
.badge-success { background-color: #2ecc71; }
.badge-warning { background-color: #f1c40f; color: #1c1c1c; }
.badge-danger  { background-color: #e74c3c; }

/* ===== MODAL ===== */
.modal-content {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid rgba(123, 45, 45, 0.2);
}
.modal-header {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  border-bottom: none;
  border-top-left-radius: 14px;
  border-top-right-radius: 14px;
}
.form-control, textarea, select {
  background-color: #fff;
  color: #333;
  border: 1px solid #ccc;
  border-radius: 6px;
}
.form-control:focus {
  border-color: #7b2d2d;
  box-shadow: 0 0 6px rgba(123, 45, 45, 0.3);
}
/* Sidebar Active / Hover Links */
.nav-link.active,
.nav-link:hover {
  background-color: rgba(220, 160, 160, 0.25) !important; /* light maroon */
  border-left: 3px solid #ecbbbbff; /* maroon indicator line */
  color: #ffffff !important; /* keep text white for visibility */
  font-weight: 600;
  transition: all 0.2s ease;
  box-shadow: 0 6px 12px rgba(220, 160, 160, 0.35); /* stronger, more visible shadow */
}
/* ===== PAGINATION ===== */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  color: #7b2d2d !important;
  border: 1px solid #7b2d2d;
  border-radius: 20px;
  padding: 3px 8px;
  margin: 0 2px;
  transition: all 0.2s ease;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: #7b2d2d !important;
  color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #7b2d2d !important;
  color: #fff !important;
  border: 1px solid #7b2d2d;
}
</style>

<div class="content-header">
  <h1>Test Bank Questions</h1>
  <p>Manage and organize your CodeQuest test questions efficiently</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Question Button -->
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-maroon fw-semibold px-3 py-2" 
              data-bs-toggle="modal" data-bs-target="#questionModal">
        <i class="fas fa-plus me-1"></i> Add Question
      </button>
    </div>

    <!-- Questions Table -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-database me-2"></i> List of Questions</span>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive">
          <table id="questionTable" class="table table-hover align-middle mb-0">
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
                <td class="text-center">{{ $question->id }}</td>
                <td>{{ $question->question }}</td>
                <td>{{ $question->output }}</td>
                <td class="text-center">
                  <span class="badge badge-{{ $question->level == 'easy' ? 'success' : ($question->level == 'intermediate' ? 'warning' : 'danger') }}">
                    {{ ucfirst($question->level) }}
                  </span>
                </td>
                <td>{{ $question->tips }}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-outline-maroon edit-question me-1" data-id="{{ $question->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-maroon delete-question" data-id="{{ $question->id }}">
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
<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="questionForm" action="{{ route('testbank.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Question</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="output" class="form-label">Output</label>
            <input type="text" class="form-control" id="output" name="output" required>
          </div>
          <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select class="form-control" id="level" name="level" required>
              <option value="easy">Easy</option>
              <option value="intermediate">Intermediate</option>
              <option value="hard">Hard</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="tips" class="form-label">Tips</label>
            <textarea class="form-control" id="tips" name="tips" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-maroon">Save Question</button>
          <button type="button" class="btn btn-outline-maroon" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function() {

    // DELETE QUESTION
    $('.delete-question').on('click', function() {
        const id = $(this).data('id');

        if (confirm('Are you sure you want to delete this question?')) {
            $.ajax({
                url: `/testbank/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Question deleted successfully!');
                    $(`tr[data-id="${id}"]`).remove(); // remove row from table
                },
                error: function(xhr) {
                    alert('Failed to delete question!');
                }
            });
        }
    });

    // EDIT QUESTION
$('.edit-question').on('click', function() {
    const id = $(this).data('id');

    $.get(`/testbank/${id}/edit`, function(data) {
        $('#questionModal .modal-title').text('Edit Question');
        $('#questionForm').attr('action', `/testbank/${id}`);
        
        // Add hidden _method input for PUT if not exists
        if ($('#questionForm input[name="_method"]').length === 0) {
            $('#questionForm').append('<input type="hidden" name="_method" value="PUT">');
        }

        // Fill form fields
        $('#question').val(data.question);
        $('#output').val(data.output);
        $('#level').val(data.level);
        $('#tips').val(data.tips);

        // Use existing modal instance to ensure Cancel works
        const modalEl = document.getElementById('questionModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });
});

});
</script>

@endsection
