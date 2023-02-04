
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sinh Viên</title>

    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- Ionicons -->
    <link
      rel="stylesheet"
      href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
    />
    <!-- Tempusdominus Bootstrap 4 -->
    <link
      rel="stylesheet"
      href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
    />
    <!-- iCheck -->
    <link
      rel="stylesheet"
      href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"
    />
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    <!-- overlayScrollbars -->
    <link
      rel="stylesheet"
      href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"
    />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" />
   <!-- DataTables -->
   <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
   <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
   <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"
              ><i class="fas fa-bars"></i
            ></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ asset('sinh-vien/') }}" class="nav-link">Home</a>
          </li>
          {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
          </li> --}}
        </ul>
        

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input
              class="form-control form-control-navbar"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item">
            <a
              class="nav-link"
              data-widget="fullscreen"
              href="{{ asset('/dang-xuat') }}"
              role="button"
            >
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.html" class="brand-link">
          <img
            src="{{ asset('dist/img/AdminLTELogo.png') }}"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: 0.8"
          />
          <span class="brand-text font-weight-light">Sinh Viên</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img
                src="{{ asset('dist/img/avatar3.png') }}"
                class="img-circle elevation-2"
                alt="User Image"
              />
            </div>
            <div class="info">
              <a href="#" class="d-block">{{Session::get('HoSV')}} {{Session::get('TenSV')}}</a>
            </div>
          </div>

          <!-- SidebarSearch Form -->
          {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input
                class="form-control form-control-sidebar"
                type="search"
                placeholder="Tìm kiếm...."
                aria-label="Search"
              />
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div> --}}

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul
              class="nav nav-pills nav-sidebar flex-column"
              data-widget="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item" >
                <a href="{{ asset('/sinh-vien') }}" class="nav-link" >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p >Bảng thông tin tổng hợp</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{ asset('/sinh-vien/hoc-phan') }}"  class="nav-link">
                  <i class="nav-icon fas fa-book-reader"></i>
                  <p>Môn học</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ asset('/sinh-vien/khao-sat-ctdt') }}"  class="nav-link">
                  <i class="nav-icon fas fa-book-reader"></i>
                  <p>CTĐT</p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{{ asset('/sinh-vien') }}"  class="nav-link">
                  <i class="fa fa-sticky-note"></i>
                 <p>Khảo sát CTĐT</p> 
                </a>
                <ul style="display: block;">
                  <li class="nav-item">
                    <a href="{{ asset('/sinh-vien/khao-sat-cdr3_ctdt') }}"  class="nav-link">
                      <i class="nav-icon fas fa-book-reader"></i>
                     <p>Khảo sát CDR3</p> 
                    </a>
                  </li>
                  <li > 
                    <a href="{{ asset('/sinh-vien/khao-sat-ctdt') }}"  class="nav-link">
                      <i class="nav-icon fas fa-book-reader"></i>
                     <p>Khảo sát Chuan Abet</p> 
                    </a>
                  </li>
                 
                </ul>
              </li> --}}
              
          
               
            

            {{--  <li class="nav-item">
                <a
                  href="#"
                  class="nav-link"
                >
                  <i class="nav-icon fas fa-gavel"></i>

                  <p>Assessment Planing</p>
                </a>
              </li> --}}

               {{-- <li class="nav-item">
                <a href="{{ asset('/sinh-vien/mon-hoc') }}" class="nav-link">
                  <i class="nav-icon fas fa-store-alt"></i>
                  <p>Môn Học</p>
                </a>
              </li>  --}}
              
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-user-friends"></i>
                  <p>Assessment Result</p>
                </a>
              </li> 

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-balance-scale-left"></i>
                  <p>Thống kê</p>
                </a>
              </li>--}}
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      @include('sweet::alert')
      @yield('content')

      <footer class="main-footer">
        <strong
          >Copyright &copy; 2021
          <a href=""> Hệ thống khảo sát chuẩn đầu ra</a
          >.</strong
        >
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

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
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
     $(function () {
      $("#example2").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
      
    });
    </script>
    <style>
  table {
        border-collapse: collapse;
        display: block;
        width: 100%;

    }
    thead, tbody {
        display: block;      
        width: 100%; 
    }
    tbody {
        overflow-y: scroll;
        overflow-x: hidden;
        height: 400px;
        width: 100%;
        
    }
     th, td {
        height: 10px;
        width: 100%; 
    } 
    /*
    .td-center{
      text-align: center;
    }
     .tr{
      width: 12%;
    }
    .sorting_1{
      width: 11%;
    }
    
   .th{
    
    width: 23%;
  }
    .sorting_2{
    
      width: 22%;
    }
      .tr-hp{
      width: 23%; 
    } */
    /* td:nth-child(9){
        min-width: 60px;
    }
    td:nth-child(8){
        min-width: 60px;
    }
    td:nth-child(7){
        min-width: 60px;
    }
    td:nth-child(6){
        min-width: 60px;
    }
    td:nth-child(5){
        min-width: 60px;
    }
    td:nth-child(4){
        min-width: 60px;
    }
   td:nth-child(3){
        min-width: 300px;
    }
    td:nth-child(2){
        min-width: 70px;
    }
    td:nth-child(1){
        min-width: 50px;
    } */
    /* a .btn-outline-secondary:visited{
      display: none;
    } */
  </style>
  
  </body>
</html>
