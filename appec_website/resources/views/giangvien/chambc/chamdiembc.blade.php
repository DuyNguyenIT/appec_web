@extends('giangvien.master')
@section('content')
<div class="content-wrapper" style="min-height: 123px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            Chấm điểm báo cáo<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Chấm điểm báo cáo</li>
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

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header"></div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" aria-describedby="example2_info">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên học phần</th>
                    
                    <th>Giảng viên giảng dạy</th>
                    <th>Học kì</th>
                    <th>Năm học</th>
                    <th>Lớp</th>
                    <th>Trạng thái</th>
                    <th>Tùy chọn</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $i=1;
                  @endphp
                  @foreach ($hocPhan as $hp)

                  <tr role="row" class="odd">
                    <td class="sorting_1 dtr-control">{{$i++}}</td>
                    <td>{{$hp[0]->tenHocPhan}}</td>
                    <td>{{$hp[0]->hoGV}} {{$hp[0]->tenGV}}</td>
                    <td>{{$hp[0]->maHK}}</td>
                    <td>{{$hp[0]->namHoc}}</td>
                    <td>{{$hp[0]->maLop}}</td>
                    <td>Đang chờ</td>
                    <td>
                      <a href="{{ asset('giang-vien/cham-diem-bao-cao/noi-dung-danh-gia/'.$hp[0]->maBaiQH.'/'.$hp[0]->maHocPhan) }}">
                        <button class="btn btn-success">
                          <i class="fas fa-align-justify"></i> Tiến hành
                          đánh giá
                        </button>
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