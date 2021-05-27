@extends('giangvien.no_menu_master')
@section('content')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/dist/css/jquery-multi-selection.css') }}" />
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('/dist/js/jquery.multi-selection.v1.js') }}"></script>
    <style>
        .jp-multiselect select {
            max-height: 130px;
        }

    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- ------------------------------------------------------------------------ --}}
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
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">Trang chủ</a></li>
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
                            <div class="card-header">
                                <h3 class="card-title">
                                </h3>
                                <div class="card-tools">
                                    {{-- <a class="btn btn-primary"
                                        href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/in-de-trac-nghiem/' . $dethi->maDe . '/' . $hocphan->maHocPhan) }}">
                                        <i class="fas fa-download"></i>
                                    </a> --}}
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/' . Session::get('maCTBaiQH')) }}"
                                        class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" name="maDe" value="{{ $dethi->maDe }}" hidden>
                                        <b>Trường: </b>Đại học Trà Vinh <br>
                                        <b>Lớp:</b>......................... <br>
                                        <b>Họ và tên:</b>...................
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                        KHOA KỸ THUẬT VÀ CÔNG NGHỆ <br>
                                        <b>{{ $dethi->tenDe }}</b><br>
                                        <b>Học phần:</b> {{ $hocphan->tenHocPhan }} <br>
                                        <b>Thời gian thi:</b> {{ $dethi->thoiGian }} phút <br>
                                        <b>Số câu hỏi:</b> {{ $dethi->soCauHoi }} <br>
                                        <b>Mã đề:</b> {{ $dethi->maDeVB }}
                                    </div>
                                </div>
                                <i> {{ $dethi->ghiChu }}</i>
                            </div>
                            <div class="card-footer">
                                @if ($dem_cau_hoi < $dethi->soCauHoi)
                                    <span style="color: red">*Hiện có: {{ $dem_cau_hoi }}/{{ $dethi->soCauHoi }} Câu
                                        hỏi</span>
                                @else
                                    <span style="color: green">Đã đủ: {{ $dem_cau_hoi }}/{{ $dethi->soCauHoi }} Câu
                                        hỏi</span>
                                @endif
                            </div>
                            <div class="card-body">
                                @php
                                    $index = 1;
                                    
                                @endphp
                                @foreach ($noidung as $data)
                                <a onclick="return confirm('Confirm?')"
                                href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/xoa-cau-hoi-trac-nghiem/' . $data->maCauHoi) }}">
                                <i class="fas fa-trash"></i>
                            </a>    
                                    <b>Câu </b> {{ $index++ }} <b>({{ $data->diem }} điểm)</b> <br>
                                    {!! $data->noiDungCauHoi !!}<br>
                                    @for ($i = 0; $i < count($data->phuong_an); $i++)
                                        @if ($data->phuong_an[$i]->isCorrect == true)
                                            <b> {!! $data->phuong_an[$i]->noiDungPA !!}</b> <br>
                                        @else
                                            {!! $data->phuong_an[$i]->noiDungPA !!} <br>
                                        @endif
                                    @endfor
                                @endforeach
                            </div>
                            <div class="card-footer">
                                @if ($dem_cau_hoi < $dethi->soCauHoi)
                                    <span style="color: red">*Hiện có: {{ $dem_cau_hoi }}/{{ $dethi->soCauHoi }} Câu
                                        hỏi</span>
                                @else
                                    <span style="color: green">Đã đủ: {{ $dem_cau_hoi }}/{{ $dethi->soCauHoi }} Câu
                                        hỏi</span>
                                @endif
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <div class="form-group">
                                    <label for="">{{ __('Chapter') }}</label>
                                    <select name="maChuong" id="chuong" class="form-control">
                                        <option value="-1">{{ __('All') }}</option>
                                        @foreach ($chuong as $chg)
                                            <option value="{{ $chg->id }}">{{ $chg->tenchuong }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">{{ __('Items') }}</label>
                                    <select name="maMuc" id="muc" class="form-control">
                                        <option value="-1">{{ __('All') }}</option>
                                        @foreach ($muc as $m)
                                            <option value="{{ $m->id }}">{{ $m->maMucVB }}: {{ $m->tenMuc }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="jp-multiselect">
                                    <div class="from-panel">
                                        <select name="from[]" id="from_box" class="form-control" size="8"
                                            multiple="multiple">
                                        </select>
                                    </div>
                                    <div class="move-panel">
                                        <button type="button" class="btn-move-all-right"></button>
                                        <button type="button" class="btn-move-selected-right "></button>
                                        <button type="button" class="btn-move-all-left"></button>
                                        <button type="button" class="btn-move-selected-left"></button>
                                    </div>
                                    <div class="to-panel">
                                        <select name="to[]" id="to_box" class="form-control" size="8" multiple="multiple">
                                        </select>
                                    </div>
                                    <div class="control-panel">
                                        <button type="button" class="btn-delete"></button>
                                        <button type="button" class="btn-up"></button>
                                        <button type="button" class="btn-down"></button>
                                        <button type="button" id="get">get</button>
                                    </div>
                                  
                                </div>
                                <script>
                                    $(".jp-multiselect").jQueryMultiSelection();

                                </script>
                            </div>
                            {{-- /card --}}
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    {{-- ---------------------------------------------------------------------------------- --}}
    <script>
        //function chuong
        $('#chuong').change(function() {
            $('select[id="from_box"]').empty();
            var ajaxurl = '/giang-vien/hoc-phan/chuong/muc/get-muc-by-machuong/' + $(this).val();
            $.ajax({
                type: 'get',
                url: ajaxurl,
                success: function(rsp) {
                    var option = "<option value='-1'>All</option>";
                    rsp.forEach(element => {
                        option += "<option value='" + element['id'] + "'>" + element[
                            'maMucVB'] + "--" + element['tenMuc'] + "</option>";
                    });
                    $('#muc').empty();
                    $('#muc').append(option);
                },
                error: function(rsp) {
                    console.log(rsp);
                }
            });
        })
        //function muc
        $('#muc').change(function() {
            var muc_url = '/giang-vien/hoc-phan/chuong/muc/get-cau-hoi-trac-nghiem-by-mamuc/' + $(this).val();
            $.ajax({
                type: 'get',
                url: muc_url,
                success: function(rsp) {
                    var option = "";
                    rsp.forEach(element => {
                        option += "<option value='" + element['maCauHoi'] + "'>" + element[
                            'noiDungCauHoi'] + "</option>";
                    });
                    $('select[id="from_box"]').empty();
                    $('select[id="from_box"]').append(option);
                },
                error: function(rsp) {
                    console.log(rsp);
                }
            });
        })
        //function get
        $('#get').click(function() {
            var to_box = [];
            $("select#to_box").map(function() {
                return $(this).val();
            }).get();
            // First, get the elements into a list
            var options = $('#to_box option'),
                data = [],
                $i = 0;
            var values = $.map(options, function(option) {
                to_box.push(option.value);
                data.push({
                    'id': option.value,
                    'noidung': option.value
                });
                $i++;
            });
            console.log(data);
          
            var url_cau_hoi =
                '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/them-cau-hoi-trac-nghiem';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                type: 'post',
                url: url_cau_hoi,
                data: {
                    array: data,
                    _token: '{{ csrf_token() }}'
                 },
                success: function(rsp) {
                    //alert(rsp)
                    //console.log(rsp);
                    window.location.href = rsp;
                }
            })
        })


    </script>
@endsection
