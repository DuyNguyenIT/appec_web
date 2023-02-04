@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 155px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Thống kê chuẩn đầu ra chương trình đào tạo<noscript></noscript><nav></nav></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thống kê chuẩn đầu ra chương trình đào tạo</li>
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
                   
                    {{-- <div class="from-group">
                      <label for="">Chọn học kì</label>
                      <select name="" id="" class="form-control custom-select">
                        <option value="">hk1</option>
                        <option value="">hk2</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="">Nhập năm học:</label>
                      <input type="text" class="form-control" placeholder="VD: 2019">
                    </div>
                    <button class="btn btn-success">
                      <i class="fas fa-filter"></i> Lọc
                    </button> --}}
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Năm học</th>
                      <th>Học kì</th>
                      <th>Mã lớp</th>
                      <th>Tên lớp</th>

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
                          <td>{{$gd->namHoc}}</td>
                          <td>{{$gd->maHK}}</td>
                          <td>{{$gd->maLop}}</td>
                          <td>{{$gd->tenLop}}</td> 
                          <td>
                            <a href="{{ asset('/quan-ly/thong-ke/thong-ke-theo-lop/'.$gd->maLop.'/'.$gd->maHK.'/'.$gd->namHoc) }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Thống kê 
                              </button>
                            </a>
                         {{--  {{ asset('/quan-ly/thong-ke/thong-ke-theo-hocphan/'.$maGV.'/'.$gd->maHocPhan.'/'.$gd->maHK.'/'.$gd->namHoc.'/'.$gd->maLop) }}
                                <a href="{{ asset('/quan-ly/thong-ke/thong-ke-theo-kqht/'.$maGV.'/'.$gd->maHocPhan.'/'.$gd->maHK.'/'.$gd->namHoc.'/'.$gd->maLop) }}">
                                  <button class="btn btn-primary"> 
                                    <i class="fas fa-chart-line"></i>Thống kê theo kqht
                                  </button>
                                </a>--}}
                                {{-- <a href="{{ asset('/quan-ly/thong-ke/thong-ke-theo-cdr3/'.$maGV.'/'.$gd->maHocPhan.'/'.$gd->maHK.'/'.$gd->namHoc.'/'.$gd->maLop) }}">
                                  <button class="btn btn-primary"> 
                                    <i class="fas fa-chart-line"></i>Thống kê cdr3 chương trình đào tạo
                                  </button>
                                </a>
                                <a href="{{ asset('/quan-ly/thong-ke/thong-ke-theo-chuanabet/'.$maGV.'/'.$gd->maHocPhan.'/'.$gd->maHK.'/'.$gd->namHoc.'/'.$gd->maLop) }}">
                                  <button class="btn btn-primary"> 
                                    <i class="fas fa-chart-line"></i>Thống kê chuẩn abet chương trình đào tạo
                                  </button>
                                </a>  --}}
                            
                           
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