@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            Level-3 Student Outcomes Management<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ asset('/quan-ly/chuan-dau-ra') }}">Level-1 Student Outcomes</a></li>
            <li class="breadcrumb-item active"><a href="{{ asset('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.$cdr1->maCDR1)}}">Level-2 Student Outcomes</a></li>
            <li class="breadcrumb-item active">Level-3 Student Outcomes</li>
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
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Message!</h5>
        {{session('success')}}
      </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i>Notification!</h5>
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
              <h3 class="card-title">

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                          <i class="fas fa-plus"></i>Add
                </button>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form action="{{ asset('quan-ly/chuan-dau-ra/chuan-dau-ra-3/them') }}" method="post">
                        @csrf
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Adding a new Level-3 Student Outcome</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">

                                <label for="">Level-3 Student Outcome ID (number)</label>
                                <input type="text" name="maCDR3VB" class="form-control" placeholder="">
                              </div>
                                <div class="form-group">
                                  <label for="">Level-3 Student Outcome Name (Vietnamese)</label>
                                  <input type="text" name="tenCDR3" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                  <label for="">Level-3 Student Outcome Name (English)</label>
                                  <input type="text" name="tenCDR3EN" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="modal-footer"> 
                              <button type="submit" class="btn btn-primary">Save</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                          </div>
                        </form>
                    </div>
                  </div>  <!-- end Modal -->
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Level-3 Student Outcome ID</th>
                      <th>Level-3 Student Outcome Name (Vietnamese)</th>
                      <th>Level-3 Student Outcome Name (English)</th>
                      <th>Level-2 Student Outcome</th>
                      <th>Management Functions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($chuandaura3 as $cdr3)
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$cdr3->maCDR3VB}}</td>
                        <td>{{$cdr3->tenCDR3}}</td>
                        <td>{{$cdr3->tenCDR3EN}}</td>
                        <td>{{$cdr3->maCDR2VB}}</td>

                        <td>
                          
                            <button title="Edit"  class="btn btn-success" data-toggle="modal" data-target="#edit_{{$cdr3->maCDR3}}">
                              <i class="fas fa-edit"></i>
                            </button>
                            <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete {{$cdr3->tenCDR3}}?')" href="{{ asset('quan-ly/chuan-dau-ra/chuan-dau-ra-3/xoa/'.$cdr3->maCDR3) }}"><i class="fa fa-trash"></i></a>
                            
                          <div class="modal fade" id="edit_{{$cdr3->maCDR3}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form action="{{ asset('quan-ly/chuan-dau-ra/chuan-dau-ra-3/sua') }}" method="post">
                              @csrf
                          
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">
                                    Editing Level-3 Student Outcome Information
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <input type="text" name="maCDR3" value="{{$cdr3->maCDR3}}" class="form-control" hidden>
                                 
                                  <div class="form-group">
                                    <label for="">Level-3 Student Outcome ID (number):</label>
                                    <input type="text" name="maCDR3VB" class="form-control" value="{{$cdr3->maCDR3VB}}">
                                  </div> 
                                  
                                  <div class="form-group">
                                    <label for="">Level-3 Student Outcome Name (Vietnamese)</label>
                                    <input type="text" name="tenCDR3" class="form-control" value="{{$cdr3->tenCDR3}}">
                                  </div>

                                  <div class="form-group">
                                    <label for="">Level-3 Student Outcome Name (English)</label>
                                    <input type="text" name="tenCDR3EN" class="form-control" value="{{$cdr3->tenCDR3EN}}">
                                  </div>
                                
                                </div> <!-- end modal-body-->
                              </form>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Update</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div> 
                            </div>
                          </div>
                      </div>
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