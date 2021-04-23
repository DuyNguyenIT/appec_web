<h5><b>2.{{ __('Learning resources') }}</b></h5>    
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
                          <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
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
      
                    <!--///////////////////////////// Modal thêm tài liệu tham khảo thêm-->
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
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                          </div>
                        </div>
                        </form>
                       
                      </div>
                    </div>
                </td>
               </tr>
               <tr>
                  <td>{{ __('Other learning materials') }}</td>
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
                      <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                  </div>
                  </form>
                 
                </div>
              </div>
                  </td>
               </tr>
             </table>