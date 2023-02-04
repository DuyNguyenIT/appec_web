<h5><b>6. Phương pháp giảng dạy </b></h5>
<!----------------------------------6. Phương pháp giảng dạy: --------------------------->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ppgiangday">
    <i class="fas fa-edit"></i>
</button>
<!-- Modal thêm phương pháp giảng dạy-->
<div class="modal fade" id="ppgiangday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                        <select name="maPP" id="" class="form-control select2" style="width:100%">
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
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<table class="table table-bordered">
    <thead style="background-color: green">
        <tr>
            <th>{{ __('No.') }}</th>
            <th>Phương pháp/ kỹ thuật giảng dạy</th>
            <th>Diễn giải</th>
            <th>{{ __('Option') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($hocPhan_ppGiangDay as $data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $data->ppGiangDay->tenPP }} </td>
                <td>{{ $data->dienGiai }}</td>
                <td>
                    <a title="Delete" class="btn btn-danger"
                        onclick="return confirm('Confirm?')"
                        href="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/xoa-phuong-phap-giang-day/'.$data->id) }}">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
