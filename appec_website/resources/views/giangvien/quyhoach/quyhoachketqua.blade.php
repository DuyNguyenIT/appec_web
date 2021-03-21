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
                      Quy hoạch đánh giá kết quả học tập<noscript></noscript>
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
                        <a href="{{ asset('giang-vien/quy-hoach-danh-gia') }}"
                          >{{$hp->tenHocPhan}}</a
                        >
                      </li>
    
                      <li class="breadcrumb-item active">
                        Quy hoạch đánh giá kết quả học tập
                      </li>
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
                        <h3 class="card-title">
                          
                        @if ($count_ct==0)
                          <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/chon-nhom-cong-thuc') }}" method="post">
                          @csrf   
                          <div class="form-group">
                                <label for="">Chọn nhóm công thức:</label>
                                <select name="groupCT" id="" class="form-control">
                                  <option value="1">
                                    @php
                                        $n=$hocphan_loai_htdg_array->where('groupCT',1)->count();
                                        $cr=0;
                                    @endphp
                                    @foreach ($hocphan_loai_htdg_array as $data)
                                      @if ($cr!=0 && $cr<$n && $data->groupCT==1)
                                          +
                                          @php
                                              $cr++;
                                          @endphp
                                          {{ $data->loaiHTDanhGia['maLoaiHTDG'] }}*{{ $data->trongSo }}%
                                      @elseif($data->groupCT==1)
                                          @php
                                              $cr++;
                                          @endphp
                                          {{ $data->loaiHTDanhGia['maLoaiHTDG'] }}*{{ $data->trongSo }}%
                                      @endif
                                    @endforeach
                                  </option>
                                  @php
                                        $n=$hocphan_loai_htdg_array->where('groupCT',2)->count();
                                        $cr=0;
                                  @endphp
                                  @if ($n>0)
                                  <option value="2" >

                                    @foreach ($hocphan_loai_htdg_array as $data)
                                      @if ($cr!=0 && $cr<$n && $data->groupCT==2)
                                          +
                                          @php
                                              $cr++;
                                          @endphp
                                          {{ $data->loaiHTDanhGia['maLoaiHTDG'] }}*{{ $data->trongSo }}%
                                      @elseif($data->groupCT==2)
                                          @php
                                              $cr++;
                                          @endphp
                                          {{ $data->loaiHTDanhGia['maLoaiHTDG'] }}*{{ $data->trongSo }}%
                                      @endif
                                    @endforeach
                                  </option>
                                  @endif
                                
                                </select>
                              </div>
                              <button type="submit" class="btn btn-primary"  >
                                <i class="fas fa-plus"></i> Choose
                              </button>
                        @endif
                         
                      </form>
                       
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
                              <th>STT</th>
                              <th>Hình thức đánh giá</th>
                              
                              <th>Tỉ lệ (%)</th>
                              <th>Phương pháp đánh giá</th>
                              <th>Tùy chọn</th>
                            </tr>
                          </thead>
                          <tbody>
                              @php
                                  $i=1;
                              @endphp
                              @foreach ($qh as $x)
                              <tr>
                                <td>{{$i++}}</td>
                                <td>{{$x->tenLoaiDG}}</td>
                                <td>{{$x->trongSo}}%</td>
                             
                                <td>{{$x->tenLoaiHTDG}}</td>
                                <td style='white-space: nowrap'>
                                  <a href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.$x->maCTBaiQH) }}" class="btn btn-success">
                                    <i class="fas fa-align-justify"></i> Nội dung quy hoạch               
                                </a>
                                  <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.$x->maCTBaiQH) }}">
                                    <button class="btn btn-success">
                                      <i class="fas fa-info-circle"></i> Nội dung đánh
                                      giá
                                    </button>
                                  </a>
                                  <button class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                  </button>
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