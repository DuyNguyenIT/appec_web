@extends('admin.no_menu_master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              {{ __('Course syllabus') }} <noscript></noscript>
              <nav></nav>
              
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active"><a href="{{ asset('quan-ly/hoc-phan') }}">{{ __('Course') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Course syllabus') }}</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-check"></i> Thông báo</h5>
          {{session('success')}}
        </div>
      @endif
      @if(session('warning'))
        <div class="alert alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> Thông báo</h5>
          {{session('warning')}}
        </div>
      @endif
    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3  style="text-align: center">
                  {{ __('COURSE SYLLABUS') }} <br>
                {{ __('Course') }} : {{ $hocPhan->tenHocPhan }} <br>
                {{ __('Course code') }}: {{ $hocPhan->maHocPhan }}
                </h3>
              </div>
              <a class="btn btn-primary" href="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/in-de-cuong-mon-hoc/'.$hocPhan->maHocPhan) }}">{{ __('Printing') }}</a>
              <!-- /.card-header -->
              <div class="card-body">
                {{-- 1.Thong tin chung --}}
              @include('admin.hocphan.noidungdecuong.1_thongtinchung')
                  {{-- 2--tai lieu tham khao --}}
              @include('admin.hocphan.noidungdecuong.2_tailieuthamkhao')
                {{-- 3--Mo ta hoc phan --}}
              @include('admin.hocphan.noidungdecuong.3_motahocphan')
                  {{-- 4 chuan dau ra mon hoc --}}
              @include('admin.hocphan.noidungdecuong.4_chuandaura')
                {{-- 5--Noi dung mon hoc --}}
              @include('admin.hocphan.noidungdecuong.5_noidungmonhoc')
              {{-- 6---Phương pháp giảng dạy --}}
              @include('admin.hocphan.noidungdecuong.6_phuongphapgiangday')
              {{-- 7 phuong thuc danh gia --}}
              @include('admin.hocphan.noidungdecuong.7_phuongthucdanhgia')
                {{-- 8 cac quy dinh chung --}}
              @include('admin.hocphan.noidungdecuong.8_cacquydinhchung')
           
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