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
                  Đồ án<noscript></noscript>
                  <nav></nav>
                </h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <a href="{{ asset('/giang-vien') }}">Trang chủ</a>
                  </li>
                  <li class="breadcrumb-item">
                    <a href="#">Đồ án</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Nội dung đánh giá</a></li>
                  <li class="breadcrumb-item active">Xem nội dung đánh giá</li>
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
                      <h3 class="">
                        <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-de-thi-trac-nghiem') }}" class="btn btn-primary">
                          <i class="fas fa-plus"></i>Thêm đề thi trắc nghiệm
                        </a>
                       
                       </h3>
                    </div>
                    {{-- <div class="card-header">Giảng viên cộng tác: <b>Võ Thành C</b></div> --}}
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>STT</th>
                            <th>Mã đề thi</th>
                            <th>Tiêu đề</th>
                            <th>Tùy chọn</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                            $i=1;
                         
                        @endphp

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