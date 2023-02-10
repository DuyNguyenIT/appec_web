@extends('bomon.master')
@section('content')
    <div class="content-wrapper" style="min-height: 155px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Students list') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('bo-mon') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ asset('bo-mon/quan-ly-lop') }}">{{ $maLop }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Students list') }}</li>
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
                                    {{ $maLop }}
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/bo-mon/quan-ly-lop') }}" class="btn btn-secondary"><i
                                            class="fas fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-header">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudent">
                                    <i class="fas fa-plus"></i>
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }} {{ __('Student') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="form-group">
                                            <label> {{ __('Student ID') }}</label>
                                            <input type="text" name="maSSV" pattern="[0-9]{9}" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label> {{ __('Student middle name') }}</label>
                                            <input type="text" name="HoSV" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label> {{ __('Student name') }}</label>
                                            <input type="text" name="TenSV" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label> {{ __('Gender') }}</label>
                                            <select name="Phai" class="form-control">
                                                <option value="Nam">{{ __('Boy') }}</option>
                                                <option value="Nu">{{ __('Girl') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label> {{ __('Birth') }}</label>
                                            <input type="text" name="ngaySinh" class="form-control">
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-primary">{{ __('Save') }}</button>

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#importExcel">
                                    <i class="fas fa-upload"></i> <i class="fas fa-file-csv"></i>
                                </button>
                                <a href="{{ asset('/bo-mon/quan-ly-lop/tai-file-mau') }}">{{ __('Template file excel') }}</a>
                                <!-- Modal -->
                                <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form
                                            action="{{ asset('/bo-mon/quan-ly-lop/cap-nhat-ds-sinh-vien-bang-excel') }}"
                                            enctype="multipart/form-data" method="post">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Import excel') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="file" name="file" id="" class="form-control">
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
                            </div>
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>{{ __('Student ID') }}</th>
                                            <th>{{ __('Student name') }}</th>
                                            <th>{{ __('Class') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($dssv as $sv)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $sv->maSSV }}</td>
                                                <td>{{ $sv->HoSV }} {{ $sv->TenSV }}</td>
                                                <td>{{ $sv->maLop }}</td>
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
