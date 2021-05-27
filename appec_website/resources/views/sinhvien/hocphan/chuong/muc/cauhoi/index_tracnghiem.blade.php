@extends('giangvien.master')
@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<div class="content-wrapper" style="min-height: 96px;">

    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            Câu hỏi trắc nghiệm<noscript></noscript>
            <nav></nav>
          </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
              <a href="{{ asset('/giang-vien/hoc-phan') }}">
                {{\Illuminate\Support\Str::limit(html_entity_decode($hocphan->tenHocPhan),$limit=20,$end='...')}}  
              </a>
            </li>
            <li class="breadcrumb-item ">
              <a href="{{ asset('/giang-vien/hoc-phan/chuong/'.Session::get('maHocPhan_chuong')) }}">
                {{\Illuminate\Support\Str::limit(html_entity_decode($chuong->tenchuong),$limit=20,$end='...')}}  
              </a>
            </li><li class="breadcrumb-item"><a href="#">    
              <a href="{{ asset('/giang-vien/hoc-phan/chuong/muc/'.Session::get('maMuc')) }}">
              {{\Illuminate\Support\Str::limit(html_entity_decode($muc->tenMuc),$limit=20,$end='...')}}  
            </a></a></li>
            <li class="breadcrumb-item active">Câu hỏi trắc nghiệm</li>
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
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCHTN">
                  <i class="fas fa-plus"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addCHTN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ asset('/giang-vien/hoc-phan/chuong/muc/cau-hoi-trac-nghiem/them') }}" method="post">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adding a new multiple choice question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="">Adding content of multiple choice question:</label>
                          <textarea name="noiDungCauHoi" id="ndch" cols="30" rows="10" class="form-control" required></textarea>
                          <script>
                            CKEDITOR.replace( 'ndch', {
                                filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                filebrowserUploadMethod: 'form'
                            } );
                        </script>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-10">
                              <label for="">Adding a new answer contents (A):</label>
                              <textarea name="phuongAn[]" id="pa1" cols="30" rows="10" class="form-control" required></textarea>
                              <script>
                                CKEDITOR.replace( 'pa1', {
                                    filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                    filebrowserUploadMethod: 'form'
                                } );
                            </script>
                            </div>
                            <div class="col-md-2">
                              <label for="">Check if correct answer </label>
                              <input type="radio" name="choice" class="form-control" value="0" checked>
                              <label for="">Point</label>
                              <input type="text" name="diemPA[]" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-10">
                              <label for="">Adding a new answer contents (B):</label>
                              <textarea name="phuongAn[]" id="pa2" cols="30" rows="10" class="form-control" required></textarea>
                              <script>
                                CKEDITOR.replace( 'pa2', {
                                    filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                    filebrowserUploadMethod: 'form'
                                } );
                            </script>
                            </div>
                            <div class="col-md-2">
                              <label for="">Check if correct answer</label>
                              <input type="radio" name="choice" class="form-control" value="1">
                              <label for="">Point</label>
                              <input type="text" name="diemPA[]" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-10">
                              <label for="">Adding a new answer contents (C):</label>
                              <textarea name="phuongAn[]" id="pa3" cols="30" rows="10" class="form-control" required></textarea>
                              <script>
                                CKEDITOR.replace( 'pa3', {
                                    filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                    filebrowserUploadMethod: 'form'
                                } );
                            </script>
                            </div>
                            <div class="col-md-2">
                              <label for="">Check if correct answer</label>
                              <input type="radio" name="choice" class="form-control" value="2">
                              <label for="">Point</label>
                              <input type="text" name="diemPA[]" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-10">
                              <label for="">Adding a new answer contents (D):</label>
                              <textarea name="phuongAn[]" id="pa4" cols="30" rows="10" class="form-control" required></textarea>
                              <script>
                                CKEDITOR.replace( 'pa4', {
                                    filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                    filebrowserUploadMethod: 'form'
                                } );
                            </script>
                            </div>
                            <div class="col-md-2">
                              <label for="">Check if correct answer</label>
                              <input type="radio" name="choice" class="form-control" value="3">
                              <label for="">Point</label>
                              <input type="text" name="diemPA[]" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="">Chuẩn đầu ra 3:</label>
                          <select name="maCDR3" id="" class="form-control">
                            @foreach ($cdr3 as $data)
                                <option value="{{ $data->maCDR3 }}">{{ $data->maCDR3VB }} - {{ $data->tenCDR3 }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Kết quả học tập:</label>
                          <select name="maKQHT" id="" class="form-control">
                            @foreach ($kqht as $data)
                                <option value="{{ $data->maKQHT }}">{{ $data->tenKQHT }}</option>
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
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Order</th>
                    <th>Question content</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $index=1;
                  @endphp
                @foreach ($cauHoi as $data)
                    <tr>
                      <td>{{ $index++ }}</td>
                      <td>
                        @php
                            $letter=['A','B','C','D'];
                        @endphp
                        {!! $data->noiDungCauHoi !!}
                        <div class="row">
                           @for ($i = 0; $i < count($data->phuong_an_trac_nghiem); $i++)
                              @if ($data->phuong_an_trac_nghiem[$i]->isCorrect==true)
                                <div class="col-md-1"> {{ $letter[$i] }}. </div>
                                <div class="col-md-11"> <b>{!! $data->phuong_an_trac_nghiem[$i]->noiDungPA !!}</b></div>
                              @else
                                <div class="col-md-1"> {{ $letter[$i] }}. </div>
                                <div class="col-md-11"> {!! $data->phuong_an_trac_nghiem[$i]->noiDungPA !!}   </div>
                              
                              @endif
                            
                            @endfor  
                        </div>
                      
                       
                      </td>
                      <td>
                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editCHTN_{{ $data->maCauHoi }}">
                            <i class="fas fa-edit"></i>
                          </button>

                              <!-- Modal -->
                              <div class="modal fade" id="editCHTN_{{ $data->maCauHoi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <form action="{{ asset('/giang-vien/hoc-phan/chuong/muc/cau-hoi-trac-nghiem/sua') }}" method="post">
                                  @csrf
                                  <input type="text" name="maCauHoi" value="{{ $data->maCauHoi }}">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      {{-- -----------------------------------EDIT----------------------------------------- --}}
                                      <h5 class="modal-title" id="exampleModalLabel">Editing a multiple choice question</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="form-group">
                                        <label for="">Editing content of multiple choice question:</label>
                                        <textarea name="noiDungCauHoi" id="edit_ndch_{{ $data->maCauHoi  }}" cols="30" rows="10" class="form-control" required>
                                            {{ $data->noiDungCauHoi }}
                                        </textarea>
                                        <script>
                                          CKEDITOR.replace( 'edit_ndch_{{ $data->maCauHoi  }}', {
                                              filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                              filebrowserUploadMethod: 'form'
                                          } );
                                      </script>
                                      </div>
                                      {{--------------------------------------A-------------------------------- --}}
                                      <div class="form-group">
                                        <input type="text" name="maPhuongAn[]"  value="{{ $data->phuong_an_trac_nghiem[0]->id }}" hidden>
                                        <div class="row">
                                          <div class="col-md-10">
                                            <label for="">Adding a new answer contents (A):</label>
                                            <textarea name="phuongAn[]" id="pa1_{{$data->maCauHoi  }}" cols="30" rows="10" class="form-control" required>
                                              {{ $data->phuong_an_trac_nghiem[0]->noiDungPA  }}
                                            </textarea>
                                            <script>
                                              CKEDITOR.replace( 'pa1_{{ $data->maCauHoi }}', {
                                                  filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                                  filebrowserUploadMethod: 'form'
                                              } );
                                          </script>
                                          </div>
                                          <div class="col-md-2">
                                            <label for="">Check if correct answer </label>
                                            @if ($data->phuong_an_trac_nghiem[0]->isCorrect==true )
                                            <input type="radio" name="choice" class="form-control" value="0" checked>
                                            @else
                                            <input type="radio" name="choice" class="form-control" value="0">
                                            @endif
                                            <label for="">Point</label>
                                            <input type="text" name="diemPA[]" class="form-control" required value="{{ $data->phuong_an_trac_nghiem[0]->diemPA }}">
                                          </div>
                                        </div>
                                      </div>
                                      {{-- -----------------------------------B------------------------------------}}
                                      <div class="form-group">
                                        <input type="text" name="maPhuongAn[]"  value="{{ $data->phuong_an_trac_nghiem[1]->id }}" hidden>
                                        <div class="row">
                                          <div class="col-md-10">
                                            <label for="">Adding a new answer contents (B):</label>
                                            <textarea name="phuongAn[]" id="pa2_{{ $data->maCauHoi }}" cols="30" rows="10" class="form-control" required>
                                              {{ $data->phuong_an_trac_nghiem[1]->noiDungPA  }}
                                            </textarea>
                                            <script>
                                              CKEDITOR.replace( 'pa2_{{ $data->maCauHoi }}', {
                                                  filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                                  filebrowserUploadMethod: 'form'
                                              } );
                                          </script>
                                          </div>
                                          <div class="col-md-2">
                                            <label for="">Check if correct answer</label>
                                            @if ($data->phuong_an_trac_nghiem[1]->isCorrect==true )
                                            <input type="radio" name="choice" class="form-control" value="1" checked>
                                            @else
                                            <input type="radio" name="choice" class="form-control" value="1">
                                            @endif
                                            <label for="">Point</label>
                                            <input type="text" name="diemPA[]" class="form-control" required value="{{ $data->phuong_an_trac_nghiem[1]->diemPA }}">
                                          </div>
                                        </div>
                                      </div>
                                      {{-- ---------------------------------C-----------------------------------}}
                                      <div class="form-group">
                                        <input type="text" name="maPhuongAn[]"  value="{{ $data->phuong_an_trac_nghiem[2]->id }}" hidden>
                                        <div class="row">
                                          <div class="col-md-10">
                                            <label for="">Adding a new answer contents (C):</label>
                                            <textarea name="phuongAn[]" id="pa3_{{ $data->maCauHoi }}" cols="30" rows="10" class="form-control" required>
                                              {{ $data->phuong_an_trac_nghiem[2]->noiDungPA  }}
                                            </textarea>
                                            <script>
                                              CKEDITOR.replace( 'pa3_{{ $data->maCauHoi }}', {
                                                  filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                                  filebrowserUploadMethod: 'form'
                                              } );
                                          </script>
                                          </div>
                                          <div class="col-md-2">
                                            <label for="">Check if correct answer</label>
                                            @if ($data->phuong_an_trac_nghiem[2]->isCorrect==true )
                                            <input type="radio" name="choice" class="form-control" value="2" checked>
                                            @else
                                            <input type="radio" name="choice" class="form-control" value="2">
                                            @endif
                                            <label for="">Point</label>
                                            <input type="text" name="diemPA[]" class="form-control" required value="{{ $data->phuong_an_trac_nghiem[2]->diemPA }}">
                                          </div>
                                        </div>
                                      </div>
                                      {{-- -------------------------------D-------------------------------}}
                                      <div class="form-group">
                                        <input type="text" name="maPhuongAn[]"  value="{{ $data->phuong_an_trac_nghiem[3]->id }}" hidden>
                                        <div class="row">
                                          <div class="col-md-10">
                                            <label for="">Adding a new answer contents (D):</label>
                                            <textarea name="phuongAn[]" id="pa4_{{ $data->maCauHoi }}" cols="30" rows="10" class="form-control" required>
                                              {{ $data->phuong_an_trac_nghiem[3]->noiDungPA  }}
                                            </textarea>
                                            <script>
                                              CKEDITOR.replace( 'pa4_{{ $data->maCauHoi }}', {
                                                  filebrowserUploadUrl: "{{route('uploadgv', ['_token' => csrf_token() ])}}",
                                                  filebrowserUploadMethod: 'form'
                                              } );
                                          </script>
                                          </div>
                                          <div class="col-md-2">
                                            <label for="">Check if correct answer</label>
                                            @if ($data->phuong_an_trac_nghiem[3]->isCorrect==true )
                                            <input type="radio" name="choice" class="form-control" value="3" checked>
                                            @else
                                            <input type="radio" name="choice" class="form-control" value="3">
                                            @endif
                                            
                                            <label for="">Point</label>
                                            <input type="text" name="diemPA[]" class="form-control" required value="{{ $data->phuong_an_trac_nghiem[3]->diemPA }}">
                                          </div>
                                        </div>
                                      </div>
                                      {{-- -----------------------------Chuẩn đầu ra-------------------------------}}
                                      <div class="form-group">
                                        <label for="">Chuẩn đầu ra 3:</label>
                                        <select name="maCDR3" id="" class="form-control">
                                          @foreach ($cdr3 as $x)
                                              @if ($data->maCDR3==$x->maCDR3)
                                              <option value="{{ $x->maCDR3 }}" selected>{{ $x->maCDR3VB }} - {{ $x->tenCDR3 }}</option>
                                                  
                                              @else
                                              <option value="{{ $x->maCDR3 }}">{{ $x->maCDR3VB }} - {{ $x->tenCDR3 }}</option>
                                                  
                                              @endif
                                          @endforeach
                                        </select>
                                      </div>
                                      {{-- ------------------------------Kết quả học tập------------------ --}}
                                      <div class="form-group">
                                        <label for="">Kết quả học tập:</label>
                                        <select name="maKQHT" id="" class="form-control">
                                          @foreach ($kqht as $x)
                                            @if ($data->maKQHT==$x->maKQHT)
                                              <option value="{{ $x->maKQHT }}" selected>{{ $x->tenKQHT }}</option>
                                                
                                            @else
                                              <option value="{{ $x->maKQHT }}">{{ $x->tenKQHT }}</option>
                                                
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