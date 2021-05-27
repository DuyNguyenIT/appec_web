{{-- @extends('sinhvien.master') --}}
@extends('sinhvien.khaosatmaster')
@section('content')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <div class="content-wrapper" style="min-height: 155px;">
      <div class="container-fluid pt-2">
        <h1 style="text-align: center">PHIẾU KHẢO SÁT <br></h1>
        <h4 style="text-align: center"> Môn: {{ $hocPhan->tenHocPhan }} <br>
            Mã học phần: {{ $hocPhan->maHocPhan }}<br>
            Tên sinh viên: {{ Session::get('HoSV') }} {{ Session::get('TenSV') }}<br>
            Lớp: {{ $lop->maLop }}
        </h4>
    </div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Khảo sát môn học<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('sinh-vien/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Khảo sát môn học</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <form name="khaosat" id="khaosat">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">

                                            </div>
                                        </div>
                                        
                                    </h3>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-check"></i> Thông báo!</h5>
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('warning'))
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Thông báo!</h5>
                                        {{ session('warning') }}
                                    </div>
                                @endif
                                <!-- /.card-header -->
                                <input type="text" id="kqht" value="{{ $kqht }}" hidden>
                             
                                <div class="card-body">
                                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6"></div>
                                            <div class="col-sm-12 col-md-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="example2"
                                                    class="table table-bordered table-hover dataTable no-footer dtr-inline"
                                                    role="grid" aria-describedby="example2_info">
                                                    <thead>
                                                        <tr class="table-primary" style="text-align: center">
                                                            <th rowspan="2" style="vertical-align: middle; width: 7%;">STT
                                                            </th>
                                                            <th rowspan="2" style="vertical-align: middle; width: 10%;">Mã
                                                                kết quả học tập</th>
                                                            <th rowspan="2" style="vertical-align: middle; width: 34%;">Kết
                                                                quả học tập</th>
                                                            <th colspan="6">Mức độ đánh giá</th>
                                                        </tr>
                                                        <tr class="table-primary">
                                                            <th style="width: 8%;">Nhớ</th>
                                                            <th style="width: 8%;">Hiểu</th>
                                                            <th style="width: 8%;">Vận dụng</th>
                                                            <th style="width: 8%;">Phân tích</th>
                                                            <th style="width: 8%;">Đánh giá</th>
                                                            <th style="width: 9%;">Sáng tạo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($CDR1 as $cdr1)
                                                            <tr>
                                                                <td colspan="9"><b>Chủ đề {{ $cdr1->maCDR1VB }}:
                                                                        {{ $cdr1->tenCDR1 }}:</b>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $j = 1;
                                                                $cur_rs = 0;
                                                                $i = 0;
                                                            @endphp
                                                            @foreach ($kqht as $x)
                                                                @if ($x->maCDR1 == $cdr1->maCDR1)
                                                                    @php
                                                                        $rs = $kqht
                                                                            ->where('maCDR1', $cdr1->maCDR1)
                                                                            ->where('maKQHT', $x->maKQHT)
                                                                            ->groupBy('maKQHT')
                                                                            ->count();
                                                                        
                                                                        if ($i >= $rs || $rs > $cur_rs) {
                                                                            $cur_rs = $rs;
                                                                            $i = 1;
                                                                        } else {
                                                                            $i += 1;
                                                                        }
                                                                    @endphp
                                                                    @if ($i == 1)
                                                                        <tr id="co">
                                                                            <td class="td-center" style="width: 7%;">
                                                                                {{ $j++ }}</td>
                                                                            <td class="td-center" style="width: 10%;"
                                                                                rowspan={{ $rs }}>
                                                                                {{ $x->maKQHTVB }} </td>
                                                                            <td style="vertical-align: middle; width: 35%;"
                                                                                rowspan={{ $rs }}>
                                                                                {{ $x->tenKQHT }}</td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_1"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="1" title="Nhớ">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_2"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="2" title="Hiểu">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_3"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="3" title="Vận dụng">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_4"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="4" title="Phân tích">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_5"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="5" title="Đánh giá">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_6"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="6" title="Sáng tạo">
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr id="co">
                                                                            <td class="td-center" style="width: 10%;"
                                                                                rowspan={{ $rs }}>
                                                                                {{ $x->maKQHTVB }} :</td>
                                                                            <td style="vertical-align: middle; width: 35%;"
                                                                                rowspan={{ $rs }}>
                                                                                {{ $x->tenKQHT }}</td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_1"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="1" title="Nhớ">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_2"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="2" title="Hiểu">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_3"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="3" title="Vận dụng">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_4"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="4" title="Phân tích">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_5"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="5" title="Đánh giá">
                                                                            </td>
                                                                            <td class="td-center" style="width: 8%;">
                                                                                <input type="radio" id="muc_6"
                                                                                    name="muc_{{ $x->maKQHT }}"
                                                                                    value="6" title="Sáng tạo">
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                    </tfoot>
                                                </table>
                                                <button type="button" style="margin-left: 90%" id="submit"
                                                    class="btn btn-success " 
                                                    onclick="return confirm('Bạn có muốn gửi khảo sát không ?')">Gửi</button>
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
        </form>
        <script>
            //-----------------
            $(document).ready(function() {

                $('#submit').click(function(e) { //khi bam gui
                   
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#submit').html('Sending..');
                    console.log('Hello');
                    ////kiem tra da check
                    var $kqht = $("#kqht").val(); //lay mang gia tri kqhht tu input text
                    console.log($kqht);
                    var data = $.parseJSON($kqht); //chuyen tu mang string sang json
                    console.log(data);
                    //kiem tra radio button da duoc chon 
                    let demFalse = 0;
                    let ktra = [];
                    $.each(data, function(i, v) //chay tung phan tu trong mang json
                        {
                            //kiem tra radio button da duoc chon 
                            if ($('input[type="radio"][name="' + 'muc_' + v['maKQHT'] + '"]').is(
                                    ':checked') == false) {
                                demFalse += 1;
                                ktra.push(v['maKQHTVB']);
                            }
                        });

                    if (demFalse > 0) {
                        alert('Vui lòng chọn mức độ !!!' + ktra);
                        location.hash = '#co';
                        var divPosition = $('#co').offset();
                        $('tbody').animate({scrollTop: divPosition.top}, 950); //"slow"                     
                        return false;
                    } else {
                        $.ajax({
                            url: "{{ asset('/sinh-vien/hoc-phan/pks-kqht/guiks-kqht/' . $hocPhan->maHocPhan) }}",
                            method: 'POST',
                            data: $('#khaosat').serialize(),
                            success: function(data) {
                                $('#submit').html('Gửi');
                                $("#submit"). attr("disabled", true);
                               
                                alert('Gửi thành công !!!');  
                                document.getElementById("khaosat").reset();
                                console.log('Submission was successful.');
                                console.log(data); 
                                location.replace("{{ asset('/sinh-vien/hoc-phan/')}}");  
                             // history.back();  
                              
                              
                            }
                        });
                        return false;
                    }
                    //end xu ly gui
                });
                //-----end document
            });
            //------------

        </script>



    </div>
@endsection
