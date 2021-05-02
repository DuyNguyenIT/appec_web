@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              {{ __('Course') }}<noscript></noscript>
              <nav></nav>
              
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Course') }}</li>
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

                  <!-- <a href="themhocphan.html">-->
                     <!-- <button type="button" class="btn btn-primary">
                        <i class="fas fa-plus"></i>-->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                          <i class="fas fa-plus"></i>{{ __('Add') }}
                      </button>
                  <!-- </a>-->
                  

                </h3>
               
                <!-- PTTMai thêm -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ asset('quan-ly/hoc-phan/them') }}" method="post">
                    @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">{{ __('Adding a new course') }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="">{{ __('Course ID') }}</label>
                            <input type="text" name="maHocPhan" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label for="">{{ __('Course Name') }}</label>
                            <input type="text" name="tenHocPhan" class="form-control" required>
                          </div>
                          <!-- <div class="form-group">
                            <label for="">Tổng tín chỉ</label>
                            <input type="number" name="tongSoTinChi" class="form-control">
                          </div>-->
                          <div class="form-group">
                            <label for="">{{ __('Number of Theory Credits') }}</label>
                            <input type="number" name="tinChiLyThuyet" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label for="">{{ __('Number of Practice Credits') }}</label>
                            <input type="number" name="tinChiThucHanh" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label for="">{{ __('Knowledge block') }}</label>
                            <select name="maCTKhoiKT" id="" class="form-control" required>
                              @foreach ($ctkhoi as $x)
                                  <option value="{{$x->maCTKhoiKT}}">{{$x->maCTKhoiKT}} - {{$x->tenCTKhoiKT}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="">{{ __('Curriculum') }}</label>
                            <select name="maCT" id="" class="form-control" required>
                              @foreach ($ctdt as $y)
                                <option value="{{$y->maCT}}" > {{$y->tenCT}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="">{{ __('Semester') }}</label>
                            <input type="number" min="1" max="8" name="phanPhoiHocKy" class="form-control"  required>
                          </div>
                          <div class="form-group">
                            <label for="">{{ __('Course Type') }}</label>
                            <select name="maLoaiHocPhan" id="" class="form-control" required>
                              @foreach ($loaihp as $z)
                                <option value="{{$z->maLoaiHocPhan}}"> {{$z->tenLoaiHocPhan}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="">{{ __('Course Description') }}</label>
                            <textarea name="moTaHocPhan" class="form-control"></textarea>
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
                <!-- hết PTTMai thêm -->
              </div>
              <!-- /.card-header -->
              <!-- PTTMai thêm đồng thời có xóa <div class="card-body"> trước đó của Duy-->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>{{ __('No.') }}</th>
                      <th>{{ __('Course ID') }}</th>
                      <th>{{ __('Course Name') }}</th>
                      <th>{{ __('Total Credits') }}</th>
                      <th>{{ __('Number of Theory Credits') }}</th>
                      <th>{{ __('Number of Practice Credits') }}</th>
                      <th>{{ __('Knowledge block') }}</th>
                      <th>{{ __('Curriculum') }}</th>
                      <th>{{ __('Option') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($hocphan as $hp)
                        <tr>
                          <td>{{$i++}}</td>
                          <td>{{$hp->maHocPhan}}</td>
                          <td>{{$hp->tenHocPhan}}</td>
                          <td>{{$hp->tongSoTinChi}}</td>
                          <td>{{$hp->tinChiLyThuyet}}</td>
                          <td>{{$hp->tinChiThucHanh}}</td>
                          <td>
                            @if (Session::has('language')&& Session::get('language'))
                                {{$hp->ctkhoi->tenCTKhoiKTEN}}
                            @else
                               {{$hp->ctkhoi->tenCTKhoiKT}}
                            @endif
                            
                          </td>
                          <td>

                            @foreach ($hp->hocphan_ctdt as $item)
                               <li>{{ $item->tenCT }}- <b>HK {{ $item->phanPhoiHocKy }}</b> ; </li> 
                            @endforeach
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_CT_{{$hp->maHocPhan }}">
                              <i class="fas fa-plus"></i>
                            </button>
                            <a href="{{ asset('quan-ly/hoc-phan/hoc-phan-ct-dao-tao/'.$hp->maHocPhan) }}" class="btn btn-primary">...</a>

                            <!-- Modal -->
                            <div class="modal fade" id="add_CT_{{$hp->maHocPhan }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="{{ asset('quan-ly/hoc-phan/them-hoc-phan-ctdt') }}" method="post">
                                  @csrf
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <input type="text" name="maHocPhan" value="{{ $hp->maHocPhan }}" hidden>
                                      <div class="form-group">
                                        <label for="">{{ __('Curriculum') }}</label>
                                        <select name="maCT" id="" class="form-control" required>
                                          @foreach ($ctdt as $y)
                                            <option value="{{$y->maCT}}" > {{$y->tenCT}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label for="">{{ __('Semester') }}</label>
                                        <input type="number" min="1" max="8" name="phanPhoiHocKy" class="form-control"  required>
                                      </div>
                                      <div class="form-group">
                                        <label for="">{{ __('Course Type') }}</label>
                                        <select name="maLoaiHocPhan" id="" class="form-control" required>
                                          @foreach ($loaihp as $z)
                                            <option value="{{$z->maLoaiHocPhan}}"> {{$z->tenLoaiHocPhan}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancle') }}</button>
                                     
                                    </div>
                                  </div>
                                </form>
                                
                              </div>
                            </div>

                          </td>
                          <td> 
                            <a href=" {{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/'.$hp->maHocPhan) }}" class="btn btn-success">
                              <i class="fas fa-align-justify"></i> {{ __('Course Syllabus') }}
                            </a>
  
                              <button title="Edit" class="btn btn-success" data-toggle="modal" data-target="#edit_{{$hp->maHocPhan}}">
                                <i class="fas fa-edit"></i> 
                              </button>
                            <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete {{$hp->tenHocPhan}}?')" href="{{ asset('quan-ly/hoc-phan/xoa/'.$hp->maHocPhan) }}"><i class="fa fa-trash"></i></a>
                              <!-- Modal -->
                            <div class="modal fade" id="edit_{{$hp->maHocPhan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="{{ asset('quan-ly/hoc-phan/sua') }}" method="post">
                                @csrf
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editing Course Information</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <input type="text" name="maHocPhan" value="{{$hp->maHocPhan}}" class="form-control" hidden>
                                    <div class="form-group">
                                      <label for="">{{ __('Course Name') }}</label>
                                      <input type="text" name="tenHocPhan" class="form-control" value="{{$hp->tenHocPhan}}" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="">{{ __('Number of Theory Credits') }}</label>
                                      <input type="number" name="tinChiLyThuyet" class="form-control" value="{{$hp->tinChiLyThuyet}}" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="">{{ __('Number of Practice Credits') }}</label>
                                      <input type="number" name="tinChiThucHanh" class="form-control" value="{{$hp->tinChiThucHanh}}" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="">{{ __('Knowledge block') }}</label>
                                      <select name="maCTKhoiKT" id="" class="form-control" required>
                                        @foreach ($ctkhoi as $x)
                                          @if ($hp->ctkhoi->maCTKhoiKT==$x->maCTKhoiKT)
                                          <option value="{{$x->maCTKhoiKT}}" selected>{{$x->maCTKhoiKT}} - {{$x->tenCTKhoiKT}}</option>
                                          @else
                                          <option value="{{$x->maCTKhoiKT}}">{{$x->maCTKhoiKT}} - {{$x->tenCTKhoiKT}}</option>
                                          @endif
                                          
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="">{{ __('Course Description') }}</label>
                                      <textarea name="moTaHocPhan" class="form-control" >{{$hp->moTaHocPhan}}</textarea>
                                    </div>
                                  </div>
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
              <!-- hết PTTMai thêm-->

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

