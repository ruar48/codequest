@extends('layouts.app')

@section('title', 'User Progress Report')

@section('content')

<style>
/* === Maroon & White Dashboard Theme === */
html, body, .wrapper, .content-wrapper {
  background: #ffffff !important;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

/* Header */
.content-header {
  text-align: center;
  padding: 25px 0 10px 0;
}
.content-header h1 {
  color: #7b2d2d;
  font-weight: 700;
  font-size: 2rem;
}
.content-header p {
  color: #555;
  margin-bottom: 0;
  font-size: 1rem;
}

/* Card Styling */
.card {
  background: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.2);
  border-radius: 16px;
  box-shadow: none;
  transition: all 0.3s ease;
  padding: 15px;
}
.card:hover {
  transform: translateY(-3px);
}
.card-header {
  background: linear-gradient(90deg, #7b2d2d, #a43e3e);
  color: #fff;
  font-weight: 600;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  padding: 14px 20px;
  margin: -15px -15px 15px -15px;
}
.card-body {
  background: #ffffff;
}

/* Table Container */
.table-responsive {
  border-radius: 12px;
  padding: 10px 20px;
}

/* Table Styling */
.table {
  background: #fff;
  color: #333;
  text-align: center;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 0;
}
.table thead th {
  background-color: #7b2d2d;
  color: #fff;
  font-weight: 600;
  text-align: center;
  padding: 12px;
}
.table tbody td {
  vertical-align: middle;
  padding: 10px;
}
.table tbody tr:hover {
  background: rgba(123, 45, 45, 0.05);
  transition: 0.3s ease;
}

/* Badges */
.badge-success {
  background-color: #2ecc71 !important;
  color: #fff !important;
}
.badge-danger {
  background-color: #e74c3c !important;
  color: #fff !important;
}

/* DataTables Controls */
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
  background-color: #ffffff;
  border: 1px solid rgba(123, 45, 45, 0.4);
  color: #333;
  border-radius: 6px;
  padding: 6px 10px;
}
.dataTables_wrapper .dataTables_info {
  color: #333;
  margin-top: 15px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background: transparent;
  border: 1px solid #7b2d2d;
  color: #7b2d2d !important;
  border-radius: 20px;
  padding: 4px 10px;
  margin: 0 3px;
  transition: all 0.2s ease;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: #7b2d2d !important;
  color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #7b2d2d !important;
  color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
  color: rgba(123, 45, 45, 0.4) !important;
  border-color: rgba(123, 45, 45, 0.2);
}

/* Responsive Fixes */
@media (max-width: 768px) {
  .card { padding: 10px; }
  .table-responsive { padding: 5px; }
}
</style>

<div class="content-header">
  <div class="container-fluid">
    <h1>User Progress Report</h1>
    <p>Detailed overview of user test performance</p>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Optional: Stat Boxes (Total Users, Avg Points, Avg Stars) -->
    <div class="row justify-content-center mb-4">
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card text-center">
          <div class="card-body">
            <h3>{{ $totalUsers }}</h3>
            <p>Total Users</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card text-center">
          <div class="card-body">
            <h3>{{ number_format($averagePoints, 2) }}</h3>
            <p>Avg Points</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card text-center">
          <div class="card-body">
            <h3>{{ number_format($averageStars, 2) }}</h3>
            <p>Avg Stars</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Table -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title mb-0">Test Performance Overview</h3>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover" id="progressTable">
          <thead>
            <tr>
              <th>User Email</th>
              <th>Full Name</th>
              <th>Question</th>
              <th>Answer</th>
              <th>Correct</th>
              <th>Points Earned</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($testPerformances as $entry)
            <tr>
              <td>{{ $entry->user->email ?? 'N/A' }}</td>
              <td>{{ $entry->user->full_name ?? 'N/A' }}</td>
              <td>{{ $entry->question->question ?? 'N/A' }}</td>
              <td><code>{{ Str::limit($entry->answer, 50) }}</code></td>
              <td>
                <span class="badge {{ $entry->is_correct ? 'badge-success' : 'badge-danger' }}">
                  {{ $entry->is_correct ? '✅ Correct' : '❌ Incorrect' }}
                </span>
              </td>
              <td><span class="badge badge-success">{{ $entry->points }} pts</span></td>
              <td>{{ $entry->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>

<!-- DataTables Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
  $('#progressTable').DataTable({
    responsive: true,
    autoWidth: false,
    pagingType: "full_numbers",
    language: {
      info: "Showing _START_ to _END_ of _TOTAL_ entries",
      paginate: { previous: "Previous", next: "Next", first: "First", last: "Last" },
      search: "Search Users:"
    }
  });
});
</script>

@endsection
