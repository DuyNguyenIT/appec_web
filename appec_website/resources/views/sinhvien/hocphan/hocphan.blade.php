@extends('sinhvien.master')
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
                  
                  
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     
                    </div><table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Tên học phần </th>
                      <th>Năm học</th>
                      <th>Học kì</th>
                      <th>Tên giảng viên</th>
                      <th>Tùy chọn</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($giangday as $data)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $data->tenHocPhan }}</td>
                        <td>{{ $data->namHoc }}</td>
                        <td>{{ $data->maHK }}</td>
                        <td>
                            @foreach ($data->GV as $gv)
                            {{ $gv->hoGV }} {{ $gv->tenGV }}
                        @endforeach
                    </td>
                        
                        <td>
                            <a id="status" href="{{ asset('sinh-vien/hoc-phan/khao-sat-hoc-phan/' . $data->maHocPhan . '/' . $data->maLop) }}" class="btn btn-primary" data-status="true" >
                                <i class="fas fa-list-ol"></i> Khảo sát 
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