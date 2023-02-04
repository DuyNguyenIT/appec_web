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
                                    
                                   
                                        Cán bộ chấm 2: {{ $gv2->hoGV }} {{ $gv2->tenGV }}
                                    
                                    
                                    <!-- Hết Mai thêm -->
                                
                                    
                                </h4>
                                <div class="card-tools">
                                    
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
                                            <th>{{ __('Student name') }}</th>
                                            <th>{{ __('Exame ID') }}</th>
                                            @if ($loaidanhgia==3) 
                                                <th>{{ __('First Lecturer Score') }}</th>
                                                <th>{{ __('Second Lecturer Score') }}</th>
                                            @else
                                                <th>{{ __('Score') }}</th>
                                            @endif
                                            
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
                                                @if ($loaidanhgia==3)
                                                    <td>{{ $data->diemSo }}</td>
                                                    <td>{{ $data->diemCB2 }}</td> 
                                                @else
                                                    <td>{{ $data->diemSo }}</td> 
                                                @endif
                                                <td>
                                                @if ($data->trangThai == false)
                                                    <span class="badge bg-warning">{{ __('Waiting First Lecturer') }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ __('First Lecturer Granded') }}</span>
                                                @endif  
                                                @if ($data->trangThaiGV2 == false)
                                                    <span class="badge bg-warning">{{ __('Waiting Second Lecturer') }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ __('Second Lecturer Granded') }}</span>
                                                @endif  
                                                </td> 
                                                <td>
                                                @if ($data->trangThaiGV2 == true)
                                                    <a href="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/xem-ket-qua-danh-gia-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                        class="btn btn-primary">{{ __('Viewing') }} {{ __('Result') }}</a>

                                                    <a href="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/sua-diem-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                        class="btn btn-primary">{{ __('Edit') }}</a>
                                                        
                                                @else
                                                    <a href="{{ asset('/giang-vien/ket-qua-danh-gia/thuc-hanh/sua-diem-thuc-hanh/' . $data->maDe . '/' . $data->maSSV) }}"
                                                    class="btn btn-primary">{{ __('Granding') }}</a>
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
