@extends('admin.master')

@section('content')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                  Education level<noscript></noscript>
                  <nav></nav>
                </h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Education level</li>
                </ol>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      <i class="fas fa-plus"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form action="/quan-ly/bac-dao-tao/them" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Adding a new education level</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                  <label for="">Nhập mã bậc đào tạo</label>
                                  <input type="text" name="maBac" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label for="">Nhập tên bậc đào tạo</label>
                                  <input type="text" name="tenBac" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Save</button>

                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                          </div>
                        </form>
                        
                      </div>
                    </div>
                  </div>

                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover" >
                      <thead>
                        <tr>
                          <th>Order</th>
                          <th>ID</th>
                          <th>education level name</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($bdt as $item)
                            <tr>
                              <td>{{$i++}}</td>
                              <td>{{$item->maBac}}</td>
                              <td>{{$item->tenBac}}</td>
                              <td>
                                  
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$item->maBac}}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Modal edit-->
                                    <div class="modal fade" id="edit_{{$item->maBac}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        {{-- form --}}
                                        <form action="{{ asset('quan-ly/bac-dao-tao/sua') }}" method="post" enctype="multipart/form-data">
                                          @csrf
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="form-group">
                                              <input type="text" class="form-control" hidden name="maBac" value="{{$item->maBac}}">
                                              </div>
                                              <div class="form-group">
                                                <label for="">Tên bậc đào tạo</label>
                                                <input type="text" name="tenBac" class="form-control" value="{{$item->tenBac}}">
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="submit" class="btn btn-primary">Lưu</button>
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                            </div>
                                          </div>
                                        </form>
                                      {{-- end form --}}
                                      </div>
                                    </div>
                                    <!-- end Modal edit-->

                                  <a class="btn btn-danger" onclick="return confirm('Bạn có muốn xóa {{$item->tenBac}}?')" href="{{ asset('quan-ly/bac-dao-tao/xoa/'.$item->maBac) }}"><i class="fa fa-trash"></i></a>
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