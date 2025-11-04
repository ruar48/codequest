@extends('layouts.app')

@section('title', 'Test Bank Questions')

@section('content')

<style>
/* --- Dashboard-Themed Styling --- */
body, .content-wrapper {
  background: linear-gradient(135deg, #0a0f24, #1c223a);
  color: #fff;
  font-family: 'Poppins', sans-serif;
}

/* Adjust spacing to match Admin/Player layout */
.content {
  padding-top: 40px !important;
  padding-bottom: 40px;
}

/* Header Section */
.content-header {
  padding-top: 10px;
  padding-bottom: 0;
  margin-bottom: 0;
  text-align: center;
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
  margin-bottom: 2px;
}

/* Button Styling */
.btn-warning, .btn-primary {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
  font-weight: 600;
  border: none;
  box-shadow: 0 0 8px rgba(250, 204, 21, 0.4);
  transition: 0.3s;
}
.btn-warning:hover, .btn-primary:hover {
  box-shadow: 0 0 15px rgba(250, 204, 21, 0.8);
  transform: translateY(-2px);
}

/* Card Design */
.card {
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(250, 204, 21, 0.25);
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(250, 204, 21, 0.25);
  margin-top: 8px !important;
  transition: 0.3s;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
}

/* Card Header */
.card-header {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
  font-weight: 700;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
}

/* Table */
.table-dark {
  background: transparent;
}
.table thead th {
  background-color: #facc15;
  color: #000;
  font-weight: 600;
}
.table tbody tr:hover {
  background: rgba(250, 204, 21, 0.1);
  transition: 0.3s;
}

/* Modal Styling */
.modal-content {
  background: #1c223a;
  color: #fff;
  border: 1px solid rgba(250, 204, 21, 0.4);
  border-radius: 12px;
}
.modal-header {
  background: linear-gradient(90deg, #facc15, #ffea80);
  color: #1c1c1c;
}
.modal-footer button {
  font-weight: 600;
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

/* Level Badge Colors */
.badge-success { background-color: #27ae60; }
.badge-warning { background-color: #f1c40f; color: #000; }
.badge-danger { background-color: #e74c3c; }
</style>

<div class="content-header">
  <h1>TEST BANK QUESTIONS</h1>
  <p>Manage and organize your CodeQuest test questions</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Question Button -->
    <div class="d-flex justify-content-end mb-2">
      <button type="button" class="btn btn-warning text-dark fw-semibold px-3 py-1" data-toggle="modal" data-target="#questionModal">
        <i class="fas fa-plus me-1"></i> Add Question
      </button>
    </div>

    <!-- Test Bank Table -->
    <div class="card">
      <div class="card-header">
        <i class="fas fa-list me-2"></i> List of Questions
      </div>
      <div class="card-body">
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

<!-- Add Question Modal -->
<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-light border border-warning rounded-3">
      <div class="modal-header bg-warning text-dark py-2">
        <h5 class="modal-title fw-bold mb-0" id="questionModalLabel">Add Question</h5>
        <button type="button" class="btn-close" data-dismiss="modal"></button>
      </div>
      <form id="questionForm">
        @csrf
        <div class="modal-body py-3">
          <div class="form-group mb-2">
            <label for="question" class="fw-bold text-warning">Question</label>
            <textarea class="form-control bg-dark text-light border-warning" id="question" name="question" required></textarea>
          </div>
          <div class="form-group mb-2">
            <label for="output" class="fw-bold text-warning">Expected Output</label>
            <textarea class="form-control bg-dark text-light border-warning" id="output" name="output" required></textarea>
          </div>
          <div class="form-group mb-2">
            <label for="level" class="fw-bold text-warning">Level</label>
            <select class="form-control bg-dark text-light border-warning" id="level" name="level" required>
              <option value="easy">Easy</option>
              <option value="intermediate">Intermediate</option>
              <option value="hard">Hard</option>
            </select>
          </div>
          <div class="form-group mb-2">
            <label for="tips" class="fw-bold text-warning">Tips</label>
            <textarea class="form-control bg-dark text-light border-warning" id="tips" name="tips"></textarea>
          </div>
        </div>
        <div class="modal-footer border-0 py-2">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-warning text-dark fw-bold btn-sm" id="saveQuestion">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Keep your existing JavaScript logic -->
{!! JsValidator::formRequest('App\\Http\\Requests\\QuestionRequest') !!}
<script>
$(document).ready(function () {
    $('#questionTable').DataTable({
        responsive: true,
        autoWidth: false,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
});
</script>

@endsection
