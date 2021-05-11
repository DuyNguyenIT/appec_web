@extends('giaovu.master')
@section('content')
    <div class="content-wrapper" style="min-height: 155px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Lớp<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Lớp</li>
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
                                        data-target="#addClass">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <!-- Modal adding class-->
                                    <div class="modal fade" id="addClass" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ asset('/giao-vu/quan-ly-lop/them-lop') }}" method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Adding a new class
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">Class ID</label>
                                                            <input type="text" name="maLop" id="" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Class name</label>
                                                            <input type="text" name="tenLop" id="" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Year</label>
                                                            <input type="text" name="namTS" id="" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1" aria-sort="ascending"
                                                            aria-label="STT: activate to sort column descending">STT</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Mã lớp: activate to sort column ascending">Mã lớp
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Tên lớp: activate to sort column ascending">Tên lớp
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Năm tuyển sinh: activate to sort column ascending">
                                                            Năm tuyển sinh</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Tùy chọn: activate to sort column ascending">Tùy
                                                            chọn</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($lop as $lp)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1 dtr-control">{{ $i++ }}</td>
                                                            <td>
                                                                {{ $lp->maLop }}
                                                            </td>
                                                            <td>{{ $lp->tenLop }}</td>
                                                            <td>{{ $lp->namTS }}</td>
                                                            <td>
                                                                <a class="btn bg-success"
                                                                    href="{{ asset('giao-vu/quan-ly-lop/xem-danh-sach-sinh-vien/' . $lp->maLop) }}">
                                                                    <span
                                                                        class="badge bg-purple">{{ $lp->countsv }}</span>
                                                                    <i class="fas fa-align-justify"></i>
                                                                    {{ __('Students list') }}
                                                                </a>
                                                                <!-- Modal edit-->
                                                                <div class="modal fade" id="edit_{{ $lp->maLop }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <form
                                                                            action="{{ asset('/giao-vu/quan-ly-lop/sua-lop') }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="exampleModalLabel">
                                                                                        {{ __('Edit') }}
                                                                                        {{ $lp->maLop }}</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <input type="text" name="maLop"
                                                                                        value="{{ $lp->maLop }}" hidden>
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="">{{ __('Class name') }}</label>
                                                                                        <input type="text" name="tenLop"
                                                                                            class="form-control"
                                                                                            value="{{ $lp->tenLop }}"
                                                                                            required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="">{{ __('Year') }}</label>
                                                                                        <input type="text" name="namTS"
                                                                                            class="form-control"
                                                                                            value="{{ $lp->namTS }}"
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">{{ __('Save') }}</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <!-- Button edit modal -->
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-toggle="modal"
                                                                        data-target="#edit_{{ $lp->maLop }}">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <a class="btn btn-danger"
                                                                        href="{{ asset('/giao-vu/quan-ly-lop/xoa-lop/' . $lp->maLop) }}"
                                                                        onclick="return confirm('Are you sure?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
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
