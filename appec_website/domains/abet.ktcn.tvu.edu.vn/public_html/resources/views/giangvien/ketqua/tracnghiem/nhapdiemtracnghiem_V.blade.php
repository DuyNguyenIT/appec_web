@extends('giangvien.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Phiếu đánh giá trắc nghiệm<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item "><a href="#">Tên môn</a></li>
                            <li class="breadcrumb-item "><a href="#">Thực hành</a></li>
                            <li class="breadcrumb-item active">Phiếu chấm</li>
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
                        <form action="{{ asset('/giang-vien/ket-qua-danh-gia/trac-nghiem/cham-diem-submit') }}"
                            method="post">
                            @csrf
                            <input type="text" name="maPhieuCham" hidden value={{ $gv->maPhieuCham }}>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        1. Giảng viên chấm: {{ $gv->hoGV }} {{ $gv->tenGV }} <br>
                                        2. Chức danh: <br>
                                        3. Đơn vị công tác: <br>
                                        4. Đề thi: {{ $dethi->tenDe }} <br>
                                        5. Học và tên sinh viên: {{ $sv->HoSV }} {{ $sv->TenSV }} <br>
                                    </h5>
                                    <div class="card-tools">
                                        <a href="{{ asset('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/' . Session::get('maCTBaiQH')) }}"
                                            class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Câu hỏi</th>
                                                <th>Phương án</th>
                                                <th></th>
                                                {{-- <th>Chọn <input type="checkbox" name="" id="selectAll"></th>
                        <script>
                          $("#selectAll").click(function(){
                                  $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
                          });
                        </script> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                                $chayCauHoi = 0;
                                                $chayCDR_PATL = 0;
                                                $cauHoiHienTai = 0;
                                                $cdrHienTai = 0;
                                            @endphp
                                            @foreach ($noidung as $tc)
                                                @php
                                                    
                                                    if ($cdrHienTai != $tc->maCDR3) {
                                                        //kiểm tra nếu chuẩn đầu ra thay đổi thì chuyển biến chạy về 1
                                                        $cdrHienTai = $tc->maCDR3;
                                                        $chayCDR_PATL = 1;
                                                    } else {
                                                        //nếu không tăng biến chạy lên
                                                        $chayCDR_PATL += 1;
                                                    }
                                                    
                                                    if ($cauHoiHienTai != $tc->maCauHoi) {
                                                        //đặt kiểm tiêu chuẩn ở dưới vì khi khác tiêu chuẩn thì biến chayCDR phải trở về 1
                                                        $cauHoiHienTai = $tc->maCauHoi;
                                                        $chayCauHoi = 1;
                                                        $chayCDR_PATL = 1;
                                                    } else {
                                                        $chayCauHoi += 1;
                                                    }
                                                    
                                                    $demTCDG = $noidung->groupBy('noiDungCauHoi')->count();
                                                    $demCDR_TCDG = $noidung
                                                        ->where('maCauHoi', $tc->maCauHoi)
                                                        ->groupBy('tenCDR3')
                                                        ->count();
                                                    $demPA_CauHoi = $noidung->where('maCauHoi', $tc->maCauHoi)->count('maPATL');
                                                    $diemCauHoi = $noidung->where('maCauHoi', $tc->maCauHoi)->first();
                                                    //$diemCauHoi=1;
                                                    $demTC_CDR = $noidung
                                                        ->where('maPATL', $tc->maPATL)
                                                        ->where('maCDR3', $tc->maCDR3)
                                                        ->count('noiDungPA');
                                                    
                                                @endphp
                                                @if ($chayCauHoi == 1)
                                                    <tr>
                                                        <td rowspan={{ $demPA_CauHoi }}>{{ $i++ }}</td>
                                                        <td rowspan={{ $demPA_CauHoi }}>{!! $tc->noiDungCauHoi !!} <b>(
                                                                {{ $diemCauHoi['diem'] }} điểm)</b></td>
                                                        @if ($chayCDR_PATL == 1)
                                                            <td>{!! $tc->noiDungPA !!}
                                                                <b>(
                                                                    @if ($tc->isCorrect == false)
                                                                        0
                                                                    @else
                                                                        {{ $diemCauHoi['diem'] }}
                                                                    @endif
                                                                    điểm)
                                                                </b>
                                                            </td>
                                                        @else
                                                            <td>{!! $tc->noiDungPA !!} <b>(
                                                                    @if ($tc->isCorrect == false)
                                                                        0
                                                                    @else
                                                                        {{ $diemCauHoi['diem'] }}
                                                                    @endif
                                                                    điểm)
                                                                </b></td>
                                                        @endif
                                                        <td>
                                                            <input type="radio" id="{{ $tc->maCauHoi }}"
                                                                name="chon_{{ $tc->maCauHoi }}"
                                                                value="{{ $tc->id }}" />

                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        @if ($chayCDR_PATL == 1)
                                                            <td>{!! $tc->noiDungPA !!} <b>(
                                                                    @if ($tc->isCorrect == false)
                                                                        0
                                                                    @else
                                                                        {{ $diemCauHoi['diem'] }}
                                                                    @endif
                                                                    điểm)
                                                                </b></td>
                                                        @else
                                                            <td>{!! $tc->noiDungPA !!} <b>(
                                                                    @if ($tc->isCorrect == false)
                                                                        0
                                                                    @else
                                                                        {{ $diemCauHoi['diem'] }}
                                                                    @endif
                                                                    điểm)
                                                                </b></td>
                                                        @endif
                                                        <td>
                                                            <input type="radio" id="{{ $tc->maCauHoi }}"
                                                                name="chon_{{ $tc->maCauHoi }}"
                                                                value="{{ $tc->id }}" />
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <h5><b>Ý kiến đóng góp</b></h5>
                                        <input type="text" name="yKienDongGop" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Chấm điểm</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </form>
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
