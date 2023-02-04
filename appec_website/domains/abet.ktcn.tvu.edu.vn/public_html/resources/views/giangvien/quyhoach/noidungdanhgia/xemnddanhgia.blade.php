@extends('giangvien.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Project') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ asset('/giang-vien') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Đồ án</a>
                            </li>
                            <li class="breadcrumb-item active">Nội dung đánh giá</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <i class="far fa-address-card"></i> Thêm phiếu chấm
                                    </button>
                                    {{-- <a href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/' . $maCTBaiQH) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-balance-scale-left"></i> Tiêu chí đánh giá đồ án
                                    </a> --}}
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#moichambc">
                                        Mời chấm báo cáo
                                    </button>
                                    <!-- Modal mời chấm báo cáo -->
                                    <div class="modal fade" id="moichambc" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form
                                                action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/moi-cham-bao-cao') }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Mời chấm báo cáo</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for=""> Chọn giảng viên:</label>
                                                            <select name="maGV_2" id="" class="form-control select2" style="width:100%">
                                                                <option value="00000">Chọn riêng giảng viên chấm cho đề tài
                                                                </option>
                                                                @foreach ($gv as $x)
                                                                    <option value="{{ $x->maGV }}">{{ $x->hoGV }}
                                                                        {{ $x->tenGV }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Modal thêm phiếu chấm -->
                                    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <form
                                                action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-phieu-cham') }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Thêm phiếu chấm
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="hocphan" style="font-size: 20px">Chọn đề tài</label>
                                                            <!-- Button trigger modal -->
                                                            <select name="maDe" id="" class="form-control custom-select  select2" style="width:100%" required>
                                                                @foreach ($deTai as $md)
                                                                    <option value="{{ $md->maDe }}">
                                                                        {{ $md->maDeVB }}--{{ $md->tenDe }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Chọn sinh viên</label>
                                                            <select name="maSSV[]" id="" class="form-control select2" style="width:100%" multiple required>
                                                                @foreach ($dsLop as $sv)
                                                                    <option value="{{ $sv->maSSV }}">
                                                                        {{ $sv->maSSV }}--{{ $sv->HoSV }}
                                                                        {{ $sv->TenSV }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if ($canbo2->maGV == '00000')
                                                            <div class="form-group">
                                                                <label for=""> Chọn giảng viên:</label>
                                                                <select name="maGV_2" id="" class="form-control select2" style="width:100%">
                                                                    @foreach ($gv as $x)
                                                                        <option value="{{ $x->maGV }}">
                                                                            {{ $x->hoGV }} {{ $x->tenGV }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Save') }}
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                            {{ __("Cancel") }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <hr>
                                    Cán bộ chấm 2: {{ $canbo2->hoGV }} {{ $canbo2->tenGV }}
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/' . Session::get('maHocPhan') . '/' . Session::get('maBaiQH') . '/' . Session::get('maHK') . '/' . Session::get('namHoc') . '/' . Session::get('maLop')) }}"
                                        class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                </div>
                            </div>
                            {{-- <div class="card-header">Giảng viên cộng tác: <b>Võ Thành C</b></div> --}}
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __("No.") }}</th>
                                            <th>Mã đề tài</th>
                                            <th>

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#themDT">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="themDT" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form
                                                            action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-de-tai') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Thêm đề
                                                                        tài</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="">Nhập mã đề tài:</label>
                                                                        <input type="text" name="maDe" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Nhập tên đề tài:</label>
                                                                        <input type="text" name="tenDe"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Lưu</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Hủy</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                            </div>
                                            Tên đề tài
                                            </th>
                                            <th>Sinh viên thực hiện</th>
                                            <th>Mã sinh viên</th>
                                            <th>Cán bộ chấm 2</th>
                                            <th>Tùy chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $chayTenDT = 0;
                                            $maDe_cur = 0;
                                        @endphp
                                        @foreach ($deThi as $dt)
                                            @php
                                                $demTenDT = $deThi->where('maDe', $dt->maDe)->count();
                                                if ($chayTenDT > $demTenDT) {
                                                    $chayTenDT = 1;
                                                } else {
                                                    $chayTenDT += 1;
                                                }
                                                if ($maDe_cur !== $dt->maDe) {
                                                    $maDe_cur = $dt->maDe;
                                                    $chayTenDT = 1;
                                                }
                                            @endphp
                                            @if ($chayTenDT == 1)
                                                <tr>
                                                    <td rowspan={{ $demTenDT }}>{{ $i++ }}</td>
                                                    <td rowspan={{ $demTenDT }}>{{ $dt->maDeVB }}</td>
                                                    <td rowspan={{ $demTenDT }}>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#editTen_{{ $dt->maDe }}">
                                                            <i class="fas fa-edit"></i> Sửa ĐT
                                                        </button>

                                                        <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xoa-ten-de-tai/'.$dt->maDe) }}"
                                                            onclick="return confirm('Confirm?')"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash"></i> Xóa ĐT
                                                        </a>
                                                        {{ $dt->tenDe }}
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="editTen_{{ $dt->maDe }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <form
                                                                    action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/sua-ten-de-tai') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                                Sửa tên DT</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input type="text" name="maDe" id="" hidden
                                                                                value="{{ $dt->maDe }}">
                                                                            <div class="form-group">
                                                                                <label for="">Tên đề tài:</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="tenDe" id=""
                                                                                    value="{{ $dt->tenDe }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Save</button>
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $dt->HoSV }} {{ $dt->TenSV }}</td>
                                                    <td>{{ $dt->maSSV }}</td>
                                                    <td>{{ $dt->hoGV }} {{ $dt->tenGV }}</td>
                                                    <td>
                                                        <button class="btn btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a class="btn btn-danger"
                                                            href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xoa-phieu-cham-do-an/' . $dt->maDe . '/' . $dt->maSSV) }}"
                                                            onclick="confirm('Confirm?')"><i
                                                                class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $dt->HoSV }} {{ $dt->TenSV }}</td>
                                                    <td>{{ $dt->maSSV }}</td>
                                                    <td>{{ $dt->hoGV }} {{ $dt->tenGV }}</td>
                                                    <td>
                                                        <button class="btn btn-primary">
                                                            <i class="fas fa-edit"></i> 
                                                        </button>
                                                        <a class="btn btn-danger"
                                                            href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xoa-phieu-cham-do-an/' . $dt->maDe . '/' . $dt->maSSV) }}"
                                                            onclick="confirm('Confirm?')"><i
                                                                class="fas fa-trash"></i></a>
                                                    </td>
                                            @endif
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
    <!-- /.content-wrapper -->
@endsection
