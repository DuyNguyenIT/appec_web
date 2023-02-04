@extends('giangvien.master')
@section('content')
<div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        
                        @if (Session::has('language') && Session::get('language')=='vi')
                            {{$hinhthucDanhGia->tenLoaiHTDG}}
                        @else
                            {{$hinhthucDanhGia->tenLoaiHTDG_EN}}
                        @endif
                        <noscript></noscript>
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
                            <a href="#">
                                @if (Session::has('language') && Session::get('language')=='vi')
                                    {{$hinhthucDanhGia->tenLoaiHTDG}}
                                @else
                                    {{$hinhthucDanhGia->tenLoaiHTDG_EN}}
                                @endif
                            </a>
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
                                                        <select name="maDe" id="" class="form-control custom-select" required>
                                                            @foreach ($deTai as $md)
                                                                <option value="{{ $md->maDe }}">
                                                                    {{ $md->maDeVB }}--{{ $md->tenDe }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Chọn sinh viên</label>
                                                        <!-- Mai sửa đề chọn nhiều -->
                                                        <br>
                                                        <!-- <select name="maSSV" id="" class="form-control custom-select"  required>-->
                                                            <select class="selectpicker" multiple data-live-search="true" name="maSSV[]">
                                                           
                                                                @foreach ($dsLop as $sv)
                                                                    <option value="{{ $sv->maSSV }}">
                                                                        {{ $sv->maSSV }}--{{ $sv->HoSV }}
                                                                        {{ $sv->TenSV }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                    
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
                                
                            </h3>
                            <div class="card-tools">
                                <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/' . Session::get('maHocPhan') . '/' . Session::get('maBaiQH') . '/' . Session::get('maHK') . '/' . Session::get('namHoc') . '/' . Session::get('maLop')) }}"
                                    class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
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
                                        
                                        <th>Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($deTai as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $data->maDeVB }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#editTen_{{ $data->maDe }}">
                                                <i class="fas fa-edit"></i>
                                                </button>
                                                {{ $data->tenDe }}
                                                <!-- Modal -->
                                                <div class="modal fade" id="editTen_{{ $data->maDe }}"
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
                                                                        Modal title</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="text" name="maDe" id="" hidden
                                                                        value="{{ $data->maDe }}">
                                                                    <div class="form-group">
                                                                        <label for="">Tên đề tài:</label>
                                                                        <input type="text" class="form-control"
                                                                            name="tenDe" id=""
                                                                            value="{{ $data->tenDe }}">
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
                                            <td>
                                                <ul>
                                                    @foreach ($dssvTrongPC as $sv)
                                                        @if ($sv->maDe ==$data->maDe)
    
                                                            <li>
                                                                <a title="{{ __('Delete') }}" class="btn btn-danger"
                                                                    onclick="return confirm('Do you want to delete student {{ $sv->maSSV }} - {{ $sv->HoSV }} {{$sv->TenSV}} ?')"
                                                                    href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/xoa-phieu-cham-SV-trong-nhom/' . $sv->maDe . '/' . $sv->maSSV )  }}"><i
                                                                        class="fa fa-trash"></i></a>
                                                                {{$sv->maSSV }} - {{ $sv->HoSV }} {{ $sv->TenSV }}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                    
                                                </ul>
                                            </td>
                                            
                                            <td>
                                                <a title="{{ __('Delete') }}" class="btn btn-danger"
                                                onclick="return confirm('Do you want to delete Topic {{ $data->maDeVB }} - {{ $data->tenDe }} ?')"
                                                href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/xoa-de-tai-hoi-thao/' . $data->maDe )  }}"><i
                                                    class="fa fa-trash"></i></a>
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