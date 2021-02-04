@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Khối kiến thức<noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active">Khối kiến thức</li>
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
                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i>
                      Thêm 
                  </button>
                  <!-- Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form action="{{ asset('quan-ly/khoi-kien-thuc/them') }}" method="post">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm khôi kiến thức </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                            <label for="">Nhập mã khối kiến thức:</label>
                            <input type="text" name="maKhoiKT" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="">Nhập tên khối kiến thức:</label>
                            <input type="text" class="form-control" name="tenKhoiKT">
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                      </div>
                    </div>
                    </form>
                      
                </div>
            </div>

                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Mã khối kiến thức</th>
                      <th>Tên khối kiến thức</th>
                      <th>Tùy chọn</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($khoikienthuc as $x)
                         <tr>
                          <td>{{$i++}}</td>
                          <td>{{$x->maKhoiKT}}</td>
                          <td>{{$x->tenKhoiKT}}</td>
                          <td>
                              <button class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$x->maKhoiKT}}">
                                <i class="fas fa-edit"></i> 
                              </button>
                              <a class="btn btn-danger" onclick="return confirm('Bạn có muốn xóa {{$x->maKhoiKT}}?')" href="{{ asset('quan-ly/khoi-kien-thuc/xoa/'.$x->maKhoiKT) }}"><i class="fa fa-trash"></i></a>
                               <!-- Modal -->
                              <div class="modal fade" id="edit_{{$x->maKhoiKT}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <form action="{{ asset('quan-ly/khoi-kien-thuc/sua') }}" method="post">
                                  @csrf
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Thêm khôi kiến thức </h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                          <input type="text" hidden name="maKhoiKT" value="{{$x->maKhoiKT}}" class="form-control">
                                      
                                        <div class="form-group">
                                          <label for="">Nhập tên khối kiến thức:</label>
                                          <input type="text" class="form-control" value="{{$x->tenKhoiKT}}" name="tenKhoiKT">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary">Lưu</button>
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    </div>
                                  </div>
                                  </form>
                                    
                              </div>
                          </div>
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