@extends('admin.no_menu_master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Đề cương môn học<noscript></noscript>
              <nav></nav>
              
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active"><a href="{{ asset('quan-ly/hoc-phan') }}">Học phần</a></li>
              <li class="breadcrumb-item active">Đề cương môn học</li>
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
                <h3  style="text-align: center">
                  ĐỀ CƯƠNG MÔN HỌC <br>
                Môn: {{ $hocPhan->tenHocPhan }} <br>
                Mã học phần: {{ $hocPhan->maHocPhan }}
                </h3>
              </div>
              <a href="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/in-de-cuong-mon-hoc/'.$hocPhan->maHocPhan) }}">IN ĐỀ CƯƠNG</a>
              <!-- /.card-header -->
              <div class="card-body">
              <h5><b>1. Thông tin chung</b></h5>    <!-- ----------------------------------1. Thông tin chung-------------------- -->
              <table class="table table-bordered">
                <thead class="thead-green" style="background-color: green">
                  <tr>
                    <th>Loại môn học</th>
                    <th>Số tín chỉ</th>
                    <th>Số giờ học</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      @php
                          $daicuong = array("A1", "A2", "A3", "A4","A5");
                          $coso = array('B1','B2' );
                          $chuyennganh = array('B3');
                      @endphp
                      @if (in_array($hocPhan->maCTKhoiKT,$daicuong))
                        <ul>
                          <li>Đại cương <i class="far fa-check-square"></i>
                          <li>Cở sở
                          <li>Chuyên ngành
                        </ul>
                      @else
                          @if (in_array($hocPhan->maCTKhoiKT,$coso))
                            <ul>
                              <li>Đại cương 
                              <li>Cở sở <i class="far fa-check-square"></i>
                              <li>Chuyên ngành
                            </ul>
                          @else
                            @if (in_array($hocPhan->maCTKhoiKT,$chuyennganh))
                                <ul>
                                <li>Đại cương 
                                <li>Cở sở 
                                <li>Chuyên ngành <i class="far fa-check-square"></i>
                              </ul>
                            @endif
                          @endif
                      @endif
                   
                      
                    </td>
                    <td>
                      <ul>
                        <li>Lý thuyết: {{ $hocPhan->tinChiLyThuyet }}
                        <li>Bài tập: 
                        <li>Thực hành: {{ $hocPhan->tinChiThucHanh }}
                      </ul>
                    </td>
                    <td>
                      <ul>
                        <li>Lý thuyết: {{ $hocPhan->tinChiLyThuyet *15 }}
                        <li>Bài tập: 
                        <li>Thực hành: {{ $hocPhan->tinChiThucHanh *30 }}
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="row">
                <div class="col-md-4">
                  <h6><b>Đối tượng học:</b></h6> 
                </div>
                <div class="col-md-7">
                  Bậc: {{ $bac->tenBac }} <br>
                  Ngành: {{ $nganh->tenNganh }} <br>
                  Chuyên ngành: {{ $CNganh->tenCNganh }}<br>
                  Hệ: {{ $he->tenHe }} <br>
                </div>
                <div class="col-md-1">
                  <td>
                  </td>
                </div>
              </div>
             <h6><b>Điều kiện tham gia môn học</b></h6>
             <table class="table table-bordered">
               <tr>
                 <td>Môn học tiên quyết</td>
                 <td><i>
                  @foreach ($monTQ as $data)
                      {{ $data->hoc_phan->tenHocPhan }};
                  @endforeach   
                </i></td>
                 <td>
                 <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMonTQ">
                  <i class="fas fa-edit"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addMonTQ" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_mon_tien_quyet') }}" method="post">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm môn tiên quyết</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <div class="form-group">
                          <label for="">Chọn môn tiên quyết</label>
                          <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                          <select name="maMonTienQuyet" id="" class="form-control">
                              @foreach ($monHoc as $data)
                                  <option value="{{ $data->maHocPhan }}"> {{ $data->maHocPhan }} -- {{ $data->tenHocPhan }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                    
                    </form>
                    
                  </div>
                </div>
                </td>
               </tr>
               <tr>
                 <td>Các yêu cầu khác</td>
                 <td>
                   <i>
                     {!! $hocPhan->yeuCau !!}
                   </i>
                 </td>
                 <td>
                  
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addyeuCau">
                    <i class="fas fa-edit"></i>
                  </button>
    
                  <!-- Modal -->
                  <div class="modal fade" id="addyeuCau" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_yeu_cau_mon_hoc') }}" method="post">
                      @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Yêu cầu khác</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                          </div>
                          <div class="form-group">
                              <textarea name="yeuCau" id="yeuCau" cols="30" rows="10" class="form-control" required>
                              
                                {{ $hocPhan->yeuCau }}
                    
                              </textarea>
                                <script>
                                  CKEDITOR.replace( 'yeuCau', {
                                      filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                                      filebrowserUploadMethod: 'form'
                                  } );
                              </script>
                          
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

                </td>
               </tr>
             </table>
             <h5><b>2.Tài liệu tham khảo</b></h5>    <!-----------------------------------2. Tài liệu tham khảo--------------------------->
             <table class="table table-bordered">
               <tr>
                 <td>Giáo trình/ Tài liệu học tập chính</td>
                 <td style="text-align: justify">
                  @if ($tailieu)
                       {!! $tailieu->giaoTrinh !!}
                  @endif
                
                 </td>
                 <td>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addgiaoTrinh">
                    <i class="fas fa-edit"></i>
                  </button>
    
                  <!-- Modal -->
                  <div class="modal fade" id="addgiaoTrinh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_giao_trinh') }}" method="post">
                      @csrf
                       <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Giáo trình/ Tài liệu học tập chính</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan}}" hidden>
                          </div>
                          <div class="form-group">
                              <textarea name="giaoTrinh" id="giaoTrinh" cols="30" rows="10" class="form-control" required>
                                @if ($tailieu)
                                    {{ $tailieu->giaoTrinh }}
                              @endif  
                              </textarea>
                                <script>
                                  CKEDITOR.replace( 'giaoTrinh', {
                                      filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                                      filebrowserUploadMethod: 'form'
                                  } );
                              </script>
                          
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
                 </td>
               </tr>
               <tr>
                 <td>Tài liệu tham khảo thêm</td>
                 <td>
                   @if ($tailieu)
                        {!! $tailieu->thamKhaoThem !!}
                   @endif
                
                 </td>
                 <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addthamKhaoThem">
                      <i class="fas fa-edit"></i>
                    </button>
      
                    <!--///////////////////////////// Modal thêm tài liệu tham khảo thêm-->
                    <div class="modal fade" id="addthamKhaoThem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_tai_lieu_tham_khao_them') }}" method="post">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tài liệu tham khảo thêm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                            </div>
                            <div class="form-group">
                                <textarea name="thamKhaoThem" id="thamKhaoThem" cols="30" rows="10" class="form-control" required>
                                  @if ($tailieu)
                                      {{ $tailieu->thamKhaoThem }}
                                @endif  
                                </textarea>
                                  <script>
                                    CKEDITOR.replace( 'thamKhaoThem', {
                                        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                                        filebrowserUploadMethod: 'form'
                                    } );
                                </script>
                            
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
                </td>
               </tr>
               <tr>
                  <td>Các loại học liệu khác</td>
                  <td>
                    @if ($tailieu)
                         {!! $tailieu->taiLieuKhac  !!}
                    @endif  
                  </td>
                  <td>
                        <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtaiLieuKhac">
                <i class="fas fa-edit"></i>
              </button>

              <!--//////////////////////// Modal thêm các loại tài liệu khác -->
              <div class="modal fade" id="addtaiLieuKhac" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_tai_lieu_khac') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Tài liệu khác</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                      </div>
                      <div class="form-group">
                          <textarea name="taiLieuKhac" id="taiLieuKhac" cols="30" rows="10" class="form-control" required>
                            @if ($tailieu)
                                  {{ $tailieu->taiLieuKhac }}
                            @endif  
                          </textarea>
                            <script>
                              CKEDITOR.replace( 'taiLieuKhac', {
                                  filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                                  filebrowserUploadMethod: 'form'
                              } );
                          </script>
                      
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
                  </td>
               </tr>
             </table>
             <h5><b>3.Mô tả môn học</b></h5>    <!-----------------------------------3. Mô tả môn học--------------------------->
             <!-- Button trigger modal -->
      
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMoTa">
                <i class="fas fa-edit"></i>
              </button> <br>

              {!! $hocPhan->moTaHocPhan !!}
              <!-- /////////////////////Modal thêm mô tả học phần-->

              <div class="modal fade" id="addMoTa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_mo_ta_mon_hoc') }}" method="post">
                  @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">mô tả</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                        </div>
                        <div class="form-group">
                            <textarea name="moTaHocPhan" id="moTa" cols="30" rows="10" class="form-control" required>
                              {{ $hocPhan->moTaHocPhan }}
                            </textarea>
                              <script>
                                CKEDITOR.replace( 'moTa', {
                                    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                                    filebrowserUploadMethod: 'form'
                                } );
                            </script>
                        
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
           

             <h5><b>4.Chuẩn đầu ra của môn học</b></h5>    <!-----------------------------------4. chuẩn đầu ra của môn học--------------------------->
              <table class="table table-bordered">
                <thead>
                    <th colspan="2"></th>
                    <th style="background-color: green">Đáp ứng CĐR của CTĐT</th>                 
                </thead>
                <tbody>
                  @foreach ($CDR1 as $cdr1)
                      <tr>
                        <td colspan="3"><b>Chủ đề {{ $cdr1->maCDR1VB }}: {{ $cdr1->tenCDR1 }}:</b> 
                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chuDe_{{ $cdr1->maCDR1VB }}">
                            <i class="fas fa-edit"></i>
                          </button>

                          <!-- /////////////////// Modal thêm chuẩn đầu ra đề cương-->
                          <div class="modal fade" id="chuDe_{{ $cdr1->maCDR1VB }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_chuan_dau_ra_mon_hoc') }}" method="post">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Chủ đề {{ $cdr1->maCDR1VB }}: {{ $cdr1->tenCDR1 }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                                  </div>
                                  <div class="form-group">
                                      <label for=""> Mã kết quả học tập:</label>
                                      <input type="text" name="maKQHTVB" placeholder="L1,L2,..." class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label for=""> Nội dung kết quả học tập:</label>
                                    <input type="text" name="tenKQHT" placeholder="Phân tích, khái niệm, mô tả,.." class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label for=""> Chọn chuẩn đầu ra:</label>
                                    <select name="maCDR3[]" id="" class="form-control" multiple>
                                      @foreach ($cdr as $t)
                                          @if ($t->maCDR1==$cdr1->maCDR1)
                                              <option value="{{ $t->maCDR3 }}"> {{ $t->maCDR3VB }} - {{ $t->tenCDR3 }}</option>
                                          @endif
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
                        </td>
                      </tr>
                      @php
                            $cur_rs=0;
                            $bienchay=0;
                      @endphp
                      @foreach ($kqht as $x)
                          @if ($x->maCDR1==$cdr1->maCDR1)
                          {{-- {{ $kqht->where('maCDR1',$cdr1->maCDR1)->where('maKQHT',$x->maKQHT)->count() }}
                          <tr>
                            <td>{{ $x->maKQHTVB }}</td>
                            <td>{{ $x->tenKQHT }}</td>
                            <td>{{ $x->maCDR3VB }}</td>
                          </tr>   --}}
                            @php
                                $rs=$kqht->where('maCDR1',$cdr1->maCDR1)->where('maKQHT',$x->maKQHT)->count(); 
                                
                                if($bienchay>$rs || $rs>$cur_rs){
                                  $cur_rs=$rs;  
                                  $bienchay=1;
                                }
                                else {
                                   $bienchay+=1;
                                }
                            @endphp
                       
                            @if($bienchay==1)
                              <tr>
                                <td rowspan={{ $rs }}>{{ $x->maKQHTVB }}</td>
                                <td rowspan={{ $rs }}>{{ $x->tenKQHT }}</td>
                                <td>{{ $x->maCDR3VB }}</td>
                              </tr>   
                            @else
                              <tr>
                                <td>{{ $x->maCDR3VB }}</td>
                              </tr>
                            @endif
                          @endif
                      @endforeach
                  @endforeach
                </tbody>
              </table>

             <h5><b>5. Nội dung môn học: </b></h5>    <!-----------------------------------5.Nội dung môn học: --------------------------->
              <table class="table table-bordered">
                <thead style="background-color: green">
                  <tr>
                    <th rowspan="2">Nội dung
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addChuong">
                        <i class="fas fa-edit"></i>
                      </button>

                      <!-- Modal thêm nội dung môn học-->
                      <div class="modal fade" id="addChuong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_noi_dung_mon_hoc') }}" method="post">
                          @csrf
                            <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Thêm nội dung</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                              <div class="form-group">
                                <label for="">Tên chương:</label>
                                <input type="text" name="tenchuong" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="">Số tiết lý thuyết:</label>
                                <input type="number" min="0" name="soTietLT" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="">Số tiết thực hành:</label>
                                <input type="number" min="0" name="soTietTH" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="">Số tiết khác:</label>
                                <input type="number" min="0" name="khác" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="">Chọn kết quả học tập:</label>
                                <select name="maKQHT[]" id="" class="form-control" multiple required>
                                  @foreach ($getKQHT as $data)
                                      <option value="{{ $data->maKQHT }}">{{ $data->maKQHTVB }} -- {{ $data->tenKQHT }}</option>
                                  @endforeach
                                </select>
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

                    </th>
                    <th rowspan="2">Chuẩn đầu ra học phần lý thuyết</th>
                    <th colspan="3"> Số tiết</th>
                  </tr>
                  <tr>
                    <th>Lý thuyết</th>
                    <th>Thực hành</th>
                    <th>Khác</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($noidung as $data)
                  <tr>
                    <td>{{ $data->tenchuong }}
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMuc">
                      <i class="fas fa-plus"></i>Thêm mục
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addMuc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_noi_dung_muc_chuong') }}" method="POST">
                          @csrf
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Adding a new item</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <input type="text" name="id_chuong" value="{{ $data->id }}" hidden>

                              <div class="form-group">
                                <label for="" >Item ID:</label>
                                <input type="text" name="maMucVB" class="form-control" >
                              </div>

                              <div class="form-group">
                                <label for="" >Item name:</label>
                                <input type="text" name="tenMuc" class="form-control" >
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

                    <td>
                      @foreach ($data->chuong_kqht as $item)
                          {{ $item->maKQHTVB }};
                      @endforeach
                    </td>
                    <td>
                      {{ $data->soTietLT }}
                    </td>
                    <td>{{ $data->soTietTH }}</td>
                    <td>{{ $data->soTietKhac }}</td>
                  </tr>
                  @foreach ($data->muc as $m)
                      <tr>
                        <td>
                          {{ $m->maMucVB }}
                          {{ $m->tenMuc }}
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                  @endforeach
                  <tr>
                    
                  </tr>
               
                  @endforeach
                 
                 
                </tbody>
              </table>
             <h5><b>6. Phương pháp giảng dạy </b></h5>    <!----------------------------------6. Phương pháp giảng dạy: --------------------------->
             <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ppgiangday">
                <i class="fas fa-edit"></i>
              </button>

              <!-- Modal thêm phương pháp giảng dạy-->
              <div class="modal fade" id="ppgiangday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_phuong_phap_giang_day') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Thêm phương pháp giảng dạy</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                      </div>
                      <div class="form-group">
                        <label for="">Chọn phương pháp giảng dạy:</label>
                        <select name="maPP" id="" class="form-control">
                          @foreach ($ppGiangDay as $data)
                              <option value="{{ $data->maPP }}">{{ $data->tenPP }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Diễn giải:</label>
                        <input type="text" name="dienGiai" class="form-control">
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
             <table class="table table-bordered">
               <thead style="background-color: green">
                   <tr>
                     <th>Mã số</th>
                     <th>Phương pháp/ kỹ thuật giảng dạy</th>
                     <th>Diễn giải</th>
                   </tr>
               </thead>
               <tbody>
                 @php
                     $i=1;
                 @endphp
                 @foreach ($hocPhan_ppGiangDay as $data)
                 <tr>
                  <td>M {{ $i++ }}</td>
                  <td>{{ $data->ppGiangDay->tenPP }} </td>
                  <td>{{ $data->dienGiai }}</td>
                </tr>
                 @endforeach
                
                 
               </tbody>
             </table>
             <h5><b>7. Phương thức đánh giá </b></h5>    <!----------------------------------7. Phương thức đánh giá: --------------------------->
            
             <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHocPhan_loaiHTDG">
              <i class="fas fa-edit"></i>
            </button>

            <!-- Modal thêm hình thức đánh giá -->
            <div class="modal fade" id="addHocPhan_loaiHTDG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_phuong_phap_danh_gia') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Cập nhật phương thức đánh giá</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                      <div class="form-group">
                        <label for="">Chọn hình thức đánh giá</label>
                        <select name="maLoaiHTDG" id="" class="form-control" required>
                          @foreach ($loaiHTDG as $data)
                              <option value="{{ $data->maLoaiHTDG }}">{{ $data->tenLoaiHTDG }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Chọn loại hình thức đánh giá</label>
                        <select name="maLoaiDG" id="" class="form-control" required>
                          @foreach ($loaiDG as $data)
                              <option value="{{ $data->maLoaiDG }}">{{ $data->tenLoaiDG }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Tỉ lệ</label>
                        <input type="number" min="25" name="trongSo" class="form-control" required>
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
             <table class="table table-bordered">
              <thead style="background-color: green">
                <th>STT</th>
                <th>Hình thức đánh giá</th>
                <th>Loại hình thức đánh giá</th>
                <th>Tỉ lệ</th>
              </thead>
              <tbody> 
                @php
                    $i=1;
                @endphp
                @foreach ($hocPhan_loaiHTDG as $data)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $data->loai_danh_gia['tenLoaiDG'] }}</td>
                      <td>{{ $data->loaiHTDanhGia['maLoaiHTDG'] }}-{{ $data->loaiHTDanhGia['tenLoaiHTDG'] }}</td>
                      <td>{{ $data->trongSo }}%</td>
                    </tr>
                @endforeach
              </tbody>
              <tr>
                <td colspan="2">Ghi chú công thức tính điểm</td>
                <td colspan="2">
                  @php
                      $n=$hocPhan_loaiHTDG->count();
                      $cr=0;
                  @endphp
                  @foreach ($hocPhan_loaiHTDG as $data)
                  @if ($cr!=0 && $cr<$n)
                      +
                      @php
                          $cr++;
                      @endphp
                  @else
                      @php
                          $cr++;
                      @endphp
                  @endif
                   {{ $data->loaiHTDanhGia['maLoaiHTDG'] }}*{{ $data->trongSo }}%
                  @endforeach
                
                </td>
              </tr>
            </table>


             <h5><b>8. Các quy định chung </b></h5>    <!----------------------------------8. Các quy định chung --------------------------->
             <h6><b>Các quy định về tham dự lớp học</b></h6>
            <ul>
              <li>Sinh viên có trách nhiệm tham dự đầy đủ các buổi học. Trong trường hợp phải nghỉ học vì lý do bất khả kháng thì phải có giấy tờ chứng minh đầy đủ và hợp lý.</li>
              <li>Sinh viên vắng quá 20% số tiết của học phần, dù có lý do hay không có lý do, đều bị coi như không hoàn thành học phần và phải đăng ký học lại vào học kỳ sau.</li>
            </ul>
            <h6><b>Quy định về hành vi trong lớp học</b></h6>
            <ul>
              <li>Học phần được thực hiện trên nguyên tắc tôn trọng người học và người dạy. Mọi hành vi làm ảnh hưởng đến quá trình dạy và học đều bị nghiêm cấm.</li>
              <li>Sinh viên phải đi học đúng giờ qui định. Sinh viên đi trễ quá 5 phút sau khi giờ học bắt đầu sẽ không được tham dự buổi học.</li>
              <li>Tuyệt đối không làm ồn, gây ảnh hưởng đến người khác trong quá trình học.</li>
              <li>Tuyệt đối không được ăn, nhai kẹo cao su, sử dụng các thiết bị như điện thoại, máy nghe nhạc trong giờ học.</li>
              <li>Máy tính xách tay, máy tính bảng chỉ được sử dụng trên lớp với mục đích ghi chép bài giảng, tính toán phục vụ bài giảng, bài tập. Tuyệt đối không dùng vào việc khác.</li>
              <li>Sinh viên vi phạm các nguyên tắc trên sẽ bị mời ra khỏi lớp và bị coi là vắng buổi học đó.</li>
            </ul>
            <h6><b>Quy định về học vụ</b></h6>
            <p>Các vấn đề liên quan đến xin bảo lưu điểm, khiếu nại điểm, chấm phúc tra, kỷ luật thi cử được thực hiện theo quy chế học vụ của trường Đại học Trà Vinh.</p>
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