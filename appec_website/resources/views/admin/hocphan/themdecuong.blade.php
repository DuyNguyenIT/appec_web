@extends('admin.no_menu_master')
@section('content')
<link rel="stylesheet" href="{{ asset('dist/css/themdecuong.css') }}">

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
              <button class="tablink" onclick="openPage('P1', this, 'blue')" id="defaultOpen">1. {{ __('General information') }}</button>
              <button class="tablink" onclick="openPage('P2', this, 'blue')" >2. {{ __('Learning resources') }}</button>
              <button class="tablink" onclick="openPage('P3', this, 'blue')">3. {{ __('Course description') }}</button>
              <button class="tablink" onclick="openPage('P4', this, 'blue')">4. {{ __('Course learning outcomes') }} (CLOs)</button>
              <button class="tablink" onclick="openPage('P5', this, 'blue')">5. {{ __('Course contents') }}</button>
              <button class="tablink" onclick="openPage('P6', this, 'blue')">6. {{ __('Teaching and learning methods') }}</button>
              <button class="tablink" onclick="openPage('P7', this, 'blue')">7. {{ __('Course assessment') }}</button>
              <button class="tablink" onclick="openPage('P8', this, 'blue')">8. {{ __('Course requirements and expectations') }}</button>
              
              <div id="P1" class="tabcontent">
                 {{-- 1.Thong tin chung --}}
              @include('admin.hocphan.noidungdecuong.1_thongtinchung')
              </div>
              
              <div id="P2" class="tabcontent">
                   {{-- 2--tai lieu tham khao --}}
              @include('admin.hocphan.noidungdecuong.2_tailieuthamkhao')
              </div>
              
              <div id="P3" class="tabcontent">
                  {{-- 3--Mo ta hoc phan --}}
              @include('admin.hocphan.noidungdecuong.3_motahocphan')
              </div>
              
              <div id="P4" class="tabcontent">
                 {{-- 4 chuan dau ra mon hoc --}}
              @include('admin.hocphan.noidungdecuong.4_chuandaura')
              </div>
              <div id="P5" class="tabcontent">
                     
                {{-- 5--Noi dung mon hoc --}}
              @include('admin.hocphan.noidungdecuong.5_noidungmonhoc')
              </div>
              <div id="P6" class="tabcontent">
              {{-- 6---Phương pháp giảng dạy --}}
              @include('admin.hocphan.noidungdecuong.6_phuongphapgiangday')
              </div>
              <div id="P7" class="tabcontent">
              {{-- 7 phuong thuc danh gia --}}
              @include('admin.hocphan.noidungdecuong.7_phuongthucdanhgia')
              </div>
              <div id="P8" class="tabcontent">
              {{-- 8 cac quy dinh chung --}}
              @include('admin.hocphan.noidungdecuong.8_cacquydinhchung')
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
  <script>
    function openPage(pageName,elmnt,color) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
      }
      document.getElementById(pageName).style.display = "block";
      elmnt.style.backgroundColor = color;
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
    </script>
@endsection