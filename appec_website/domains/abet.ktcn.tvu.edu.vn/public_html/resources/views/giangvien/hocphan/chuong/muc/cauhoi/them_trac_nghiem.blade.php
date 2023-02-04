@extends('giangvien.master')
@section('content')
    <div class="content-wrapper" style="min-height: 96px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            Câu hỏi trắc nghiệm<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item">
                                Tên học phần
                            </li>
                            <li class="breadcrumb-item ">
                                Tên chương
                            </li>
                            <li class="breadcrumb-item"><a href="#">
                                    Tên mục
                            </li>
                            <li class="breadcrumb-item active">Câu hỏi trắc nghiệm</li>
                            <li class="breadcrumb-item active">Thêm CH trắc nghiệm</li>

                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h1></h1>
                                </div>
                                <div class="card-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
