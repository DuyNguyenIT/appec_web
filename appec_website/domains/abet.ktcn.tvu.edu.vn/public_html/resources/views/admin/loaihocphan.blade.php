@extends('admin.master')
@section('content')
    <div class="content-wrapper" style="min-height: 22px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Course type') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Course type') }}</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#addModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ asset('quan-ly/loai-hoc-phan/them') }}" method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ __('Add') }} {{ __('Course type') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">{{ __('Course type ID') }}:</label>
                                                            <input type="text" name="maLoaiHocPhan" class="form-control"
                                                                placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Course type name') }}:</label>
                                                            <input type="text" name="tenLoaIHocPhan" class="form-control"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ __('Save') }}</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ __('Cancle') }} </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </h3>
                            </div>
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>{{ __('Course type ID') }}</th>
                                            <th>{{ __('Course type name') }}</th>
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($loaihocphan as $x)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $x->maLoaiHocPhan }}</td>
                                                <td>{{ $x->tenLoaiHocPhan }}</td>
                                                <td>
                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#edit_{{ $x->maLoaiHocPhan }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a class="btn btn-danger"
                                                        onclick="return confirm('Bạn có muốn xóa {{ $x->tenLoaiHocPhan }}?')"
                                                        href="{{ asset('quan-ly/loai-hoc-phan/xoa/' . $x->maLoaiHocPhan) }}"><i
                                                            class="fa fa-trash"></i></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="edit_{{ $x->maLoaiHocPhan }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form action="{{ asset('quan-ly/loai-hoc-phan/sua') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            {{ __('Edit') }} {{ __('Course type') }}
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="text" hidden name="maLoaiHocPhan"
                                                                            value="{{ $x->maLoaiHocPhan }}"
                                                                            class="form-control" placeholder="">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="">{{ __('Course type name') }}:</label>
                                                                            <input type="text" name="tenLoaiHocPhan"
                                                                                value="{{ $x->tenLoaiHocPhan }}"
                                                                                class="form-control" placeholder="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">{{ __('Save') }}</button>
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">{{ __('Cancel') }}</button>
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
