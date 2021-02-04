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
                        <a href="{{ asset('giang-vien') }}">Trang chủ</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="{{ asset('giang-vien/ket-qua-danh-gia') }}"
                          >{{$hp->tenHocPhan}}</a
                        >
                      </li>
                      <li class="breadcrumb-item active">Đồ án</li>
                    </ol>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
    
            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="">
                          <b>Cán bộ chấm 1:</b> {{$gv->hoGV}} {{$gv->tenGV}}<br />
                          <b>Cán bộ chấm 2:</b> {{$gv2->hoGV}} {{$gv2->tenGV}}<br />
                        </h4>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table  id="example2" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>STT</th>
                              <th>Tên đề tài</th>
                              <th>Sinh viên thực hiện</th>
                              <th>Mã sinh viên</th>
                              <th>Điểm CB1</th>
                              <th>Điểm CB2</th>
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
                                            <td rowspan={{$demTenDT}}>{{$dt->tenDe}}</td>
                                            
                                            <td>{{$dt->HoSV}} {{$dt->TenSV}}</td>
                                            <td>{{$dt->maSSV}}</td>
                                            @if ($dt->trangThai==false)
                                                 <td>
                                                  {{$dt->diemSo}}
                                                </td>
                                                <td>
                                                  {{$dt->diemCB2}}
                                                </td>
                                                <td>
                                                <a href="{{ asset('/giang-vien/ket-qua-danh-gia/nhap-diem-do-an/'.$dt->maDe.'/'.$dt->maSSV) }}">
                                                    <button class="btn btn-primary">
                                                    <i class="fas fa-edit"></i> Chấm điểm
                                                    </button>
                                                </a>
                                                </td>
                                            @else
                                                <td>{{$dt->diemSo}}</td>
                                                <td>{{$dt->diemCB2}}</td>
                                                <td>
                                                  <a href="{{ asset('/giang-vien/ket-qua-danh-gia/xem-ket-qua-danh-gia/'.$dt->maDe.'/'.$dt->maSSV.'/1') }}">
                                                    <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i> Xem kết quả cán bộ chấm 1
                                                    </button>
                                                </a>

                                                <a href="{{ asset('/giang-vien/ket-qua-danh-gia/xem-ket-qua-danh-gia/'.$dt->maDe.'/'.$dt->maSSV.'/2') }}">
                                                  <button class="btn btn-primary">
                                                  <i class="fas fa-eye"></i> Xem kết quả cán bộ chấm 2
                                                  </button>
                                              </a>
                                                </td>
                                            @endif
                                           
                                        </tr> 
                                    @else
                                        <tr>
                                            <td>{{$dt->HoSV}} {{$dt->TenSV}}</td>
                                            <td>{{$dt->maSSV}}</td>
                                            @if ($dt->trangThai==false)
                                                 <td>

                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                  <a href="{{ asset('/giang-vien/ket-qua-danh-gia/nhap-diem-do-an/'.$dt->maDe.'/'.$dt->maSSV) }}">
                                                      <button class="btn btn-primary">
                                                      <i class="fas fa-edit"></i> Chấm điểm
                                                      </button>
                                                  </a>
                                                </td>
                                            @else
                                                <td>{{$dt->diemSo}}</td>
                                                <td>{{$dt->diemCB2}}</td>

                                                <td>
                                                  <a href="{{ asset('/giang-vien/ket-qua-danh-gia/xem-ket-qua-danh-gia/'.$dt->maDe.'/'.$dt->maSSV.'/1') }}">
                                                      <button class="btn btn-success">
                                                      <i class="fas fa-eye"></i> Xem kết quả cán bộ chấm 1
                                                      </button>
                                                  </a>

                                                  <a href="{{ asset('/giang-vien/ket-qua-danh-gia/xem-ket-qua-danh-gia/'.$dt->maDe.'/'.$dt->maSSV.'/2') }}">
                                                    <button class="btn btn-primary">
                                                    <i class="fas fa-eye"></i> Xem kết quả cán bộ chấm 2
                                                    </button>
                                                </a>
                                                </td>
                                            @endif
                                        </tr>
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