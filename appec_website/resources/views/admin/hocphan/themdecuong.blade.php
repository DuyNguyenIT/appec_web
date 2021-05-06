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
                <div class="card-tools">
                  <a class="btn btn-primary" href="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/in-de-cuong-mon-hoc/'.$hocPhan->maHocPhan) }}"><i class="fas fa-download"></i></a>
                  <a href="{{ asset('/quan-ly/hoc-phan') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h3  style="text-align: center">
                  {{ __('COURSE SYLLABUS') }} <br>
                {{ __('Course') }} : {{ $hocPhan->tenHocPhan }} <br>
                {{ __('Course code') }}: {{ $hocPhan->maHocPhan }}
                </h3>
               
              </div>
              
                <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs"  role="tablist" >
                    <li class="nav-item">
                      <a class="nav-link active" id="tab_P1" data-toggle="tab" href="#P1" role="tab" aria-controls="P1" aria-selected="true">
                        1. {{ __('General information') }}
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="tab_P2" data-toggle="tab" href="#P2" role="tab" aria-controls="P2" aria-selected="false">
                        2. {{ __('Learning resources') }}
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="tab" href="#P3" role="tab" aria-controls="P3" aria-selected="false">
                        3. {{ __('Course description') }}
                      
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="tab" href="#P4" role="tab" aria-controls="P4" aria-selected="false">
                        4. {{ __('Course learning outcomes') }} (CLOs)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="tab" href="#P5" role="tab" aria-controls="P5" aria-selected="false">
                        5. {{ __('Course contents') }}
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="tab" href="#P6" role="tab" aria-controls="P6" aria-selected="false">
                        6. {{ __('Teaching and learning methods') }}
                      </a>
          
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="tab" href="#P7" role="tab" aria-controls="P7" aria-selected="false">
                        7. {{ __('Course assessment') }}
                      </a>
          
                    </li>
                    <li class="nav-item" >
                      <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="tab" href="#P8" role="tab" aria-controls="P8" aria-selected="false">
                        8. {{ __('Course requirements and expectations') }}
                      </a>
                    </li>
                  </ul>
                </div>
                <!-- /.card -->
              
         

 
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div  class="tab-pane fade active show" id="P1" role="tabpanel" aria-labelledby="P1">
                    @include('admin.hocphan.noidungdecuong.1_thongtinchung')
                  </div>
                  <div class="tab-pane fade show" id="P2" role="tabpanel" aria-labelledby="P2">
                    @include('admin.hocphan.noidungdecuong.2_tailieuthamkhao')

                  </div>
                  <div class="tab-pane fade " id="P3" role="tabpanel" aria-labelledby="P3">
                    @include('admin.hocphan.noidungdecuong.3_motahocphan')

                  </div>
                  <div class="tab-pane fade " id="P4" role="tabpanel" aria-labelledby="P4">
                    @include('admin.hocphan.noidungdecuong.4_chuandaura')
                  </div>
                  <div class="tab-pane fade " id="P5" role="tabpanel" aria-labelledby="P5">
                    @include('admin.hocphan.noidungdecuong.5_noidungmonhoc')
                  </div>
                  <div class="tab-pane fade " id="P6" role="tabpanel" aria-labelledby="P6">
                    @include('admin.hocphan.noidungdecuong.6_phuongphapgiangday')
                  </div>
                  <div class="tab-pane fade " id="P7" role="tabpanel" aria-labelledby="P7">
                    @include('admin.hocphan.noidungdecuong.7_phuongthucdanhgia')
                  </div>
                  <div class="tab-pane fade " id="P8" role="tabpanel" aria-labelledby="P8">
                    @include('admin.hocphan.noidungdecuong.8_cacquydinhchung')
                  </div>
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

        
  <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
      
  <script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
@endsection