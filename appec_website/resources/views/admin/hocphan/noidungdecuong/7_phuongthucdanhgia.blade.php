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
                  <br>  hoặc <br>
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
