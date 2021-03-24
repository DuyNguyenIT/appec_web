@extends('admin.no_menu_master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              {{ __('Course syllabus') }} <noscript></noscript>
              <nav></nav>
              
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active"><a href="{{ asset('quan-ly/hoc-phan') }}">{{ __('Course') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Course syllabus') }}</li>
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
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-check"></i> Thông báo</h5>
          {{session('success')}}
        </div>
      @endif
      @if(session('warning'))
        <div class="alert alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> Thông báo</h5>
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
                  COURSE SYLLABUS <br>
                {{ __('Course') }}: {{ $hocPhan->tenHocPhan }} <br>
                {{ __('Course code') }}: {{ $hocPhan->maHocPhan }}
                </h3>
              </div>
              <a class="btn btn-primary" href="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/in-de-cuong-mon-hoc/'.$hocPhan->maHocPhan) }}">{{ __('Print') }}</a>
              <!-- /.card-header -->
              <div class="card-body">
              <h5><b>1. {{ __('General information') }}</b></h5>    <!-- ----------------------------------1. ThÃ´ng tin chung-------------------- -->
              <table class="table table-bordered">
                <thead class="thead-green" style="background-color: green">
                  <tr>
                    <th>{{ __('Course type') }}</th>
                    <th>{{ __('Number of credits') }}</th>
                    <th>{{ __('Number of learning periods') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      @php
                          $daicuong = array("A1", "A2", "A3", "A4","A5");
                          $coso = array('B1' );
                          $chuyennganh = array('B2','B3');
                      @endphp
                      @if (in_array($hocPhan->maCTKhoiKT,$daicuong))
                        <ul>
                          <li>{{ __('General ') }}  <i class="far fa-check-square"></i>
                          <li>{{ __('Basic') }}  
                          <li> {{ __('Specialized') }}
                        </ul>
                      @else
                          @if (in_array($hocPhan->maCTKhoiKT,$coso))
                            <ul>
                              <li>{{ __('General ') }}  
                              <li>{{ __('Basic') }}    <i class="far fa-check-square"></i>
                              <li>{{ __('Specialized') }}
                            </ul>
                          @else
                            @if (in_array($hocPhan->maCTKhoiKT,$chuyennganh))
                                <ul>
                                <li>{{ __('General ') }}  
                                <li>{{ __('Basic') }}   
                                <li>{{ __('Specialized') }} <i class="far fa-check-square"></i>
                              </ul>
                            @endif
                          @endif
                      @endif
                   
                      
                    </td>
                    <td>
                      <ul>
                        <li>{{ __('Theory') }}: {{ $hocPhan->tinChiLyThuyet }}
                        <li>{{ __('Exercise') }}: 
                        <li>{{ __('Practice') }}: {{ $hocPhan->tinChiThucHanh }}
                      </ul>
                    </td>
                    <td>
                      <ul>
                        <li>{{ __('Theory') }}: {{ $hocPhan->tinChiLyThuyet *15 }}
                        <li>{{ __('Exercise') }}: 
                        <li>{{ __('Practice') }}: {{ $hocPhan->tinChiThucHanh *30 }}
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="row">
                <div class="col-md-4">
                  <h6><b>{{ __('Learners') }}:</b></h6> 
                </div>
                <div class="col-md-7">
                  {{__('Education level')}}: {{ $bac->tenBac }} <br>
                  {{ __('Specialized') }}: {{ $nganh->tenNganh }} <br>
                  {{ __('Major') }}: {{ $CNganh->tenCNganh }}<br>
                  {{ __('Forms of training') }}: {{ $he->tenHe }} <br>
                </div>
                <div class="col-md-1">
                  <td>
                  </td>
                </div>
              </div>
             <h6><b>{{ __('Forms of training') }}</b></h6>
             <table class="table table-bordered">
               <tr>
                 <td>{{ __('Prerequisites') }}</td>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Adding a new prerequisites') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <div class="form-group">
                          <label for="">{{ __('Prerequisites') }}</label>
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
                 <td>{{ __('Other requirements') }}</td>
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
                          <h5 class="modal-title" id="exampleModalLabel">{{ __('Other requirements') }}</h5>
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
                          <button type="submit" class="btn btn-primary">Save</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                      
                      </form>
                   
                    </div>
                  </div>

                </td>
               </tr>
             </table>
             <h5><b>2.{{ __('Learning resources') }}</b></h5>    <!-----------------------------------2. TÃ i liá»‡u tham kháº£o--------------------------->
             <table class="table table-bordered">
               <tr>
                 <td>{{ __('Books ') }}</td>
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
                          <h5 class="modal-title" id="exampleModalLabel">{{ __('Books ') }}</h5>
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
                          <button type="submit" class="btn btn-primary">Save</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </form>
                   
                    </div>
                  </div>
                 </td>
               </tr>
               <tr>
                 <td>{{ __('References') }}</td>
                 <td>
                   @if ($tailieu)
                        {!! $tailieu->thamKhaoThem !!}
                   @endif
                
                 </td>
                 <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addthamKhaoThem">
                      <i class="fas fa-edit"></i>
                    </button>
      
                    <!--///////////////////////////// Modal thÃªm tÃ i liá»‡u tham kháº£o thÃªm-->
                    <div class="modal fade" id="addthamKhaoThem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_tai_lieu_tham_khao_them') }}" method="post">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('References') }}</h5>
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
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                        </form>
                       
                      </div>
                    </div>
                </td>
               </tr>
               <tr>
                  <td>{{ __('Other learning materials ') }}</td>
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

              <!--//////////////////////// Modal thÃªm cÃ¡c loáº¡i tÃ i liá»‡u khÃ¡c -->
              <div class="modal fade" id="addtaiLieuKhac" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_tai_lieu_khac') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ __('Other learning materials ') }}</h5>
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
                      <button type="submit" class="btn btn-primary">Save</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                  </form>
                 
                </div>
              </div>
                  </td>
               </tr>
             </table>
             <h5><b>3.{{ __('Course description') }}</b></h5>    <!-----------------------------------3. MÃ´ táº£ mÃ´n há»c--------------------------->
             <!-- Button trigger modal -->
      
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMoTa">
                <i class="fas fa-edit"></i>
              </button> <br>

              {!! $hocPhan->moTaHocPhan !!}
              <!-- /////////////////////Modal thÃªm mÃ´ táº£ há»c pháº§n-->

              <div class="modal fade" id="addMoTa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_mo_ta_mon_hoc') }}" method="post">
                  @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Course description') }}</h5>
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
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
           

             <h5><b>4.{{ __('Course learning outcomes ') }}</b></h5>    <!-----------------------------------4. Chuan dau ra mon hoc--------------------------->
              <table class="table table-bordered">
                <thead>
                    <th colspan="2"></th>
                    <th style="background-color: green">{{ __('Satisfy LOs of the program') }}</th>                 
                </thead>
                <tbody>
                  @foreach ($CDR1 as $cdr1)
                      <tr>
                        <td colspan="3"><b>{{ __('Topic') }} {{ $cdr1->maCDR1VB }}: {{ $cdr1->tenCDR1 }}:</b> 
                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chuDe_{{ $cdr1->maCDR1VB }}">
                            <i class="fas fa-edit"></i>
                          </button>

                          <!-- /////////////////// Modal them noi dung mon hoc-->
                          <div class="modal fade" id="chuDe_{{ $cdr1->maCDR1VB }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_chuan_dau_ra_mon_hoc') }}" method="post">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">{{ __('Topic') }} {{ $cdr1->maCDR1VB }}: {{ $cdr1->tenCDR1 }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                                  </div>
                                  <div class="form-group">
                                      <label for=""> {{ _('Studying results ID') }}:</label>
                                      <input type="text" name="maKQHTVB" placeholder="L1,L2,..." class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label for=""> {{ __('studying results content') }}:</label>
                                    <input type="text" name="tenKQHT" placeholder="PhÃ¢n tÃ­ch, khÃ¡i niá»‡m, mÃ´ táº£,.." class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label for=""> {{ __('Level-3 outcome') }}:</label>
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
                                  <button type="submit" class="btn btn-primary">Save</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                                
                                if($bienchay>=$rs || $rs>$cur_rs){
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

             <h5><b>5. {{ __('Course content') }}: </b></h5>    <!-----------------------------------5.Noi dung mon hoc: --------------------------->
              <table class="table table-bordered">
                <thead style="background-color: green">
                  <tr>
                    <th rowspan="2">{{ __('Course content') }}
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addChuong">
                        <i class="fas fa-edit"></i>
                      </button>

                      <!-- Modal thÃªm ná»™i dung mÃ´n há»c-->
                      <div class="modal fade" id="addChuong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_noi_dung_mon_hoc') }}" method="post">
                          @csrf
                            <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">{{ __('Adding a new content') }}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                              <div class="form-group">
                                <label for="">{{ __('Chapter name') }}:</label>
                                <input type="text" name="tenchuong" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="">{{ __('Theory') }}:</label>
                                <input type="number" min="0" name="soTietLT" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="">{{ __('Practice') }}:</label>
                                <input type="number" min="0" name="soTietTH" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="">{{ __('Others') }}:</label>
                                <input type="number" min="0" name="khÃ¡c" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="">{{ __('Studying results') }}:</label>
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
                    <th rowspan="2">Chuáº©n Ä‘áº§u ra há»c pháº§n lÃ½ thuyáº¿t</th>
                    <th colspan="3"> Sá»‘ tiáº¿t</th>
                  </tr>
                  <tr>
                    <th>LÃ½ thuyáº¿t</th>
                    <th>Thá»±c hÃ nh</th>
                    <th>KhÃ¡c</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($noidung as $data)
                  <tr>
                    <td><b>{{ $data->tenchuong }}</b>
                      
                    <!-- Button thÃªm má»¥c -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMuc_{{ $data->id  }}">
                      <i class="fas fa-plus"></i>Adding item
                    </button>


                    <!-- Modal thÃªm má»¥c -->
                    <div class="modal fade" id="addMuc_{{ $data->id  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                    {{-- Button thÃªm ká»¹ nÄƒng UIT --}}
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMucDoKyNangUIT_{{ $data->id }}">
                      <i class="fas fa-plus"></i>Adding level of skill
                    </button>
                    <div class="modal fade" id="addMucDoKyNangUIT_{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_muc_do_ky_nang_uti') }}" method="POST">
                          @csrf
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Adding level of skill</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <input type="text" name="id_chuong" value="{{ $data->id }}" hidden>

                              <div class="form-group">
                                <label for="" >Choosing topic:</label>
                                <select name="maCDR1" id="" class="form-control">
                                 @foreach ($CDR1 as $cdr1)
                                     <option value="{{ $cdr1->maCDR1}}">{{ $cdr1->tenCDR1 }}</option>
                                 @endforeach
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="" >Result assiment:</label>
                                <select name="maKQHT[]" id="" class="form-control" multiple>
                                  @foreach ($getKQHT as $x)
                                      <option value="{{ $x->maKQHT }}">{{ $x->maKQHTVB }}-- {{ $x->tenKQHT }}</option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="" >Choosing U - I - T:</label>
                                <select name="ky_nang" id="" class="form-control">
                                  <option value="U">U</option>
                                  <option value="I">I</option>
                                  <option value="T">T</option>
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
                 @foreach ($CDR1 as $x)
                  <tr>
                      <td><b>Topic: {{ $x->tenCDR1 }}</b></td>
                      <td colspan="4">
                        @foreach ($mudokynangUIT as $uit)
                          @if ($uit->maCDR1==$x->maCDR1 && $uit->id_chuong==$data->id)
                              {{ $uit->maKQHTVB }}({{ $uit->ky_nang }});
                          @endif
                        @endforeach 
                      </td>    
                  </tr>
                 @endforeach
                
               
                  @endforeach

                </tbody>
              </table>
             <h5><b>6. PhÆ°Æ¡ng phÃ¡p giáº£ng dáº¡y </b></h5>    <!----------------------------------6. PhÆ°Æ¡ng phÃ¡p giáº£ng dáº¡y: --------------------------->
             <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ppgiangday">
                <i class="fas fa-edit"></i>
              </button>

              <!-- Modal thÃªm phÆ°Æ¡ng phÃ¡p giáº£ng dáº¡y-->
              <div class="modal fade" id="ppgiangday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_phuong_phap_giang_day') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">ThÃªm phÆ°Æ¡ng phÃ¡p giáº£ng dáº¡y</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                      </div>
                      <div class="form-group">
                        <label for="">Chá»n phÆ°Æ¡ng phÃ¡p giáº£ng dáº¡y:</label>
                        <select name="maPP" id="" class="form-control">
                          @foreach ($ppGiangDay as $data)
                              <option value="{{ $data->maPP }}">{{ $data->tenPP }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Diá»…n giáº£i:</label>
                        <input type="text" name="dienGiai" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">LÆ°u</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Há»§y</button>
                    </div>
                  </div>
                  </form>
                 
                </div>
              </div>
             <table class="table table-bordered">
               <thead style="background-color: green">
                   <tr>
                     <th>MÃ£ sá»‘</th>
                     <th>PhÆ°Æ¡ng phÃ¡p/ ká»¹ thuáº­t giáº£ng dáº¡y</th>
                     <th>Diá»…n giáº£i</th>
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
             <h5><b>7. PhÆ°Æ¡ng thá»©c Ä‘Ã¡nh giÃ¡ </b></h5>    <!----------------------------------7. PhÆ°Æ¡ng thá»©c Ä‘Ã¡nh giÃ¡: --------------------------->
            
             <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHocPhan_loaiHTDG">
              <i class="fas fa-edit"></i>
            </button>

            <!-- Modal thÃªm hÃ¬nh thá»©c Ä‘Ã¡nh giÃ¡ -->
            <div class="modal fade" id="addHocPhan_loaiHTDG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_phuong_phap_danh_gia') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Cáº­p nháº­t phÆ°Æ¡ng thá»©c Ä‘Ã¡nh giÃ¡</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                      <div class="form-group">
                        <label for="">Chá»n hÃ¬nh thá»©c Ä‘Ã¡nh giÃ¡</label>
                        <select name="maLoaiHTDG" id="" class="form-control" required>
                          @foreach ($loaiHTDG as $data)
                              <option value="{{ $data->maLoaiHTDG }}">{{ $data->tenLoaiHTDG }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Chá»n loáº¡i hÃ¬nh thá»©c Ä‘Ã¡nh giÃ¡</label>
                        <select name="maLoaiDG" id="" class="form-control" required>
                          @foreach ($loaiDG as $data)
                              <option value="{{ $data->maLoaiDG }}">{{ $data->tenLoaiDG }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Tá»‰ lá»‡</label>
                        <input type="number" min="25" name="trongSo" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label for="">Group</label>
                        <select name="groupCT" id="" class="form-control">
                          <option value="1">1</option>
                          <option value="2">2</option>
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
             <table class="table table-bordered">
              <thead style="background-color: green">
                <th>STT</th>
                <th>HÃ¬nh thá»©c Ä‘Ã¡nh giÃ¡</th>
                <th>Loáº¡i hÃ¬nh thá»©c Ä‘Ã¡nh giÃ¡</th>
                <th>Tá»‰ lá»‡</th>
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
                <td colspan="2">Ghi chÃº cÃ´ng thá»©c tÃ­nh Ä‘iá»ƒm</td>
                <td colspan="2">
                  @php
                      $n=$hocPhan_loaiHTDG->where('groupCT',1)->count();
                      $cr=0;
                  @endphp
                  @foreach ($hocPhan_loaiHTDG as $data)
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
                  <br>  hoáº·c <br>
                  {{-- groupCT==2 --}}
                  @php
                  $n=$hocPhan_loaiHTDG->where('groupCT',2)->count();
                  $cr=0;
              @endphp
              @foreach ($hocPhan_loaiHTDG as $data)
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
                </td>
              </tr>
            </table>


             <h5><b>8. Course requirements and expectations: </b></h5>    <!----------------------------------8. CÃ¡c quy Ä‘á»‹nh chung --------------------------->
             <h6><b>8.1 Requirements on attendance</b></h6>
            <ul>
              <li>Students are responsible for attending all classes. In case of absence due to force majeure circumstances, there must be sufficient and reasonable evidence.</li>
              <li>Students who do not attend more than 20% of the class sections, whether for reason or not, are deemed not to have completed the course and must re-enroll in the following semester.</li>
            </ul>
            <h6><b>8.2 Requirements and expectations on student behaviors </b></h6>
            <ul>
              <li>Students must show their respects for teachers and other learners.</li>
              <li>Students must be on time. Students who are late more than five minutes will not be allowed to attend the class.</li>
              <li>Students should not make noise and interfere with others in the learning process.</li>
              <li>Students should not eat, chew gum, and use devices such as cell phones, music players during class hours.</li>
              <li>Laptops and tablets can only be used in class for the purpose of learning. </li>
              <li>Students who violate the above principles will be asked to leave the class and considered absent from the class. </li>
            </ul>
            <h6><b>8.3 Requirements on learning issues</b></h6>
            <p>Issues related to applying for score reservation, scoring complaints, scoring, exam disciplines are done according to the Learning Regulation of Tra Vinh University.</p>
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