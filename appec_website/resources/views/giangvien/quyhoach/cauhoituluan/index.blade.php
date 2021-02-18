@extends('giangvien.master')
@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<div class="content-wrapper" style="min-height: 96px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
             {{ $noidungqh->tenNoiDungQH }}<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('#') }}">Tên học phần</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('') }}">Nội dung quy hoạch</a></li>
            <li class="breadcrumb-item active">Chương quy hoạch</li>
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
              <h3 class="card-title"></h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  <i class="fas fa-plus"></i> Thêm chương quy hoạch
              </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/chuong/them-chuong-noi-dung-quy-hoach') }}" method="post">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chọn chương quy hoạch </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                       
                          <div class="form-group">
                            <label for="">Chọn chương:</label>
                            <select name="id_chuong" id="" class="form-control">
                              @foreach ($chuong_hp as $item)
                                <option value="{{ $item->id }}">{{ $item->tenchuong }}</option>
                                  
                              @endforeach
                            </select>
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
                    <th>Chương</th>
                    <th>Tùy chọn</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $i=1;
                  @endphp
                  @foreach ($chuong as $ch)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $ch->tenchuong }}</td>
                        <td>
                            <button>xem câu hỏi trong chương</button>
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