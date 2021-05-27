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
                            Thực hành<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ asset('giang-vien') }}">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ asset('giang-vien/ket-qua-danh-gia') }}">{{ $hp->tenHocPhan }}</a>
                            </li>
                            <li class="breadcrumb-item active">Thực hành</li>
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
                                <h4 class="card-title">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOne">
                                        Chọn đề cho từng sinh viên
                                    </button>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        Chọn đề cho cả lớp
                                    </button>
                                    <!-- Modal thêm 1-->
                                    <div class="modal fade" id="addOne" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form
                                                action="{{ asset('/giang-vien/ket-qua-danh-gia/tu-luan/them-mot-phieu-cham') }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Adding a new
                                                            Assessment Rubrics</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">Chọn đề thi</label>
                                                            <select name="maDe" id="" class="form-control">
                                                                @foreach ($deThi as $dt)
                                                                    <option value="{{ $dt->maDe }}">{{ $dt->maDeVB }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Chọn sinh viên</label>
                                                            <select name="dssv[]" id="" class="form-control" multiple>
                                                                @foreach ($dssv as $sv)
                                                                    <option value="{{ $sv->maSSV }}">
                                                                        {{ $sv->maSSV }}-- {{ $sv->HoSV }}
                                                                        {{ $sv->TenSV }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Modal thêm nhiều-->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form
                                                action="{{ asset('/giang-vien/ket-qua-danh-gia/tu-luan/them-nhieu-phieu-cham') }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Thêm 1 đề thi cho cả
                                                            lớp</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">Chọn đề thi</label>
                                                            <select name="maDe" id="" class="form-control">
                                                                @foreach ($deThi as $dt)
                                                                    <option value="{{ $dt->maDe }}">
                                                                        {{ $dt->maDeVB }}</option>
                                                                @endforeach
                                                            </select>
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
                                </h4>
                                <div class="card-tools">
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.session::get('maHocPhan').'/'.session::get('maBaiQH').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop')) }}" class="btn btn-secondary">
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
                                            <th>Mã sinh viên</th>
                                            <th>Sinh viên thực hiện</th>
                                            <th>Mã đề</th>
                                            <th>Điểm đánh giá</th>
                                            <th>Trạng thái</th>
                                            <th>Tùy chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($phieucham as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data->maSSV }}</td>
                                                <td>{{ $data->HoSV }} {{ $data->TenSV }}</td>
                                                <td>{{ $data->maDeVB }}</td>
                                                <td>{{ $data->diemSo }}</td>
                                                <td>
                                                    @if ($data->trangThai == true)
                                                        <span class="badge bg-success">Đã chấm</span>
                                                    @else
                                                        <span class="badge bg-warning">Chờ chấm</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->trangThai == true)
                                                        <a href="{{ asset('/giang-vien/ket-qua-danh-gia/tu-luan/xem-ket-qua-danh-gia-tu-luan/' . $data->maDe . '/' . $data->maSSV) }}"
                                                            class="btn btn-primary">Xem KQ</a>
                                                    @else
                                                        <a href="{{ asset('/giang-vien/ket-qua-danh-gia/tu-luan/nhap-diem-tu-luan/' . $data->maDe . '/' . $data->maSSV) }}"
                                                            class="btn btn-primary">Chấm</a>
                                                    @endif
                                                </td>
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
    </div>

@endsection
