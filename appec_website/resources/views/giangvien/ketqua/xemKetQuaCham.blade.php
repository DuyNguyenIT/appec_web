@extends('giangvien.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Xem phiếu đánh giá đồ án<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item "><a href="#">Tên môn</a></li>
                            <li class="breadcrumb-item "><a href="#">Đồ án</a></li>
                            <li class="breadcrumb-item active">Xem phiếu chấm</li>
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
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="">
                                    1. Họ và tên (thành viên chấm): {{ $gv->hoGV }} {{ $gv->tenGV }} <br>
                                    2. Chức danh: <br>
                                    3. Đơn vị công tác: <br>
                                    4. Tên đề tài: {{ $deTai->tenDe }} <br>
                                    5. Học và tên sinh viên bảo vệ: {{ $sv->HoSV }} {{ $sv->TenSV }} <br>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <i>(Thành viên chấm chọn tiêu chí tương ứng với mức độ mà sinh viên đạt được)</i>
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tiêu chuẩn</th>
                                            <th>Chuẩn đầu ra</th>
                                            <th>Tiêu chí</th>
                                            <th>Điểm đánh giá</th>
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
                                                    <td rowspan={{ $demTieuChi_TCDG }}>{{ $tc->tenTCDG }}
                                                        <b>({{ $tc->diem }} điểm)</b>
                                                    </td>
                                                    @if ($chayCDR_TCDG == 1)
                                                        <td rowspan={{ $demTC_CDR }}>{{ $tc->maCDR3VB }}:
                                                            {{ $tc->tenCDR3 }}</td>
                                                        <td>{{ $tc->tenTCCD }} <b>({{ $tc->diemTCCD }} điểm)</b></td>
                                                        <td>{{ $tc->diemDG }}</td>
                                                    @else
                                                        <td>{{ $tc->tenTCCD }} <b>({{ $tc->diemTCCD }} điểm)</b></td>
                                                        <td>{{ $tc->diemDG }}</td>
                                                    @endif
                                                </tr>
                                            @else
                                                <tr>
                                                    @if ($chayCDR_TCDG == 1)
                                                        <td rowspan={{ $demTC_CDR }}>{{ $tc->maCDR3VB }}:
                                                            {{ $tc->tenCDR3 }}</td>
                                                        <td>{{ $tc->tenTCCD }} <b>({{ $tc->diemTCCD }} điểm)</b></td>
                                                        <td>{{ $tc->diemDG }}</td>
                                                    @else
                                                        <td>{{ $tc->tenTCCD }} <b>({{ $tc->diemTCCD }} điểm)</b></td>
                                                        <td>{{ $tc->diemDG }}</td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                <hr>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    @endsection
