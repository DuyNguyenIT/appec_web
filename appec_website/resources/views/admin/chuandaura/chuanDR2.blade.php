@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 155px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Level-2 Student Outcomes Management<noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('quan-ly') }}">Home</a></li>
              <li class="breadcrumb-item ">
                  <a href="{{ asset('quan-ly/chuan-dau-ra') }}">
                    Level-1 Student Outcomes
                  </a>
              </li>
              <li class="breadcrumb-item active">Level-2 Student Outcomes</li>
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

              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus"></i>Add
              </button>

            
                    <!-- Modal -->
                  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">
                            Adding a new Level-2 Student Outcomes
                          </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="">Level-2 Student Outcomes ID:</label>
                            <input type="text" name="maCDR2VB" class="form-control" placeholder="">
                          </div>
                          <div class="form-group">
                            <label for="">Level-2 Student Outcomes name:</label>
                            <input type="text" name="tenCDR2" class="form-control" placeholder="">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">
                            Save
                          </button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Level-2 Student Outcomes ID</th>
                      <th>Level-2 Student Outcomes Name</th>
                      <th>Level-1 Student Outcomes</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($chuandaura2 as $cdr2)
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$cdr2->maCDR2VB}}</td>
                        <td>{{$cdr2->tenCDR2}}</td>
                        <td>{{$cdr2->maCDR1VB}}</td>
                        <td style='white-space: nowrap'>
                          
                            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                              <i class="fas fa-edit"></i> 
                            </button>
                            <a href="{{ asset('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.$cdr2->maCDR2) }}">
                              <button class="btn btn-primary">
                              Level-3 Student Outcomes
                              </button>
                          </a>
                          
                        </td>
                      </tr>
                    @endforeach

                    </tr>
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