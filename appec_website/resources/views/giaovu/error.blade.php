@extends('giaovu.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chức năng đang được cập nhật</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giao-vu') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">404 Error Page</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-warning"> 404</h2>
                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! không tìm thấy trang</h3>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>
@endsection
