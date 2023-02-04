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
                            {{ __('Statistics') }}<noscript></noscript>
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
                                <a href="{{ asset('giang-vien/quy-hoach-danh-gia') }}">{{ $hp->tenHocPhan }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                
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
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.Session::get('maHocPhan').'/'.Session::get('maBaiQH').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maLop')) }}" class="btn btn-secondary">
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
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($qh as $x)
                                            @if ($x->maLoaiHTDG == 'T8')
                                                <tr>
                                                    <td rowspan="2">{{ $i++ }}</td>
                                                    <td rowspan="2">{{ $x->tenLoaiDG }}</td>
                                                    <td rowspan="2">{{ $x->trongSo }}%</td>
                                                    <td rowspan="2">{{ $x->tenLoaiHTDG }}</td>
                                                    <td>
                                                        Cán bộ chấm 1 <br>
                                                        <a
                                                            href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH . '/1') }}">
                                                            <button class="btn btn-primary">
                                                                <i class="fas fa-chart-line"></i>SO
                                                            </button>
                                                        </a>
                                                        <a
                                                            href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-xep-hang/' . $x->maCTBaiQH . '/1') }}">
                                                            <button class="btn btn-primary">
                                                                <i class="fas fa-chart-line"></i>{{ __('Rank') }}
                                                            </button>
                                                        </a>
                                                        <a
                                                            href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-diem-chu/' . $x->maCTBaiQH . '/1') }}">
                                                            <button class="btn btn-primary">
                                                                <i class="fas fa-chart-line"></i>{{__('Grate')}}
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Cán bộ chấm 2 <br>
                                                        <a
                                                            href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH . '/2') }}">
                                                            <button class="btn btn-primary">
                                                                <i class="fas fa-chart-line"></i>SOs
                                                            </button>
                                                        </a>
                                                        <a
                                                            href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-xep-hang/' . $x->maCTBaiQH . '/2') }}">
                                                            <button class="btn btn-primary">
                                                                <i class="fas fa-chart-line"></i>{{ __('Rank') }}
                                                            </button>
                                                        </a>
                                                        <a
                                                            href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-diem-chu/' . $x->maCTBaiQH . '/2') }}">
                                                            <button class="btn btn-primary">
                                                                <i class="fas fa-chart-line"></i>{{__('Grate')}}
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @else
                                                @if ($x->maLoaiHTDG = 'T1')
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $x->tenLoaiDG }}</td>
                                                        <td>{{ $x->trongSo }}%</td>
                                                        <td>{{ $x->tenLoaiHTDG }}</td>
                                                        <td>
                                                            <a
                                                                href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH) }}">
                                                                <button class="btn btn-primary">
                                                                    <i class="fas fa-chart-line"></i> {{ __('SOs') }}
                                                                </button>
                                                            </a>
                                                            <a
                                                                href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-xep-hang/' . $x->maCTBaiQH) }}">
                                                                <button class="btn btn-primary">
                                                                    <i class="fas fa-chart-line"></i>{{ __('Rank') }}
                                                                </button>
                                                            </a>
                                                            <a href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-diem-chu/' . $x->maCTBaiQH) }}"
                                                                class="btn btn-primary">
                                                                <i class="fas fa-chart-line"></i>{{__('Grate')}}
                                                            </a>
                                                            <a href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-abet/' . $x->maCTBaiQH) }}"
                                                                class="btn btn-primary">
                                                                <i class="fas fa-chart-line"></i>{{ __("ABET's SO") }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @if ($x->maLoaiHTDG = 'T3')
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $x->tenLoaiDG }}</td>
                                                            <td>{{ $x->trongSo }}%</td>
                                                            <td>{{ $x->tenLoaiHTDG }}</td>
                                                            <td>
                                                                <a
                                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH) }}">
                                                                    <button class="btn btn-primary">
                                                                        <i class="fas fa-chart-line"></i>{{ __('SOs') }}
                                                                    </button>
                                                                </a>
                                                                <a
                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-xep-hang/' . $x->maCTBaiQH) }}">
                                                                    <button class="btn btn-primary">
                                                                        <i class="fas fa-chart-line"></i>{{ __('Rank') }}
                                                                    </button>
                                                                </a>
                                                                <a
                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-diem-chu/' . $x->maCTBaiQH) }}">
                                                                    <button class="btn btn-primary">
                                                                        <i class="fas fa-chart-line"></i>{{__('Grate')}}
                                                                    </button>
                                                                </a>
                                                                <a href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thu-hanh/thong-ke-theo-abet/' . $x->maCTBaiQH) }}"
                                                                    class="btn btn-primary">
                                                                    <i class="fas fa-chart-line"></i>{{ __("ABET's SO") }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
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
