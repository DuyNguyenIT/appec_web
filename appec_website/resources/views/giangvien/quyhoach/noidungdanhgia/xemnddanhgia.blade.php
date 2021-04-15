@extends('giangvien.master')
@section('content')






     <!-- Content Wrapper. Contains page content -->
     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                  Đồ án<noscript></noscript>
                  <nav></nav>
                </h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <a href="{{ asset('/giang-vien') }}">Trang chủ</a>
                  </li>
                  <li class="breadcrumb-item">
                    <a href="quyhoachKQHT.html">Đồ án</a>
                  </li>
                  <li class="breadcrumb-item active">Nội dung đánh giá</li>
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
      
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >
                        <i class="far fa-address-card"></i> Thêm phiếu chấm
                      </button>
                      <a href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.$maCTBaiQH) }}"class="btn btn-primary">
                        <i class="fas fa-balance-scale-left"></i> Tiêu chí đánh giá đồ án
                      </a>
                      <button class="btn btn-primary" data-toggle="modal" data-target="#moichambc">
                          Mời chấm báo cáo
                      </button>
                        <!-- Modal mời chấm báo cáo -->
                        <div class="modal fade" id="moichambc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/moi-cham-bao-cao') }}" method="post">
                              @csrf
                               <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Mời chấm báo cáo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="form-group">
                                  <label for=""> Chọn giảng viên:</label>
                                  <select name="maGV_2" id="" class="form-control">
                                    <option value="00000">Chọn riêng giảng viên chấm cho đề tài</option>
                                    @foreach ($gv as $x)
                                        <option value="{{$x->maGV}}">{{$x->hoGV}} {{$x->tenGV}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                              </div>
                            </div>
                            </form>
                           
                          </div>
                        </div>

                      <!-- Modal thêm phiếu chấm -->
                      <div
                        class="modal fade bd-example-modal-lg"
                        id="exampleModal"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-phieu-cham') }}" method="post">
                           @csrf
                            <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">
                                Thêm phiếu chấm
                              </h5>
                              <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <label for="hocphan" style="font-size: 20px">Chọn đề tài</label> 
                                <!-- Button trigger modal -->
                                <select name="maDe" id="" class="form-control custom-select">
                                    @foreach ($deTai as $md)
                                        
                                        <option value="{{$md->maDe}}">
                                          {{$md->maDeVB}}--{{$md->tenDe}}
                                        </option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="">Chọn sinh viên</label>
                                <select name="maSSV" id="" class="form-control custom-select">
                                  @foreach ($dsLop as $sv)
                                      <option value="{{$sv->maSSV}}">{{$sv->maSSV}}--{{$sv->HoSV}} {{$sv->TenSV}}</option>
                                  @endforeach
                                </select>
                              </div>
                              
                              @if ($canbo2->maGV=='00000')
                                <div class="form-group">
                                  <label for=""> Chọn giảng viên:</label>
                                    <select name="maGV_2" id="" class="form-control">
                                      @foreach ($gv as $x)
                                          <option value="{{$x->maGV}}">{{$x->hoGV}} {{$x->tenGV}}</option>
                                      @endforeach
                                    </select>
                              </div>
                              @endif
                              
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">
                                Lưu
                              </button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Hủy
                              </button>
                            </div>
                          </div>
                          </form>
                         
                        </div>
                      </div>
                      <hr>
                      Cán bộ chấm 2: {{$canbo2->hoGV}} {{$canbo2->tenGV}}
                     </h3>
                  </div>
                  {{-- <div class="card-header">Giảng viên cộng tác: <b>Võ Thành C</b></div> --}}
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table
                      id="example2"
                      class="table table-bordered table-hover"
                    >
                      <thead>
                        <tr>
                          <th>STT</th>
                          <th>Mã đề tài</th>
                          <th>
                         
                          
                          <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#themDT">
                              <i class="fas fa-plus"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="themDT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-de-tai') }}" method="post">
                                  @csrf
                                  <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Thêm đề tài</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="form-group">
                                      <label for="">Nhập mã đề tài:</label>
                                      <input type="text" name="maDe" class="form-control">
                                    </div>
                                    <div class="form-group">
                                      <label for="">Nhập tên đề tài:</label>
                                      <input type="text" name="tenDe" class="form-control">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                   
                                  </div>
                                </div>
                                </form>
                                
                              </div>
                            </div>
                          Tên đề tài
                          </th>
                          <th>Sinh viên thực hiện</th>
                          <th>Mã sinh viên</th>
                          <th>Cán bộ chấm 2</th>
                          <th>Tùy chọn</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $i=1;
                          $chayTenDT=0;
                          $maDe_cur=0;
                      @endphp
                        @foreach ($deThi as $dt)
                        @php      
                             $demTenDT=$deThi->where('maDe',$dt->maDe)->count();
                             if($chayTenDT>$demTenDT)
                                $chayTenDT=1;
                             else {
                                $chayTenDT+=1;
                            }
                             if($maDe_cur!==$dt->maDe){
                                $maDe_cur=$dt->maDe;
                                $chayTenDT=1;
                            }
                        @endphp
                        @if ($chayTenDT==1)
                        <tr>
                            <td rowspan={{$demTenDT}}>{{$i++}}</td>
                            <td rowspan={{$demTenDT}}>{{$dt->maDeVB}}</td>
                            <td rowspan={{$demTenDT}}>{{$dt->tenDe}}

                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editTen_{{ $dt->maDe }}">
  
<i class="fas fa-edit"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="editTen_{{ $dt->maDe }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/sua-ten-de-tai') }}" method="post">
    @csrf
  <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" name="maDe" id="" hidden value="{{ $dt->maDe }}">
          <div class="form-group">
            <label for="">T�n &#273;&#7873; t�i:</label>
          <input type="text" class="form-control" name="tenDe" id="" value="{{ $dt->tenDe }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
</td>
                            
                            <td>{{$dt->HoSV}} {{$dt->TenSV}}</td>
                            <td>{{$dt->maSSV}}</td>
                            <td>{{$dt->hoGV}} {{$dt->tenGV}}</td>
                            <td>
                              <button class="btn btn-primary">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                              </button>
                              <a class="btn btn-danger" href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xoa-phieu-cham-do-an/'.$dt->maDe.'/'.$dt->maSSV) }}" onclick="confirm('x�c nh&#7853;n x�a?')"><i class="fas fa-trash"></i></a>

                            </td>
                        </tr>
                        @else
                        <tr>
                          <td>{{$dt->HoSV}} {{$dt->TenSV}}</td>
                          <td>{{$dt->maSSV}}</td>
                          <td>{{$dt->hoGV}} {{$dt->tenGV}}</td>
                          <td>
                            <button class="btn btn-primary">
                              <i class="fas fa-edit"></i> Chỉnh sửa
                            </button>
                              <a class="btn btn-danger" href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xoa-phieu-cham-do-an/'.$dt->maDe.'/'.$dt->maSSV) }}" onclick="confirm('x�c nh&#7853;n x�a?')"><i class="fas fa-trash"></i></a>

                          </td>
                        @endif
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