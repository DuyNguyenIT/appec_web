@extends('admin.master')
@section('content')

<div class="content-wrapper" style="min-height: 22px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            Statistics<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $ctDaoTao->tenCT }}</li>
            <li class="breadcrumb-item active">Chọn thời gian</li>
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
                  <b>{{ $ctDaoTao->tenCT }}</b>
              </h3>
              <div class="card-tools">
                <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh') }}" class="btn btn-success">
                       <i class="fas fa-arrow-left"></i>
                 </a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Years</th>
                    <th>Semester</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $i=1;
                  @endphp
                   @foreach ($gd as $item)
                   <tr>
                       <td>{{ $i++ }}</td>
                       <td>{{ $item->namHoc }}</td>
                      
                       <td>
                           <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh/namhoc/lop/HK1/'. $item->namHoc) }}"
                               class="btn btn-success">
                               <i class="fas fa-align-justify"></i>
                               {{ __('First semester') }} 
                               
                               
                           </a>
                           <a href="{{ asset('/quan-ly/thong-ke-ket-qua-theo-hoc-ki/chuong-trinh/namhoc/lop/HK2/'.$item->namHoc ) }}"
                               class="btn btn-success">
                               <i class="fas fa-align-justify"></i>
                               {{ __('Second semester') }}
                             
                
                               
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