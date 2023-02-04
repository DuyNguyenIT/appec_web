@extends('giangvien.master')
@section('content')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Statistics of ABET's SOs by year<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">Statistics of ABET's SOs by year</li>
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
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/giang-vien/thong-ke/xuat-ket-qua-thong-ke-theo-nam-hoc/abet/'.Session::get('namHoc')) }}" class="btn btn-success">
                                        <i class="fas fa-download"></i> <i class="fas fa-file-excel"></i>
                                    </a>
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia') }}" class="btn btn-success">
                                           <i class="fas fa-arrow-left"></i>
                                     </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                (X: Not valuating in course)
                                <table id="" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">{{ __('No.') }}</th>
                                            <th rowspan="2">{{ __('Year') }}</th>
                                            <th rowspan="2">{{ __('Semester') }}</th>
                                            <th rowspan="2">{{ __('Class') }}</th>
                                            <th rowspan="2">{{ __('Course') }}</th>
                                            <th colspan="6">Statistics of ABET's SOs (%)</th>
                                        </tr>
                                        <tr>
                                            @foreach ($chuanAbet as $abet)
                                            <th>{{ $abet->maChuanAbetVB }}</th>
                                            @endforeach
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($arr_thongkeKQ as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data[0] }}</td>
                                                <td>{{ $data[1] }}</td>
                                                <td>{{ strtoupper($data[2]) }}</td>
                                                <td>
                                                    ({{ $data[3] }})
                                                    @foreach ($hocPhan as $hp)
                                                        @if ($hp->maHocPhan==$data[3])
                                                            @if (Session::has('language') && Session::get('language')=='en')
                                                            {{ $hp->tenHocPhanEN }}
                                                            @else
                                                            {{ $hp->tenHocPhan }}
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if ($data[4]==0)
                                                        X
                                                    @else
                                                        {{ number_format($data[4]*100,2) }}
                                                    @endif
                                                </td>
                                                <td>@if ($data[5]==0)
                                                    X
                                                @else
                                                    {{ number_format($data[5]*100,2) }}
                                                @endif</td>
                                                <td>@if ($data[6]==0)
                                                    X
                                                @else
                                                    {{ number_format($data[6]*100,2) }}
                                                @endif</td>
                                                <td>
                                                    @if ($data[7]==0)
                                                        X
                                                    @else
                                                        {{ number_format($data[7]*100,2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data[8]==0)
                                                        X
                                                    @else
                                                        {{ number_format($data[8]*100,2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data[9]==0)
                                                        X
                                                    @else
                                                        {{ number_format($data[9]*100,2) }}
                                                    @endif
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
    </div>
   
@endsection
