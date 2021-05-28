<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('Administration') }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- flag-icon-css -->
    <link rel="stylesheet" href="{{ asset('/plugins/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
    <!-- iCheck -->
    <link rel="stylesheet"
        href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.cssplugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ asset('quan-ly') }}" class="nav-link">{{ __('Home') }}</a>
                </li>
            </ul>
            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search" />
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Language Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        @if (Session::has('language') && Session::get('language') == 'vi')
                            <i class="flag-icon flag-icon-vn"></i>
                        @else
                            <i class="flag-icon flag-icon-us"></i>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-0">
                        @if (Session::has('language') && Session::get('language') == 'vi')
                            <a href="{{ asset('/language/en') }}" class="dropdown-item ">
                                <i class="flag-icon flag-icon-us mr-2"></i> {{ __('English') }}
                            </a>
                            <a href="{{ asset('/language/vi') }}" class="dropdown-item active">
                                <i class="flag-icon flag-icon-vn mr-2"></i> {{ __('Vietnamese') }}
                            </a>
                        @else
                            <a href="{{ asset('/language/en') }}" class="dropdown-item active">
                                <i class="flag-icon flag-icon-us mr-2"></i> {{ __('English') }}
                            </a>
                            <a href="{{ asset('/language/vi') }}" class="dropdown-item">
                                <i class="flag-icon flag-icon-vn mr-2"></i> {{ __('Vietnamese') }}
                            </a>
                        @endif
                    </div>
                </li>
                <!-- Messages Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="{{ asset('/dang-xuat') }}" role="button">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ asset('quan-ly') }}" class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: 0.8" />
                <span class="brand-text font-weight-light">{{ __('Administration') }}</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('dist/img/avatar5.png') }}" class="img-circle elevation-2"
                            alt="User Image" />
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ __('Administrator') }}</a>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search"
                            placeholder="{{ __('Search') }}...." aria-label="Search" />
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>{{ __('Dashboard') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/bac-dao-tao') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Education level') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/nganh-hoc') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Majors') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/chuyen-nganh') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Specialized') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/he') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Forms of training') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/chuong-trinh-dao-tao') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Curriculum') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/chuan-dau-ra') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Student Outcomes') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/chuan-dau-ra2-abet') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>CLOs level2 <->ABET's SOs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/chuan-dau-ra3-abet') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>CLOs level 3 <->ABET's SOs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/loai-hoc-phan') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Course type') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/hoc-phan') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Courses') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/khoi-kien-thuc') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Knowledge block') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/phuong-phap-giang-day') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>{{ __('Teaching methods') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/tai-khoan') }}" class="nav-link">
                                <i class="nav-icon  fas fa-users-cog"></i>
                                <p>{{ __('Accounts') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/quan-ly/thong-ke') }}" class="nav-link">
                                <i class="nav-icon  fas fa-chart-bar"></i>
                                <p>{{ __('Statistics') }} </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        @include('sweet::alert')
        @yield('content')
        <footer class="main-footer">
            <strong>Copyright &copy; 2020-2021
                <a href="https://adminlte.io"> CAP</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script>
        $.widget.bridge("uibutton", $.ui.button);

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
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });

    </script>
</body>

</html>
