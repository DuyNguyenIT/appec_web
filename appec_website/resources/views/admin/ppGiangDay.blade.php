@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              {{ __('Teaching methods') }}<noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('quan-ly') }}">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Teaching methods') }}</li>
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
                <h3 class="card-title"></h3>
                <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPPGD">
                <i class="fas fa-plus"></i>
              </button>

              <!-- Modal -->
              <div class="modal fade" id="addPPGD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form action="{{ asset('/quan-ly/phuong-phap-giang-day/them') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }} {{ __('Teaching methods') }}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="">{{ __('Teaching methods name') }}</label>
                          <input type="text" name="tenPP" class="form-control" required>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>{{ __('No.') }}</th>
                      <th>{{ __('Teaching methods name') }}</th>
                      <th>{{ __('Option') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($ppGiangDay as $data)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $data->tenPP}}</td>
                      <td>
                       <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editPP_{{ $data->maPP }}">
                          <i class="fas fa-edit"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="editPP_{{ $data->maPP }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <form action="{{ asset('/quan-ly/phuong-phap-giang-day/sua') }}" method="post">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit') }} {{ __('Teaching methods') }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <input type="text" name="maPP" value="{{ $data->maPP }}" hidden>
                                    <div class="form-group">
                                      <label for="">{{ __('Teaching methods name') }}</label>
                                      <input type="text" name="tenPP" value="{{ $data->tenPP }}" class="form-control" required>
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
@endsection