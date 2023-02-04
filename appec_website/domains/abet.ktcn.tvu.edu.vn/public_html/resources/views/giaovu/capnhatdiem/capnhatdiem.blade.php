@extends('giaovu.master')
@section('content')
    <div class="content-wrapper" style="min-height: 155px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Cập nhật điểm kết thúc môn<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Cập nhật điểm kết thúc môn</li>
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
                                                    <tr role="row">
                                                        <th>{{ __('No.') }}</th>
                                                        <th>{{ __('Academic year') }}</th>
                                                        <th>{{ __('Option') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($giangday as $gd)
                                                        <tr>
                                                            <td >{{ $i++ }}</td>
                                                            <td>{{ $gd->namHoc }}</td>
                                                            
                                                            <td>
                                                                <a href="{{ asset('/giao-vu/cap-nhat-diem-ket-thuc/hoc-phan/'.$gd->namHoc.'/HK1') }}" class="btn btn-success">
                                                                    {{ __('First semester') }}
                                                                </a>
                                                                <a href="{{ asset('/giao-vu/cap-nhat-diem-ket-thuc/hoc-phan/'.$gd->namHoc.'/HK2') }}" class="btn btn-success">
                                                                    {{ __('Second semester') }}
                                                                </a>
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
