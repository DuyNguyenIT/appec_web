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
                  {{ __('Multiple Choice Exam') }}<noscript></noscript>
                  <nav></nav>
                </h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <a href="{{ asset('/giang-vien') }}">{{ __('Home') }}</a>
                  </li>
                  <li class="breadcrumb-item">
                    <a href="#">{{ __('Multiple Choice Exam') }}</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">{{ __('Assessment Content') }}</a></li>
                  <li class="breadcrumb-item active">{{ __('Viewing') }} {{ __('Assessment content') }}</li>
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
                            <i class="fas fa-plus"></i>{{ __('Adding a new Exam') }}
                          </button>
                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-de-thi-trac-nghiem-submit') }}" method="post">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">{{ __('Adding a new Exam') }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="">{{ __('Exame ID') }}</label>
                                    <input type="text" class="form-control" name="maDeVB" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="">{{ __('Title') }}</label>
                                    <input type="text" class="form-control" name="tenDe" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="">{{ __('Duration') }} ({{ __('minutes') }})</label>
                                    <input type="number" class="form-control"  name="thoiGian" min="30" max="180">
                                  </div>
                                  <div class="form-group">
                                    <label for="">The number of question</label>
                                    <input type="number" class="form-control" name="soCauHoi" min="1" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="">Note</label>
                                    <input type="text" class="form-control" name="ghiChu">
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
                    {{-- <div class="card-header">Giảng viên cộng tác: <b>Võ Thành C</b></div> --}}
                    <!-- /.card-header -->
                  
                    <div class="card-body">
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Order</th>
                            <th>Exame ID</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>The number of question</th>
                            <th>Note</th>
                            <th>Option</th>
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
                                  <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.$data->maDe) }}" class="btn btn-primary">Cấu trúc nội dung</a>
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