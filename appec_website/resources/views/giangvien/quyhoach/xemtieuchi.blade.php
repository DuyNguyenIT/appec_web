@extends('giangvien.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Nhóm tiêu chí đánh giá<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item "><a href="quyhoachKQHT.html">Đồ án</a></li>
                            <li class="breadcrumb-item "><a
                                    href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/' . Session::get('maCTBaiQH')) }}">Nội
                                    dung đánh giá</a></li>
                            <li class="breadcrumb-item active">Nhóm tiêu chí đánh giá</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-tieu-chi-danh-gia/' . Session::get('maCTBaiQH')) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-plus"></i> 
                                    </a>
                                    {{-- <button class="btn btn-success">
                                        <i class="fas fa-print"></i> Xuất tiêu chí đánh giá
                                    </button> --}}
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/' . Session::get('maHocPhan') . '/' . Session::get('maBaiQH') . '/' . Session::get('maHK') . '/' . Session::get('namHoc') . '/' . Session::get('maLop')) }}"
                                        class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tiêu chuẩn</th>
                                            <th colspan="2">Chuẩn đầu ra - ABET</th>
                                            <th>Tiêu chí</th>
                                            <th>Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $chayTieuChuan = 0;
                                            $chayCDR_TCDG = 0;
                                            $tieuChuanHienTai = 0;
                                            $cdrHienTai = 0;
                                        @endphp
                                        @foreach ($tieuchi as $tc)
                                            @php
                                                
                                                if ($cdrHienTai != $tc->maCDR3) {
                                                    //kiểm tra nếu chuẩn đầu ra thay đổi thì chuyển biến chạy về 1
                                                    $cdrHienTai = $tc->maCDR3;
                                                    $chayCDR_TCDG = 1;
                                                } else {
                                                    //nếu không tăng biến chạy lên
                                                    $chayCDR_TCDG += 1;
                                                }
                                                if ($tieuChuanHienTai != $tc->maTCDG) {
                                                    //đặt kiểm tiêu chuẩn ở dưới vì khi khác tiêu chuẩn thì biến chayCDR phải trở về 1
                                                    $tieuChuanHienTai = $tc->maTCDG;
                                                    $chayTieuChuan = 1;
                                                    $chayCDR_TCDG = 1;
                                                } else {
                                                    $chayTieuChuan += 1;
                                                }
                                                
                                                $demTCDG = $tieuchi->groupBy('tenTCDG')->count();
                                                $demCDR_TCDG = $tieuchi
                                                    ->where('maTCDG', $tc->maTCDG)
                                                    ->groupBy('tenCDR3')
                                                    ->count();
                                                $demTieuChi_TCDG = $tieuchi->where('maTCDG', $tc->maTCDG)->count('tenTCCD');
                                                $demTC_CDR = $tieuchi
                                                    ->where('maTCDG', $tc->maTCDG)
                                                    ->where('maCDR3', $tc->maCDR3)
                                                    ->count('tenTCCD');
                                            @endphp
                                            @if ($chayTieuChuan == 1)
                                                <tr>
                                                    <td rowspan={{ $demTieuChi_TCDG }}>{{ $i++ }}</td>
                                                    <td rowspan={{ $demTieuChi_TCDG }}><b>{{ $tc->tenTCDG }}</b></td>
                                                    @if ($chayCDR_TCDG == 1)
                                                        <td rowspan={{ $demTC_CDR }}>{{ $tc->maCDR3VB }}:
                                                            {{ $tc->tenCDR3 }}; <br> {{ $tc->maChuanAbetVB }}-- {{ $tc->tenChuanAbet }}</td>
                                                        <td rowspan={{ $demTC_CDR }}>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_abet_{{ $tc->maTCDG }}__{{ $tc->maCDR3 }}">
                                                                <i class="fas fa-edit"></i> ABET's SO
                                                            </button>
                                                            
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="edit_abet_{{ $tc->maTCDG }}__{{ $tc->maCDR3 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/sua-chuan-abet') }}" method="post">
                                                                    @csrf
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit') }} </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input type="text" name="maTCDG" value="{{ $tc->maTCDG }}" hidden>
                                                                            <input type="text" name="maCDR3" value="{{ $tc->maCDR3 }}" hidden>
                                                                            <div class="form-group">
                                                                                <label >{{ __('SOs') }}</label>
                                                                                <select name="maChuanAbet" id="" class="form-control">
                                                                                    @foreach ($ABET as $abet)
                                                                                        @if ($tc->maChuanAbet==$abet->maChuanAbet)
                                                                                            <option value="{{ $abet->maChuanAbet }}" selected>{{ $abet->maChuanAbetVB }}-- {{ $abet->tenChuanAbet }}</option>
                                                                                        @else
                                                                                            <option value="{{ $abet->maChuanAbet }}" >{{ $abet->maChuanAbetVB }}-- {{ $abet->tenChuanAbet }}</option>
                                                                                        @endif
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

                                                        {{-- end modal --}}
                                                        </td>
                                                        <td>{{ $chayCDR_TCDG }}. {{ $tc->tenTCCD }}</td>
                                                        <td>{{ $tc->diemTCCD }} điểm</td>
                                                    @else
                                                        <td>{{ $chayCDR_TCDG }}. {{ $tc->tenTCCD }}</td>
                                                        <td>{{ $tc->diemTCCD }} điểm</td>
                                                    @endif
                                                </tr>
                                            @else
                                                <tr>
                                                    @if ($chayCDR_TCDG == 1)
                                                        <td rowspan={{ $demTC_CDR }}>{{ $tc->maCDR3VB }}:
                                                            {{ $tc->tenCDR3 }}; <br> {{ $tc->maChuanAbetVB }}-- {{ $tc->tenChuanAbet }}</td>
                                                        <td rowspan={{ $demTC_CDR }}>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_abet_{{ $tc->maTCDG }}_{{ $tc->maCDR3 }}">
                                                                <i class="fas fa-edit"></i> ABET's SO
                                                            </button>
                                                            
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="edit_abet_{{ $tc->maTCDG }}_{{ $tc->maCDR3 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/sua-chuan-abet') }}" method="post">
                                                                        @csrf
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit') }} </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input type="text" name="maTCDG" value="{{ $tc->maTCDG }}" hidden>
                                                                                <input type="text" name="maCDR3" value="{{ $tc->maCDR3 }}" hidden>

                                                                                <div class="form-group">
                                                                                    <label >{{ __('SOs') }}</label>
                                                                                    <select name="maChuanAbet" id="" class="form-control">
                                                                                        @foreach ($ABET as $abet)
                                                                                            @if ($tc->maChuanAbet==$abet->maChuanAbet)
                                                                                                <option value="{{ $abet->maChuanAbet }}" selected>{{ $abet->maChuanAbetVB }}-- {{ $abet->tenChuanAbet }}</option>
                                                                                            @else
                                                                                                <option value="{{ $abet->maChuanAbet }}" >{{ $abet->maChuanAbetVB }}-- {{ $abet->tenChuanAbet }}</option>
                                                                                            @endif
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

                                                        {{-- end modal --}}
                                                        </td>
                                                        <td>{{ $chayCDR_TCDG }}. {{ $tc->tenTCCD }}</td>
                                                        <td>{{ $tc->diemTCCD }} điểm</td>
                                                    @else
                                                        <td>{{ $chayCDR_TCDG }}. {{ $tc->tenTCCD }}</td>
                                                        <td>{{ $tc->diemTCCD }} điểm</td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
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
@endsection
