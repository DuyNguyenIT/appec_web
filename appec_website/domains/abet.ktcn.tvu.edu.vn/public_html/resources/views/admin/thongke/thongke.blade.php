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
            <li class="breadcrumb-item active">Statistics</li>
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
                  <b>Thống kê chuẩn đầu ra cấp chương trình</b>
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Curriculum name</th>
                    <th>Statistic Functions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $i=1;
                  @endphp
                  @foreach ($ctdaotao as $ct)
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$ct->tenCT}}</td>
                        <td>
                            <a href="{{ asset('/quan-ly/thong-ke/thong-ke-cap-chuong-trinh/'.$ct->maCT) }}">
                                <button class="btn btn-primary"> 
                                  <i class="fas fa-chart-line"></i>Statistics CDIO
                                </button>
                            </a>
                            <a href="{{ asset('/quan-ly/thong-ke/thong-ke-cap-chuong-trinh/abet/'.$ct->maCT) }}">
                              <button class="btn btn-primary"> 
                                <i class="fas fa-chart-line"></i>Statistics ABET
                              </button>
                          </a>
                          <a href="{{ asset('/quan-ly/thong-ke/thong-ke-cap-chuong-trinh/export/'.$ct->maCT) }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Excel CDIO
                          </a>
                          <a href="{{ asset('/quan-ly/thong-ke/thong-ke-cap-chuong-trinh/export-abet/'.$ct->maCT) }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Excel ABET
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