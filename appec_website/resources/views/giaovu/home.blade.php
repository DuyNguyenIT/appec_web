@extends('giaovu.master')
@section('content')
<div class="content-wrapper" style="min-height: 126px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            Bảng điều khiển<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Bảng điều khiển</li>
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
      <!-- Small boxes (Stat box) -->
          
<div class="row">
<div class="col-lg-3 col-6">
<!-- small box -->
<div class="small-box bg-info">
  <div class="inner">
    <h3>1</h3>

    <p>Học phần</p>
  </div>
  <div class="icon">
    <i class="icon ion-document"></i>
  </div>
  <a href="#" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-6">
<!-- small box -->
<div class="small-box bg-success">
  <div class="inner">
    <h3>83<sup style="font-size: 20px">%</sup></h3>

    <p>Học sinh đạt</p>
  </div>
  <div class="icon">
    <i class="ion ion-stats-bars"></i>
  </div>
  <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-6">
<!-- small box -->
<div class="small-box bg-warning">
  <div class="inner">
    <h3>1</h3>

    <p>Bài kiểm tra mới</p>
  </div>
  <div class="icon">
    <i class="ion ion-person-add"></i>
  </div>
  <a href="#" class="small-box-footer">Xem thêm<i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-6">
<!-- small box -->
<div class="small-box bg-danger">
  <div class="inner">
    <h3>20</h3>

    <p>Tiêu chuẩn đã đạt</p>
  </div>
  <div class="icon">
    <i class="ion ion-pie-graph"></i>
  </div>
  <a href="#" class="small-box-footer">Xem thêm<i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
</div>

      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <!-- /.card -->
  </section>
  <!-- /.content -->
</div>
@endsection