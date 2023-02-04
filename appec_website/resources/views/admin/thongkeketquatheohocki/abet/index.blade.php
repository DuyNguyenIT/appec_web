@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
     <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            Statistics<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{__('Home') }}</a></li>
            <li class="breadcrumb-item ">{{ $ctdaotao->tenCT }}</li>
            <li class="breadcrumb-item ">{{ session::get('maHK') }}</li>
            <li class="breadcrumb-item ">{{ session::get('namHoc') }}</li>
            <li class="breadcrumb-item active">Thống kê</li>

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
                        <h3 class="card-title">
                            {{ __('Curriculum') }}: {{ $ctdaotao->tenCT}} <br>
                            {{ __('Academic year') }} : {{ Session::get('namHoc') }} <br>
                            {{ __('Semester') }} : {{ Session::get('maHK') }} <br>
                            {{ __('Class ID') }} : {{ Session::get('maLop') }} <br>
                        </h3>
                        <div class="card-tools">
                            <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh/namhoc/lop/export-thong-ke-theo-abet/'.Session::get('maLop')) }}" class="btn btn-success">
                                <i class="fas fa-download"></i> <i class="fas fa-file-excel"></i>
                            </a>
                            <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh/namhoc/lop/'.Session::get('maHK').'/'.Session::get('namHoc')) }}" class="btn btn-success">
                                  <i class="fas fa-arrow-left"></i>
                            </a>
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        (Unit:%)
                        <table id="" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th rowspan="2">{{ __('No.') }}</th>
                                    <th rowspan="2">{{ __('Subject') }}</th>
                                    <th colspan="6">ABET</th>
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
                                        <td>
                                            ({{ $data[0] }})
                                            @foreach ($hocPhan as $hp)
                                                @if ($hp->maHocPhan==$data[0])
                                                    @if (Session::has('language') && Session::get('language')=='en')
                                                    {{ $hp->tenHocPhanEN }}
                                                    @else
                                                    {{ $hp->tenHocPhan }}
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ number_format($data[1]*100,2) }}</td>
                                        <td>{{ number_format($data[2]*100,2) }}</td>
                                        <td>{{ number_format($data[3]*100,2) }}</td>
                                        <td>{{ number_format($data[4]*100,2) }}</td>
                                        <td>{{ number_format($data[5]*100,2) }}</td>
                                        <td>{{ number_format($data[6]*100,2) }}</td>
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
                <!-- STACKED BAR CHART -->
                <div class="card card-success">
                    {{-- <div class="card-header">
                        <h3 class="card-title">Biểu đồ</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div> --}}
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
</div>
@endsection