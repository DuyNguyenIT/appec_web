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
                Dashboard<noscript></noscript>
                <nav></nav>
              </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
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
              <div class="small-box bg-gradient-info">
                <div class="inner">
                  <h5>Education level</h5>

                  <p>{{ $education_level }}</p>
                </div>
                <div class="icon">
                  <i class="icon ion-document"></i>
                </div>
                <a href="{{ asset('quan-ly/bac-dao-tao') }}" class="small-box-footer"
                  >More <i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ---------------------------------------->
            <!-- ----------------cột 2------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-gradient-success">
                <div class="inner">
                  <h5>Majors</h5>

                  <p>{{ $majors }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-clipboard"></i>
                </div>
                <a href="{{ asset('quan-ly/nganh-hoc') }}" class="small-box-footer"
                  >More <i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!------------------------------------------- -->
            <!-- --------------------------cột 3---------------- -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-gradient-warning">
                <div class="inner">
                  <h5>Specialized</h5>

                  <p>{{ $specialized }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-email"></i>
                </div>
                <a href="{{ asset('quan-ly/chuyen-nganh') }}" class="small-box-footer"
                  >More<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!--------------------------------------------------- -->
            <!--------------------cột 4------------------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-gradient-orange">
                <div class="inner">
                  <h5>Forms of planing</h5>

                  <p>{{ $forms_of_planning }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-checkmark-round"></i>
                </div>
                <a href="{{ asset('quan-ly/he') }}" class="small-box-footer"
                  >More<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ---------------------------------------------------->
            <!--------------------cột 5------------------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-gradient-maroon">
                <div class="inner">
                  <h5>Curriculum</h5>

                  <p>{{ $curriculums }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ asset('quan-ly/chuong-trinh-dao-tao') }}" class="small-box-footer"
                  >More<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ---------------------------------------------------->
            <!-- ---------------------cột 6------------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-gradient-olive">
                <div class="inner">
                  <h5>LV1 Students outcomes</h5>

                  <p>{{ $lv1_students_outcomes }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-printer"></i>
                </div>
                <a href="{{ asset('quan-ly/chuan-dau-ra') }}" class="small-box-footer"
                  >More<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ./col -->
             <!-- ---------------------cột 7------------------------ -->
             <div class="col-lg-2 col-6">
              <div class="small-box bg-gradient-dark">
                <div class="inner">
                  <h5>Course types</h5>

                  <p>{{ $course_type }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-printer"></i>
                </div>
                <a href="{{ asset('quan-ly/loai-hoc-phan') }}" class="small-box-footer"
                  >More<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ./col -->
             <!-- ---------------------cột 8------------------------ -->
             <div class="col-lg-2 col-6">
              <div class="small-box bg-cyan">
                <div class="inner">
                  <h5>Course</h5>

                  <p>{{ $course }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-printer"></i>
                </div>
                <a href="{{ asset('quan-ly/loai-hoc-phan') }}" class="small-box-footer"
                  >More<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ./col -->
            <!-- ---------------------cột 9------------------------ -->
            <div class="col-lg-2 col-6">
              <div class="small-box bg-gradient-indigo">
                <div class="inner">
                  <h5>Knowledge block</h5>

                  <p>{{ $knowledge_block }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-printer"></i>
                </div>
                <a href="{{ asset('quan-ly/khoi-kien-thuc') }}" class="small-box-footer"
                  >More<i class="fas fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <!-- ./col -->
             <!-- ---------------------cột 10------------------------ -->
             <div class="col-lg-2 col-6">
              <div class="small-box bg-gradient-teal">
                <div class="inner">
                  <h5>Teaching methods</h5>

                  <p>{{ $teaching_method }}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-printer"></i>
                </div>
                <a href="{{ asset('quan-ly/phuong-phap-giang-day') }}" class="small-box-footer"
                  >More<i class="fas fa-arrow-circle-right"></i
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