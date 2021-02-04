@extends('giaovu.master')

@section('content')

   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Quy hoạch đánh giá kết quả học tập<noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="{{ asset('giang-vien') }}">Trang chủ</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ asset('giang-vien/quy-hoach-danh-gia') }}">{{$hp->tenHocPhan}}</a>
              </li>

              <li class="breadcrumb-item active">
                Quy hoạch đánh giá kết quả học tập
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
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-check"></i> Thông báo!</h5>
      {{session('success')}}
    </div>
    @endif
    @if(session('warning'))
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Thông báo!</h5>
        {{session('warning')}}
      </div>
    @endif


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
                <table
                  id="example2"
                  class="table table-bordered table-hover"
                >
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Hình thức đánh giá</th>
                      <th>Tỉ lệ (%)</th>
                      <th>Phương pháp đánh giá</th>
                      <th>Tùy chọn</th>
                    </tr>
                  </thead>
                  <tbody>
                      @php
                          $i=1;
                      @endphp
                      @foreach ($qh as $x)
                      @if ($x->maLoaiHTDG=="T8")
                        <tr>
                          <td rowspan="2">{{$i++}}</td>
                          <td rowspan="2">{{$x->tenLoaiDG}}</td>
                          <td rowspan="2">{{$x->trongSo}}%</td>
                          <td rowspan="2">{{$x->tenLoaiHTDG}}</td>
                          <td>
                            Cán bộ chấm 1 <br>
                            <a href="{{ asset('/giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-tieu-chi/'.$x->maCTBaiQH.'/1') }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo tiêu chí
                            </button>
                            </a>
                            <a href="{{ asset('giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-xep-hang/'.$x->maCTBaiQH.'/1') }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo xếp hạng
                            </button>
                            </a>
                            <a href="{{ asset('giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-diem-chu/'.$x->maCTBaiQH.'/1') }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo điểm chữ
                            </button>
                            </a>
                          </td>
                        </tr>
                        <tr>
                          
                          <td>
                            Cán bộ chấm 2 <br>
                            <a href="{{ asset('/giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-tieu-chi/'.$x->maCTBaiQH.'/2') }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo tiêu chí
                            </button>
                            </a>
                            <a href="{{ asset('giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-xep-hang/'.$x->maCTBaiQH.'/2') }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo xếp hạng
                            </button>
                            </a>
                            <a href="{{ asset('giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-diem-chu/'.$x->maCTBaiQH.'/2') }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo điểm chữ
                            </button>
                            </a>
                          </td>
                        </tr>
                      @else
                        <tr>
                          <td>{{$i++}}</td>
                          <td>{{$x->tenLoaiDG}}</td>
                          <td>{{$x->trongSo}}%</td>
                          <td>{{$x->tenLoaiHTDG}}</td>
                          <td>
                            <a href="{{ asset('/giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-tieu-chi/'.$x->maCTBaiQH) }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo tiêu chí
                            </button>
                            </a>
                            <a href="{{ asset('giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-xep-hang/'.$x->maCTBaiQH) }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo xếp hạng
                            </button>
                            </a>
                            <a href="{{ asset('giao-vu/thong-ke/thong-ke-theo-hoc-phan/thong-ke-theo-diem-chu/'.$x->maCTBaiQH) }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê theo điểm chữ
                            </button>
                            </a>
                          </td>
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