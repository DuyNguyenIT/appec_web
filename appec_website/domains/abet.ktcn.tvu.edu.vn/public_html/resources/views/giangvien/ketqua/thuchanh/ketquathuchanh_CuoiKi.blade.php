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
                            {{ __('Practice') }}<noscript></noscript>
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
                            <li class="breadcrumb-item active">{{ __('Practice') }}</li>
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

                                    <button class="btn btn-primary" data-toggle="modal" data-target="#moichambc">
                                        Mời chấm báo cáo
                                    </button>
                                    <!-- Modal mời chấm báo cáo -->
                                    <div class="modal fade" id="moichambc" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form
                                                action="{{ asset('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/moi-cham-thuc-hanh') }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Mời chấm báo cáo</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for=""> Chọn giảng viên:</label>
                                                            <select name="maGV_2" id="" class="form-control select2" style="width:100%">
                                                                <option value="00000">Chọn riêng giảng viên chấm cho đề tài
                                                                </option>
                                                                @foreach ($gv as $x)
                                                                    <option value="{{ $x->maGV }}">{{ $x->hoGV }}
                                                                        {{ $x->tenGV }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Modal thêm 1-->
                                    <div class="modal fade" id="addOne" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form
                                                action="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/them-mot-phieu-cham') }}"
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
                                                            <select name="dssv[]" id="" class="form-control select2" style="width:100%" multiple>
                                                                @foreach ($dssv as $sv)
                                                                    <option value="{{ $sv->maSSV }}">
                                                                        {{ $sv->maSSV }}-- {{ $sv->HoSV }}
                                                                        {{ $sv->TenSV }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if ($gv2->maGV == '00000')
                                                            <div class="form-group">
                                                                <label for=""> Chọn giảng viên:</label>
                                                                <select name="maGV_2" id="" class="form-control select2" style="width:100%">
                                                                    @foreach ($gv as $x)
                                                                        <option value="{{ $x->maGV }}">
                                                                            {{ $x->hoGV }} {{ $x->tenGV }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ __('Cancel') }}</button>
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
                                                action="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/them-nhieu-phieu-cham') }}"
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
                                                            <input type="hidden" name="Dssvtam[]" value="{{$data->maSSV}}">

                                                            
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
                                    <a href="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/xuat-bang-diem-thuc-hanh/'.Session::get('maCTBaiQH')) }}" class="btn btn-success">
                                        <i class="fas fa-download"></i> <i class="fas fa-file-excel"></i>
                                    </a>
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.session::get('maHocPhan').'/'.session::get('maBaiQH').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop')) }}" 
                                        class="btn btn-success">
                                           <i class="fas fa-arrow-left"></i>
                                     </a>
                                </div>
                            </div>
                            <div class="card-body">
                                Cán bộ chấm 2: {{ $gv2->hoGV }} {{ $gv2->tenGV }}
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>{{ __('Student ID') }}</th>                                           
                                            <th>{{ __('Student name') }}</th>
                                            <th>{{ __('Exame ID') }}</th>
                                            <th>{{ __('Mark') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Mark of granding officer') }} 2</th>
                                            <th>{{ __('Option') }}</th>
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
                                                        <span class="badge bg-success">{{ __('Granded') }}</span>
                                                    @else
                                                        <span class="badge bg-warning">{{ __('Waiting') }}</span>
                                                    @endif
                                                </td>

                                                <td>{{ $data->diemCB2 }}</td>
                                               
                                                <td>
                                                    @if ($data->trangThai == true)
                                                    <a href="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/xem-ket-qua-danh-gia-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                        class="btn btn-primary">{{ __('Viewing') }} {{ __('Result') }}</a>

                                                        <a href="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/sua-diem-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                            
                                                @else
                                                <a href="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/sua-diem-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                    class="btn btn-primary">{{ __('Granding') }}</a>
                                                    <a href="{{ asset('/giang-vien/ket-qua-danh-gia/xoa-phieu-cham/' . $data->maDe . '/' . $data->maSSV) }}" 
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
