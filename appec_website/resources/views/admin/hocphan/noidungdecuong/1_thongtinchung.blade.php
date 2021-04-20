<h5><b>1. General information</b></h5>    <!-- ----------------------------------1. Thông tin chung-------------------- -->
              <table class="table table-bordered">
                <thead class="thead-green" style="background-color: green">
                  <tr>
                    <th>Course type</th>
                    <th>Number of credits</th>
                    <th>Number of learning periods</th>
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
                          <li>General   <i class="far fa-check-square"></i>
                          <li>Basic   
                          <li>Specialized 
                        </ul>
                      @else
                          @if (in_array($hocPhan->maCTKhoiKT,$coso))
                            <ul>
                              <li>General   
                              <li>Basic    <i class="far fa-check-square"></i>
                              <li>Specialized 
                            </ul>
                          @else
                            @if (in_array($hocPhan->maCTKhoiKT,$chuyennganh))
                                <ul>
                                <li>General   
                                <li>Basic   
                                <li>Specialized  <i class="far fa-check-square"></i>
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