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
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item "><a href="{{ asset('/giang-vien/quy-hoach-danh-gia') }}">Nội dung
                                    đánh giá</a></li>
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
                           
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary"
                                    href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/in-de-thuc-hanh/' . $dethi->maDe . '/' . $hocphan->maHocPhan) }}">
                                    <i class="fas fa-download"></i></a>
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/' . Session::get('maCTBaiQH')) }}"
                                    class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                </div>

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
                                        <b>Thời gian thi:</b> {{ $dethi->thoiGian }} phút <br>
                                        <b>Mã đề:</b> {{ $dethi->maDeVB }}
                                    </div>
                                </div>
                                <h3 class="card-title"></h3>
                                <i> {{ $dethi->ghiChu }}</i>
                            </div>
                            
                            <div class="card-body">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($noidung as $data)
                                <a title="Delete" class="btn btn-danger"
                                onclick="return confirm('Do you want to delete this question?')"
                                href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/xoa-cau-hoi-de-thuc-hanh/' . $dethi->maDe . '/' . $data->maCauHoi) }}"><i
                                    class="fa fa-trash"></i></a>
                                    <b>Câu </b> {{ $i++ }} <b>({{ $data->diem }}điểm)</b>
                                   
                                    {!! $data->noiDungCauHoi !!}
                                    <div class="card" style="background-color: rgb(166, 243, 239); display:float">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Phương án trả lời:
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                  <i class="fas fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                                  <i class="fas fa-times"></i>
                                                </button>
                                              </div>
                                        </div>
                                        
                                        <div class="card-body">
                                            @for ($k = 0; $k < count($data->phuongAn); $k++)
                                            [{{ $k + 1 }}] ({{ $data->phuongAn[$k]->diemPA }}
                                            điểm)(ABET:{{ $data->phuongAn[$k]->maChuanAbetVB }})(CDR3:{{ $data->phuongAn[$k]->maCDR3VB }}):
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#editPA_{{ $data->phuongAn[$k]->id }}">
                                                <li class="fas fa-edit"></li>
                                            </button>
                                            {!! $data->phuongAn[$k]->noiDungPA !!}
                                            <!-- Modal -->
                                            <div class="modal fade" id="editPA_{{ $data->phuongAn[$k]->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <form
                                                        action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/sua-phuong-an-thuc-hanh') }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa
                                                                    phương án</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input type="text" name="id"
                                                                        value="{{ $data->phuongAn[$k]->id }}" hidden>
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea name="noiDungPA"
                                                                        id="edit_PA_{{ $data->phuongAn[$k]->id }}"
                                                                        cols="30" rows="10">
                                              {!! $data->phuongAn[$k]->noiDungPA !!}
                                              </textarea>
                                                                    <script>
                                                                        CKEDITOR.replace("edit_PA_" +
                                                                            {{ $data->phuongAn[$k]->id }}, {
                                                                                filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
                                                                                filebrowserUploadMethod: 'form'
                                                                            });

                                                                    </script>
                                                                </div>
                                                                <div class="from-group">
                                                                    <label for="">chọn chuẩn đầu ra abet:</label>
                                                                    <select name="maChuanAbet" id="" class="form-control">
                                                                        @foreach ($abet as $ab)
                                                                            @if ($data->phuongAn[$k]->maChuanAbet == $ab->maChuanAbet)
                                                                                <option value="{{ $ab->maChuanAbet }}"
                                                                                    selected>
                                                                                    {{ $ab->maChuanAbetVB }}--{{ $ab->tenChuanAbet }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $ab->maChuanAbet }}">
                                                                                    {{ $ab->maChuanAbetVB }}--{{ $ab->tenChuanAbet }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Điểm phương án</label>
                                                                    <input type="text" name="diemPA"
                                                                        value="{{ $data->phuongAn[$k]->diemPA }}"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="from-group">
                                                                    <label for="">chọn chuẩn đầu ra 3:</label>
                                                                    <select name="maCDR3" id="" class="form-control">
                                                                        @foreach ($cdr3 as $cd)
                                                                            @if ($data->phuongAn[$k]->maCDR3 == $cd->maCDR3)
                                                                                <option value="{{ $cd->maCDR3 }}"
                                                                                    selected>
                                                                                    {{ $cd->maCDR3VB }}--{{ $cd->tenCDR3 }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $cd->maCDR3 }}">
                                                                                    {{ $cd->maCDR3VB }}--{{ $cd->tenCDR3 }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endfor
                                        </div>

                                    </div>
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
                        <div class="card card-info card-outline">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <h3>{{ __('Questions list') }}</h3>
                                </h5>
                                <p class="card-text">
                                    <!-- /.card-header -->
                                <div class="card-body" style="background-color: whitesmoke">
                                    <form
                                        action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/them-cau-hoi-de-thuc-hanh') }}"
                                        method="post">
                                        @csrf
                                        <input type="text" name="maDe" value="{{ $dethi->maDe }}" hidden>
                                        <div class="form-group">
                                            <label for="">{{ __('SOs') }}:</label>
                                            <select name="maCDR3" id="them_maCDR3" class="form-control" required>
                                                @foreach ($cdr3 as $data)
                                                    <option value="{{ $data->maCDR3 }}">
                                                        {{ $data->maCDR3VB }}--{{ $data->tenCDR3 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __("ABET's SO") }}:</label>
                                            <select name="maChuanAbet" id="them_maChuanAbet" class="form-control">
                                                @foreach ($abet as $ab)
                                                    <option value="{{ $ab->maChuanAbet }}">
                                                        {{ $ab->maChuanAbetVB }}--{{ $ab->tenChuanAbet }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                                        <div class="form-group">
                                            <label>  {{ __('Questions list') }}</label>
                                            <table id="example2" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('No.') }}</th>
                                                        <th>{{ __('Question') }}</th>
                                                        <th>{{ __('Choise') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($cauhoi as $item)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{!! $item->noiDungCauHoi !!}</td>
                                                            <td>
                                                                <input type="radio" id="ch_{{ $item->maCauHoi }}"
                                                                    name="maCauHoi" value="{{ $item->maCauHoi }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot></tfoot>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="">Nhập số ý trả lời:</label>
                                                <input type="number" min="1" max="20" id="soTC" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="tbl-content">
                                                <div class='form-group'>"
                                                    <label for=''>Nhập nội dung ý:</label>
                                                    <textarea name='phuongAn[]' id='ckcontent_1' cols='30' rows='10'
                                                        class='form-control' required></textarea>
                                                    <label for=''>Nhập điểm</label>
                                                    <input type='text' name='diem[]' class='form-control'>
                                                </div>
                                                <script>
                                                    CKEDITOR.replace('ckcontent_1', {
                                                        filebrowserUploadUrl: "{{ route('uploadgv', ['_token' => csrf_token()]) }}",
                                                        filebrowserUploadMethod: 'form'
                                                    });

                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">{{ __("Save") }}</button>
                                            <button class="btn btn-info" type="reset">{{ __('Cancel') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                                </p>
                            </div>
                        </div><!-- /.card -->

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
        //số ý
        $('#soTC').on('keyup', function() {
            var soTC = this.value;
            console.log(soTC);
            var html = "";
            if(soTC>20){
                alert('Quá nhiều ý!');
                $('#soTC').val(0);
                $('#tbl-content').empty();
                return;
            }
            $('#tbl-content').empty();
            for (let index = 1; index <= soTC; index++) {
                html += "<div class='form-group'>" +
                    "<label for=''>Nhập nội dung ý "+index+":</label>" +
                    "<textarea name='phuongAn[]' id='ckcontent_" + index +
                    "' cols='30' rows='10' class='form-control' required></textarea>" +
                    "<label for=''>Nhập điểm</label>" +
                    "<input type='text' name='diem[]' class='form-control'>" +
                    "</div>";
            }
            console.log(html);
            $('#tbl-content').append(html);
            for (let index = 1; index <= soTC; index++) {
                CKEDITOR.replace('ckcontent_' + index, {
                    filebrowserUploadUrl: "{{ route('uploadgv', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'
                });
            }
        });
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
            var muc_url = '/giang-vien/hoc-phan/chuong/muc/get-cau-hoi-thuc-hanh-by-mamuc/' + $(this).val();
            $.ajax({
                type: 'get',
                url: muc_url,
                success: function(rsp) {
                    
                    var table_content = "";
                    var $i=1;
                    rsp.forEach(element => {
                        table_content+= "<tr><td>"+$i+"</td>"+
                            "<td>"+element['noiDungCauHoi']+"</td>"+
                            "<td>"+
                               "   <input type='radio' id='ch_"+element['maCauHoi']+"'"+                             
                                    "name='maCauHoi' value='"+element['maCauHoi']+"'>"+
                            "</td></tr>" ; 
                        $i+=1;  
                    });
                    console.log(table_content);
                    $('table[id="example2"]').children('tbody').empty();
                    $('table[id="example2"]').children('tbody').append(table_content);
                   
                    
                },
                error: function(rsp) {
                    console.log(rsp);
                }
            });
        })
        $('#them_maCDR3').change(function () {     
            var url='/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/get-abet-by-cdr3/'+$('#them_maCDR3').val();
            $.ajax({
                type: "get",
                url: url,
                success: function (data) {
                    $('them_maChuanAbet').empty();
                    var html='';
                    data.forEach(element => {
                        html+="<option value='"+element['maChuanAbet']+"'>"+element['maChuanAbetVB']+"--"+element['tenChuanAbet']+"</option>";
                    });
                    $('#them_maChuanAbet').empty();
                    $('#them_maChuanAbet').append(html);
                }
            });
        });
    </script>
@endsection
