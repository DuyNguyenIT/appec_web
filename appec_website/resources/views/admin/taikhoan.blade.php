@extends('admin.master')
@section('content')
<div class="content-wrapper" style="min-height: 96px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            Accounts Management<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('quan-ly') }}">Home</a></li>
            <li class="breadcrumb-item active">Accounts</li>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  <i class="fas fa-plus"></i>Add
              </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form action="{{ asset('quan-ly/tai-khoan/them') }}" method="post">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adding a new account </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" required>
                          </div>
                          <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" required>
                          </div>
                          <div class="form-group">
                            <label for="">Permission</label>
                            <select name="permission" id="" class="form-control" required>
                              <option value="1" selected>Administration</option>
                              <option value="2">Lecture</option>
                              <option value="3">Giáo vụ</option>
                              <option value="4">Bo mon</option>
                              <option value="5">Khoa</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="">is Blocked</label>
                            <select name="isBlock" class="form-control">
                              <option value="1">yes</option>
                              <option value="0">no</option>

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

               
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>User name</th>
                    <th>Email</th>
                    <th>Permission</th>
                    <th>is Block</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $i=1;
                  @endphp
                  @foreach ($users as $u)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$u->username}}</td>
                    <td>{{$u->email}}</td>
                    <td>
                      @php
                          $text_array=['Administration','Lecture','Giáo vụ','Bo mon','Khoa'];
                      @endphp
                      {{--  $u->permission-1 cho đúng chỉ mục của array--}}
                      <span class="badge badge-success">{{ $text_array[($u->permission-1)] }}</span> 
                    </td>
                    <td>
                        @if ($u->isBlock==1)
                        <span class="badge badge-danger">Blocked</span>
                        @endif
                    </td>
                    <td>
                      
                        <button title="Edit" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$u->username}}">
                          <i class="fas fa-edit"></i>
                        </button>
                        @if ($u->isBlock==0)
                        <a title="Block" href="{{ asset('quan-ly/tai-khoan/khoa/'.$u->username) }}" class="btn btn-warning"><i class="fa fa-lock"></i></a>
                            
                        @else
                        <a title="unBlock" href="{{ asset('quan-ly/tai-khoan/mo-khoa/'.$u->username) }}" class="btn btn-info"><i class="fas fa-lock-open"></i></a>
                        @endif
                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete {{$u->username}}?')" href="{{ asset('quan-ly/tai-khoan/xoa/'.$u->username) }}"><i class="fa fa-trash"></i></a>



                        <div class="modal fade" id="edit_{{$u->username}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <form action="{{ asset('quan-ly/tai-khoan/sua') }}" method="post">
                            @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">
                                    Editing the account
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="username" value="{{$u->username}}" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{$u->email}}" placeholder="Email" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="">Permission</label>
                                    <select name="permission" id="" class="form-control" required>
                                    
                                      @for ($i = 0; $i < count($text_array); $i++)
                                          @if ($u->permission==($i+1))
                                            <option value="{{ $i+1 }}" selected>{{ $text_array[$i] }}</option>
                                          @else
                                          <option value="{{ $i+1 }}">{{ $text_array[$i] }}</option>
                                          @endif
                                      @endfor
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="">is Blocked</label>
                                    <select name="isBlock" class="form-control">
                                      @if ($u->isBlock==true)
                                      <option value="1" selected>yes</option>
                                      <option value="0">no</option>
                                      @else
                                      <option value="1">yes</option>
                                      <option value="0" selected>no</option>
                                      @endif
                                      
        
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
@endsection