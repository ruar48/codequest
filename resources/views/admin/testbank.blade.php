@extends('layouts.app')

@section('title', 'Test Bank Questions')

@section('content')

<style>
/* === Match Dashboard Style === */
body, .content-wrapper {
  background-color: #ffffff !important;
  color: #333;
  font-family: 'Poppins', sans-serif;
}

/* Header */
.content-header {
  text-align: center;
  padding-top: 15px;
  padding-bottom: 0;
  margin-bottom: 15px;
}
.content-header h1 {
  font-weight: 700;
  color: #6b0f1a;
  font-size: 1.8rem;
}
.content-header p {
  color: #6b6b6b;
  font-size: 0.95rem;
  margin-bottom: 0;
}

/* Add Question Button */
.btn-primary {
  background-color: #6b0f1a;
  color: #fff;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  transition: all 0.3s ease;
}
.btn-primary:hover {
  background-color: #8b1d26;
  transform: translateY(-2px);
}

/* Card Styling */
.card {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 12px;
  box-shadow: none;
  margin-top: 8px;
}
.card-header {
  background: #fff;
  border-bottom: 2px solid #6b0f1a;
  color: #6b0f1a;
  font-weight: 700;
  font-size: 1.1rem;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
  padding: 12px 15px;
}

/* Table */
.table {
  background-color: #ffffff;
  color: #333;
  border-radius: 8px;
  overflow: hidden;
}
.table thead th {
  background-color: #6b0f1a;
  color: #fff;
  font-weight: 600;
  border: none;
}
.table tbody tr:hover {
  background-color: rgba(107, 15, 26, 0.05);
  transition: 0.3s;
}
.badge-success { background-color: #27ae60; }
.badge-warning { background-color: #f1c40f; color: #1c1c1c; }
.badge-danger  { background-color: #e74c3c; }

/* Action Buttons */
.btn-outline-warning {
  color: #d97706;
  border: 1px solid #d97706;
}
.btn-outline-warning:hover {
  background-color: #d97706;
  color: white;
}
.btn-outline-danger {
  color: #b91c1c;
  border: 1px solid #b91c1c;
}
.btn-outline-danger:hover {
  background-color: #b91c1c;
  color: white;
}

/* Modal */
.modal-content {
  background-color: #fff;
  color: #333;
  border-radius: 12px;
  border: 1px solid #ddd;
}
.modal-header {
  background-color: #6b0f1a;
  color: #fff;
  border-bottom: none;
}
.form-control, textarea, select {
  background-color: #fff;
  color: #333;
  border: 1px solid #ccc;
}
.form-control:focus {
  border-color: #6b0f1a;
  box-shadow: 0 0 5px rgba(107, 15, 26, 0.4);
}
</style>

<div class="content-header">
  <h1>Test Bank</h1>
  <p>Manage and organize your CodeQuest test questions efficiently</p>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Add Question Button -->
    <div class="d-flex justify-content-end mb-2">
      <button type="button" class="btn btn-primary fw-semibold px-3 py-1" 
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
          <table id="questionTable" class="table table-hover align-middle mb-0 rounded">
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
          <button type="submit" class="btn btn-primary">Save Question</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
