@extends('admin.master')
@section('content')

    <div class="content-wrapper" style="min-height: 22px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Curriculum') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Curriculum') }}</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

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
                                    {{-- <a href="{{ asset('quan-ly/chuong-trinh-dao-tao/excel') }}">Xuất excel</a> --}}
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ asset('quan-ly/chuong-trinh-dao-tao/them') }}" method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ __('Adding a new') }} {{ __('Curriculum') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">{{ __('Curriculum name') }}:</label>
                                                            <input type="text" name="tenCT" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Education level') }}</label>
                                                            <select name="maBac" id="" class="form-control" required>
                                                                @foreach ($bac as $x)
                                                                    <option value="{{ $x->maBac }}">{{ $x->tenBac }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Specialized') }}</label>
                                                            <select name="maCNganh" id="" class="form-control" required>
                                                                @foreach ($chuyennganh as $y)
                                                                    <option value="{{ $y->maCNganh }}">
                                                                        {{ $y->tenCNganh }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Forms of training') }}</label>
                                                            <select name="maHe" id="" class="form-control" required>
                                                                @foreach ($he as $z)
                                                                    <option value="{{ $z->maHe }}">
                                                                        {{ $z->tenHe }}</option>
                                                                @endforeach
                                                            </select>
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
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>{{ __('Curriculum name') }}</th>
                                            <th>{{ __('Education level') }}</th>
                                            <th>{{ __('Specialized') }}</th>
                                            <th>{{ __('Forms of training') }}</th>
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($ctdaotao as $ct)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $ct->tenCT }}</td>
                                                <td>{{ $ct->bac->tenBac }}</td>
                                                <td>{{ $ct->cnganh->tenCNganh }}</td>
                                                <td>{{ $ct->he->tenHe }}</td>
                                                <td>

                                                    <button class="btn btn-success" data-toggle="modal"
                                                        data-target="#edit_{{ $ct->maCT }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a class="btn btn-danger"
                                                        onclick="return confirm('Bạn có muốn xóa {{ $ct->tenCT }}?')"
                                                        href="{{ asset('quan-ly/chuong-trinh-dao-tao/xoa/' . $ct->maCT) }}"><i
                                                            class="fa fa-trash"></i></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="edit_{{ $ct->maCT }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form
                                                                action="{{ asset('quan-ly/chuong-trinh-dao-tao/sua') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            {{ __('Edit') }} {{ __('curriculum') }}
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="text" name="maCT"
                                                                            value="{{ $ct->maCT }}"
                                                                            class="form-control" hidden>
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="">{{ __('Curriculum name') }}</label>
                                                                            <input type="text" name="tenCT"
                                                                                class="form-control"
                                                                                value="{{ $ct->tenCT }}" required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label
                                                                                for="">{{ __('Education level') }}</label>
                                                                            <select name="maBac" id="" class="form-control"
                                                                                required>
                                                                                @foreach ($bac as $x)
                                                                                    @if ($ct->maBac == $x->maBac)
                                                                                        <option value="{{ $x->maBac }}"
                                                                                            selected>{{ $x->tenBac }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $x->maBac }}">
                                                                                            {{ $x->tenBac }}</option>
                                                                                    @endif

                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">{{ __('Specialized') }}</label>
                                                                            <select name="maCNganh" id=""
                                                                                class="form-control" required>
                                                                                @foreach ($chuyennganh as $y)
                                                                                    @if ($ct->maCNganh == $y->maCNganh)
                                                                                        <option
                                                                                            value="{{ $y->maCNganh }}"
                                                                                            selected>{{ $y->tenCNganh }}
                                                                                        </option>

                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $y->maCNganh }}">
                                                                                            {{ $y->tenCNganh }}</option>

                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="">{{ __('Forms of training') }}</label>
                                                                            <select name="maHe" id="" class="form-control"
                                                                                required>
                                                                                @foreach ($he as $z)
                                                                                    @if ($ct->maHe == $z->maHe)
                                                                                        <option value="{{ $z->maHe }}"
                                                                                            selected>{{ $z->tenHe }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $z->maHe }}">
                                                                                            {{ $z->tenHe }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </form>

                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('Update') }}</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">{{ __('Cancel') }}</button>
                                                            </div>
                                                        </div>
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
