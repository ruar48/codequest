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
<!-- jQuery (make sure it's included first) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">


<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">


  <style>
    #load{
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('{{ asset('dist/img/Dual Ring-1s-200px.png') }}')
    50% 50% no-repeat rgb(249,249,249);
    opacity: 1;
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
      <!-- Navbar Search -->
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
      <img src="{{ asset('dist/img/logo_1.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8; ">
      <span class="brand-text font-weight-light">CodeQuest</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/logo_1.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Test Admin</a>
        </div>
      </div>


<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard.index') }}" class="nav-link {{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <!-- Users -->
        <li class="nav-item {{ Request::routeIs('admins.index', 'educators.index', 'player.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::routeIs('admins.index', 'educators.index', 'player.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Users
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admins.index') }}" class="nav-link {{ Request::routeIs('admins.index') ? 'active' : '' }}">
                        <i class="fas fa-user-shield ml-5"></i>
                        <p>Admin</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('educators.index') }}" class="nav-link {{ Request::routeIs('educators.index') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher ml-5"></i>
                        <p>Educator</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('player.index') }}" class="nav-link {{ Request::routeIs('player.index') ? 'active' : '' }}">
                        <i class="fas fa-user ml-5"></i>
                        <p>Player</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Tips -->
        {{-- <li class="nav-item">
            <a href="{{ route('admin.tips') }}" class="nav-link {{ Request::routeIs('admin.tips') ? 'active' : '' }}">
                <i class="nav-icon fas fa-lightbulb"></i>
                <p>Tips</p>
            </a>
        </li> --}}

        <!-- Test Bank -->
        <li class="nav-item">
            <a href="{{ route('testbank.index') }}" class="nav-link">
                <i class="nav-icon fas fa-database"></i>
                <p>Test Bank</p>
            </a>
        </li>

        <!-- Leaderboard -->
        <li class="nav-item">
            <a href="{{ route('admin.leaderboard') }}" class="nav-link {{ Request::routeIs('admin.leaderboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-trophy"></i>
                <p>Leaderboard</p>
            </a>
        </li>

        <!-- PHP & SQL Logs -->
        <li class="nav-item">
            <a href="{{ route('code.logs') }}" class="nav-link {{ Request::routeIs('code.logs') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>PHP & SQL Logs</p>
            </a>
        </li>

        <!-- Reports -->
        <li class="nav-item {{ Request::routeIs('user.progress', 'analytics.report', 'user.test_progress', 'export.reports') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::routeIs('user.progress', 'analytics.report', 'user.test_progress', 'export.reports') ? 'active' : '' }}">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                    Reports
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <!-- User Progress Reports -->
                <li class="nav-item">
                    <a href="{{ route('user.progress') }}" class="nav-link {{ Request::routeIs('user.progress') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate nav-icon ml-3"></i>
                        <p>User Progress</p>
                    </a>
                </li>

                <!-- Engagement Analytics -->
                <li class="nav-item">
                    <a href="{{ route('analytics.report') }}" class="nav-link {{ Request::routeIs('analytics.report') ? 'active' : '' }}">
                        <i class="fas fa-chart-line nav-icon ml-3"></i>
                        <p>Engagement Analytics</p>
                    </a>
                </li>

                <!-- Quiz & Test Performance -->
                <li class="nav-item">
                    <a href="{{ route('user.test_progress') }}" class="nav-link {{ Request::routeIs('user.test_progress') ? 'active' : '' }}">
                        <i class="fas fa-poll nav-icon ml-3"></i>
                        <p>Quiz Performance</p>
                    </a>
                </li>

                <!-- Export Reports -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-export nav-icon ml-3"></i>
                        <p>Export Reports</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->




    @yield('content')






  </div>


</div>
<!-- ./wrapper -->
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script type="text/javascript">
    $(window).on('load', function(){
      setTimeout(function(){
            $('#load').fadeOut('slow');
        });
    });
  </script>
</body>
</html>
