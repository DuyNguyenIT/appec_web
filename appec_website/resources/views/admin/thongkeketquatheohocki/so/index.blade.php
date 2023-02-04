@extends('admin.master')
@section('content')
<style type="text/css">
       
    .first {
      position:absolute;
      /*position: relative;*/
      width:60px;
      padding: 5px;
    
      left: auto;
      display: block;
      z-index: 3;
     background-color:  #28a745;
    }

    .second {
        position:absolute;
        /*position: relative;*/
        width:300px;
        padding: 5px;
       
        left:80px;
        z-index: 3;
       background-color: #28a745;
    }
    .third {
        position:absolute;
        width:inherit;
        display:block;
        top:auto;
        background-color:#28a745;
    }
    .fourth{
        position:relative;
        /* width:100%; */
        left:360px;
        top:0px;
        background-color:#28a745;
        padding: 5px;
  
    }
    .fifth{
      top:0px;
      left: 360px;
      position: relative;
      z-index: 2;

    }
    .table-fixed {
        width:100%;
        height:720px;
        overflow:scroll;  
    }
   
  </style>
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
                            <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh/namhoc/lop/export-thong-ke-theo-so/'.Session::get('maLop')) }}" class="btn btn-success">
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
                        <table id="" class="tatable table-bordered table-hover table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th class="first" rowspan="2">{{ __('No.') }}</th>
                                    <th class="second" rowspan="2">{{ __('Subject') }}</th>
                                    {{-- <th class="fourth" colspan="{{ count($arr_thongkeKQ[0]) }}">SO</th> --}}
                                    @foreach ($CDR3 as $cdr3)
                                        <th class="fourth">{{ $cdr3->maCDR3VB }}</th>
                                    @endforeach
                                </tr>
                                {{-- <tr>
                                   
                                    
                                </tr> --}}
                            </thead>
                            <tbody>
                                @php
                                    $index = 1;
                                @endphp
                                @foreach ($arr_thongkeKQ as $data)
                                    <tr>
                                        <td class="first">{{ $index++ }}</td>
                                        <td class="second">
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
                                        @for ($i = 1; $i < count($data); $i++)
                                            <td class="fourth">
                                                @if ($data[$i]!=0)
                                                    <b>{{ number_format($data[$i]*100,2) }}</b>
                                                @else
                                                    0
                                                @endif
                                                
                                            </td>
                                        @endfor
                                        
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