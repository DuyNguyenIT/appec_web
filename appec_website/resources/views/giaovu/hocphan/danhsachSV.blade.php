@extends('giaovu.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            Danh sách sinh viên<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item">
                                Danh sach sinh vien
                            </li>
                            <li class="breadcrumb-item active">Danh sách sinh viên</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ __('Course') }}: {{ $hocphan->tenHocPhan }} {{ __('Semester') }}:
                                    {{ $maHK }}
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/giao-vu/hoc-phan-giang-day') }}" class="btn btn-secondary"><i
                                            class="fas fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <div class="card-header">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#importExcel">
                                    Import excel
                                </button>
                                <a href="{{ asset('/giao-vu/hoc-phan-giang-day/tai-file-mau') }}">Template file excel</a>
                                <!-- Modal -->
                                <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form
                                            action="{{ asset('/giao-vu/hoc-phan-giang-day/cap-nhat-ds-sinh-vien-bang-excel') }}"
                                            enctype="multipart/form-data" method="post">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Import excel</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="file" name="file" id="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã sinh viên</th>
                                            <th>Tên sinh viên</th>
                                            <th>Lớp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($dssv as $sv)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $sv->maSSV }}</td>
                                                <td>{{ $sv->sinhvien->HoSV }} {{ $sv->sinhvien->TenSV }}</td>
                                                <td>{{ $sv->sinhvien->maLop }}</td>
                                            </tr>
                                        @endforeach
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
@endsection
