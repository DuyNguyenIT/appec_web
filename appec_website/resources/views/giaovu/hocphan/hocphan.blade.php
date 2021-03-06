@extends('giaovu.master')
@section('content')
    <div class="content-wrapper" style="min-height: 155px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ __('Course') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giao-vu') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Course') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form
                                                action="{{ asset('/giao-vu/hoc-phan-giang-day/them-hoc-phan-giang-day-submit') }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- <div class="form-group">
                              <label for="">Chọn ngành:</label>
                              <select name="" id="" class="form-control">
                                <option value=""></option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="">Chọn chuyên ngành:</label>
                              <select name="" id="" class="form-control">
                                <option value=""></option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="">Chọn bậc</label>
                              <select name="" id="" class="form-control">
                                <option value=""></option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="">Chọn hệ</label>
                              <select name="" id="" class="form-control">
                                <option value=""></option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="">Chọn chương trình đào tạo:</label>
                              <select name="" id="" class="form-control">
                                <option value=""></option>
                              </select>
                            </div> --}}
                                                        {{-- <div class="form-group">
                              <label for="">Chọn loại học phần:</label>
                              <select name="maHocPhan" id="" class="form-control">
                                <option value=""></option>
                              </select>
                            </div> --}}
                                                        <div class="form-group">
                                                            <label for="">{{ __('Courses') }}:</label>
                                                            <select name="maHocPhan" id="" class="form-control mdb-select"
                                                                searchable="Find...">
                                                                @foreach ($hocphan as $hp)
                                                                    <option value="{{ $hp->maHocPhan }}">
                                                                        {{ $hp->maHocPhan }}: {{ $hp->tenHocPhan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Lecture') }}:</label>
                                                            <select name="maGV" id="" class="form-control">
                                                                @foreach ($giangvien as $gv)
                                                                    <option value="{{ $gv->maGV }}">
                                                                        {{ $gv->hoGV }} {{ $gv->tenGV }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Class') }}</label>
                                                            <select name="maLop" id="" class="form-control">
                                                                @foreach ($lop as $lp)
                                                                    <option value="{{ $lp->maLop }}">
                                                                        {{ $lp->tenLop }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Semester') }}</label>
                                                            <select name="maHK" id="" class="form-control">
                                                                <option value="HK1">Hk1</option>
                                                                <option value="HK2">Hk2</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Academic year') }}:</label>
                                                            <select name="namHoc" id="" class="form-control">
                                                                @foreach ($years_array as $data)
                                                                    <option value="{{ $data }}">
                                                                        {{ $data }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="sumit"
                                                            class="btn btn-primary">{{ __('Save') }}</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    {{-- <button class="btn btn-success">
                    <i class="fas fa-upload"></i>  <i class="fas fa-file-excel"></i> 
                  </button> --}}
                                </h3>
                            </div>
                            <!-- /.card-header -->
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
                                                    <tr role="row">
                                                        <th>{{ __('No.') }}</th>
                                                        <th>{{ __('Academic year') }}</th>
                                                        <th>{{ __('Semester') }}</th>
                                                        <th>{{ __('Courses') }}</th>
                                                        <th>{{ __('Class') }}</th>
                                                        <th>{{ __('Lecture') }}</th>
                                                        <th>{{ __('Option') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($giangday as $gd)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1 dtr-control">{{ $i++ }}</td>
                                                            <td>{{ $gd->namHoc }}</td>
                                                            <td>{{ $gd->maHK }}</td>
                                                            <td>{{ $gd->tenHocPhan }}</td>
                                                            <td>{{ $gd->maLop }}</td>
                                                            <td>
                                                                @foreach ($gd->GV as $gv)
                                                                    <li>{{ $gv->hoGV }} {{ $gv->tenGV }}</li>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a class="btn bg-success"
                                                                    href="{{ asset('/giao-vu/hoc-phan-giang-day/xem-danh-sach-sinh-vien/' . $gd->maHocPhan . '/' . $gd->maLop . '/' . $gd->maHK . '/' . $gd->namHoc) }}">
                                                                    <span
                                                                        class="badge bg-purple">{{ $gd->countsv }}</span>
                                                                    <i class="fas fa-align-justify"></i>
                                                                    {{ __('Students list') }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                </tfoot>
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
