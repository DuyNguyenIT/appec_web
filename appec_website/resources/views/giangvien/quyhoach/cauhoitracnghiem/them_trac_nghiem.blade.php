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
                            {{ __('Add') }} {{ __('Multiple choices question') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item">Ngân hàng câu hỏi trắc nghiệm</li>
                            <li class="breadcrumb-item active">Thêm câu hỏi</li>
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
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Nhập câu hỏi</h3>
                                        <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/' . Session::get('maMuc').'/'.Session::get('maCTBaiQH')) }}"
                                            class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">CKeditor</label>
                                    </div>
                                    <form
                                        action="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/them-cau-hoi-submit') }}"
                                        method="post">
                                        @csrf
                                        {{-- <div class="form-group">
                                            <label for="">Kết quả học tập:</label>
                                            <select name="maKQHT" class="form-control">
                                                @foreach ($kqht as $data)
                                                    <option value="{{ $data->maKQHT }}">
                                                        {{ $data->maKQHTVB }}--{{ $data->tenKQHT }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <div class="form-group">
                                            <label for=""> Nội dung quy hoạch:</label>
                                            <select name="maNoiDungQH" id="" class="form-control" required>
                                                @foreach ($ndqh as $nd)
                                                    <option value="{{ $nd->maNoiDungQH }}">{{ $nd->tenNoiDungQH }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('SO') }}:</label>
                                            <select name="maCDR3" id="maCDR3" class="form-control">
                                                @foreach ($cdr3 as $data)
                                                    <option value="{{ $data->maCDR3 }}">{{ $data->maCDR3VB }} -
                                                        {{ $data->tenCDR3 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __("ABET's SO") }}:</label>
                                            <select name="maChuanAbet" id="maChuanAbet" class="form-control">
                                                @foreach ($abet as $data)
                                                    <option value="{{ $data->maChuanAbet }}">
                                                        {{ $data->maChuanAbetVB }} - {{ $data->tenChuanAbet }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="">Nội dung câu hỏi:</label>
                                            <textarea type="text" name="noiDungCauHoi" id="noiDungCauHoi"
                                                class="form-control" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lựa chọn A</label>
                                            <textarea type="text" name="phuongAn[]" id="phuongAn1" class="form-control"
                                                required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lựa chọn B</label>
                                            <textarea type="text" name="phuongAn[]" id="phuongAn2" class="form-control"
                                                required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lựa chọn C</label>
                                            <textarea type="text" name="phuongAn[]" id="phuongAn3" class="form-control"
                                                required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lựa chọn D</label>
                                            <textarea type="text" name="phuongAn[]" id="phuongAn4" class="form-control"
                                                required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Đáp án</label><br>
                                            A <input type="radio" name="choice" value="0" checked>
                                            B <input type="radio" name="choice" value="1">
                                            C <input type="radio" name="choice" value="2">
                                            D <input type="radio" name="choice" value="3">
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
