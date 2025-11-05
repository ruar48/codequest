@extends('layouts.app')

@section('title', 'Test Bank Questions')

@section('content')

<style>
/* === Global Dashboard Theme === */
body, .content-wrapper {
  background: linear-gradient(135deg, #0a0f24, #1c223a);
  color: #fff;
  font-family: 'Poppins', sans-serif;
}

/* Header */
.content-header {
  text-align: center;
  padding-top: 15px;
  padding-bottom: 0;
  margin-bottom: 5px;
}

.content-header h1 {
  font-weight: 700;
  color: #facc15;
  font-size: 1.8rem;
  text-shadow: 0 0 12px rgba(250, 204, 21, 0.4);
}

.content-header p {
  color: #e5e5e5;
  font-size: 0.95rem;
  margin-bottom: 0;
}

/* Buttons */
.btn-primary {
  background-color: #facc15;
  color: #1c1c1c;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  transition: all 0.3s;
}
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 10px rgba(250, 204, 21, 0.8);
}

/* Cards */
.card {
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250, 204, 21, 0.25);
  box-shadow: 0 4px 16px rgba(250, 204, 21, 0.25);
  border-radius: 16px;
  margin-top: 8px !important;
  transition: all 0.3s ease;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
}
.card-header {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
  font-weight: 700;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
}

/* Table */
.table-dark, .table {
  background: transparent;
  color: #fff;
}
.table thead th {
  color: #000;
  background-color: #facc15;
  font-weight: 600;
}
.table tbody tr:hover {
  background: rgba(250, 204, 21, 0.1);
  transition: 0.3s;
}

/* Badges */
.badge-success { background-color: #27ae60; }
.badge-warning { background-color: #f1c40f; color: #1c1c1c; }
.badge-danger  { background-color: #e74c3c; }

/* Modal */
.modal-content {
  background-color: #101020;
  color: #fff;
  border: 1px solid rgba(250, 204, 21, 0.4);
  border-radius: 12px;
}
.modal-header {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
  border-bottom: none;
}
.form-control, textarea, select {
  background-color: #0a0f24;
  color: #fff;
  border: 1px solid rgba(250, 204, 21, 0.5);
}
.form-control:focus {
  box-shadow: 0 0 8px rgba(250, 204, 21, 0.6);
  border-color: #facc15;
}

/* DataTables */
.dataTables_wrapper .dataTables_filter input {
  background-color: #0a0f24;
  border: 1px solid rgba(250, 204, 21, 0.4);
  color: #fff;
  border-radius: 6px;
  padding: 4px 8px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background-color: transparent;
  border: none;
  color: #facc15 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #000 !important;
  border-radius: 6px;
}
.dataTables_wrapper .dataTables_info {
  color: #aaa;
}
</style>

<div class="content-header">
  <h1>TEST BANK QUESTIONS</h1>
  <p>Manage and organize your CodeQuest test questions efficiently</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Question Button -->
    <div class="d-flex justify-content-end mb-2">
      <button type="button" class="btn btn-primary text-dark fw-semibold px-3 py-1" 
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
          <table id="questionTable" class="table table-dark table-hover align-middle mb-0 rounded">
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
                  <button class="btn btn-sm btn-outline-warning edit-question me-1" data-id="{{ $question->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-danger delete-question" data-id="{{ $question->id }}">
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

<!-- Add/Edit Question Modal -->
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
            <textarea name="question" id="question" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label for="output" class="form-label">Expected Output</label>
            <input type="text" name="output" id="output" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select name="level" id="level" class="form-control" required>
              <option value="easy">Easy</option>
              <option value="intermediate">Intermediate</option>
              <option value="hard">Hard</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="tips" class="form-label">Tips</label>
            <textarea name="tips" id="tips" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Question</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Initialize DataTables
    $('#questionTable').DataTable();

    // Edit button click
    $('.edit-question').on('click', function () {
      const id = $(this).data('id');
      const row = $('tr[data-id="'+id+'"]');
      const question = row.find('td:nth-child(2)').text();
      const output = row.find('td:nth-child(3)').text();
      const level = row.find('td:nth-child(4) span').text().toLowerCase();
      const tips = row.find('td:nth-child(5)').text();

      $('#questionForm').attr('action', '/testbank/' + id);
      $('#questionForm').append('<input type="hidden" name="_method" value="PUT">');
      $('#question').val(question);
      $('#output').val(output);
      $('#level').val(level);
      $('#tips').val(tips);
      $('#questionModal .modal-title').text('Edit Question');
      var modal = new bootstrap.Modal(document.getElementById('questionModal'));
      modal.show();
    });

    // Clear form on modal hide
    $('#questionModal').on('hidden.bs.modal', function () {
      $('#questionForm').trigger("reset");
      $('#questionForm').attr('action', "{{ route('testbank.store') }}");
      $('#questionForm input[name="_method"]').remove();
      $('#questionModal .modal-title').text('Add Question');
    });
  });
</script>

@endsection
