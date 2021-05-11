@extends('giangvien.master')
@section('content')
    <link rel="stylesheet" href="{{ asset('dist/css/foldertree.css') }}">
    <div class="content-wrapper" style="min-height: 58px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Course contents') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien/hoc-phan') }}">
                                    {{ \Illuminate\Support\Str::limit(html_entity_decode($hocPhan->tenHocPhan), $limit = 20, $end = '...') }}
                                </a></li>
                            <li class="breadcrumb-item active">{{ __('Course contents') }}</li>
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
                                    <h3 class="d-flex justify-content-between">
                                        {{ $hocPhan->tenHocPhan }}
                                        <a href="{{ asset('/giang-vien/hoc-phan') }}" class="btn btn-secondary"><i
                                                class="fas fa-arrow-left"></i></a>
                                    </h3>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul id="myUL">
                                    @foreach ($chuong as $ch)
                                        <li>
                                            <span class="caret">{{ $ch->tenchuong }}</span>
                                            <ul class="nested">
                                                @foreach ($ch->muc as $item)
                                                    <li>{{ $item->maMucVB }}. {{ $item->tenMuc }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach

                                </ul>
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
    <script src="{{ asset('dist/js/foldertree.js') }}"></script>
@endsection
