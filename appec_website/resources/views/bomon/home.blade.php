@extends('bomon.master')
@section('content')
     <!-- Content Wrapper. Contains page content -->
     <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Dashboard') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- ------------cột 1--------------------- -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-info">
                            <div class="inner">
                                <h5>Giảng viên</h5>

                                <p>32</p>
                            </div>
                            <div class="icon">
                                <i class="icon ion-document"></i>
                            </div>
                            <a href="{{ asset('quan-ly/bac-dao-tao') }}" class="small-box-footer">{{ __('Details') }} <i
                                    class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ---------------------------------------->
                    <!-- ----------------cột 2------------------ -->
                    <div class="col-lg-2 col-6">
                        <div class="small-box bg-gradient-success">
                            <div class="inner">
                                <h5>Lớp</h5>

                                <p>20</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                            <a href="{{ asset('quan-ly/nganh-hoc') }}" class="small-box-footer">{{ __('Details') }} <i
                                    class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!------------------------------------------- -->
                    
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <!-- /.card -->
        </section>
        <!-- /.content -->

     </div>
@endsection