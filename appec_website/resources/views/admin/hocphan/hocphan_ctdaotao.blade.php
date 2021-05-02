@extends('admin.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('Course') }} - {{ __('Curriculum') }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('quan-ly') }}">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item"><a href="{{ asset('quan-ly/hoc-phan') }}">{{ __('Courses') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Courses') }}  - {{ __('Curriculum') }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">
                      {{ __('Course name') }}: {{ $hp->tenHocPhan }}--{{ __('Course ID') }}: {{ $hp->maHocPhan }}
                    </div>
                    <div class="card-tools">
                      <a href="{{ asset('/quan-ly/hoc-phan') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                    </div>
                  </div>
                 
                  <div class="card-body">
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                              <th>{{ __('No.') }}</th>
                              <th>{{ __('Curriculum name') }}</th>
                              <th>{{ __('Semester') }}</th>
                              <th>{{ __('Course type') }}</th>
                              <th>{{ __('Option') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($hp_ctdt as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ $data->ctDaoTao[0]->tenCT }}
                                    </td>
                                    <td>
                                        {{ $data->phanPhoiHocKy }}
                                    </td>
                                    <td>
                                        {{ $data->loaiHocPhan[0]->tenLoaiHocPhan }}
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{ $data->id }}">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete ?')" href="{{ asset('quan-ly/hoc-phan/xoa-hoc-phan-ct-dao-tao/'.$data->id) }}"><i class="fa fa-trash"></i></a>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="edit_{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form action="{{ asset('/quan-ly/hoc-phan/chinh-sua-hoc-phan-ct-dao-tao') }}" method="post">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Course') }} - {{ __('Curriculum') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="text" name="id" value="{{ $data->id }}" hidden>
                                                            <input type="text" name="maHocPhan" value="{{ $hp->maHocPhan }}" hidden>
                                                            <div class="form-group">
                                                                <label for="">{{ __('Curriculum') }}</label>
                                                                <select name="maCT" class="form-control">
                                                                    @foreach ($ctdt as $ct)
                                                                        @if ($ct->maCT==$data->maCT)
                                                                            <option value="{{ $ct->maCT }}" selected>{{ $ct->tenCT }}</option>
                                                                            
                                                                        @else
                                                                             <option value="{{ $ct->maCT }}">{{ $ct->tenCT }}</option>
                                                                            
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">{{ __('Semester') }}</label>
                                                                <input type="text" name="phanPhoiHocKy" class="form-control" value="{{ $data->phanPhoiHocKy }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">{{ __('Course type') }}</label>
                                                                <select name="maLoaiHocPhan" class="form-control">
                                                                    @foreach ($loaihp as $lhp)
                                                                        @if ($lhp->maLoaiHocPhan==$data->maLoaiHocPhan)
                                                                            <option value="{{ $lhp->maLoaiHocPhan }}" selected>{{ $lhp->tenLoaiHocPhan }}</option>
                                                                            
                                                                        @else
                                                                             <option value="{{ $lhp->maLoaiHocPhan }}">{{ $lhp->tenLoaiHocPhan }}</option>
                                                                            
                                                                        @endif
                                                                    @endforeach
                                                                </select>
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
                      </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
@endsection