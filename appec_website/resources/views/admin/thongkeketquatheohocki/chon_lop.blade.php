@extends('admin.master')
@section('content')

<div class="content-wrapper" style="min-height: 22px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            {{ __("Statistics") }}<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{__('Home') }}</a></li>
            <li class="breadcrumb-item ">{{ $ctDaoTao->tenCT }}</li>
            <li class="breadcrumb-item ">{{ session::get('maHK') }}</li>
            <li class="breadcrumb-item ">{{ session::get('namHoc') }}</li>
            <li class="breadcrumb-item active">Chọn lớp</li>

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
                  <b>{{ $ctDaoTao->tenCT }} - {{ session::get('maHK') }} - {{ session::get('namHoc') }}</b>
              </h3>
              <div class="card-tools">
                <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh/namhoc/'.Session::get('maCT')) }}" class="btn btn-success">
                       <i class="fas fa-arrow-left"></i>
                 </a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>{{ __('No.') }}</th>
                    <th>{{ __('Class ID') }}</th>
                    <th>{{ __('Option') }} </th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $i=1;
                  @endphp
                   @foreach ($gd as $item)
                   <tr>
                       <td>{{ $i++ }}</td>
                       <td>{{ $item->maLop }}</td>
                       <td>
                           <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh/namhoc/lop/thong-ke-theo-abet/'.$item->maLop) }}" class="btn btn-success">
                            ABET's SO
                            </a>
                            <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh/namhoc/lop/thong-ke-theo-so/'.$item->maLop) }}" class="btn btn-success">
                            SOs
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