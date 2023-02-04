@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            {{ __('Level-2 Student Outcomes Management')}}<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ asset('/quan-ly/chuan-dau-ra') }}">{{ __('Level-1 Student Outcomes') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Level-2 Student Outcomes')}}</li>
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
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
        <h5><i class="icon fas fa-check"></i> Message!</h5>
        {{session('success')}}
      </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
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
                          <i class="fas fa-plus"></i>{{ __('Add') }}
                </button>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form action="{{ asset('quan-ly/chuan-dau-ra/chuan-dau-ra-2/them') }}" method="post">
                        @csrf
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">{{ __('Adding a new Level-2 Student Outcome')}}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">x</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">

                                <label for="">{{ __('Level-2 Student Outcome ID')}}</label>
                                <input type="text" name="maCDR2VB" class="form-control" placeholder="">
                              </div>
                                <div class="form-group">
                                  <label for="">{{ __('Level-2 Student Outcome Name')}} (Vietnamese)</label>
                                  <input type="text" name="tenCDR2" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                  <label for="">{{ __('Level-2 Student Outcome Name')}} (English)</label>
                                  <input type="text" name="tenCDR2EN" class="form-control" placeholder="">
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
                      <th>{{ __('No.') }}</th>
                      <th> {{ __('Level-2 Student Outcome ID') }}</th>
                      <th> {{ __('Level-2 Student Outcome Name')}} (Vietnamese)</th>
                      <th>{{ __('Level-2 Student Outcome Name')}} (English)</th>
                      <th> {{ __('Level-1 Student Outcome ID') }} </th>
                      <th>{{ __('Option') }}</th>
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
                        <td>{{$cdr2->tenCDR2EN}}</td>
                        <td>{{$cdr2->maCDR1VB}}</td>

                        <td>
                          
                            <button title="Edit"  class="btn btn-success" data-toggle="modal" data-target="#edit_{{$cdr2->maCDR2}}">
                              <i class="fas fa-edit"></i>
                            </button>
                            <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete {{$cdr2->tenCDR2}}?')" href="{{ asset('quan-ly/chuan-dau-ra/chuan-dau-ra-2/xoa/'.$cdr2->maCDR2) }}"><i class="fa fa-trash"></i></a>
                            <a href="{{ asset('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.$cdr2->maCDR2) }}">
                              <button class="btn btn-primary">
                                {{ __('Level-3 Student Outcomes')}}
                              </button>
                          </a>
                          <div class="modal fade" id="edit_{{$cdr2->maCDR2}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form action="{{ asset('quan-ly/chuan-dau-ra/chuan-dau-ra-2/sua') }}" method="post">
                              @csrf
                          
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">
                                    {{ __('Editing Level-2 Student Outcome Information')}}
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">�</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <input type="text" name="maCDR2" value="{{$cdr2->maCDR2}}" class="form-control" hidden>
                                 
                                  <div class="form-group">
                                    <label for="">{{ __('Level-2 Student Outcome ID')}} :</label>
                                    <input type="text" name="maCDR2VB" class="form-control" value="{{$cdr2->maCDR2VB}}">
                                  </div> 
                                  
                                  <div class="form-group">
                                    <label for="">{{ __('Level-2 Student Outcome Name')}} (Vietnamese)</label>
                                    <input type="text" name="tenCDR2" class="form-control" value="{{$cdr2->tenCDR2}}">
                                  </div>

                                  <div class="form-group">
                                    <label for="">{{ __('Level-2 Student Outcome Name')}} (English)</label>
                                    <input type="text" name="tenCDR2EN" class="form-control" value="{{$cdr2->tenCDR2EN}}">
                                  </div>
                                
                                </div> <!-- end modal-body-->
                              </form>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel')}}</button>
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