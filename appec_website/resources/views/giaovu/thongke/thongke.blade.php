@extends('giaovu.master')
@section('content')
    <div class="content-wrapper" style="min-height: 155px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Thống kê<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Thống kê</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <div class="form-group">
                                        <label for="hocphan">Chọn ngành</label>
                                        <!-- Button trigger modal -->
                                        <select id="nganh" class="form-control custom-select">
                                            <option disabled="">--Chọn ngành--</option>
                                            <option value="1" selected="">Công nghệ thông tin</option>
                                            <option value="2">Cơ khí</option>
                                            <option value="1">Điện tử - tự động hóa</option>
                                            <option value="1">Xây dựng</option>
                                        </select>
                                    </div>
                                    <div class="from-group">
                                        <label for="">Chọn học kì</label>
                                        <select name="" id="" class="form-control custom-select">
                                            <option value="">Học kì 1</option>
                                            <option value="">Học kì 2</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nhập năm học:</label>
                                        <input type="text" class="form-control" placeholder="VD: 2018-2019">
                                    </div>
                                    <button class="btn btn-success">
                                        <i class="fas fa-filter"></i> Lọc
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6"></div>
                                        <div class="col-sm-12 col-md-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="example2"
                                                class="table table-bordered table-hover dataTable no-footer dtr-inline"
                                                role="grid" aria-describedby="example2_info">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Năm học</th>
                                                        <th>Học kì</th>
                                                        <th>Tên học phần</th>
                                                        <th>Mã lớp</th>
                                                        <th>Giảng viên hướng dẫn</th>
                                                        <th>Tùy chọn</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                        
                                                    @endphp
                                                    @foreach ($giangday as $gd)
                                                        @php
                                                            $dem = 0;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $gd->namHoc }}</td>
                                                            <td>{{ $gd->maHK }}</td>
                                                            <td>{{ $gd->tenHocPhan }}</td>
                                                            <td>{{ $gd->maLop }}</td>
                                                            <td>
                                                                @foreach ($gd->GV as $gv)
                                                                    @php
                                                                        $dem++;
                                                                        $maGV = $gv->maGV;
                                                                    @endphp
                                                                    <li>{{ $gv->hoGV }} {{ $gv->tenGV }}</li>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @if ($dem > 1)
                                                                    <a
                                                                        href="{{ asset('/giao-vu/thong-ke/thong-ke-theo-hoc-phan/00000/' . $gd->maHocPhan . '/' . $gd->maHK . '/' . $gd->namHoc . '/' . $gd->maLop) }}">
                                                                        <button class="btn btn-primary">
                                                                            <i class="fas fa-chart-line"></i>Thống kê
                                                                        </button>
                                                                    </a>
                                                                @else
                                                                    <a
                                                                        href="{{ asset('/giao-vu/thong-ke/thong-ke-theo-hoc-phan/' . $maGV . '/' . $gd->maHocPhan . '/' . $gd->maHK . '/' . $gd->namHoc . '/' . $gd->maLop) }}">
                                                                        <button class="btn btn-primary">
                                                                            <i class="fas fa-chart-line"></i>Thống kê
                                                                        </button>
                                                                    </a>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                </tfoot>
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
@endsection
