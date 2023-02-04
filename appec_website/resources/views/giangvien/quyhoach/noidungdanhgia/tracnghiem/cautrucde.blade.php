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
        .picklist {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            -webkit-box-align: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
            height: 100%;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        .btn-move {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            display: block;
             width: 100%;
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
                            {{ __("Exam structure") }} <noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item ">
                                <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.Session::get('maHocPhan').'/'.Session::get('maBaiQH').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maLop')) }}">
                                        Planing assessment
                                </a>
                            </li>
                            <li class="breadcrumb-item ">
                                <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH')) }}">
                                    Multiple choices question
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ __("Exam structure") }}</li>
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
                                        <b>School: </b>Tra Vinh University <br>
                                        <b>Class:</b>......................... <br>
                                        <b>Full name:</b>...................
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                        SCHOOL OF ENGINEERING AND TECHONOLOGY <br>
                                        <b>{{ $dethi->tenDe }}</b><br>
                                        <b>Course:</b> 
                                        @if (Session::get('language') && Session::get('language')=='en')
                                        {{ $hocphan->tenHocPhanEN }} 
                                        @else
                                        {{ $hocphan->tenHocPhan }} 
                                        @endif    
                                        
                                            <br>
                                        <b>Duration:</b> {{ $dethi->thoiGian }} minutes <br>
                                        <b>The number of question:</b> {{ $dethi->soCauHoi }} <br>
                                        <b>Exam ID:</b> {{ $dethi->maDeVB }}
                                    </div>
                                </div>
                                <i> {{ $dethi->ghiChu }}</i>
                            </div>
                            <div class="card-footer">
                                @if ($dem_cau_hoi < $dethi->soCauHoi)
                                    <span style="color: red">*Currently: {{ $dem_cau_hoi }}/{{ $dethi->soCauHoi }} questions</span>
                                @else
                                    <span style="color: green">Fully: {{ $dem_cau_hoi }}/{{ $dethi->soCauHoi }} questions</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <input type="checkbox" name="check_all" >Select all
                                <script>
                                   $('input[name="check_all"]').click(function() {
                                        if ($(this).is(':checked')) {
                                            $('input[name="select_all[]"]').prop('checked', true);
                                        }else{
                                            $('input[name="select_all[]"]').prop('checked', false);
                                        }
                                    });
                                </script>
                            </div>
                            <div class="card-body">
                                @php
                                    $index = 1;
                                    
                                @endphp
                                
                                <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/xoa-nhieu-cau-hoi-trac-nghiem') }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">  <i class="fas fa-trash"></i> Delete all questions</button>
                                    <br>
                                    @foreach ($noidung as $data)
                                        <a onclick="return confirm('Confirm?')"
                                            href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/xoa-cau-hoi-trac-nghiem/' . $data->maCauHoi) }}">
                                            <i class="fas fa-trash"></i>
                                        </a>    
                                        <b>Question </b> {{ $index++ }} <b>({{ $data->diem }} mark) </b>  <input type="checkbox" name="select_all[]" value="{{ $data->maCauHoi }}"> <br>
                                        {!! $data->noiDungCauHoi !!}<br>
                                        @for ($i = 0; $i < count($data->phuong_an); $i++)
                                            @if ($data->phuong_an[$i]->isCorrect == true)
                                                <b> {!! $data->phuong_an[$i]->noiDungPA !!}</b> <br>
                                            @else
                                                {!! $data->phuong_an[$i]->noiDungPA !!} <br>
                                            @endif
                                        @endfor
                                    @endforeach
                                </form>
                                
                            </div>
                            <div class="card-footer">
                                @if ($dem_cau_hoi < $dethi->soCauHoi)
                                    <span style="color: red">*Currently: {{ $dem_cau_hoi }}/{{ $dethi->soCauHoi }} question</span>
                                @else
                                    <span style="color: green">Fully: {{ $dem_cau_hoi }}/{{ $dethi->soCauHoi }} question</span>
                                @endif
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <div class="form-group">
                                    <label for="">{{ __('Chapter') }}</label>
                                    <select name="maChuong" id="chuong" class="form-control select2" style="width:100%">
                                        <option value="-1">{{ __('All') }}</option>
                                        @foreach ($chuong as $chg)
                                            <option value="{{ $chg->id }}">{{ $chg->tenchuong }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">{{ __('Items') }}</label>
                                    <select name="maMuc" id="muc" class="form-control select2" style="width:100%">
                                        <option value="-1">{{ __('All') }}</option>
                                        @foreach ($muc as $m)
                                            <option value="{{ $m->id }}">{{ $m->maMucVB }}: {{ $m->tenMuc }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="jp-multiselect picklist" style="">
                                    <div class="from-panel">
                                        <select name="from[]" id="from_box" class="form-control"  size="18"
                                        
                                            multiple="multiple">
                                        </select>
                                    </div>
                                    <div class="move-panel">
                                        <button type="button"  class="btn-sm btn-move btn-move-all-right"></button>
                                        <button type="button" class="btn-sm btn-move btn-move-selected-right "></button>
                                        <button type="button" class="btn-sm btn-move btn-move-all-left"></button>
                                        <button type="button" class="btn-sm btn-move btn-move-selected-left"></button>
                                    </div>
                                    <div class="to-panel">
                                        <select name="to[]" id="to_box" class="form-control" size="8" multiple="multiple">
                                        </select>
                                    </div>
                                    <div class="control-panel">
                                        <button type="button" class="btn-sm btn-move btn-delete"></button>
                                        <button type="button" class="btn-sm btn-move btn-up"></button>
                                        <button type="button" class="btn-sm btn-move btn-down"></button>
                                        <button type="button" class="btn-sm btn-move" id="get">get</button>
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
            //console.log(data);
          
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
