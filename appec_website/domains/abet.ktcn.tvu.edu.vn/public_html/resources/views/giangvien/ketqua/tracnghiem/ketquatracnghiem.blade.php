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
                            {{ __('Multiple Choice Exam') }}<noscript></noscript>
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
                                <a href="{{ asset('giang-vien/ket-qua-danh-gia') }}">
                                    @if (session::has('language') && session::get('language')=='en')
                                    {{ $hp->tenHocPhanEN }}
                                    @else
                                    {{ $hp->tenHocPhan }}
                                    @endif
                                    
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/' . Session::get('maHocPhan') . '/' . Session::get('maBaiQH') . '/' . Session::get('maHK') . '/' . Session::get('namHoc') . '/' . Session::get('maLop')) }}">
                                    {{ __('Result') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Multiple Choice Exam') }}</li>
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
                                                action="{{ asset('/giang-vien/ket-qua-danh-gia/trac-nghiem/them-mot-phieu-cham') }}"
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
                                                action="{{ asset('/giang-vien/ket-qua-danh-gia/trac-nghiem/them-nhieu-phieu-cham') }}"
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
                                                            @foreach ($phieucham as $data)                                                           
                                                            <input type="hidden" name="maDetam[]" value="{{$data->maDe}}">
                                                          @endforeach
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
                                    <a href="{{ asset('/giang-vien/ket-qua-danh-gia/trac-nghiem/xuat-bang-diem-trac-nghiem/'.Session::get('maCTBaiQH')) }}" class="btn btn-success">
                                        <i class="fas fa-download"></i> <i class="fas fa-file-excel"></i>
                                    </a>
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/' . Session::get('maHocPhan') . '/' . Session::get('maBaiQH') . '/' . Session::get('maHK') . '/' . Session::get('namHoc') . '/' . Session::get('maLop')) }}"
                                        class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>{{ __('Student ID') }}</th>
                                            <th>{{ __('Student Name') }}</th>
                                            <th>{{ __('Exame ID') }}</th>
                                            <th>{{ __('Mark') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($phieucham as $pc)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $pc->maSSV }}</td>
                                                <td>{{ $pc->HoSV }} {{ $pc->TenSV }}</td>
                                                <td>{{ $pc->maDeVB }}</td>
                                                <td>
                                                    @if ($pc->diemSo != 0)
                                                        {{ $pc->diemSo }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($pc->trangThai == true)
                                                        <span class="badge bg-success">{{ __('Granded') }}</span>
                                                    @else
                                                        <span class="badge bg-warning">{{ __('Waiting') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($pc->trangThai == true)
                                                        <a href="{{ asset('/giang-vien/ket-qua-danh-gia/trac-nghiem/xem-ket-qua-danh-gia-trac-nghiem/' . $pc->maDe . '/' . $pc->maSSV) }}"
                                                            class="btn btn-primary"><i class="fas fa-eye"></i> {{ __('Viewing') }} {{ __('Result') }}</a>
                                                            <a href="{{ asset('/giang-vien/ket-qua-danh-gia/trac-nghiem/sua-ket-qua-danh-gia-trac-nghiem/' . $pc->maDe . '/' . $pc->maSSV) }}"
                                                                class="btn btn-primary"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                                                    @else
                                                        <a href="{{ asset('/giang-vien/ket-qua-danh-gia/trac-nghiem/nhap-diem-trac-nghiem/' . $pc->maDe . '/' . $pc->maSSV) }}"
                                                            class="btn btn-primary">{{ __('Granding') }}</a>
                                                            <a href="{{ asset('/giang-vien/ket-qua-danh-gia/xoa-phieu-cham/' . $pc->maDe . '/' . $pc->maSSV) }}" 
                                                                class="btn btn-danger" onclick="return confirm('Confirm?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
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
