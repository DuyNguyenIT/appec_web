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
                            {{ __('Edit') }} {{ __('Multiple choices question') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item ">Ngân hàng câu hỏi trắc nghiệm</li>
                            <li class="breadcrumb-item active">Sửa câu hỏi</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="d-flex justify-content-between">
                                        {{ __('Edit') }} {{ __('Multiple choices question') }}
                                        <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/' . Session::get('maMuc').'/'.Session::get('maCTBaiQH')) }}"
                                            class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">CKeditor</label>
                                    </div>
                                    <form
                                        action="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/sua-cau-hoi-submit') }}"
                                        method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for=""> Nội dung quy hoạch:</label>
                                            <select name="maNoiDungQH" id="" class="form-control" required>
                                                @foreach ($ndqh_dropdownlist as $nd)
                                                @if ($nd->maNoiDungQH==$ndqh->maNoiDungQH)
                                                    <option value="{{ $nd->maNoiDungQH }}" selected>{{ $nd->tenNoiDungQH }}</option>
                                                @else
                                                    <option value="{{ $nd->maNoiDungQH }}">{{ $nd->tenNoiDungQH }}</option>
                                                @endif
                                                  
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('Students outcomes') }} 3 (CDIOs):</label>
                                            <select name="maCDR3" id="" class="form-control">
                                                @foreach ($cdr3 as $data)
                                                    @if ($cauhoi->phuong_an_trac_nghiem[0]->maCDR3 == $data->maCDR3)
                                                        <option value="{{ $data->maCDR3 }}" selected>
                                                            {{ $data->maCDR3VB }} - {{ $data->tenCDR3 }}</option>
                                                    @else
                                                        <option value="{{ $data->maCDR3 }}">{{ $data->maCDR3VB }} -
                                                            {{ $data->tenCDR3 }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Abet:</label>
                                            <select name="maChuanAbet" id="" class="form-control">
                                                @foreach ($abet as $data)
                                                    @if ($cauhoi->phuong_an_trac_nghiem[0]->maChuanAbet == $data->maChuanAbet)
                                                        <option value="{{ $data->maChuanAbet }}" selected>
                                                            {{ $data->maChuanAbetVB }} - {{ $data->tenChuanAbet }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $data->maChuanAbet }}">
                                                            {{ $data->maChuanAbetVB }} - {{ $data->tenChuanAbet }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('Question content') }}:</label>
                                            <input type="text" name="maCauHoi" value="{{ $cauhoi->maCauHoi }}" hidden>
                                            <textarea type="text" name="noiDungCauHoi" id="noiDungCauHoi"
                                                class="form-control">{{ $cauhoi->noiDungCauHoi }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lựa chọn A</label>
                                            <input type="text" name="maPhuongAn[]"
                                                value="{{ $cauhoi->phuong_an_trac_nghiem[0]->id }}" hidden>
                                            <textarea type="text" name="phuongAn[]" id="phuongAn1" class="form-control">
                                    {{ $cauhoi->phuong_an_trac_nghiem[0]->noiDungPA }}
                                  </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lựa chọn B</label>
                                            <input type="text" name="maPhuongAn[]"
                                                value="{{ $cauhoi->phuong_an_trac_nghiem[1]->id }}" hidden>
                                            <textarea type="text" name="phuongAn[]" id="phuongAn2" class="form-control">
                                    {{ $cauhoi->phuong_an_trac_nghiem[1]->noiDungPA }}
                                  </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lựa chọn C</label>
                                            <input type="text" name="maPhuongAn[]"
                                                value="{{ $cauhoi->phuong_an_trac_nghiem[2]->id }}" hidden>
                                            <textarea type="text" name="phuongAn[]" id="phuongAn3" class="form-control">
                                    {{ $cauhoi->phuong_an_trac_nghiem[2]->noiDungPA }}
                                  </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lựa chọn D</label>
                                            <input type="text" name="maPhuongAn[]"
                                                value="{{ $cauhoi->phuong_an_trac_nghiem[3]->id }}" hidden>
                                            <textarea type="text" name="phuongAn[]" id="phuongAn4" class="form-control">
                                    {{ $cauhoi->phuong_an_trac_nghiem[3]->noiDungPA }}
                                  </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('Answer') }}</label><br>
                                            @php
                                                $leter = ['A', 'B', 'C', 'D'];
                                            @endphp
                                            @for ($i = 0; $i < count($cauhoi->phuong_an_trac_nghiem); $i++)
                                                {{ $leter[$i] }}
                                                @if ($cauhoi->phuong_an_trac_nghiem[$i]->isCorrect == 1)
                                                    <input type="radio" name="choice" value="{{ $i }}" checked>
                                                @else
                                                    <input type="radio" name="choice" value="{{ $i }}">
                                                @endif
                                            @endfor
                                        </div>
                                      
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                            <button type="reset" class="btn btn-info">{{ __('Reset') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        $("#customSwitch1").change(function() {
            if (this.checked) {
                CKEDITOR.replace('noiDungCauHoi', {
                    filebrowserUploadUrl: "{{ route('uploadgv', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'
                });
                for (let index = 1; index <= 4; index++) {
                    var name = "phuongAn" + index;
                    CKEDITOR.replace(name, {
                        filebrowserUploadUrl: "{{ route('uploadgv', ['_token' => csrf_token()]) }}",
                        filebrowserUploadMethod: 'form'
                    });
                }
            } else {
                if (CKEDITOR.instances["noiDungCauHoi"]) {
                    CKEDITOR.instances["noiDungCauHoi"].destroy();
                }
                for (let index = 1; index <= 4; index++) {
                    var name = "phuongAn" + index;
                    console.log(name);
                    if (CKEDITOR.instances[name]) {
                        CKEDITOR.instances[name].destroy();
                    }
                }
            }
        });
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

    </script>
@endsection
