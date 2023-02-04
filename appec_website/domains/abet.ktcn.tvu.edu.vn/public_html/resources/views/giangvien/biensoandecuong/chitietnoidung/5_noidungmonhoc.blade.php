<h5><b>5. Nội dung môn học: </b></h5>
<!-----------------------------------5.Nội dung môn học: --------------------------->
<table class="table table-bordered">
    <thead style="background-color: green">
        <tr>
            <th rowspan="2"> {{ __('Course contents') }}
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addChuong">
                    <i class="fas fa-plus"></i> Chapter
                </button>
                <!-- Modal thêm nội dung môn học-->
                <div class="modal fade" id="addChuong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ asset('/giang-vien/bien-soan-de-cuong/them_noi_dung_mon_hoc') }}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}</h5>
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
                                                <option value="{{ $data->maKQHT }}">{{ $data->maKQHTVB }} --
                                                    {{ $data->tenKQHT }}</option>
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
                <td>
                    <b>{{ $data->tenchuong }}</b><br>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_chapter_{{ $data->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a title="Delete" class="btn btn-danger"
                            onclick="return confirm('Confirm?')"
                            href="{{ asset('/giang-vien/bien-soan-de-cuong/xoa-noi-dung-mon-hoc/'.$data->id) }}">
                            <i class="fa fa-trash"></i>
                        </a> 
                    </div>
                    
                    <!-- Modal edit chuong -->
                    <div class="modal fade" id="edit_chapter_{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ asset('/giang-vien/bien-soan-de-cuong/sua-noi-dung-mon-hoc') }}" method="post">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="id" value="{{ $data->id }}" hidden>
                                        <div class="form-group">
                                            <label for="">{{ __('Chapter name') }}:</label>
                                            <input type="text" name="tenchuong" class="form-control" required value="{{ $data->tenchuong }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Số tiết lý thuyết:</label>
                                            <input type="number" min="0" name="soTietLT" value="{{ $data->soTietLT }}" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Số tiết thực hành:</label>
                                            <input type="number" min="0" name="soTietTH" value="{{ $data->soTietTH }}"  class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Số tiết khác:</label>
                                            <input type="number" name="soTietKhac" value="{{ $data->soTietKhac }}" min="0"  class="form-control" >
                                        </div>
                                      
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">{{ __("Save") }}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Button thêm mục -->
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#addMuc_{{ $data->id }}">
                        <i class="fas fa-plus"></i>{{ __('Adding item') }}
                    </button>

                    <!-- Modal thêm mục -->
                    <div class="modal fade" id="addMuc_{{ $data->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ asset('/giang-vien/bien-soan-de-cuong/them_noi_dung_muc_chuong') }}"
                                method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Adding item') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="id_chuong" value="{{ $data->id }}" hidden>
                                        <div class="form-group">
                                            <label for="">{{ __('Item ID') }}:</label>
                                            <input type="text" name="maMucVB" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('Item name') }}:</label>
                                            <input type="text" name="tenMuc" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- Button thêm kỹ năng UIT --}}
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#addMucDoKyNangUIT_{{ $data->id }}">
                        <i class="fas fa-plus"></i>{{ __('Adding level of skill') }}
                    </button>
                     {{-- Modal thêm kỹ năng UIT --}}
                    <div class="modal fade" id="addMucDoKyNangUIT_{{ $data->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ asset('/giang-vien/bien-soan-de-cuong/them_muc_do_ky_nang_uti') }}"
                                method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Adding level of skill') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="id_chuong" value="{{ $data->id }}" hidden>
                                        <div class="form-group">
                                            <label for="">{{ __('Choosing topic') }}:</label>
                                            <select name="maCDR1" id="" class="form-control">
                                                @for ($i = 1; $i < count($CDR1); $i++)
                                                    <option value="{{ $CDR1[$i]['maCDR1'] }}">{{ $CDR1[$i]['tenCDR1'] }}
                                                    </option>
                                                @endfor
                                                
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('Studying results') }}:</label>
                                            <select name="maKQHT[]" id="" class="form-control" multiple>
                                                @foreach ($getKQHT as $x)
                                                    <option value="{{ $x->maKQHT }}">{{ $x->maKQHTVB }}--
                                                        {{ $x->tenKQHT }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('Choosing') }} U - I - T:</label>
                                            <select name="ky_nang" id="" class="form-control">
                                                <option value="U">U</option>
                                                <option value="I">I</option>
                                                <option value="T">T</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                   
                </td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_hpkqht_{{$data->id}}">
                        <i class="fas fa-plus"></i> LO
                    </button>

                    @foreach ($data->chuong_kqht as $item)
                        {{ $item->maKQHTVB }} 
                        <a title="Delete" 
                            onclick="return confirm('Confirm?')"
                            href="{{ asset('/giang-vien/bien-soan-de-cuong/xoa-chuong-ket-qua-hoc-tap/'.$data->id.'/'.$item->maKQHT) }}">
                            <i class="fa fa-trash"></i>
                        </a>;
                    @endforeach

                    <!-- Modal chuong kqht-->
                    <div class="modal fade" id="add_hpkqht_{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <form action="{{ asset('/giang-vien/bien-soan-de-cuong/them-chuong-ket-qua-hoc-tap') }}" method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <input type="text" name="machuong" value="{{ $data->id }}" hidden>
                                <div class="form-group">
                                    <label for="">Chọn kết quả học tập:</label>
                                    <select name="maKQHT[]" id="" class="form-control" multiple required>
                                        @foreach ($getKQHT as $kqht)
                                            <option value="{{ $kqht->maKQHT }}">{{ $kqht->maKQHTVB }} --
                                                {{ $kqht->tenKQHT }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                <td>
                    {{ $data->soTietLT }}
                </td>
                <td>{{ $data->soTietTH }}</td>
                <td>{{ $data->soTietKhac }}</td>
            </tr>
            @foreach ($data->muc as $m)
                <tr>
                    <td>
                        <div class="btn-group">
                            <!-- Button edit item modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_muc_{{$m->id}}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a title="Delete" class="btn btn-danger"
                                onclick="return confirm('Confirm?')"
                                href="{{ asset('/giang-vien/bien-soan-de-cuong/xoa_noi_dung_muc_chuong/'.$m->id) }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        {{ $m->maMucVB }}
                        {{ $m->tenMuc }}
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <!-- Modal -->
                    <div class="modal fade" id="edit_muc_{{$m->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ asset('/giang-vien/bien-soan-de-cuong/sua_noi_dung_muc_chuong') }}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit') }} {{ __('Item') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="id" value="{{ $m->id }}" hidden>
                                    <div class="form-group">
                                        <label for="">{{ __('Item ID') }}:</label>
                                        <input type="text" name="maMucVB" class="form-control" value="{{ $m->maMucVB }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ __('Item name') }}:</label>
                                        <input type="text" name="tenMuc" class="form-control" value="{{ $m->tenMuc }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">{{ __("Save") }}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _('Cancel') }}</button>
                                </div>
                            </div>
                            </form>
                      
                        </div>
                    </div>
                </tr>
            @endforeach
            @for ($i = 1; $i < count($CDR1); $i++)
                <tr>
                    <td><b>{{ __('Topic') }}: {{ $CDR1[$i]['tenCDR1'] }}</b></td>
                    <td colspan="4">
                        @foreach ($mudokynangUIT as $uit)
                            @if ($uit->maCDR1 == $CDR1[$i]['maCDR1'] && $uit->id_chuong == $data->id)
                                {{ $uit->maKQHTVB }}({{ $uit->ky_nang }})
                                <a title="Delete" 
                                    onclick="return confirm('Confirm?')"
                                    href="{{ asset('/giang-vien/bien-soan-de-cuong/xoa_muc_do_ky_nang_uti/'.$uit->id) }}">
                                    <i class="fa fa-trash"></i>
                                </a>;
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
