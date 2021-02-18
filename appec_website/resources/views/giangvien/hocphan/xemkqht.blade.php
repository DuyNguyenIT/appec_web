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
                  kết quả học tập của học phần<noscript></noscript>
                  <nav></nav>
                </h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <a href="{{ asset('/giang-vien') }}">Trang chủ</a>
                  </li>
                  <li class="breadcrumb-item active">
                    <a href="{{ asset('/giang-vien/hoc-phan') }}">Học phần</a>
                  </li>
                  <li class="breadcrumb-item active">
                    kết quả học tập của học phần
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

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">
                      <!-- Button trigger modal -->
                      <button
                        type="button"
                        class="btn btn-primary"
                        data-toggle="modal"
                        data-target="#exampleModal"
                      >
                        <i class="fas fa-plus"></i> Thêm
                      </button>

                      <!-- Modal -->
                      <div
                        class="modal fade"
                        id="exampleModal"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">
                                Thêm kết quả học tập của học phần
                              </h5>
                              <button type="button" class="close"   data-dismiss="modal" aria-label="Close" >
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <label for="hocphan" style="font-size: 20px"
                                  >Nhập kết quả học tập của học phần:</label
                                >
                                <input   type="text"   class="form-control"  placeholder="Nhập kết quả học tập của học phần" style="width: 100%"
                                />
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
                    <table
                      id="example2"
                      class="table table-bordered table-hover"
                    >
                      <thead>
                        <tr>
                          <th>STT</th>
                          <th>Tên kết quả học tập của học phần</th>
                          <th>Đáp ứng chuẩn đầu ra </th>
                          <th>Tùy chọn</th>
                        </tr>
                      </thead>
                      <tbody>
                          @php
                              $i=1;
                              $dem=0; 
                          @endphp
                          @foreach ($kqht as $x)
                            @php
                                $rs=$x->groupBy("maKQHT")->count();
                                $dem=$dem+1;
                                if($dem>$rs)
                                  $dem=1;
                            @endphp
                            @if($dem==1)
                              {{$dem}}
                              <tr>
                                <td rowspan={{$rs}}>{{$i++}}</td>
                                <td rowspan={{$rs}}>{{$x->tenKQHT}}</td>
                                <td>{{$x->maCDR3VB}}--{{$x->tenCDR3}}</td>
                                <td rowspan={{$rs}}>
                                    
                                </td>
                              </tr>
                            @else
                              <tr>
                                <td>{{$x->maCDR3VB}}--{{$x->tenCDR3}}</td>
                              </tr>
                            @endif
                                               
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