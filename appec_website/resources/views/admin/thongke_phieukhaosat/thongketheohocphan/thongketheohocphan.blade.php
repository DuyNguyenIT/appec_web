@extends('admin.master')

@section('content')

   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Thống kê theo học phần<noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="{{ asset('quan-ly') }}">Trang chủ</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ asset('') }}">{{$hp->tenHocPhan}}</a>
              </li>

              <li class="breadcrumb-item active">
                Thống kê theo học phần
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
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Mã học phần</th>
                      <th>Mã  giảng viên hướng dẫn</th>
                      <th>Mã lớp</th>
                      <th>Học kì</th>
                      <th>Năm học</th>
                      <th>Tùy chọn</th>
                    </tr>
                </thead>
                 <tbody>
                    @php
                        $i=1;
                        
                    @endphp
                    @foreach ($giangday as $gd)
                      @php
                          $dem=0;
                      @endphp
                        <tr>
                          <td>{{$i++}}</td>
                          <td>{{$gd->maHocPhan}}</td>
                          <td>{{$gd->maGV}}</td>
                          <td>{{$gd->maLop}}</td>
                          <td>{{$gd->maHK}}</td>
                          <td>{{$gd->namHoc}}</td>
                          <td>
                              <a href="{{ asset('/quan-ly/thong-ke/thong-ke-theo-hocphan/thong-ke-theo-kqht/'.$gd->maHocPhan.'/'.$gd->maLop) }}">
                                  <button class="btn btn-primary"> 
                                    <i class="fas fa-chart-line"></i>Thống kê theo kết quả học tập
                                  </button>
                                </a>
                                <a href="{{ asset('/quan-ly/thong-ke/thong-ke-theo-hocphan/thong-ke-theo-cdr3/'.$gd->maHocPhan.'/'.$gd->maLop) }}">
                                  <button class="btn btn-primary"> 
                                    <i class="fas fa-chart-line"></i>Thống kê theo chuẩn đầu ra 3
                                  </button>
                                </a>
                                 <a href="{{ asset('/quan-ly/thong-ke/thong-ke-theo-hocphan/thong-ke-theo-chuanabet/'.$gd->maHocPhan.'/'.$gd->maLop) }}">
                                  <button class="btn btn-primary"> 
                                    <i class="fas fa-chart-line"></i>Thống kê theo chuẩn Abet
                                  </button>
                                </a>  
                             
                           
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