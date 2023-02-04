@extends('giangvien.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            Quy hoạch đánh giá kết quả học tập<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ asset('#') }}">{{ $hp->tenHocPhan }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Thống kê
                            </li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('giang-vien/thong-ke') }}" class="btn btn-secondary">
                                           <i class="fas fa-arrow-left"></i>
                                     </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Hình thức đánh giá</th>
                                            <th>Tỉ lệ (%)</th>
                                            <th>Phương pháp đánh giá</th>
                                            <th>Tùy chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="2">1</td>
                                            <td rowspan="2">Đánh giá kết thúc môn</td>
                                            <td rowspan="2">100%</td>
                                            <td rowspan="2">Đồ án</td>
                                            <td>
                                                Cán bộ chấm 1 <br>
                                                <a
                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-tieu-chi-kl/1') }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-chart-line"></i>Thống kê theo tiêu chí
                                                    </button>
                                                </a>
                                                <a
                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-xep-hang-kl/1') }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-chart-line"></i>Thống kê theo xếp hạng
                                                    </button>
                                                </a>
                                                <a
                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-diem-chu-kl/1') }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-chart-line"></i>Thống kê theo điểm chữ
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Cán bộ chấm 2 <br>
                                                <a
                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-tieu-chi-kl/2') }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-chart-line"></i>Thống kê theo tiêu chí
                                                    </button>
                                                </a>
                                                <a
                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-xep-hang-kl/2') }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-chart-line"></i>Thống kê theo xếp hạng
                                                    </button>
                                                </a>
                                                <a
                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-diem-chu-kl/2') }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-chart-line"></i>Thống kê theo điểm chữ
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
