@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Học phần<noscript></noscript>
              <nav></nav>
              
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active">Học phần</li>
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
    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                      <i class="fas fa-plus"></i>
                      Thêm học phần
                    </button>
                 

                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form action="{{ asset('/quan-ly/hoc-phan/them') }}" method="post">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                              Thêm học phần
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="">Nhập mã học phần:</label>
                              <input type="text" name="maHocPhan" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Nhập tên học phần:</label>
                              <input type="text" name="tenHocPhan" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Tổng số tín chỉ lý thuyết:</label>
                              <input type="text" name="tinChiLyThuyet" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Tổng số tín chỉ thực hành:</label>
                              <input type="text" name="tinChiThucHanh" class="form-control" placeholder="">
                            </div>
                            <input type="text" name="tongSoTinChi" value="0" hidden>
                            <div class="form-group">
                              <label for="">Chọn chi tiết khôi kiến thức:</label>
                         
                              <select name="maCTKhoiKT" class="form-control">
                                @foreach ($ctkkt as $data)
                                    <option value="{{ $data->maCTKhoiKT }}">
                                      {{ $data->tenCTKhoiKT }}
                                    </option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                              Lưu
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                              Hủy
                            </button>
                          </div>
                        </div>
                        </form>
                       
                      </div>
                    </div><table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Tên học phần giảng dạy</th>
                      <th>Tổng số tín chỉ</th>
                      <th>LT</th>
                      <th>TH</th>
                      <th>Tùy chọn</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($hocPhan as $data)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $data->tenHocPhan }}</td>
                        <td>{{ $data->tongSoTinChi }}</td>
                        <td>{{ $data->tinChiLyThuyet }}</td>
                        <td>{{ $data->tinChiThucHanh }}</td>
                        
                        <td>
                          
                          <a href="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/'.$data->maHocPhan) }}" class="btn btn-success">
                            <i class="fas fa-align-justify"></i> Đề cương môn học
                          </a>

                          
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
@endsection