@extends('giangvien.master')
@section('content')
<div class="content-wrapper" style="min-height: 58px;">
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

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  <i class="fas fa-plus"></i> Thêm
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
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
                          <label for="hocphan">Chọn ngành</label>
                          <!-- Button trigger modal -->
                          <select id="nganh" class="form-control custom-select">
                            <option disabled="">--Chọn ngành--</option>
                            <option value="1" selected="">
                              Công nghệ thông tin
                            </option>
                            <option value="2">Cơ khí</option>
                            <option value="1">
                              Điện tử - tự động hóa
                            </option>
                            <option value="1">Xây dựng</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="hocphan">Chọn học phần</label>
                          <!-- Button trigger modal -->
                          <select id="hocphan" class="form-control custom-select">
                            <option>Công nghệ phần mềm</option>
                            <option>Nhập môn công nghệ thông tin</option>
                            <option>Kỹ thuật lập trình</option>
                            <option>Cơ sở dữ liệu</option>
                            <option selected="">
                              Hệ quản trị cơ sở dữ liệu
                            </option>
                          </select>
                        </div>
                        <div class="from-group">
                          <label for="">Chọn học kì</label>
                          <select name="" id="" class="form-control custom-select">
                            <option value="">Học kì 1</option>
                            <option value="">Học kì 2</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Nhập năm học:</label>
                          <input type="text" class="form-control" placeholder="VD: 2018-2019">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary">
                          Lưu
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                          Hủy
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" aria-describedby="example2_info">
                <thead>
                  <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="STT: activate to sort column descending">STT</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Tên học phần: activate to sort column ascending">Tên học phần</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ngành: activate to sort column ascending">Ngành</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Học kì: activate to sort column ascending">Học kì</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Năm học: activate to sort column ascending">Năm học</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Tùy chọn: activate to sort column ascending">Tùy chọn</th></tr>
                </thead>
                <tbody>
                  
                <tr role="row" class="odd">
                    <td class="sorting_1 dtr-control">1</td>
                    <td>Hệ quản trị cơ sở dữ liệu</td>
                    <td>Công nghệ thông tin</td>
                    <td>Học kì 1</td>
                    <td>2018-2019</td>
                    <td>
                      <a href="chude.html">
                        <button class="btn btn-success">
                          <i class="fas fa-align-justify"></i> kết quả học
                          tập của học phần
                        </button>
                      </a>
                      <a href="danhsachhs.html">
                        <button class="btn btn-primary">
                          <i class="fas fa-align-justify"></i> Xem danh
                          sách sinh viên
                        </button>
                      </a>
                      <button class="btn btn-primary">
                        <i class="fas fa-print"></i>
                        In đề cương chi tiết môn học
                      </button>
                    </td>
                  </tr></tbody>
                <tfoot></tfoot>
              </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 1 of 1 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
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