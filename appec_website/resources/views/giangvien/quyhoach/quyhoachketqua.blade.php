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
                        <a href="{{ asset('giang-vien/quy-hoach-danh-gia') }}"
                          >{{$hp->tenHocPhan}}</a
                        >
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
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >
                            <i class="fas fa-plus"></i> Thêm
                          </button>
    
                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/them-quy-hoach') }}" method="post" enctype="multipart/form-data">
                              @csrf
                                <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">
                                    Thêm quy hoạch đánh giá
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <input type="text" name="maHocPhan" value="{{$hp->maHocPhan}}" hidden>
                                  </div>
                                  <div class="form-group">
                                    <label for="" style="font-size: 20px">Chọn hình thức đánh giá:</label>
                                    <select name="maLoaiDG" class="form-control custom-select">
                                        @foreach ($ldg as $x)
                                            <option value="{{$x->maLoaiDG}}">{{$x->tenLoaiDG}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                
                                  <div class="form-group">
                                    <label for="" style="font-size: 20px">Nhập tỉ lệ:</label>
                                    <input required type="text" name="trongSo" class="form-control" placeholder="VD:20,30,..." style="width: 100%" />
                                  </div>
    
                                  <div class="form-group">
                                    <label for="" style="font-size: 20px" >Chọn phương pháp đánh giá:</label>
                                    <select name="maLoaiHTDG" id="" class="form-control custom-select">
                                        @foreach ($lhtdg as $x)
                                        <option value="{{$x->maLoaiHTDG}}">{{$x->tenLoaiHTDG}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">
                                    Lưu
                                  </button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal" >
                                    Hủy
                                  </button>
                                </div>
                              </div>
                              </form>
                            
                            </div>
                          </div>
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
                              <tr>
                                <td>{{$i++}}</td>
                                <td>{{$x->tenLoaiDG}}</td>
                                <td>{{$x->trongSo}}%</td>
                             
                                <td>{{$x->tenLoaiHTDG}}</td>
                                <td>
                                  <a href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.$x->maCTBaiQH) }}" class="btn btn-success">
                                    <i class="fas fa-align-justify"></i> Nội dung quy hoạch               
                                </a>
                                  <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/xem-noi-dung-danh-gia/'.$x->maCTBaiQH) }}">
                                    <button class="btn btn-success">
                                      <i class="fas fa-info-circle"></i> Nội dung đánh
                                      giá
                                    </button>
                                  </a>
                                  <button class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Chỉnh sửa
                                  </button>
                                </td>
                              </tr>
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