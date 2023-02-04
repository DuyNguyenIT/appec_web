<h5><b>7. Phương thức đánh giá </b></h5>
<!----------------------------------7. Phương thức đánh giá: --------------------------->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHocPhan_loaiHTDG">
    <i class="fas fa-edit"></i>
</button>
<!-- Modal thêm hình thức đánh giá -->
<div class="modal fade" id="addHocPhan_loaiHTDG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ asset('/giang-vien/bien-soan-de-cuong/them_phuong_phap_danh_gia') }}" method="post">
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
                        <label for="">Chọn  hình thức đánh giá</label>
                        <select name="maLoaiDG" id="" class="form-control" required>
                            @foreach ($loaiDG as $data)
                                <option value="{{ $data->maLoaiDG }}">{{ $data->tenLoaiDG }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Chọn loại hình thức đánh giá</label>
                        <select name="maLoaiHTDG" id="" class="form-control" required>
                            @foreach ($loaiHTDG as $data)
                                <option value="{{ $data->maLoaiHTDG }}">{{ $data->tenLoaiHTDG }}</option>
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
        <th>{{ __('No.') }}</th>
        <th>{{ __('Assessment activity') }}</th>
        <th>Loại hình thức đánh giá</th>
        <th>{{ __('Weight') }}</th>
        <th>{{ __('LOs assessed') }}</th>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($hocPhan_loaiHTDG as $data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>

                    <!-- nut sua -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{ $data->id }}">
                        <i class="fas fa-edit"></i>
                    </button>

                    <a title="Delete" class="btn btn-danger"
                        onclick="return confirm('Confirm?')"
                        href="{{ asset('/giang-vien/bien-soan-de-cuong/xoa_phuong_phap_danh_gia/'.$data->id) }}">
                        <i class="fa fa-trash"></i>
                    </a>

                    {{ $data->loai_danh_gia['tenLoaiDG'] }}
                </td>
                <td>{{ $data->loaiHTDanhGia['maLoaiHTDG'] }}-{{ $data->loaiHTDanhGia['tenLoaiHTDG'] }}</td>
                <td>{{ $data->trongSo }}%</td>
                <td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_{{$data->id }}">
                        <i class="fas fa-plus"></i>
                    </button>
                    @if ($data->hp_loaihtdg_kqht)
                        @foreach ($data->hp_loaihtdg_kqht as $t)
                            {{ $t->maKQHTVB}} <a title="Delete" class=""
                            onclick="return confirm('Confirm?')"
                            href="{{ asset('/giang-vien/bien-soan-de-cuong/xoa_hocphan_loaihtdg_kqht/'.$t->id) }}">
                         <i class="fa fa-trash"></i>
                     </a>;
                        @endforeach
                    @endif
                
                    <!-- Modal -->
                    <div class="modal fade" id="add_{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <form action="{{ asset('/giang-vien/bien-soan-de-cuong/them_hocphan_loaihtdg_kqht') }}" method="post">
                        @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }} {{ __('LOs assessed') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <input type="text" name="maHP_LHTDG" value="{{ $data->id }}" hidden>
                                <div class="modal-body">
                                    <select name="maKQHT[]" class="form-control" multiple>
                                        @foreach ($kqht as $x)
                                            <option value="{{ $x->maKQHT }}">{{ $x->maKQHTVB }} {{ $x->tenKQHT }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </td>
            </tr>

              <!-- Modal -->
            <div class="modal fade" id="edit_{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ asset('/giang-vien/bien-soan-de-cuong/sua_phuong_phap_danh_gia') }}" method="post">
                    @csrf
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <label for="">Chọn  hình thức đánh giá</label>
                                <select name="maLoaiDG" class="form-control" required>
                                    @foreach ($loaiDG as $ldg)
                                        @if ( $ldg->maLoaiDG==$data->maLoaiDG)
                                            <option value="{{ $ldg->maLoaiDG }}" selected>{{ $ldg->tenLoaiDG }}</option> 
                                        @else
                                            <option value="{{ $ldg->maLoaiDG }}">{{ $ldg->tenLoaiDG }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="id" value="{{ $data->id }}" hidden>
                                <label for="">Chọn loại hình thức đánh giá</label>
                                <select name="maLoaiHTDG" id="" class="form-control" required>
                                    @foreach ($loaiHTDG as $lhtdg)
                                        @if ($lhtdg->maLoaiHTDG==$data->maLoaiHTDG)
                                            <option value="{{ $lhtdg->maLoaiHTDG }}" selected>{{ $lhtdg->tenLoaiHTDG }}</option>
                                        @else
                                            <option value="{{ $lhtdg->maLoaiHTDG }}">{{ $lhtdg->tenLoaiHTDG }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Tỉ lệ</label>
                                <input type="number" min="25" name="trongSo" class="form-control" value="{{ $data->trongSo }}" required>
                            </div>

                            <div class="form-group">
                                <label for="">Group</label>
                                <select name="groupCT" id="" class="form-control">
                                    @if ($data->groupCT==1)
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                    @else
                                        <option value="1">1</option>
                                        <option value="2" selected>2</option>
                                    @endif
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
        @endforeach
    </tbody>
    <tr>
        <td colspan="2">Ghi chú công thức tính điểm</td>
        <td colspan="3">
            @php
                $n = $hocPhan_loaiHTDG->where('groupCT', 1)->count();
                $cr = 0;
            @endphp
            @foreach ($hocPhan_loaiHTDG as $data)
                @if ($cr != 0 && $cr < $n && $data->groupCT == 1)
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
            <br> hoặc <br>
            {{-- groupCT==2 --}}
            @php
                $n = $hocPhan_loaiHTDG->where('groupCT', 2)->count();
                $cr = 0;
            @endphp
            @foreach ($hocPhan_loaiHTDG as $data)
                @if ($cr != 0 && $cr < $n && $data->groupCT == 2)
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
