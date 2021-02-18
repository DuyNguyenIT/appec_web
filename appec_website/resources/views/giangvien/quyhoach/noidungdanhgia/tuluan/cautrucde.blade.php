@extends('giangvien.master')
@section('content')
<div class="content-wrapper" style="min-height: 96px;">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">
                Phân bổ nội dung<noscript></noscript>
                <nav></nav>
              </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active">Nội dung đánh giá</li>
                <li class="breadcrumb-item active">Phân bổ nội dung</li>
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
                  <h3 class="card-title"></h3>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      <i class="fas fa-plus"></i>Thêm cấu hình
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/them-cau-truc-de-luan') }}" method="post">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm cấu trúc đề thi </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                             <input type="text" name="maDe" value="{{ $maDe }}" hidden>
                             <div class="form-group">
                               <label for="">Chọn kết quả học tập</label>
                               <select name="maKQHT" id="" class="form-control">
                                  @foreach ($kqht as $item)
                                      <option value="{{ $item->maKQHT}}">{{ $item->tenKQHT }}</option>
                                  @endforeach
                               </select>
                             </div>
                             <div class="form-group">
                               <label for="">Số câu hỏi</label>
                               <input type="text" name="soCauHoi" class="form-control">
                             </div>
                             <div class="form-group">
                               <label for="">Điểm nhóm kết quả học tập</label>
                               <input type="text" name="diemNhomKQHT" class="form-control">
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
    

                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>STT</th>
                        <th>Tên kết quả học tập</th>
                        <th>Số câu hỏi</th>
                        <th>Điểm nhóm kết quả học tập</th>
                        <th>Tùy chọn</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $i=1;
                      @endphp
                      @foreach ($phanBo as $data)
                          <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->kqht->tenKQHT }}</td>
                            <td>{{ $data->soCauHoi }}</td>
                            <td>{{ $data->diemNhomKQHT }}</td>
                            <td></td>
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