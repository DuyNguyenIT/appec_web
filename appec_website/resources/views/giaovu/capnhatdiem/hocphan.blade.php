@extends('giaovu.master')
@section('content')
<div class="content-wrapper" style="min-height: 155px;">
     <!-- Content Header (Page header) -->
     <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> {{ __('Course information') }}<noscript></noscript>
                        <nav></nav>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('/giao-vu') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ asset('/giao-vu/cap-nhat-diem-ket-thuc') }}">{{ $maHK }} {{ $namHoc }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Course') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
      <!-- /.content-header -->
      <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Semester') }}: {{ $maHK }} -- {{ __('Academic year') }}: {{ $namHoc }}
                            </h3>
                            <div class="card-tools">
                                <a href="{{ asset('/giao-vu/cap-nhat-diem-ket-thuc') }}" class="btn btn-success">
                                      <i class="fas fa-arrow-left"></i>
                                </a>
                        </div>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('No.') }}</th>
                                        <th>{{ __('Course name') }}</th>
                                        <th>{{ __('Lecture') }}</th>
                                        <th>{{ __('Class') }}</th>
                                        <th>{{ __('Option') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($giangday as $gd)
                                       <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $gd->hocphan->tenHocPhan }}</td>
                                            <td>
                                                @foreach ($gd->GV as $gv)
                                                    <li>{{ $gv->hoGV }} {{ $gv->tenGV }}</li>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $gd->maLop }}
                                            </td>
                                            <td></td>
                                       </tr>
                                    @endforeach
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection