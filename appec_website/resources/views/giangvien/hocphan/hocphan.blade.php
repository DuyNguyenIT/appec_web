@extends('giangvien.master')
@section('content')
<div class="content-wrapper" style="min-height: 58px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            {{ __('Courses') }}<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Courses') }}</li>
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
                
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th >{{ __('No.') }}</th>
                    <th >{{ __('Course name') }}</th>

                    <th >{{ __('Option') }}</th></tr>

                </thead>
                <tbody>
              
                  @php
                      $i=1;
                  @endphp
                  @foreach ($gd as $item)
                  <tr >
                    <td>{{$i++}}</td>
                    <td>{{$item->tenHocPhan}}</td>

                    <td style='white-space: nowrap'>
                        <a class="btn btn-primary" href="{{ asset('/giang-vien/hoc-phan/in-de-cuong-mon-hoc/'.$item->maHocPhan) }}">
                          <i class="far fa-file-word"></i>
                              {{ __('Printing') }} {{ __('Course Syllabus') }}
                        </a>
                         
                        <a href="{{ asset('/giang-vien/hoc-phan/chuong/'.$item->maHocPhan) }}" class="btn btn-success">
                          <i class="fas fa-list-ol"></i> {{ __('Chapter') }}
                        </a>
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