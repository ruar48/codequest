<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'My Laravel App')</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('dist/img/logo_1.png') }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* === Loader === */
    #load {
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('{{ asset('dist/img/Dual Ring-1s-200px.png') }}') 50% 50% no-repeat rgb(245,245,245);
      opacity: 0.95;
    }

    /* === Body & Content === */
    body, .content-wrapper {
      background: linear-gradient(135deg, #0a0f24, #1c223a);
      font-family: 'Poppins', sans-serif;
      color: #ffffff;
    }

    .content-wrapper {
      padding: 20px;
    }

    /* === Navbar === */
    .main-header.navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .nav-link {
      color: #ffffffff;
      transition: all 0.2s ease-in-out;
    }

    .nav-link.active, 
    .nav-link:hover {
      color: #f59e0b !important;
      background-color: rgba(255, 255, 255, 1);
      border-radius: 6px;
    }

    /* === Sidebar === */
    .main-sidebar {
      background: linear-gradient(180deg, #1f2937 0%, #0f172a 100%);
      color: #e5e7eb;
      transition: all 0.3s ease-in-out;
    }

    /* Brand Link (Top Logo Section) */
    .brand-link {
      background: linear-gradient(90deg, #111827, #1e293b);
      color: #ffffff !important; /* updated to white */
      text-shadow: 0 0 4px rgba(255,255,255,0.3); /* subtle glow */
      border-bottom: 1px solid rgba(250, 204, 21, 0.2);
    }

    /* Brand Image Slight Glow */
    .brand-link .brand-image {
      opacity: 0.9;
      filter: drop-shadow(0 0 3px rgba(250, 204, 21, 0.4));
    }

    /* Sidebar Links */
    .sidebar .nav-sidebar .nav-link {
      color: #ffffff;
      font-weight: 500;
      transition: all 0.2s ease-in-out;
    }

    .sidebar .nav-sidebar .nav-link:hover,
    .sidebar .nav-sidebar .nav-link.active {
      color: #facc15;
      background: rgba(250, 204, 21, 0.1);
      border-left: 3px solid #facc15;
      border-radius: 0 8px 8px 0;
    }

    .sidebar .nav-treeview .nav-link {
      color: #d1d5db;
      padding-left: 2.5rem;
    }

    .sidebar .nav-treeview .nav-link:hover,
    .sidebar .nav-treeview .nav-link.active {
      color: #facc15;
      background: rgba(250, 204, 21, 0.08);
      border-left: 3px solid #facc15;
      border-radius: 0 8px 8px 0;
    }

    .user-panel {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-panel .info a {
      color: #ffffff;
      font-weight: 500;
      transition: all 0.2s ease-in-out;
    }

    .user-panel .info a:hover {
      color: #facc15;
      text-decoration: none;
    }

    .user-panel .image div {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #ffffff;
      font-weight: bold;
      font-size: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* === Tables & Cards === */
    table.dataTable tbody tr:hover {
      background-color: rgba(250,204,21,0.1) !important;
    }

    .card {
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.05);
      transition: all 0.3s ease-in-out;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(250,204,21,0.15);
    }

    .card-header {
      background: #facc15;
      color: #1e293b;
      font-weight: 700;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }

    /* === Scrollbar Styling === */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #e5e7eb;
    }

    ::-webkit-scrollbar-thumb {
      background: #f59e0b;
      border-radius: 4px;
    }
  </style>
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed">
    <div id="load"></div>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('dist/img/logo_1.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8;">
      <span class="brand-text font-weight-light">CodeQuest</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <div class="img-circle elevation-2 d-flex align-items-center justify-content-center bg-primary text-white"
               style="width: 40px; height: 40px; font-weight: bold; font-size: 18px;">
              {{ strtoupper(substr(Auth::user()->full_name ?? Auth::user()->email, 0, 1)) }}
          </div>
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->full_name ?? 'Guest' }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        @yield('sidebar') <!-- You can keep sidebar links here -->
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
</div>
<!-- ./wrapper -->

<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<script type="text/javascript">
    $(window).on('load', function(){
      setTimeout(function(){
            $('#load').fadeOut('slow');
        });
    });
</script>
</body>
</html>
