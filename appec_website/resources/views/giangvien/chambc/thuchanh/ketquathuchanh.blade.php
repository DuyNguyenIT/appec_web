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
                                <a href="{{ asset('#') }}">Nội dung đánh giá</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ asset('#') }}">Nhập điểm đánh giá</a>
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
                                <h4 class="card-title">
                                    
                                </h4>
                                <div class="card-tools">
                                    {{-- <a href="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/xuat-bang-diem-thuc-hanh/'.Session::get('maCTBaiQH')) }}" class="btn btn-success">
                                        <i class="fas fa-download"></i> <i class="fas fa-file-excel"></i>
                                    </a> --}}
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.session::get('maHocPhan').'/'.session::get('maBaiQH').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop')) }}" 
                                        class="btn btn-success">
                                           <i class="fas fa-arrow-left"></i>
                                     </a>
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
                                                <td>
                                                    @if ($data->trangThai == true)
                                                    <a href="{{ asset('/giang-vien/cham-diem-bao-cao/thuc-hanh/xem-ket-qua-danh-gia-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                        class="btn btn-primary">{{ __('Viewing') }} {{ __('Result') }}</a>

                                                        <a href="{{ asset('/giang-vien/cham-diem-bao-cao/thuc-hanh/sua-diem-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                            
                                                @else
                                                <a href="{{ asset('/giang-vien/cham-diem-bao-cao/thuc-hanh/nhap-diem-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                    class="btn btn-primary">{{ __('Granding') }}</a>
                                                    <a href="{{ asset('/giang-vien/cham-diem-bao-cao/xoa-phieu-cham/' . $data->maDe . '/' . $data->maSSV) }}" 
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
