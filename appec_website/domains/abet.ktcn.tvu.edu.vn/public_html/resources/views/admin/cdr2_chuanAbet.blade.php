@extends('admin.master')
@section('content')
    <style>
        table {
            z-index: 1;
        }

        .fixed_header thead {
            background: green;
            color: #fff;
            width: 300px;
        }

        .fixed_header th,
        td {
            padding: 0.25rem;
        }

        .fixed_header th {
            background: green;
            color: black;
            position: sticky;
            top: 0;
            /* Don't forget this, required for the stickiness */
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        }

        .fixed_header tr:hover {
            background-color: rgb(181, 209, 138);
        }

        .fixed_header td:hover::after,
        .fixed_header th:hover::after {
            content: "";
            position: absolute;
            background-color: rgb(181, 209, 138);
            left: 0;
            top: -5000px;
            height: 100px;
            width: 100%;
            z-index: -1;
        }

    </style>
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
                                <h3 class="card-title">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </h3>
                                <!-- Modal add-->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
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
                                                        <label>{{ __('Level-2 Student Outcomes') }}</label>
                                                        <select name="maCDR2" class="form-control">
                                                            @foreach ($cdr2 as $cd)
                                                                <option value="{{ $cd->maCDR2 }}">
                                                                    @if (Session::has('language') && Session::get('language') == 'vi')
                                                                        {{ $cd->maCDR2VB }}--{{ $cd->tenCDR2 }}
                                                                    @else
                                                                        {{ $cd->maCDR2VB }}--{{ $cd->tenCDR2EN }}
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Abet') }}</label>
                                                        <select name="maChuanAbet" class="form-control">
                                                            @foreach ($chuanAbet as $abet)
                                                                <option value="{{ $abet->maChuanAbet }}">
                                                                    @if (Session::has('language') && Session::get('language') == 'vi')
                                                                        {{ $abet->maChuanAbetVB }}--{{ $abet->tenChuanAbet }}
                                                                    @else
                                                                        {{ $abet->maChuanAbetVB }}--{{ $abet->tenChuanAbet_EN }}
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Save') }}
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        {{ __('Cancel') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered fixed_header">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Level-2 Student Outcomes') }}</th>
                                            @foreach ($chuanAbet as $abet)
                                                <th>{{ $abet->maChuanAbetVB }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($cdr2 as $cd2)
                                            <tr>
                                                <td>
                                                    @if (Session::has('language') && Session::get('language') == 'vi')
                                                        {{ $cd2->maCDR2VB }}--{{ $cd2->tenCDR2 }}
                                                    @else
                                                        {{ $cd2->maCDR2VB }}--{{ $cd2->tenCDR2EN }}
                                                    @endif
                                                </td>
                                                @foreach ($chuanAbet as $abet)
                                                    <td>
                                                        @foreach ($cdr2_abet as $data)
                                                            @if ($data->maChuanAbet == $abet->maChuanAbet && $data->maCDR2 == $cd2->maCDR2)
                                                                <!-- Button trigger modal -->
                                                                <button type="button" class="btn btn-primary"
                                                                    data-toggle="modal"
                                                                    data-target="#edit_{{ $data->id }}">
                                                                    x
                                                                </button>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="edit_{{ $data->id }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <form
                                                                            action="{{ asset('/quan-ly/chuan-dau-ra2-abet/sua') }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="exampleModalLabel">
                                                                                        {{ __('Edit') }}</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="id"
                                                                                            value="{{ $data->id }}"
                                                                                            hidden>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>{{ __('Level-2 Student Outcomes') }}</label>
                                                                                        <select name="maCDR2"
                                                                                            class="form-control">
                                                                                            @foreach ($cdr2 as $cd)
                                                                                                @if ($data->maCDR2 == $cd->maCDR2)
                                                                                                    <option
                                                                                                        value="{{ $cd->maCDR2 }}"
                                                                                                        selected>
                                                                                                        @if (Session::has('language') && Session::get('language') == 'vi')
                                                                                                            {{ $cd->maCDR2VB }}--{{ $cd->tenCDR2 }}
                                                                                                        @else
                                                                                                            {{ $cd->maCDR2VB }}--{{ $cd->tenCDR2EN }}
                                                                                                        @endif
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $cd->maCDR2 }}">
                                                                                                        @if (Session::has('language') && Session::get('language') == 'vi')
                                                                                                            {{ $cd->maCDR2VB }}--{{ $cd->tenCDR2 }}
                                                                                                        @else
                                                                                                            {{ $cd->maCDR2VB }}--{{ $cd->tenCDR2EN }}
                                                                                                        @endif
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>{{ __('Abet') }}</label>
                                                                                        <select name="maChuanAbet"
                                                                                            class="form-control">
                                                                                            @foreach ($chuanAbet as $abet)
                                                                                                @if ($data->maChuanAbet == $abet->maChuanAbet)
                                                                                                    <option
                                                                                                        value="{{ $abet->maChuanAbet }}"
                                                                                                        selected>
                                                                                                        @if (Session::has('language') && Session::get('language') == 'vi')
                                                                                                            {{ $abet->maChuanAbetVB }}--{{ $abet->tenChuanAbet }}
                                                                                                        @else
                                                                                                            {{ $abet->maChuanAbetVB }}--{{ $abet->tenChuanAbet_EN }}
                                                                                                        @endif
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $abet->maChuanAbet }}">
                                                                                                        @if (Session::has('language') && Session::get('language') == 'vi')
                                                                                                            {{ $abet->maChuanAbetVB }}--{{ $abet->tenChuanAbet }}
                                                                                                        @else
                                                                                                            {{ $abet->maChuanAbetVB }}--{{ $abet->tenChuanAbet_EN }}
                                                                                                        @endif
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">
                                                                                        {{ __('Update') }}
                                                                                    </button>
                                                                                    @if (Session::has('language') && Session::get('language') == 'vi')
                                                                                        <a href="{{ asset('/quan-ly/chuan-dau-ra2-abet/xoa/' . $data->id) }}"
                                                                                            class="btn btn-danger"
                                                                                            onclick=" return confirm('Xác nhận xóa?')">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ asset('/quan-ly/chuan-dau-ra2-abet/xoa/' . $data->id) }}"
                                                                                            class="btn btn-danger"
                                                                                            onclick=" return confirm('delete confirmation?')">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </a>
                                                                                    @endif
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">{{ __('Cancel') }}
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            @break
                                                        @endif
                                                @endforeach
                                                </td>
                                        @endforeach

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
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
