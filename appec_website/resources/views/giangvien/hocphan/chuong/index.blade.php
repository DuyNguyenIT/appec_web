@extends('giangvien.master')
@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<div class="content-wrapper" style="min-height: 58px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            Nội dung học phần<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('giang-vien/hoc-phan') }}">{{$hocPhan->tenHocPhan}}</a></li>
            <li class="breadcrumb-item active">Nội dung học phần</li>
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
            <div class="card-header">
              <h3 class="card-title">
                  
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th >STT</th>
                    <th >Tên chương</th>
                    <th >Mô tả</th>
                    <th> Học phần</th>
                    <th >Tùy chọn</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @php
                      $i=1;
                  @endphp
                @foreach ($chuong as $item)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>{{$item->tenchuong}}</td>
                      <td>{!! html_entity_decode($item->mota) !!}</td>
                      <td>{{$item->hocphan->tenHocPhan}}</td>
                      <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$item->id}}">
                          <li class="fas fa-edit"></li>
                        </button>
                        <a href="{{ asset('/giang-vien/hoc-phan/chuong/'.$item->id.'/'.$item->tenkhongdau.'/cau-hoi-tu-luan') }}" class="btn btn-primary" ><i class="fas fa-th-list"></i> Câu hỏi tự luận</a>
                        <a href="" class="btn btn-danger" ><i class="fas fa-trash"></i></a>
                        <!-- Modal -->
                        <div class="modal fade" id="edit_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <form action="{{ asset('giang-vien/hoc-phan/chuong/suasubmit') }}" method="post">
                            @csrf
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <input type="text" name="id" value="{{$item->id}}" hidden>
                                <div class="form-group">
                                  <label for="">Nhập tên chương:</label>

                                  <input type="text" name="tenchuong" value="{{$item->tenchuong}}" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label for="">Nhập mô tả</label>
                                  <textarea name="mota" id="ckcontent_{{$item->id}}" class="form-control" cols="30" rows="10" required>
                                    {{$item->mota}}
                                  </textarea>
                                  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
                                  <script>
                                    CKEDITOR.replace( 'ckcontent_{{$item->id}}', {
                                        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                                        filebrowserUploadMethod: 'form'
                                    } );
                                </script>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                              </div>
                            </div>
                            </form>
                            
                          </div>
                        </div>
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