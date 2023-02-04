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
                            {{ __('Project') }}<noscript></noscript>
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
                                <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/' . Session::get('maHocPhan') . '/' . Session::get('maBaiQH') . '/' . Session::get('maHK') . '/' . Session::get('namHoc') . '/' . Session::get('maLop')) }}">
                                    @if (session::has('language') && session::get('language')=='en')
                                        {{ $hp->tenHocPhanEN }}
                                    @else
                                       {{ $hp->tenHocPhan }}
                                    @endif
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Project') }}</li>
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
                                    <b>{{ __("Granding examiner") }} 1:</b> {{ $gv->hoGV }} {{ $gv->tenGV }} {{$gv->LoaiCB}}<br />
                                    <b>{{ __("Granding examiner") }} 2:</b> {{ $gv2->hoGV }} {{ $gv2->tenGV }} {{$gv2->LoaiCB}}<br />
                                </h4>
                                <div class="card-tools">
                                    <a href="{{ asset('/giang-vien/ket-qua-danh-gia/xuat-bang-diem-do-an/'.Session::get('maCTBaiQH')) }}" class="btn btn-success">
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
                                            <th>{{ __('Project name') }}</th>
                                            <th>{{ __('Student name') }}</th>
                                            <th>{{ __('Student ID') }}</th>
                                            <th>{{ __('Mark of granding examiner') }} 1</th>
                                            <th>{{ __('Mark of granding examiner') }} 2</th>
                                            <th>{{ __('Option') }}</th>
                                            <th>{{ __('Edit') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $chayTenDT = 0;
                                            $maDe_cur = 0;
                                        @endphp
                                        @foreach ($deThi as $dt)
                                            @php
                                                $demTenDT = $deThi->where('maDe', $dt->maDe)->count();
                                                if ($chayTenDT > $demTenDT) {
                                                    $chayTenDT = 1;
                                                } else {
                                                    $chayTenDT += 1;
                                                }
                                                if ($maDe_cur !== $dt->maDe) {
                                                    $maDe_cur = $dt->maDe;
                                                    $chayTenDT = 1;
                                                }
                                            @endphp
                                            @if ($chayTenDT == 1)
                                                <tr>
                                                    <td rowspan={{ $demTenDT }}>{{ $i++ }}</td>
                                                    <td rowspan={{ $demTenDT }}>{{ $dt->tenDe }}</td>
                                                    <td>{{ $dt->HoSV }} {{ $dt->TenSV }}</td>
                                                    <td>{{ $dt->maSSV }}</td>
                                                    @if ($dt->trangThai == false)
                                                        <td>
                                                            {{ $dt->diemSo }}
                                                        </td>
                                                        <td>
                                                            {{ $dt->diemCB2 }}
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="{{ asset('/giang-vien/ket-qua-danh-gia/nhap-diem-do-an/' . $dt->maDe . '/' . $dt->maSSV) }}">
                                                                <button class="btn btn-primary">
                                                                    <i class="fas fa-edit"></i> {{ __('Granding') }}
                                                                </button>
                                                            </a>
                                                        </td>
                                                    @else
                                                        <td>
                                                            @if ($dt->diemSo<4)
                                                                <span style="color:red">{{ $dt->diemSo }}</span>
                                                            @else
                                                            {{ $dt->diemSo }}
                                                            @endif
                                                            </td>
                                                        <td>
                                                            @if ($dt->diemSo<4)
                                                            <span style="color:red">{{ $dt->diemCB2 }}</span>

                                                                
                                                            @else
                                                            {{ $dt->diemCB2 }}
                                                            @endif
                                                            </td>
                                                        <td>
                                                            <a
                                                                href="{{ asset('/giang-vien/ket-qua-danh-gia/xem-ket-qua-danh-gia/' . $dt->maDe . '/' . $dt->maSSV . '/1') }}">
                                                                <button class="btn btn-success">
                                                                    <i class="fas fa-eye"></i> {{ __('Mark of granding examiner') }} 1
                                                                </button>
                                                            </a>
                                                            <a
                                                                href="{{ asset('/giang-vien/ket-qua-danh-gia/xem-ket-qua-danh-gia/' . $dt->maDe . '/' . $dt->maSSV . '/2') }}">
                                                                <button class="btn btn-primary">
                                                                    <i class="fas fa-eye"></i> {{ __('Mark of granding examiner') }} 2
                                                                </button>
                                                            </a>
                                                        </td>
                                                    @endif
                                                    <td> <a
                                                        href="{{ asset('/giang-vien/ket-qua-danh-gia/sua-ket-qua-danh-gia-do-an/' . $dt->maDe . '/' . $dt->maSSV . '/1') }}">
                                                        <button class="btn btn-success">
                                                            <i class="fas fa-edit"></i> {{ __('Edit') }}
                                                        </button>
                                                    </a></td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $dt->HoSV }} {{ $dt->TenSV }}</td>
                                                    <td>{{ $dt->maSSV }}</td>
                                                    @if ($dt->trangThai == false)
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="{{ asset('/giang-vien/ket-qua-danh-gia/nhap-diem-do-an/' . $dt->maDe . '/' . $dt->maSSV) }}">
                                                                <button class="btn btn-primary">
                                                                    <i class="fas fa-edit"></i> Granding
                                                                </button>
                                                            </a>
                                                        </td>
                                                    @else
                                                        <td>{{ $dt->diemSo }}</td>
                                                        <td>{{ $dt->diemCB2 }}</td>
                                                        <td>
                                                            <a
                                                                href="{{ asset('/giang-vien/ket-qua-danh-gia/xem-ket-qua-danh-gia/' . $dt->maDe . '/' . $dt->maSSV . '/1') }}">
                                                                <button class="btn btn-success">
                                                                    <i class="fas fa-eye"></i> {{ __('Mark of granding examiner') }} 1
                                                                </button>
                                                            </a>
                                                            <a
                                                                href="{{ asset('/giang-vien/ket-qua-danh-gia/xem-ket-qua-danh-gia/' . $dt->maDe . '/' . $dt->maSSV . '/2') }}">
                                                                <button class="btn btn-primary">
                                                                    <i class="fas fa-eye"></i> {{ __('Mark of granding examiner') }} 2
                                                                </button>
                                                            </a>
                                                        </td>
                                                    @endif
                                                    <td> <a
                                                        href="{{ asset('/giang-vien/ket-qua-danh-gia/sua-ket-qua-danh-gia-do-an/' . $dt->maDe . '/' . $dt->maSSV . '/1') }}">
                                                        <button class="btn btn-success">
                                                            <i class="fas fa-edit"></i> {{ __('Edit') }}
                                                        </button>
                                                    </a></td>
                                                </tr>
                                            @endif
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
    <!-- /.content-wrapper -->
@endsection
