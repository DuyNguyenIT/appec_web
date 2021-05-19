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
                            Câu hỏi tự luận<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ asset('#') }}">
                                    Ngân hàng câu hỏi
                                </a>
                            </li>

                            <li class="breadcrumb-item active">Câu hỏi tự luận</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Thông báo!</h5>
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Thông báo!</h5>
                {{ session('warning') }}
            </div>
        @endif
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                                <h3 class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.Session::get('maHocPhan').'/'.Session::get('maBaiQH').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maLop')) }}"
                                        class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                </h3>


                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <form
                                            action="{{ asset('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/them') }}"
                                            method="post">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Thêm câu hỏi tự luận
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="text" name="maChuong" value="{{ $chuong->id }}" id=""
                                                        hidden>
                                                    <div class="form-group">
                                                        <label for="">Nhập nội dung câu hỏi:</label>
                                                        <textarea name="noiDungCauHoi" id="ckcontent" cols="30" rows="10"
                                                            class="form-control" required></textarea>
                                                        <script>
                                                            CKEDITOR.replace('ckcontent', {
                                                                filebrowserUploadUrl: "{{ route('uploadgv', ['_token' => csrf_token()]) }}",
                                                                filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for=""> Đáp ứng kết quả học tập:</label>
                                                        <select name="maKQHT" id="" class="form-control" required>
                                                            @foreach ($kqht as $x)
                                                                <option value="{{ $x->maKQHT }}">
                                                                    {{ $x->maKQHTVB }}-{{ $x->tenKQHT }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""> Nội dung qh:</label>
                                                        <select name="maNoiDungQH" id="" class="form-control" required>
                                                            @foreach ($ndqh as $nd)
                                                                <option value="{{ $nd->maNoiDungQH }}">
                                                                    {{ $nd->tenNoiDungQH }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>


                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('No.') }}</th>
                                                <th>{{ __('Question content') }}</th>
                                                <th>{{ __('Option') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($cauhoi as $x)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{!! html_entity_decode($x->noiDungCauHoi) !!}</td>
                                                    <td>
                                                        <div class="bnt-group">
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary"
                                                                data-toggle="modal"
                                                                data-target="#edit_{{ $x->maCauHoi }}">
                                                                <li class="fas fa-edit"></li>
                                                            </button>

                                                            <a class="btn btn-danger" onclick="return confirm('Confirm?')"
                                                                href="{{ asset('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/xoa/' . $x->maCauHoi) }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>


                                                        <!-- Modal -->
                                                        <div class="modal fade" id="edit_{{ $x->maCauHoi }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <form
                                                                    action="{{ asset('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/sua') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                                Sửa nội dung câu hỏi</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input type="text" name="maChuong"
                                                                                value="{{ $chuong->id }}" id="" hidden>
                                                                            <input type="text" name="maCauHoi"
                                                                                value="{{ $x->maCauHoi }}" id="" hidden>
                                                                            <div class="form-group">
                                                                                <label for="">Nhập nội dung câu hỏi:</label>
                                                                                <textarea name="noiDungCauHoi"
                                                                                    id="ckcontent_{{ $x->maCauHoi }}"
                                                                                    cols="30" rows="10" class="form-control"
                                                                                    required>
                                              {{ $x->noiDungCauHoi }}
                                            </textarea>
                                                                                <script>
                                                                                    CKEDITOR.replace(
                                                                                        'ckcontent_{{ $x->maCauHoi }}', {
                                                                                            filebrowserUploadUrl: "{{ route('uploadgv', ['_token' => csrf_token()]) }}",
                                                                                            filebrowserUploadMethod: 'form'
                                                                                        });

                                                                                </script>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for=""> Đáp ứng kết quả học
                                                                                    tập:</label>
                                                                                <select name="maKQHT" id=""
                                                                                    class="form-control" required>
                                                                                    @foreach ($kqht as $x)
                                                                                        <option
                                                                                            value="{{ $x->maKQHT }}">
                                                                                            {{ $x->maKQHTVB }}-{{ $x->tenKQHT }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Lưu</button>
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Đóng</button>
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>


                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
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
