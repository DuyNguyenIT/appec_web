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
                        <form action="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-tieu-chi-submit') }}"
                            method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">


                                    </h3>
                                    <div class="card-tools">
                                        <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.session::get('maCTBaiQH')) }}"
                                            class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                    </div>
                                    <input type="text" name="maCTBaiQH" value="{{ $maCTBaiQH }}" hidden>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="">{{ __('Planning Content') }}:</label>
                                        <select name="maNoiDungQH" id="maNoiDungQH" class="form-control select2" style="width:100%">
                                            @foreach ($ndqh as $z)
                                                @if (Session::has('maNoiDungQH') && Session::get('maNoiDungQH')==$z->maNoiDungQH)
                                                    <option value="{{ $z->maNoiDungQH }}" selected>{{ $z->tenNoiDungQH }}</option>
                                                @else
                                                    <option value="{{ $z->maNoiDungQH }}">{{ $z->tenNoiDungQH }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ __('Standard') }} (Theo thứ tự của phiếu chấm):</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="maTCDG" id="tenTCDG" class="form-control select2" style="width:100%" required>
                                                    @foreach ($tieuchuan as $tc)
                                                        @if (Session::has('maTCDG') && Session::has('maTCDG')==$tc->maTCDG)
                                                            <option value="{{ $tc->maTCDG }}" selected>{{ $tc->tenTCDG }} -
                                                                {{ $tc->diem }} {{ __('mark') }}</option>
                                                        @else
                                                            <option value="{{ $tc->maTCDG }}">{{ $tc->tenTCDG }} -
                                                                {{ $tc->diem }} {{ __('mark') }}</option>
                                                        @endif
                                                       
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" href="" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#themTieuChuan">
                                                    {{ __('Add') }} {{ __('Standard') }}
                                                </button>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-danger" id="delStand">
                                                    {{ __('Delete') }} {{ __('Standard') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                   
                                    <hr>
                                    <div class="fomr-group">
                                        <label for="">{{ __('Studying results') }}</label>
                                        <select name="maKQHT" id="maKQHT" class="form-control select2" style="width:100%">
                                            @foreach ($kqht as $y)
                                                @if (Session::has('maKQHT') && Session::get('maKQHT')==$y->maKQHT )
                                                <option value="{{ $y->maKQHT }}" selected>
                                                    {{ $y->maKQHTVB }}--{{ $y->tenKQHT }}</option>
                                                @else
                                                <option value="{{ $y->maKQHT }}">
                                                    {{ $y->maKQHTVB }}--{{ $y->tenKQHT }}</option>
                                                @endif
                                              
                                            @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                 
                                    <div class="form-group">
                                        <label for="">{{ __('Student Outcomes') }}:</label>
                                        <select name="maCDR3" id="maCDR3" class="form-control select2" style="width:100%" required>
                                            @foreach ($cdr3 as $x)
                                                @if (Session::has('maCDR3') && Session::get('maCDR3')==$x->maCDR3 )
                                                    <option value="{{ $x->maCDR3 }}" selected>{{ $x->maCDR3VB }}:
                                                        {{ $x->tenCDR3 }}
                                                    </option>
                                                @else
                                                    <option value="{{ $x->maCDR3 }}">{{ $x->maCDR3VB }}:
                                                        {{ $x->tenCDR3 }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Chọn số tiêu chí cần nhập:</label>
                                        <select name="" id="soTC" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
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
                                                @for ($i = 1; $i <= 1; $i++)
                                                    <tr>
                                                        <td>{{ $i }}</td>
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
                                        <button class="btn btn-primary" type="submit"> {{ __('Save') }}</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </form>

                        <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-tieu-chuan') }}"
                            method="post">
                            @csrf
                            <!-- Modal -->
                            <div class="modal fade" id="themTieuChuan" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <input type="text" hidden  name="maNoiDungQH" id="maNoiDungQH"
                                            value="{{ $ndqh[0]->maNoiDungQH }}">

                                         
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for=""> Nhập tên tiêu chuẩn:</label>
                                                <input type="text" class="form-control" name="tenTCDG">
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('mark') }}:</label>
                                                <input type="text" class="form-control" name="diemTCDG">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ __('Cancel') }}</button>
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
            var soTC = this.value;
            var html = "";
            $('#tbl-content').empty();
            for (let index = 1; index <= soTC; index++) {
                html += "<tr>" +
                    "<td>" + index + "</td>" +
                    "<td>" +
                    "<input type='text' name='tenTCCD[]' class='form-control'>" +
                    "</td>" +
                    "<td>" +
                    "<input type='text' name='diemTCCD[]' class='form-control'>" +
                    "</td>" +
                    "</tr>";
            }
            $('#tbl-content').append(html);
        });


        $('#maNoiDungQH').on('change', function() {
            var maNoiDungQH = this.value;
            $('input[id=maNoiDungQH]').val(this.value);
            $.ajax({
                type: 'GET',
                url: '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/get-tieu-chuan-by-NDQH/' + maNoiDungQH,
                success: function(data) {
                    $('#tenTCDG').empty();
                    $('#tenTCDG').append(data);
                }
            })

            $.ajax({
                type: 'GET',
                url: '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/get-kqht-by-NDQH/' + maNoiDungQH,
                success: function(data) {
                    $('#maKQHT').empty();
                    $('#maKQHT').append(data);
                }
            })

            $.ajax({
                type: 'GET',
                url: '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/get-cdr3-by-NDQH/' + maNoiDungQH,
                success: function(data) {
                    $('#maCDR3').empty();
                    $('#maCDR3').append(data);
                }
            })
        })

       

        $('select[name="maCDR3"]').change(function () { 
            
            var url='/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/get-abet-by-cdr3/'+$('select[name="maCDR3"]').val();
            $.ajax({
                type: "get",
                url: url,
                success: function (data) {
                    $('select[name="maChuanAbet"]').empty();
                    var html='';
                    data.forEach(element => {
                        html+="<option value='"+element['maChuanAbet']+"'>"+element['maChuanAbetVB']+"--"+element['tenChuanAbet']+"</option>";
                    });
                    $('select[name="maChuanAbet"]').append(html);
                }
            });
        });


        $('#delStand').click(function (e) { 
            e.preventDefault();
            var rs=confirm('Xóa tiêu chuẩn đang chọn');
            if(rs){
                var val=$("#tenTCDG option:selected").val();
                ///
                console.log(val);
                window.location.replace( '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xoa-tieu-chuan/' + val);
                // $.ajax({
                //     type: 'GET',
                //     url:
                // })
                // window. location. reload();
            }
        });

    </script>
@endsection
