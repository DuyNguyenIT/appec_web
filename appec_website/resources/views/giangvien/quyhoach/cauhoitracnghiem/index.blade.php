@extends('giangvien.master')
@section('content')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <div class="content-wrapper" style="min-height: 96px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            Câu hỏi trắc nghiệm<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/giang-vien') }}">{{ __('Home') }}</a></li>
                           
                            <li class="breadcrumb-item">
                                Câu hỏi trắc nghiệm

                            </li>
                            <li class="breadcrumb-item active">Câu hỏi trắc nghiệm</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="d-flex justify-content-between">
                                    <a href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/them-cau-hoi') }}"
                                        class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.Session::get('maHocPhan').'/'.Session::get('maBaiQH').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maLop')) }}"
                                        class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>{{ __('Question content') }}</th>
                                            <th>{{ __('Studying results') }}</th>
                                            <th>{{ __('SOs') }}</th>
                                            <th>{{ __("ABET's SO") }}</th>
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @foreach ($cauHoi as $data)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>
                                                    @php
                                                        $letter = ['A', 'B', 'C', 'D'];
                                                    @endphp
                                                    {!! $data->noiDungCauHoi !!}
                                                    <div class="row">
                                                        @for ($i = 0; $i < count($data->phuong_an_trac_nghiem); $i++)
                                                            @if ($data->phuong_an_trac_nghiem[$i]->isCorrect == true)
                                                                <div class="col-md-1"> {{ $letter[$i] }}. </div>
                                                                <div class="col-md-11"> <b>{!! $data->phuong_an_trac_nghiem[$i]->noiDungPA !!}</b></div>
                                                            @else
                                                                <div class="col-md-1"> {{ $letter[$i] }}. </div>
                                                                <div class="col-md-11"> {!! $data->phuong_an_trac_nghiem[$i]->noiDungPA !!} </div>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $data->maKQHTVB }}-- {{ $data->tenKQHT }}
                                                </td>
                                                <td>
                                                     {{ $data->maCDR3VB }} {{---- {{ $data->tenCDR3 }} --}}
                                                </td>
                                                <td>
                                                    {{ $data->maChuanAbetVB }}{{--  -- {{ $data->tenChuanAbet }} --}}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/sua-cau-hoi/' . $data->maCauHoi) }}"
                                                            class="btn btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/xoa-cau-hoi/' . $data->maCauHoi) }}"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
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
