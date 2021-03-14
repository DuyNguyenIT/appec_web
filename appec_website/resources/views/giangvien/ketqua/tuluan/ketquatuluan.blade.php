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
                      Tự luận<noscript></noscript>
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
                        <a href="{{ asset('giang-vien/ket-qua-danh-gia') }}"
                          >{{$hp->tenHocPhan}}</a
                        >
                      </li>
                      <li class="breadcrumb-item active">Tự luận</li>
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
                        <h4 class="">
                                <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPC">
                                <li class="fa fas-plus"></li>
                                Thêm phiếu chấm
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="addPC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ asset('/giang-vien/ket-qua-danh-gia/tuluan/them-phieu-cham') }}" method="post">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Thêm phiếu chấm</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Chọn sinh viên:</label>
                                                <select name="maSSV[]" id="" class="form-control" multiple>
                                                    @foreach ($dssv as $sv)
                                                        <option value="{{ $sv->maSSV }}">{{ $sv->maSSV }}--{{ $sv->HoSV }} {{ $sv->TenSV }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Chọn đề:</label>
                                                <select name="maDe" id="" class="form-control">
                                                        @foreach ($deThi as $dt)
                                                            <option value="{{ $dt->maDe }}">{{ $dt->maDeVB }}-- {{ $dt->tenDe }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                                   
                                </div>
                            </div>
                        </h4>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table  id="example2" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>STT</th>
                              <th>Mã sinh viên</th>
                              <th>Tên sinh viên</th>
                              <th>Mã đề</th>
                              <th>Tùy chọn</th>
                            </tr>
                          </thead>
                          <tbody>
                            
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