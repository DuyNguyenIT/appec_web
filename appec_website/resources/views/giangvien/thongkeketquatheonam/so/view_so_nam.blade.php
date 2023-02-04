@extends('giangvien.master')
@section('content')
<style type="text/css">
       
    .first {
      position:absolute;
      /*position: relative;*/
      width:100px;
      /* padding: 5px; */
     height: 35px;
      left: auto;
      /* display: block; */
      z-index: 3;
     background-color:  white;
    }

    .second {
        position:absolute;
        /* position: relative; */
        width:100px;
        padding: 0px;
        display: block;
        height: 35px;
        left:100px;
        z-index: 3;
       background-color: white;
    }
    .third {
        position:absolute;
        left:200px;
        width:350px;
        height: 35px;
        display:block;
        z-index: 3;
        top:auto;
        background-color:white;
    }
    .fourth{
        position:absolute;
        /* width:100%; */
        left:550px;
        top:0px;
        background-color:white;
        padding: 5px;
  
    }
    .fifth{
        position:relative;
        /* width:100%; */
        left:550px;
        top:0px;
        background-color:white;
        padding: 5px;

    }
    .sixth{
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

<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Statistics of CDIO's SOs by year<noscript></noscript>
                        <nav></nav>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ asset('/giang-vien/quy-hoach-danh-gia') }}">Assessment Planning</a></li>
                        <li class="breadcrumb-item active">Statistics of CDIO's SOs by year</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
                               Year: {{ Session::get('namHoc') }}
                            </h3>
                            <div class="card-tools">
                                <a href="{{ asset('/giang-vien/thong-ke/xuat-ket-qua-thong-ke-theo-nam-hoc/so/'.Session::get('namHoc')) }}" class="btn btn-success">
                                    <i class="fas fa-download"></i> <i class="fas fa-file-excel"></i>
                                </a>
                                <a href="{{ asset('/giang-vien/quy-hoach-danh-gia') }}" class="btn btn-success">
                                       <i class="fas fa-arrow-left"></i>
                                 </a>
                            </div>
                        </div>
                        (X: Not valuating in course; Unit:%)
                        <!-- /.card-header -->
                        <table id="" class="tatable table-bordered table-hover table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th class="first" >{{ __('Semester') }}</th>
                                    <th class="second" >{{ __('Class') }}</th>
                                    <th class="third" >{{ __('Course') }}</th>
                                    
                                    {{-- <th class="third" >{{ __('Class') }}</th> --}}
                                    {{-- <th class="second" >{{ __('Course') }}</th> --}}
                                    {{-- <th class="fourth" colspan="{{ count($arr_thongkeKQ[0]) }}">SO</th> --}}
                                    @foreach ($CDR3 as $cdr3)
                                        <th class="fifth">{{ $cdr3->maCDR3VB }}</th>
                                    @endforeach
                                </tr>
                                {{-- <tr>
                                   
                                    
                                </tr> --}}
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($arr_thongkeKQ as $data)
                                    <tr>
                                        <td class="first">
                                            @if ($data[1]=='HK1')
                                                first
                                            @else
                                                second
                                            @endif
                                        </td>
                                        <td class="second">{{ strtoupper($data[2]) }}</td>
                                         <td class="third">{{ $data[3] }}
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
                                
                                          {{-- <td class="third">{{ $data[2] }}</td> --}}
                                        {{-- <td class="second">
                                            ({{ $data[3] }})
                                            {{-- @foreach ($hocPhan as $hp)
                                                @if ($hp->maHocPhan==$data[3])
                                                    @if (Session::has('language') && Session::get('language')=='en')
                                                    {{ $hp->tenHocPhanEN }}
                                                    @else
                                                    {{ $hp->tenHocPhan }}
                                                    @endif
                                                    
                                                @endif
                                            @endforeach 
                                        </td> --}}
                                        @for ($j = 4; $j < count($data); $j++)
                                            <td class="fifth">
                                                @if ($data[$j]!=0)
                                                    <b>{{ number_format($data[$j]*100,2) }}</b>
                                                @else
                                                    X
                                                @endif
                                                
                                            </td>
                                        @endfor
                                        
                                    </tr>
                                @endforeach
                               
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                        <!-- /.card-body -->
                    </div>
                   
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
 </div>
@endsection