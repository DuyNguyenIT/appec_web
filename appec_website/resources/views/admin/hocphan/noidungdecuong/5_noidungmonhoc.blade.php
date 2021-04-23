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
      <th colspan="3"> {{ __('Number of learning periods') }}</th>
    </tr>
    <tr>
      <th>{{ __('Theory') }}</th>
      <th>{{ __('Practice') }}</th>
      <th>{{ __('Others') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($noidung as $data)
    <tr>
      <td><b>{{ $data->tenchuong }}</b>
        
      <!-- Button thêm mục -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMuc_{{ $data->id  }}">
        <i class="fas fa-plus"></i>Adding item
      </button>


      <!-- Modal thêm mục -->
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
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
              </div>
            </div>
          </form>
            
        </div>
      </div>

      {{-- Button thêm kỹ năng UIT --}}
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
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
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
        <td><b>{{ __('Topic') }}: {{ $x->tenCDR1 }}</b></td>
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