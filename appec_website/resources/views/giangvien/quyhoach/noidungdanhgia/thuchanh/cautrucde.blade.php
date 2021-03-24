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
                Cấu trúc đề thi<noscript></noscript>
                <nav></nav>
              </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ asset('gian-vien') }}">Trang chủ</a></li>
                <li class="breadcrumb-item "><a href="{{ asset('/giang-vien/quy-hoach-danh-gia') }}">Nội dung đánh giá</a></li>
                <li class="breadcrumb-item "><a href="#"></a> Thực hành</li>
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
                <a class="btn btn-primary" href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/in-de-thuc-hanh/'.$dethi->maDe.'/'.$hocphan->maHocPhan) }}">Print</a>

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
                      $i=1;
                  @endphp
                  @foreach ($noidung as $data)
                        <b>Câu </b> {{ $i++ }} <b>({{ $data->diem }}điểm)</b> 
                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete this question?')" 
                        href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/xoa-cau-hoi-de-thuc-hanh/'.$dethi->maDe.'/'.$data->maCauHoi) }}"><i class="fa fa-trash"></i></a>
                      {!! $data->noiDungCauHoi !!}
                  @endforeach
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body" style="background-color: whitesmoke">
                  <h3>Adding new content form</h3>
                  <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/them-cau-hoi-de-thuc-hanh') }}" method="post">
                  @csrf
                    <input type="text" name="maDe" value="{{ $dethi->maDe }}" hidden>
                    <div class="form-group">
                      <label for="">Chọn chuẩn đầu ra:</label>
                      <select name="maCDR3" id="" class="form-control" required>
                        @foreach ($cdr3 as $data)
                            <option value="{{ $data->maCDR3 }}">{{ $data->maCDR3VB }}--{{ $data->tenCDR3 }}</option>
                        @endforeach
                      </select>
                    </div>
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
                        @endphp
                      @foreach ($cauhoi as $item)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{!! $item->noiDungCauHoi !!}</td>
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
                      <div class="form-group">
                        <label for="">Chọn số ý trả lời:</label>
                        <select name="" id="soTC" class="form-control" >
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-group">
                        <div id="tbl-content">
                          <div class='form-group'>"
                            <label for=''>Nhập nội dung ý:</label>
                            <textarea name='phuongAn[]' id='ckcontent_1' cols='30' rows='10' class='form-control' required></textarea>
                            <label for=''>Nhập điểm</label>
                            <input type='text' name='diem[]' class='form-control'>
                          </div>
                          <script>
                            CKEDITOR.replace( 'ckcontent_1', {
                                filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                                filebrowserUploadMethod: 'form'
                            } );
                          </script>
                        </div>
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
<script>
   $('#soTC').on('change', function() {
        var soTC= this.value;
        console.log(soTC);
        var html="";
        $('#tbl-content').empty();
        for (let index = 1; index <= soTC; index++) {
            html+= "<div class='form-group'>"+
                  "<label for=''>Nhập nội dung ý:</label>"+
                  "<textarea name='phuongAn[]' id='ckcontent_"+index+"' cols='30' rows='10' class='form-control' required></textarea>"+
                  "<label for=''>Nhập điểm</label>"+
                  "<input type='text' name='diem[]' class='form-control'>"+
                  "</div>";
        }
        console.log(html);
        $('#tbl-content').append(html);
        for (let index = 1; index <=soTC; index++) {
          CKEDITOR.replace( 'ckcontent_'+index, {
                filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            } );
        }
    });
</script>
@endsection