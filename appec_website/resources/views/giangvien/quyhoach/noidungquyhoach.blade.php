@extends('giangvien.master')
@section('content')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Nhóm tiêu chí đánh giá<noscript></noscript><nav></nav></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">Trang chủ</a></li>
              <li class="breadcrumb-item "><a href="quyhoachKQHT.html">Đồ án</a></li>
              <li class="breadcrumb-item "><a href="noidungdanhgia_3.html">Nội dung đánh giá</a></li>
              <li class="breadcrumb-item active">Nhóm tiêu chí đánh giá</li>

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
                  <h3 class="">
                      <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-plus"></i> Thêm
                        </button>
                        <button class="btn btn-success">
                            <i class="fas fa-print"></i> Xuất tiêu chí đánh giá
                        </button>

                   <!-- Modal -->
                  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Thêm nội dung</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                          <div class="form-group">
                            <label for="hocphan" style="font-size:20px">Nhập nhóm tiêu chí</label>
                            <!-- Button trigger modal -->
                            <input type="text" class="form-control" id="" placeholder="Nhập nhóm tiêu chí...">
                          </div>
                        
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary">Lưu</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        </div>
                      </div>
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
                      <th>Nhóm tiêu chí</th>
                      <th>Tùy chọn</th>
                    </tr>
                  </thead>
                   <tbody>
                     <tr>
                       <td>1</td>
                       <td>Quyển báo cáo</td>
                       <td>
                         <a href="tieuchi_1.html">
                            <button class="btn btn-success">
                            <i class="fas fa-info-circle"></i> Chi tiết
                           </button>
                         </a>
                          
                       </td>
                     </tr>
                     <tr>
                        <td>2</td>
                        <td>Mô hình</td>
                        <td>
                          <a href="tieuchi_2.html">
                            <button class="btn btn-success">
                                <i class="fas fa-info-circle"></i> Chi tiết
                            </button>
                          </a>
                            
                        </td>
                      </tr>

                      <tr>
                        <td>3</td>
                        <td>Cài đặt</td>
                        <td>
                          <a href="tieuchi_3.html">
                            <button class="btn btn-success">
                                <i class="fas fa-info-circle"></i> Chi tiết
                            </button>
                          </a>
                            
                        </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Demo minh họa chức năng phân quyền</td>
                        <td>
                          <a href="tieuchi_4.html">
                            <button class="btn btn-success">
                                <i class="fas fa-info-circle"></i> Chi tiết
                            </button>
                          </a>
                        </td>
                      </tr>
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
@endsection