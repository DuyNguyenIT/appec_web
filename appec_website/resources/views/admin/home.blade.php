@extends('admin.master')
@section('content')

     <!-- Content Wrapper. Contains page content -->
     <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">
                Control panel<noscript></noscript>
                <nav></nav>
              </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Control panel</li>
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
            <!-- ------------cột 1--------------------- -->
            <div class="col-lg-2 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>#</h3>

                  <p>#</p>
                </div>
                <div class="icon">
                  <i class="icon ion-document"></i>
                </div>
                <a href="#" class="small-box-footer"
                  >Chi tiết <i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ---------------------------------------->
            <!-- ----------------cột 2------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>#</h3>

                  <p>#</p>
                </div>
                <div class="icon">
                  <i class="ion ion-clipboard"></i>
                </div>
                <a href="#" class="small-box-footer"
                  >Xem thêm <i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!------------------------------------------- -->
            <!-- --------------------------cột 3---------------- -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>#</h3>

                  <p>#</p>
                </div>
                <div class="icon">
                  <i class="ion ion-email"></i>
                </div>
                <a href="#" class="small-box-footer"
                  >Xem thêm<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!--------------------------------------------------- -->
            <!--------------------cột 4------------------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>#</h3>

                  <p>#</p>
                </div>
                <div class="icon">
                  <i class="ion ion-checkmark-round"></i>
                </div>
                <a href="#" class="small-box-footer"
                  >Xem thêm<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ---------------------------------------------------->
            <!--------------------cột 5------------------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>#</h3>

                  <p>#</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"
                  >Xem thêm<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ---------------------------------------------------->
            <!-- ---------------------cột 6------------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>20</h3>

                  <p>#</p>
                </div>
                <div class="icon">
                  <i class="ion ion-printer"></i>
                </div>
                <a href="#" class="small-box-footer"
                  >Xem thêm<i class="fas fa-arrow-circle-right"></i
                ></a>
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
    <!-- /.content-wrapper -->

@endsection