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

        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class=""></h3>
                         {{-- <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-de-thi-tu-luan') }}" class="btn btn-primary">
                           <i class="fas fa-plus"></i>Thêm đề thi
                         </a> --}}
                         <!-- Button trigger modal -->

                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-plus"></i>Thêm đề thi
                          </button>
                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-de-thi-tu-luan-submit') }}" method="post">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Thêm đề thi</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="">Mã đề</label>
                                    <input type="text" class="form-control" name="maDeVB">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Tiêu đề</label>
                                    <input type="text" class="form-control" name="tenDe">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Thời gian thi</label>
                                    <input type="text" class="form-control" name="thoiGian">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Số câu hỏi</label>
                                    <input type="text" class="form-control" name="soCauHoi">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Ghi chú</label>
                                    <input type="text" class="form-control" name="ghiChu">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Lưu</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                </div>
                              </div>
                              </form>
                              
                            </div>
                          </div>


                       
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
                            <th>Thời gian thi</th>
                            <th>Số cấu hỏi</th>
                            <th>Ghi chú</th>
                            <th>Tùy chọn</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                            $i=1;
                          @endphp
                          @foreach ($dethi as $data)
                              <tr>
                                <td>
                                  {{ $i++ }}
                                </td>
                                <td>
                                  {{ $data->maDeVB}}
                                </td>
                                <td>{{ $data->tenDe }}</td>
                                <td>{{ $data->thoiGian }} phút</td>
                                <td>{{ $data->soCauHoi }}</td>
                                <td>{{ $data->ghiChu }}</td>
                                <td>
                                  <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$data->maDe) }}" class="btn btn-primary">Cấu trúc đề thi</a>
                                  <button class="btn btn-danger">Xóa</button>
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