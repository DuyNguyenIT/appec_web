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
                            {{ __('Assessment Planning') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Assessment Planning') }}
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
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>{{ __('Academic year') }}</th>
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($gd as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->namHoc }}</td>
                                               
                                                <td>
                                                    <a href="{{ asset('giang-vien/quy-hoach-danh-gia/' . $item->namHoc . '/HK1') }}"
                                                        class="btn btn-success">
                                                        <i class="fas fa-align-justify"></i>
                                                        {{ __('First semester') }} 
                                                        <span
                                                             class="badge bg-purple">{{ count($gd_full->where('namHoc',$item->namHoc)->where('maHK','HK1')) }}</span>
                                                        
                                                    </a>
                                                    <a href="{{ asset('giang-vien/quy-hoach-danh-gia/' . $item->namHoc . '/HK2') }}"
                                                        class="btn btn-success">
                                                        <i class="fas fa-align-justify"></i>
                                                        {{ __('Second semester') }}
                                                        <span
                                                        class="badge bg-purple">{{ count($gd_full->where('namHoc',$item->namHoc)->where('maHK','HK2')) }}</span>
                                         
                                                    </a>
                                                    <a href="{{ asset('giang-vien/thong-ke/thong-ke-theo-nam-hoc/abet/'.$item->namHoc) }}" class="btn btn-success">
                                                        Statistics of ABET's SOs
                                                    </a>
                                                    <a href="{{ asset('giang-vien/thong-ke/thong-ke-theo-nam-hoc/so/'.$item->namHoc) }}" class="btn btn-success">
                                                        Statistics of CDIO's SOs
                                                    </a>
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
        <!-- /.content -->
    </div>
@endsection
