@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              {{ __('Level-1 Student Outcomes') }} <noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Level-1 Student Outcomes') }}</li>
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

              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-plus"></i>
              </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form action="{{ asset('quan-ly/chuan-dau-ra/them') }}" method="post">
                    @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">

                            <label for="">{{ __('Level-1 Student Outcome ID') }}:</label>
                            <input type="text" name="maCDR1VB" class="form-control" placeholder="">
                          </div>
                            <div class="form-group">
                              <label for="">{{ __('Level-1 Student Outcome Name') }}:</label>
                              <input type="text" name="tenCDR1" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">{{ __('Level-1 Student Outcome Name') }} (EN):</label>
                              <input type="text" name="tenCDR1EN" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="modal-footer"> 
                          <button type="submit" class="btn btn-primary">{{ _('Save') }}</button>
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
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>{{ __('No.') }}</th>
                      <th>{{ __('Level-1 Student Outcomes ID') }}</th>
                      <th>{{ __('Level-1 Student Outcomes Name') }} </th>
                      <th>{{ __('Option') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($chuandaura as $cdr)
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$cdr->maCDR1VB}}</td>
                        <td>
                          @if (Session::has('language') && Session::get('language')=='vi')
                              {{$cdr->tenCDR1}}
                          @else
                              {{$cdr->tenCDR1EN}}s
                          @endif
                        </td>
                        <td>
                         
                          <div class="btn-group">
                            <button title="Edit" class="btn btn-success" data-toggle="modal" data-target="#edit_{{$cdr->maCDR1}}">
                              <i class="fas fa-edit"></i> 
                            </button>
                          <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete {{$cdr->tenCDR1}}?')" href="{{ asset('quan-ly/chuan-dau-ra/xoa/'.$cdr->maCDR1) }}"><i class="fa fa-trash"></i></a>

                          </div>
                          <a href="{{ asset('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.$cdr->maCDR1) }}" class="btn btn-primary">
                                <i class="fas fa-align-justify"></i>{{ __('Level-2 Student Outcomes') }}
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
                                        <span aria-hidden="true">x</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <input type="text" name="maCDR1" value="{{$cdr->maCDR1}}" class="form-control" hidden>
                                      <!-- PTTMai th�m -->
                                      <div class="form-group">
                                        <label for="">{{ __('Level-1 Student Outcome ID') }}:</label>
                                        <input type="text" name="maCDR1VB" class="form-control" value="{{$cdr->maCDR1VB}}">
                                      </div> 
                                      
                                      <div class="form-group">
                                        <label for="">{{ __('Level-1 Student Outcome Name') }}</label>
                                        <input type="text" name="tenCDR1" class="form-control" value="{{$cdr->tenCDR1}}">
                                      </div>

                                      <div class="form-group">
                                        <label for="">{{ __('Level-1 Student Outcome Name') }} (EN)</label>
                                        <input type="text" name="tenCDR1EN" class="form-control" value="{{$cdr->tenCDR1EN}}">
                                      </div>
                                      <!-- h&#7871;t PTTMai th�m -->
                                    </div> <!-- end modal-body-->
                                  </form>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
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