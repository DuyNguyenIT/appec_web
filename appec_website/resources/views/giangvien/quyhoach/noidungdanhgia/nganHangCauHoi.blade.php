@extends('giangvien.master')
@section('content')
    <link rel="stylesheet" href="{{ asset('dist/css/foldertree.css') }}">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Multipel question store') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ asset('/giang-vien') }}">{{ __('Home') }}</a>
                            </li>
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
                            </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('dist/js/foldertree.js') }}"></script>
@endsection
