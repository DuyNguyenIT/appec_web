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
                  {{ __('Majors') }}<noscript></noscript>
                  <nav></nav>
                </h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ asset('quan-ly') }}">{{ __('Home') }}</a></li>
                  <li class="breadcrumb-item active">{{ __('Majors') }}</li>
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
        <h5><i class="icon fas fa-check"></i> Thông báo!</h5>
        {{session('success')}}
      </div>
      @endif
      @if(session('warning'))
        <div class="alert alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> Thông báo!</h5>
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
                        <i class="fas fa-plus"></i>
                      </button>

                        <!-- Modal -->
                        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <form action="{{ asset('quan-ly/nganh-hoc/them') }}" method="post">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">{{ __('Adding a new') }} {{ __('Majors') }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                      <div class="form-group">
                                        <label for="">{{ __('Major ID') }}:</label>
                                        <input type="text" name="maNganh" class="form-control" required>
                                      </div>
                                      <div class="form-group">
                                        <label for="">{{ __('Major name') }}:</label>
                                        <input type="text" name="tenNganh" class="form-control" required>
                                      </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
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
                          <th>{{ __('No.') }}</th>
                          <th>{{ __('Major ID') }}</th>
                          <th>{{ __('Major name') }}</th>
                          <th>{{ __('Option') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($nganh as $x)
                                <tr>
                                  <td>{{$i++}}</td>
                                  <td>

                                    {{$x->maNganh}}
                                  </td>
                                  <td>

                                    {{$x->tenNganh}}
                                  </td>
                                  <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$x->maNganh}}">
                                      <i class="fa fa-edit"></i>
                                    </button>
                                    <a class="btn btn-danger" onclick="return confirm('Confirming delete {{$x->tenNganh}}?')" href="{{ asset('quan-ly/nganh-hoc/xoa/'.$x->maNganh) }}"><i class="fa fa-trash"></i></a>
                                    <!-- Button trigger modal --> 
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit_{{$x->maNganh}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <form action="{{ asset('quan-ly/nganh-hoc/sua') }}" method="post">
                                          @csrf
                                           <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editing majors information</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <input type="text" name="maNganh" value="{{$x->maNganh}}" hidden>
                                                <div class="form-group">
                                                  <label for="">{{ __('Major name') }}:</label>
                                                  <input type="text" name="tenNganh" class="form-control" value="{{$x->tenNganh}}" required>
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
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