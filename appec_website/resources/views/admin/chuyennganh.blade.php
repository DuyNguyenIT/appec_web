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
                    Specialized Management<noscript></noscript>
                  <nav></nav>
                </h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">Home</a></li>
                  <li class="breadcrumb-item active">Specialized</li>
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
      <h5><i class="icon fas fa-exclamation-triangle"></i> Notification!</h5>
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
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal"  data-toggle="modal">
                        <i class="fas fa-plus"></i>Add
                      </button>

                        <!-- Modal -->
                        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <form action="{{ asset('quan-ly/chuyen-nganh/them') }}" method="post">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Adding a new Specialized</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                      <div class="form-group">
                                        <label for="">Specialized Name</label>
                                        <input type="text" name="tenCNganh" class="form-control" required>
                                      </div>
                                
                                    <div class="form-group">
                                        <label for="">Major</label>
                                        <select name="maNganh" id="" class="form-control">
                                        @foreach ($nganh as $x)
                                            <option value="{{$x->maNganh}}">{{$x->maNganh}} - {{$x->tenNganh}}</option>  
                                        @endforeach
                                        </select>
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
                    <table
                      id="example2"
                      class="table table-bordered table-hover"
                    >
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Specialized Name</th>
                          <th>Major ID</th>
                          <th>Major</th>
                          <th>Management Functions</th>
                        </tr>
                      </thead>
                      <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($cnganh as $y)
                                <tr>
                                  <td>{{$i++}}</td>
                                  <td>
                                    {{$y->tenCNganh}}
                                  </td>
                                  <td>
                                    {{$y->maNganh}}
                                  </td>
                                  <td>
                                    {{$y->nganh->tenNganh}}
                                  </td>
                                  <td>
                                    <button title="Edit" type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$y->maCNganh}}">
                                      <i class="fa fa-edit" ></i>
                                    </button>
                                    <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete {{$y->tenCNganh}}?')" href="{{ asset('quan-ly/chuyen-nganh/xoa/'.$y->maCNganh) }}" ><i class="fa fa-trash" ></i></a>
                                    <!-- Button trigger modal -->
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit_{{$y->maCNganh}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <form action="{{ asset('quan-ly/chuyen-nganh/sua') }}" method="post">
                                          @csrf
                                           <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editing Specialized Information</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <input type="text" name="maCNganh" value="{{$y->maCNganh}}" hidden>
                                                <div class="form-group">
                                                  <label for="">Specialized Name</label>
                                                  <input type="text" name="tenCNganh" class="form-control" value="{{$y->tenCNganh}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Major</label>
                                                    <select name="maNganh" id="" class="form-control">
                                                      @foreach ($nganh as $z)
                                                        @if ($y->nganh->maNganh==$z->maNganh)
                                                        <option value="{{$z->maNganh}}" selected>{{$z->maNganh}} - {{$z->tenNganh}}</option>
                                                        @else
                                                        <option value="{{$z->maNganh}}">{{$z->maNganh}} - {{$z->tenNganh}}</option>
                                                        @endif
                                                        
                                                      @endforeach
                                                    </select>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                              </div>
                                            </div>
                                        </form>
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
      <!-- /.content-wrapper -->
@endsection