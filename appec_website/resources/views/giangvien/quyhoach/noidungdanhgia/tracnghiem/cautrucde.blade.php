@extends('giangvien.no_menu_master')
@section('content')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<div class="content-wrapper" style="min-height: 96px;">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">
                Cấu trúc đề thi trắc nghiệm<noscript></noscript>
                <nav></nav>
              </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item ">Nội dung đánh giá</li>
                <li class="breadcrumb-item ">Trắc ngiệm</li>
                <li class="breadcrumb-item active">Cấu trúc đề thi</li>
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
            <a class="btn btn-primary" href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/in-de-trac-nghiem/'.$dethi->maDe.'/'.$hocphan->maHocPhan) }}">Print</a>

                <div class="card-header">
                  <div class="row">
                    <div class="col-md-5">
                        <b>Trường: </b>Đại học Trà Vinh <br>
                        <b>Lớp:</b>......................... <br>
                        <b>Họ và tên:</b>................... 
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        KHOA KỸ THUẬT VÀ CÔNG NGHỆ <br>
                        <b>{{ $dethi->tenDe }}</b><br>
                        <b>Học phần:</b> {{ $hocphan->tenHocPhan }} <br>
                        <b>Thời gian thi:</b>  {{ $dethi->thoiGian }} phút <br>
                        <b>Mã đề:</b> {{ $dethi->maDeVB }}
                    </div>
                  </div>
                  <h3 class="card-title"></h3>
                <i>  {{ $dethi->ghiChu }}</i>
                </div>
                <div class="card-body">
                  @php
                      $index=1;
                  @endphp
                  @foreach ($noidung as $data) 
                      <b>Câu </b> {{ $index++ }} <b>({{ $data->diem }} điểm)</b>
                      {!! $data->noiDungCauHoi !!}
                      @for ($i = 0; $i < count($data->phuong_an); $i++)
                          @if ($data->phuong_an[$i]->isCorrect==true)
                              <b>{!! $data->phuong_an[$i]->noiDungPA !!}</b>
                          @else
                          {!! $data->phuong_an[$i]->noiDungPA !!}
                          @endif
                          
                      @endfor
                  @endforeach
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body" style="background-color: whitesmoke">
                  <h3>Adding new content form</h3>
                  <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/them-cau-hoi-trac-nghiem') }}" method="post">
                  @csrf
                    <input type="text" name="maDe" value="{{ $dethi->maDe }}" hidden>

                    <div class="form-group">
                      <table id="example2" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Order</th>
                          <th>Question</th>
                          <th>Choise</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $i=1;
                            $letter=['A','B','C','D'];
                        @endphp
                      @foreach ($cauhoi as $item)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{!! $item->noiDungCauHoi !!}
                            @for ($i = 0; $i < count($item->phuong_an_trac_nghiem); $i++)
                               @if ($item->phuong_an_trac_nghiem[$i]->isCorrect==true)
                                    <b>{!! $item->phuong_an_trac_nghiem[$i]->noiDungPA !!}</b>
                                @else
                                    {!! $item->phuong_an_trac_nghiem[$i]->noiDungPA !!}
                                @endif
                            @endfor
                          </td>
                          <td>
                            <input type="radio" id="ch_{{$item->maCauHoi }}" name="maCauHoi" value="{{$item->maCauHoi }}">
                          </td>
                        </tr> 
                      @endforeach
                      </tbody>
                      <tfoot></tfoot>
                    </table>
                    </div>
                  
                    <div class="form-group">
                      <button class="btn btn-primary" type="submit">Save</button>
                      <button class="btn btn-info" type="reset">Cancel</button>
                    </div>
                  </form>
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
