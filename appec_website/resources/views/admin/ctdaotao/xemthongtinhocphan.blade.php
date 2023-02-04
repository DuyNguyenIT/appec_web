@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        {{ __('Course information') }} <noscript></noscript>
                        <nav></nav>
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Course information') }}</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bien_soan_de_cuong">
                                    <i class="fas fa-plus"></i> {{ __('edit syllabus') }}
                                </button>
                                <!-- Modal bien soan de cuong-->
                                <div class="modal fade" id="bien_soan_de_cuong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <form action="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/them-bien-soan-de-cuong') }}" method="post">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('edit syllabus') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">{{ __('Lecture') }}</label>
                                                <select name="maGV" id="" class="form-control">
                                                    @foreach ($giangvien as $gv)
                                                        <option value="{{ $gv->maGV }}">{{ $gv->maGV }}--{{ $gv->hoGV }} {{ $gv->tenGV }}</option>
                                                    @endforeach
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

                                {{-- Phan bien de cuong --}}
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#phan_bien_de_cuong">
                                    <i class="fas fa-plus"></i> {{ __('revise syllabus') }}
                                </button>

                                <!-- Modal phan bien de cuong-->
                                <div class="modal fade" id="phan_bien_de_cuong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <form action="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/them-phan-bien-de-cuong') }}" method="post">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('revise syllabus') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="maGV">{{ __('Lecture') }}</label>
                                                <select name="maGV" id="" class="form-control">
                                                    @foreach ($giangvien as $gv)
                                                        <option value="{{ $gv->maGV }}">{{ $gv->maGV }}--{{ $gv->hoGV }} {{ $gv->tenGV }}</option>
                                                    @endforeach
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
                            </h3>
                            <div class="card-tools">
                                <a href="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong') }}" class="btn btn-secondary">
                                      <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('No.') }}</th>
                                        <th>{{ __('Course ID') }}</th>
                                        <th>{{ __('Course Name') }}</th>
                                        <th>{{ __('Total Credits') }}</th>
                                        <th>{{ __('Knowledge block') }}</th>
                                        <th>{{ __('edit syllabus') }}</th>
                                        <th>{{ __('revise syllabus') }}</th>
                                        <th>{{ __('Curriculum') }}</th>
                                        <th>{{ __('Option') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($hocphan as $hp)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $hp->maHocPhan }}</td>
                                            <td>
                                                @if (session::has('language') && session::get('language')=='vi')
                                                {{ $hp->tenHocPhan }} -  ({{ $hp->tenHocPhanEN }})
                                                @else
                                                {{ $hp->tenHocPhanEN }}
                                                @endif
                                                
                                            </td>
                                            <td><b>{{ $hp->tongSoTinChi }}</b> ({{ $hp->tinChiLyThuyet }} {{ __('Thoery') }} + {{ $hp->tinChiThucHanh }} {{ __('Practice') }})</td>
                                            <td>
                                                @if (session::has('language') && session::get('language')=='vi')
                                                    {{ $hp->ctkhoi->tenCTKhoiKT }}
                                                @else
                                                    {{ $hp->ctkhoi->tenCTKhoiKTEN }}
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($bienSoan as $bs)
                                                     <li><b>{{ $bs->giang_vien->hoGV }} {{ $bs->giang_vien->tenGV }}</b></li>
                                                     <i>
                                                        (Từ: {{ \Carbon\Carbon::parse($bs->thoiGianBatDau)->format('d/m/Y h:m:s')}} đến: {{ \Carbon\Carbon::parse($bs->thoiGianKetThuc)->format('d/m/Y h:m:s')}})
                                                     </i>
                                                     <a title="Delete" 
                                                    onclick="return confirm('Confirm?')"
                                                    href="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/xoa-bien-soan-de-cuong/'.$bs->maGV) }}">
                                                 <i class="fa fa-trash"></i>
                                             </a>;
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($phanBien as $pb)
                                                <li><b>{{ $pb->giang_vien->hoGV }} {{ $pb->giang_vien->tenGV }}</b></li>
                                                <i>(Từ: {{ \Carbon\Carbon::parse($pb->thoiGianBatDau)->format('d/m/Y h:m:s')}} đến: {{ \Carbon\Carbon::parse($pb->thoiGianKetThuc)->format('d/m/Y h:m:s')}})</i>
                                                     <a title="Delete" 
                                                    onclick="return confirm('Confirm?')"
                                                    href="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/xoa-phan-bien-de-cuong/'.$pb->maGV) }}">
                                                 <i class="fa fa-trash"></i> 
                                             </a> ;
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($hp->hocphan_ctdt as $item)
                                                    <li>{{ $item->tenCT }}- <b>HK {{ $item->phanPhoiHocKy }}</b> ;
                                                    </li>
                                                @endforeach
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#add_CT_{{ $hp->maHocPhan }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <a href="{{ asset('quan-ly/hoc-phan/hoc-phan-ct-dao-tao/' . $hp->maHocPhan) }}"
                                                    class="btn btn-primary">...</a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="add_CT_{{ $hp->maHocPhan }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form
                                                            action="{{ asset('quan-ly/hoc-phan/them-hoc-phan-ctdt') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        {{ __('Add') }}</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="text" name="maHocPhan"
                                                                        value="{{ $hp->maHocPhan }}" hidden>
                                                                    <div class="form-group">
                                                                        <label for="">{{ __('Curriculum') }}</label>
                                                                        <select name="maCT" id="" class="form-control"
                                                                            required>
                                                                            @foreach ($ctdt as $y)
                                                                                <option value="{{ $y->maCT }}">
                                                                                    {{ $y->tenCT }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">{{ __('Semester') }}</label>
                                                                        <input type="number" min="1" max="8"
                                                                            name="phanPhoiHocKy" class="form-control"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">{{ __('Course Type') }}</label>
                                                                        <select name="maLoaiHocPhan" id=""
                                                                            class="form-control" required>
                                                                            @foreach ($loaihp as $z)
                                                                                <option
                                                                                    value="{{ $z->maLoaiHocPhan }}">
                                                                                    {{ $z->tenLoaiHocPhan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">{{ __('Save') }}</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">{{ __('Cancle') }}</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- style='white-space: nowrap' --}}
                                            <td >
                                                <a href=" {{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/' . $hp->maHocPhan) }}"
                                                    class="btn btn-success">
                                                    <i class="fas fa-align-justify"></i> {{ __('Course Syllabus') }}
                                                </a>
                                                <button title="Edit" class="btn btn-success" data-toggle="modal"
                                                    data-target="#edit_{{ $hp->maHocPhan }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a title="Delete" class="btn btn-danger"
                                                    onclick="return confirm('Do you want to delete {{ $hp->tenHocPhan }}?')"
                                                    href="{{ asset('quan-ly/hoc-phan/xoa/' . $hp->maHocPhan) }}"><i
                                                        class="fa fa-trash"></i></a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="edit_{{ $hp->maHocPhan }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form action="{{ asset('quan-ly/hoc-phan/sua') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Editing Course Information</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="text" name="maHocPhan"
                                                                        value="{{ $hp->maHocPhan }}"
                                                                        class="form-control" hidden>
                                                                    <div class="form-group">
                                                                        <label for="">{{ __('Course Name') }}</label>
                                                                        <input type="text" name="tenHocPhan"
                                                                            class="form-control"
                                                                            value="{{ $hp->tenHocPhan }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">{{ __('Course Name') }} EN</label>
                                                                        <input type="text" name="tenHocPhanEN"
                                                                            class="form-control"
                                                                            value="{{ $hp->tenHocPhanEN }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="">{{ __('Number of Theory Credits') }}</label>
                                                                        <input type="number" name="tinChiLyThuyet"
                                                                            class="form-control"
                                                                            value="{{ $hp->tinChiLyThuyet }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="">{{ __('Number of Practice Credits') }}</label>
                                                                        <input type="number" name="tinChiThucHanh"
                                                                            class="form-control"
                                                                            value="{{ $hp->tinChiThucHanh }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="">{{ __('Knowledge block') }}</label>
                                                                        <select name="maCTKhoiKT" id=""
                                                                            class="form-control" required>
                                                                            @foreach ($ctkhoi as $x)
                                                                                @if ($hp->ctkhoi->maCTKhoiKT == $x->maCTKhoiKT)
                                                                                    <option
                                                                                        value="{{ $x->maCTKhoiKT }}"
                                                                                        selected>{{ $x->maCTKhoiKT }}
                                                                                        -
                                                                                        {{ $x->tenCTKhoiKT }}
                                                                                    </option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $x->maCTKhoiKT }}">
                                                                                        {{ $x->maCTKhoiKT }} -
                                                                                        {{ $x->tenCTKhoiKT }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="">{{ __('Course Description') }}</label>
                                                                        <textarea name="moTaHocPhan"
                                                                            class="form-control">{{ $hp->moTaHocPhan }}</textarea>
                                                                    </div>
                                                                </div>
                                                        </form>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Update</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
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

</div>
@endsection