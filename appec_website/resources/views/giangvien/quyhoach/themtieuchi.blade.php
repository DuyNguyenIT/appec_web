@extends('giangvien.master')
@section('content')

 <!-- jQuery -->
 <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
 <!-- ChartJS -->
 <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>


<div class="content-wrapper" style="min-height: 96px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                Thêm tiêu chí đánh giá<noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active">Đồ án</li>
              <li class="breadcrumb-item active">Nội dung đánh giá</li>
              <li class="breadcrumb-item active">Nhóm tiêu chí đánh giá</li>
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
              <form action="{{ asset('giang-vien/quy-hoach-danh-gia/them-tieu-chi-submit') }}" method="post">
                @csrf
               
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <input type="text" name="maCTBaiQH" value="{{$maCTBaiQH}}"  hidden>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Chọn chuẩn đầu ra:</label>
                            <select name="maCDR3" id="" class="form-control">
                                @foreach ($cdr3 as $x)
                                    <option value="{{$x->maCDR3}}">{{$x->maCDR3VB}}: {{$x->tenCDR3}}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="fomr-group">
                            <label for="">Chọn kết quả học tập</label>
                            
                            <select name="maKQHT" id="" class="form-control">
                                @foreach ($kqht as $y)
                                    <option value="{{$y->maKQHT}}">{{$y->tenKQHT}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Chọn loại hình thức đánh giá:</label>
                            <select name="maLoaiHTDG" id="" class="form-control">
                                @foreach ($loai_htdg as $x)
                                    <option value="{{$x->maLoaiHTDG}}">{{$x->tenLoaiHTDG}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nhập nội dung yêu cầu đánh giá:</label>
                            <input type="text" name="noiDungCauHoi" class="form-control">
                        </div>
                        <hr>
                            <div class="form-group">
                                <label for="">Chọn nội dung quy hoạch:</label>
                                <select name="maNoiDungQH" id="maNoiDungQH" class="form-control" >
                                 
                                    @foreach ($ndqh as $z)
                                        <option value="{{$z->maNoiDungQH}}">{{$z->tenNoiDungQH}}</option>
                                    @endforeach
                        
                                  
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Chọn tiêu chuẩn:</label>
                                <div class="row">
                                    <div class="col-md-9">
                                        <select name="maTCDG" id="tenTCDG" class="form-control">
                                            @foreach ($tieuchuan as $tc)
                                                <option value="{{$tc->maTCDG}}">{{$tc->tenTCDG}} - {{$tc->diem}} điểm</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" href="" class="btn btn-primary" data-toggle="modal" data-target="#themTieuChuan">
                                            Thêm tiêu chuẩn
                                        </button>
                                    </div>
                                </div>
                            </div>
                        
                        

                        <div class="form-group">
                            <label for="">Chọn số tiêu chí cần nhập:</label>
                            <select name="" id="soTC" class="form-control" >
                                <option value="4">4</option>
                                <option value="6">6</option>
                                <option value="8">8</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tiêu chí</th>
                                        <th>Nội dung tiêu chí</th>
                                        <th>Điểm tiêu chí</th>
                                    </tr>     
                                </thead>
                                <tbody id="tbl-content">
                                @for ($i = 1; $i <= 4; $i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                            <input type='text' name="tenTCCD[]" class='form-control'>
                                        </td>
                                        <td>
                                            <input type='text' name="diemTCCD[]" class='form-control'>
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"> Lưu</button>
                        </div>

                    </div>
                <!-- /.card-body -->
                </div>
            </form>
            

            <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/them-tieu-chuan') }}" method="post">
                @csrf
                <!-- Modal -->
                <div class="modal fade" id="themTieuChuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm tiêu chuẩn</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <input type="text" hidden name="maNoiDungQH" id="maNoiDungQH" value="{{$ndqh[0]->maNoiDungQH}}">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for=""> Nhập tên tiêu chuẩn:</label>
                                    <input type="text" class="form-control" name="tenTCDG"> 
                                </div>
                                <div class="form-group">
                                    <label for="">Nhập điểm tiêu chuẩn:</label>
                                    <input type="text" class="form-control" name="diemTCDG">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
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
        var html="";
        $('#tbl-content').empty();
        for (let index = 1; index <= soTC; index++) {
            html+= "<tr>"+
                        "<td>"+index+"</td>"+
                        "<td>"+
                            "<input type='text' name='tenTCCD[]' class='form-control'>"+
                        "</td>"+
                        "<td>"+
                            "<input type='text' name='diemTCCD[]' class='form-control'>"+
                        "</td>"+
                    "</tr>"; 
        }
        $('#tbl-content').append(html);

    });

    $('#maNoiDungQH').on('change',function(){
        var maNoiDungQH=this.value;
        $('input[id=maNoiDungQH]').val(this.value);
        $.ajax({
            type:'GET',
            url:'/giang-vien/quy-hoach-danh-gia/get-tieu-chuan-by-NDQH/'+maNoiDungQH,
            success:function(data) {
                $('#tenTCDG').empty();
                $('#tenTCDG').append(data);
            }
        })
    })
  </script>
@endsection