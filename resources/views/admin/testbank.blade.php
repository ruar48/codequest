@extends('layouts.app')

@section('title', 'Test Bank Questions')

@section('content')

<style>
/* === GLOBAL THEME (Maroon + White Dashboard Look) === */
body, .content-wrapper {
  background-color: #ffffff;
  font-family: 'Poppins', sans-serif;
  color: #3b3b3b;
}

/* === HEADER === */
.content-header {
  text-align: center;
  padding-top: 20px;
  margin-bottom: 15px;
}
.content-header h1 {
  font-weight: 700;
  color: #7a1f1f; /* Maroon */
  font-size: 1.8rem;
}
.content-header p {
  color: #666;
  font-size: 0.95rem;
  margin-bottom: 0;
}

/* === BUTTONS === */
.btn-primary {
  background-color: #7a1f1f;
  color: #fff;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  transition: all 0.3s ease;
}
.btn-primary:hover {
  background-color: #5e1717;
  transform: translateY(-2px);
}
.btn-outline-warning, .btn-outline-danger {
  border-radius: 8px;
}

/* === CARD STYLING === */
.card {
  background-color: #ffffff;
  border: 1px solid #e6e6e6;
  border-radius: 14px;
  box-shadow: none;
}
.card-header {
  background-color: #fafafa;
  color: #7a1f1f;
  font-weight: 600;
  border-bottom: 1px solid #e6e6e6;
  font-size: 1rem;
  padding: 10px 15px;
}

/* === TABLE DESIGN === */
.table {
  background-color: #fff;
  color: #333;
}
.table thead th {
  background-color: #7a1f1f;
  color: #fff;
  font-weight: 600;
  text-align: center;
}
.table tbody td {
  vertical-align: middle;
}
.table-hover tbody tr:hover {
  background-color: rgba(122, 31, 31, 0.08);
  transition: 0.2s;
}

/* === BADGES === */
.badge-success {
  background-color: #2ecc71;
}
.badge-warning {
  background-color: #f1c40f;
  color: #000;
}
.badge-danger {
  background-color: #e74c3c;
}

/* === MODAL === */
.modal-content {
  background-color: #fff;
  color: #333;
  border: 1px solid #ddd;
  border-radius: 12px;
}
.modal-header {
  background-color: #7a1f1f;
  color: #fff;
  border-bottom: none;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
}
.form-control, textarea, select {
  background-color: #fff;
  border: 1px solid #ccc;
  color: #333;
  border-radius: 6px;
}
.form-control:focus {
  border-color: #7a1f1f;
  box-shadow: 0 0 6px rgba(122, 31, 31, 0.3);
}

/* === DATATABLE ORGANIZER === */
.dataTables_wrapper .dataTables_filter input {
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 4px 8px;
}
.dataTables_wrapper .dataTables_length select {
  border-radius: 6px;
  border: 1px solid #ccc;
}
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
  color: #333;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  color: #7a1f1f !important;
  border: none !important;
  background: transparent !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #7a1f1f !important;
  color: #fff !important;
  border-radius: 6px;
}

/* === RESPONSIVENESS === */
@media (max-width: 768px) {
  .content-header h1 {
    font-size: 1.5rem;
  }
}
</style>

<div class="content-header">
  <h1><i class="fas fa-database me-2"></i> Test Bank Questions</h1>
  <p>Manage and organize your CodeQuest test questions efficiently</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Question Button -->
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#questionModal">
        <i class="fas fa-plus me-1"></i> Add Question
      </button>
    </div>

    <!-- Questions Table -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-layer-group me-2"></i> List of Questions</span>
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
<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="questionForm" action="{{ route('testbank.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i> Add Question</h5>
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
          <button type="submit" class="btn btn-primary">Save Question</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- DataTables + Bootstrap -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- Page Organizer Script -->
<script>
$(document).ready(function () {
    $('#questionTable').DataTable({
        responsive: true,
        autoWidth: false,
        dom: '<"row mb-3"' +
                '<"col-md-6 d-flex align-items-center"l>' +
                '<"col-md-6 d-flex justify-content-end"f>' +
             '>rtip',
        pagingType: "full_numbers",
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ questions",
            paginate: {
                previous: "Previous",
                next: "Next",
                first: "First",
                last: "Last"
            },
            search: "Search:"
        },
        pageLength: 10,
        order: [[0, 'asc']]
    });
});
</script>

@endsection
