@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Level-1 Student Outcomes Management<noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Level-1 Student Outcomes</li>
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
                    <form action="{{ asset('quan-ly/chuan-dau-ra/them') }}" method="post">
                    @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Adding a new Level-1 Student Outcomes</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">

                            <label for="">Level-1 Student Outcome ID (number):</label>
                            <input type="text" name="maCDR1VB" class="form-control" placeholder="">
                          </div>
                            <div class="form-group">
                              <label for="">Level-1 Student Outcome Name:</label>
                              <input type="text" name="tenCDR1" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="modal-footer"> 
                          <button type="submit" class="btn btn-primary">Save</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </form>
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
                      <th>Level-1 Student Outcomes Name</th>
                      <th>Management Functions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($chuandaura as $cdr)
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$cdr->tenCDR1}}</td>
                        <td>
                          <button title="Edit" class="btn btn-success" data-toggle="modal" data-target="#edit_{{$cdr->maCDR1}}">
                            <i class="fas fa-edit"></i> 
                          </button>
                          <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want ro delete {{$cdr->tenCDR1}}?')" href="{{ asset('quan-ly/chuan-dau-ra/xoa/'.$cdr->maCDR1) }}"><i class="fa fa-trash"></i></a>
                          <a href="{{ asset('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.$cdr->maCDR1) }}">
                              <!-- <button class="btn btn-primary">Chuẩn đầu ra 2</button>-->
                            <button title="Level-2 Student Outcomes Management"  class="btn btn-success" data-toggle="modal" data-target="#addModal">
                                <i class="fas fa-align-justify"></i>Level-2 Student Outcomes
                            </button>
                          </a>  
                         
                              <div class="modal fade" id="edit_{{$cdr->maCDR1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <form action="{{ asset('quan-ly/chuan-dau-ra/sua') }}" method="post">
                                  @csrf
                              
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">
                                        Editing Level-1 Student Outcome Information
                                      </h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <input type="text" name="maCDR1" value="{{$cdr->maCDR1}}" class="form-control" hidden>
                                      <!-- PTTMai thêm -->
                                      <div class="form-group">
                                        <label for="">Level-1 Student Outcome ID (number):</label>
                                        <input type="text" name="maCDR1VB" class="form-control" value="{{$cdr->maCDR1VB}}">
                                      </div> 
                                      <!-- hết PTTMai thêm -->
                                      <div class="form-group">
                                        <label for="">Level-1 Student Outcome Name</label>
                                        <input type="text" name="tenCDR1" class="form-control" value="{{$cdr->tenCDR1}}">
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