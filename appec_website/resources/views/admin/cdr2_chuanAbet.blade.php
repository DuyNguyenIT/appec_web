@extends('admin.master')
@section('content')
    <div class="content-wrapper" style="min-height: 96px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Level-2 Student Outcomes') }} <-> Abet <noscript></noscript>
                                <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('quan-ly') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Level-2 Student Outcomes') }} <-> Abet </li>
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
                                <h3 class="card-title"></h3>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ asset('quan-ly/chuan-dau-ra2-abet/them') }}" method="post">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        {{ __('Adding a new') }} {{ __('Level-2 Student Outcomes') }}
                                                        {{ __('Abet') }} </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="">{{ __('Level-2 Student Outcomes') }}</label>
                                                        <input type="text" name="maHe" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">{{ __('Abet') }}</label>
                                                        <input type="text" class="form-control" name="tenHe">
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
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('No.') }}</th>
                                                <th>{{ __('Level-2 Student Outcomes') }}</th>
                                                <th>{{ __('Abet') }}</th>
                                                <th>{{ __('Option') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($he as $h)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $h->maHe }}</td>
                                                    <td>{{ $h->tenHe }}</td>
                                                    <td>
                                                        <button title="Edit" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#edit_{{ $h->maHe }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a title="Delete" class="btn btn-danger"
                                                            onclick="return confirm('Do you want to delete {{ $h->tenHe }}?')"
                                                            href="{{ asset('quan-ly/chuan-dau-ra2-abet/xoa/' . $h->id) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        <div class="modal fade" id="edit_{{ $h->maHe }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <form
                                                                    action="{{ asset('quan-ly/chuan-dau-ra2-abet/sua') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                                {{ __('Editing') }}
                                                                                {{ __('Level-2 Student Outcomes') }}
                                                                                {{ __('Abets') }}
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">×</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input type="text" name="id"
                                                                                value="{{ $h->id }}" hidden>
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="">{{ __('Level-2 Student Outcomes') }}</label>
                                                                                <input type="text" name="tenHe"
                                                                                    class="form-control"
                                                                                    value="{{ $h->tenHe }}"
                                                                                    placeholder="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                {{ __('Update') }}
                                                                            </button>
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">
                                                                                {{ __('Cancel') }}
                                                                            </button>
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
