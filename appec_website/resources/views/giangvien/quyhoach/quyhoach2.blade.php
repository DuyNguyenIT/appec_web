@extends('giangvien.master')
<link rel="stylesheet" href="{{ asset('dist/css/hortreebootstrap.css') }}">
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Assessment Planning') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ asset('giang-vien/quy-hoach-danh-gia') }}">
                                    @if (session::has('language') && session::get('language')=='en') 
                                    {{ $hp->tenHocPhanEN }}
                                     @else 
                                     {{ $hp->tenHocPhan }}
                                    @endif

                                    
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ __('Assessment Planning') }}
                            </li>
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
                                    @if ($count_ct == 0)
                                        <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/chon-nhom-cong-thuc') }}"
                                            method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">{{ __('Formula') }}:</label>
                                                <select name="groupCT" id="" class="form-control">
                                                    <option value="1">
                                                        @php
                                                            $n = $hocphan_loai_htdg_array->where('groupCT', 1)->count();
                                                            $cr = 0;
                                                        @endphp
                                                        @foreach ($hocphan_loai_htdg_array as $data)
                                                            @if ($cr != 0 && $cr < $n && $data->groupCT == 1)
                                                                +
                                                                @php
                                                                    $cr++;
                                                                @endphp
                                                                ({{ $data->loaiHTDanhGia['maLoaiHTDG'] }} -  
                                                                    @if (Session::has('language') && Session::get('language')=='en')
                                                                        {{ $data->loaiHTDanhGia['tenLoaiHTDG_EN'] }}
                                                                    @else
                                                                    {{ $data->loaiHTDanhGia['tenLoaiHTDG'] }}
                                                                    @endif
                                                                ) *{{ $data->trongSo }}%
                                                            @elseif($data->groupCT==1)
                                                                @php
                                                                    $cr++;
                                                                @endphp
                                                                 ({{ $data->loaiHTDanhGia['maLoaiHTDG'] }} -  
                                                                 @if (Session::has('language') && Session::get('language')=='en')
                                                                        {{ $data->loaiHTDanhGia['tenLoaiHTDG_EN'] }}
                                                                    @else
                                                                    {{ $data->loaiHTDanhGia['tenLoaiHTDG'] }}
                                                                    @endif
                                                                ) *{{ $data->trongSo }}%
                                                            @endif
                                                        @endforeach
                                                    </option>
                                                    @php
                                                        $n = $hocphan_loai_htdg_array->where('groupCT', 2)->count();
                                                        $cr = 0;
                                                    @endphp
                                                    @if ($n > 0)
                                                        <option value="2">
                                                            @foreach ($hocphan_loai_htdg_array as $data)
                                                                @if ($cr != 0 && $cr < $n && $data->groupCT == 2)
                                                                    +
                                                                    @php
                                                                        $cr++;
                                                                    @endphp
                                                                     ({{ $data->loaiHTDanhGia['maLoaiHTDG'] }} -  
                                                                     @if (Session::has('language') && Session::get('language')=='en')
                                                                        {{ $data->loaiHTDanhGia['tenLoaiHTDG_EN'] }}
                                                                    @else
                                                                    {{ $data->loaiHTDanhGia['tenLoaiHTDG'] }}
                                                                    @endif
                                                                     ) *{{ $data->trongSo }}%
                                                                @elseif($data->groupCT==2)
                                                                    @php
                                                                        $cr++;
                                                                    @endphp
                                                                     ({{ $data->loaiHTDanhGia['maLoaiHTDG'] }} -  
                                                                     @if (Session::has('language') && Session::get('language')=='en')
                                                                        {{ $data->loaiHTDanhGia['tenLoaiHTDG_EN'] }}
                                                                    @else
                                                                    {{ $data->loaiHTDanhGia['tenLoaiHTDG'] }}
                                                                    @endif
                                                                     ) *{{ $data->trongSo }}%
                                                                @endif
                                                            @endforeach
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> {{ __('Choose') }}
                                            </button>
                                    @endif
                                    </form>
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/'.Session::get('namHoc').'/'.Session::get('maHK')) }}" class="btn btn-success"><i
                                            class="fas fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($count_ndqh==0)
                                <a title="Delete" class="btn btn-danger"
                                    onclick="return confirm('Confirm?')"
                                    href="{{ asset('/giang-vien/quy-hoach-danh-gia/xoa-nhom-cong-thuc/'.Session::get('maBaiQH')) }}">
                                <i class="fa fa-trash"></i> {{ __('Delete') }} {{ __('Formula') }}
                            </a>
                                @endif
                                {{-- div tree --}}
                                <div class="tree ">
                                    <ul>
                                        <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse"
                                                    href="#Web" aria-expanded="true" aria-controls="Web"><i
                                                        class="collapsed"><i class="fas fa-folder"></i></i>
                                                    <i class="expanded"><i class="far fa-folder-open"></i></i>
                                                    {{ __('Course') }}: 
                                                        @if (session::has('language') && session::get('language')=='en') 
                                                        {{ $gd[0]->tenHocPhanEN }} 
                                                        @else 
                                                        {{ $gd[0]->tenHocPhan }} 
                                                        @endif
                                                    --
                                                    {{ __('Semester') }}: {{ $gd[0]->maHK }} --
                                                    {{ __('Academic year') }}: {{ $gd[0]->namHoc }} --||--
                                                    {{ __('Class ID') }}: {{ strtoupper($gd[0]->maLop) }} </a></span>
                                            <div id="Web" class="collapse show">
                                                <ul>
                                                    {{-- <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#page1" aria-expanded="false" aria-controls="page1"><i class="collapsed"><i class="fas fa-folder"></i></i>
                                            <i class="expanded"><i class="far fa-folder-open"></i></i> Page 1</a></span>
                                            <ul><div id="page1" class="collapse">
                                                <li><span><i class="far fa-file"></i><a href="#!"> Link 1</a></span></li>
                                                <li><span><i class="far fa-file"></i><a href="#!"> Link 2</a></span></li>
                                                <li><span><i class="far fa-file"></i><a href="#!"> Link 3</a></span></li>
                                                <li><span><i class="far fa-file"></i><a href="#!"> Link 4</a></span></li></div>
                                            </ul>
                                        </li> --}}
                                                    @foreach ($qh as $x)
                                                        <li>
                                                            <span><a style="color:#000; text-decoration:none;"
                                                                    data-toggle="collapse"
                                                                    href="#Page_{{ $x->maCTBaiQH }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="Page_{{ $x->maCTBaiQH }}"><i
                                                                        class="collapsed"><i class="fas fa-folder"></i></i>
                                                                    <i class="expanded"><i
                                                                            class="far fa-folder-open"></i></i>
                                                                    @if (Session::has('language') && Session::get('language') == 'en')
                                                                        {{ $x->tenLoaiDG_EN }}
                                                                    @else
                                                                        {{ $x->tenLoaiDG }}
                                                                    @endif --
                                                                    @if (Session::has('language') && Session::get('language') == 'en')
                                                                        {{ $x->tenLoaiHTDG_EN }}
                                                                    @else
                                                                        {{ $x->tenLoaiHTDG }}
                                                                    @endif -- {{ $x->trongSo }}%
                                                                </a></span>
                                                            <ul>
                                                                <div id="Page_{{ $x->maCTBaiQH }}" class="collapse">
                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/' . $x->maCTBaiQH) }}">
                                                                                1.
                                                                                {{ __('Planning Content') }}</a></span>
                                                                    </li>
                                                                    @if ($x->maLoaiHTDG == 'T8' ||  $x->maLoaiHTDG == 'T6')
                                                                        <li><span><i class="far fa-circle"></i><a 
                                                                                    href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/' . $x->maCTBaiQH) }}">
                                                                                    2.
                                                                                    {{ __('Assessment form') }}</a></span>
                                                                        </li>
                                                                        <li><span><i class="far fa-circle"></i><a 
                                                                                    href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/' . $x->maCTBaiQH) }}">
                                                                                    3.
                                                                                    {{ __('Project title') }}</a></span>
                                                                        </li>
                                                                    @else
                                                                        {{-- T1 - tu luan --}}
                                                                        @if ($x->maLoaiHTDG == 'T1')
                                                                            <li><span><a style="color:#000; text-decoration:none;"
                                                                                        data-toggle="collapse"
                                                                                        href="#store_{{ $x->maCTBaiQH }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="store_{{ $x->maCTBaiQH }}"><i
                                                                                            class="collapsed"><i
                                                                                                class="fas fa-folder"></i></i>
                                                                                        <i class="expanded"><i
                                                                                                class="far fa-folder-open"></i></i>
                                                                                        2. {{ __('Questions store') }}
                                                                                        @if (Session::has('language') && Session::get('language') == 'en')
                                                                                            ({{ $x->tenLoaiHTDG_EN }})
                                                                                        @else
                                                                                            ({{ $x->tenLoaiHTDG }})
                                                                                        @endif
                                                                                    </a></span>
                                                                                <ul>
                                                                                    <div id="store_{{ $x->maCTBaiQH }}"
                                                                                        class="collapse">
                                                                                        @foreach ($chuong as $ch)
                                                                                            <li><span><a style="color:#000; text-decoration:none;"
                                                                                                        data-toggle="collapse"
                                                                                                        href="#chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"
                                                                                                        aria-expanded="false"
                                                                                                        aria-controls="chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"><i
                                                                                                            class="collapsed"><i
                                                                                                                class="fas fa-folder"></i></i>
                                                                                                        <i class="expanded"><i
                                                                                                                class="far fa-folder-open"></i></i>
                                                                                                        {{ $ch->tenchuong }}</a></span>
                                                                                                <ul>
                                                                                                    <div id="chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"
                                                                                                        class="collapse">
                                                                                                        @foreach ($ch->muc as $m)
                                                                                                            <li><span><i
                                                                                                                        class="far fa-file"></i><a 
                                                                                                                        href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-tu-luan/' . $m->id.'/'.$x->maCTBaiQH) }}">
                                                                                                                        {{ $m->maMucVB }}
                                                                                                                        {{ $m->tenMuc }}</a></span>
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </div>
                                                                                                </ul>
                                                                                            </li>
                                                                                        @endforeach
                                                                                </ul>
                                                                            </li>
                                                                        @else
                                                                            {{-- T2 - trac nghiem --}}
                                                                            @if ($x->maLoaiHTDG == 'T2')
                                                                                <li><span><a style="color:#000; text-decoration:none;"
                                                                                            data-toggle="collapse"
                                                                                            href="#store_{{ $x->maCTBaiQH }}"
                                                                                            aria-expanded="false"
                                                                                            aria-controls="store_{{ $x->maCTBaiQH }}"><i
                                                                                                class="collapsed"><i
                                                                                                    class="fas fa-folder"></i></i>
                                                                                            <i class="expanded"><i
                                                                                                    class="far fa-folder-open"></i></i>
                                                                                            2.
                                                                                            {{ __('Questions store') }}
                                                                                            @if (Session::has('language') && Session::get('language') == 'en')
                                                                                                ({{ $x->tenLoaiHTDG_EN }})
                                                                                            @else
                                                                                                ({{ $x->tenLoaiHTDG }})
                                                                                            @endif
                                                                                        </a></span>
                                                                                    <ul>
                                                                                        <div id="store_{{ $x->maCTBaiQH }}"
                                                                                            class="collapse">
                                                                                            @foreach ($chuong as $ch)
                                                                                                <li><span><a style="color:#000; text-decoration:none;"
                                                                                                            data-toggle="collapse"
                                                                                                            href="#chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"
                                                                                                            aria-expanded="false"
                                                                                                            aria-controls="chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"><i
                                                                                                                class="collapsed"><i
                                                                                                                    class="fas fa-folder"></i></i>
                                                                                                            <i
                                                                                                                class="expanded"><i
                                                                                                                    class="far fa-folder-open"></i></i>
                                                                                                            {{ $ch->tenchuong }}</a></span>
                                                                                                    <ul>
                                                                                                        <div id="chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"
                                                                                                            class="collapse">
                                                                                                            @foreach ($ch->muc as $m)
                                                                                                                <li><span><i
                                                                                                                            class="far fa-file"></i><a 
                                                                                                                            href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/' . $m->id.'/'.$x->maCTBaiQH) }}">
                                                                                                                            {{ $m->maMucVB }}
                                                                                                                            {{ $m->tenMuc }}</a></span>
                                                                                                                </li>
                                                                                                            @endforeach
                                                                                                        </div>
                                                                                                    </ul>
                                                                                                </li>
                                                                                            @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                            @else
                                                                                {{-- T3 - thuc hanh --}}
                                                                                @if ($x->maLoaiHTDG == 'T3')
                                                                                    <li><span><a style="color:#000; text-decoration:none;"
                                                                                                data-toggle="collapse"
                                                                                                href="#store_{{ $x->maCTBaiQH }}"
                                                                                                aria-expanded="false"
                                                                                                aria-controls="store_{{ $x->maCTBaiQH }}"><i
                                                                                                    class="collapsed"><i
                                                                                                        class="fas fa-folder"></i></i>
                                                                                                <i class="expanded"><i
                                                                                                        class="far fa-folder-open"></i></i>
                                                                                                2.
                                                                                                {{ __('Questions store') }}
                                                                                                @if (Session::has('language') && Session::get('language') == 'en')
                                                                                                    ({{ $x->tenLoaiHTDG_EN }})
                                                                                                @else
                                                                                                    ({{ $x->tenLoaiHTDG }})
                                                                                                @endif
                                                                                            </a></span>
                                                                                        <ul>
                                                                                            <div id="store_{{ $x->maCTBaiQH }}"
                                                                                                class="collapse">
                                                                                                @foreach ($chuong as $ch)
                                                                                                    <li><span><a style="color:#000; text-decoration:none;"
                                                                                                                data-toggle="collapse"
                                                                                                                href="#chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"
                                                                                                                aria-expanded="false"
                                                                                                                aria-controls="chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"><i
                                                                                                                    class="collapsed"><i
                                                                                                                        class="fas fa-folder"></i></i>
                                                                                                                <i
                                                                                                                    class="expanded"><i
                                                                                                                        class="far fa-folder-open"></i></i>
                                                                                                                {{ $ch->tenchuong }}</a></span>
                                                                                                        <ul>
                                                                                                            <div id="chapter_{{ $x->maLoaiHTDG }}_{{ $ch->id }}"
                                                                                                                class="collapse">
                                                                                                                @foreach ($ch->muc as $m)
                                                                                                                    <li><span><i
                                                                                                                                class="far fa-file"></i><a 
                                                                                                                                href="{{ asset('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-thuc-hanh/' . $m->id.'/'.$x->maCTBaiQH) }}">
                                                                                                                                {{ $m->maMucVB }}
                                                                                                                                {{ $m->tenMuc }}</a></span>
                                                                                                                    </li>
                                                                                                                @endforeach
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                @endforeach
                                                                                        </ul>
                                                                                    </li>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                        <li><span><i class="far fa-circle"></i><a 
                                                                                    href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.$x->maCTBaiQH) }}">
                                                                                    3. {{ __('Examination') }}</a></span>
                                                                        </li>
                                                                    @endif
                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                href="{{ asset('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.$x->maCTBaiQH) }}">
                                                                                4. {{ __('Result') }}</a></span></li>
                                                                    <li>
                                                                                <span><a style="color:#000; text-decoration:none;"
                                                                                    data-toggle="collapse"
                                                                                    href="#Statistics_{{ $x->maCTBaiQH }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="store_{{ $x->maCTBaiQH }}"><i
                                                                                        class="collapsed"><i
                                                                                            class="fas fa-folder"></i></i>
                                                                                    <i class="expanded"><i
                                                                                            class="far fa-folder-open"></i></i>
                                                                                    5. {{ __('Statistics') }}
                                                                                </a></span>
                                                                        <ul>
                                                                            <div id="Statistics_{{ $x->maCTBaiQH }}"
                                                                                class="collapse">
                                                                                @if ($x->maLoaiHTDG=='T8' || $x->maLoaiHTDG=='T6'){{-- do an và hội thảo--}}
                                                                                    <li>
                                                                                        <span><a style="color:#000; text-decoration:none;"
                                                                                            data-toggle="collapse"
                                                                                            href="#project_{{ $x->maLoaiHTDG }}"
                                                                                            aria-expanded="false"
                                                                                            aria-controls="project_{{ $x->maLoaiHTDG }}"><i
                                                                                                class="collapsed"><i
                                                                                                    class="fas fa-folder"></i></i>
                                                                                            <i
                                                                                                class="expanded"><i
                                                                                                    class="far fa-folder-open"></i></i>
                                                                                            {{ __('Granding examiner') }}</a></span>
                                                                                            <div class="collapse" id="project_{{ $x->maLoaiHTDG }}">
                                                                                                <ul>
                                                                                                    <li>
                                                                                                        <span><a style="color:#000; text-decoration:none;"
                                                                                                            data-toggle="collapse"
                                                                                                            href="#project_CP1_{{ $x->maLoaiHTDG }}"
                                                                                                            aria-expanded="false"
                                                                                                            aria-controls="project_{{ $x->maLoaiHTDG }}"><i
                                                                                                                class="collapsed"><i
                                                                                                                    class="fas fa-folder"></i></i>
                                                                                                            <i
                                                                                                                class="expanded"><i
                                                                                                                    class="far fa-folder-open"></i></i>
                                                                                                            1</a></span>
                                                                                                        <div class="collapse" id="project_CP1_{{ $x->maLoaiHTDG }}">
                                                                                                            <ul>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-clo/' . $x->maCTBaiQH.'/1') }}">
                                                                                                                    {{ __("CLOs") }}</a></span></li>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-abet/' . $x->maCTBaiQH).'/1' }}">
                                                                                                                     {{ __("ABET'sSO") }}</a></span></li>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH . '/1') }}">
                                                                                                                     {{ __('SOs') }}</a></span></li>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-xep-hang/' . $x->maCTBaiQH . '/1') }}">
                                                                                                                    {{ __('Rank') }}</a></span></li>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-diem-chu/' . $x->maCTBaiQH . '/1') }}">
                                                                                                                     {{ __('Grate') }}</a></span></li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                    @if ($x->maGV_2!='00000')
                                                                                                    <li> 
                                                                                                        <span><a style="color:#000; text-decoration:none;"
                                                                                                        data-toggle="collapse"
                                                                                                        href="#project_CP2_{{ $x->maLoaiHTDG }}"
                                                                                                        aria-expanded="false"
                                                                                                        aria-controls="project_{{ $x->maLoaiHTDG }}"><i
                                                                                                            class="collapsed"><i
                                                                                                                class="fas fa-folder"></i></i>
                                                                                                        <i
                                                                                                            class="expanded"><i
                                                                                                                class="far fa-folder-open"></i></i>
                                                                                                        2</a></span>
                                                                                                        <div class="collapse" id="project_CP2_{{ $x->maLoaiHTDG }}">
                                                                                                            <ul>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-clo/' . $x->maCTBaiQH.'/2') }}">
                                                                                                                    {{ __("CLOs") }}</a></span></li>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-abet/' . $x->maCTBaiQH.'/2')}}">
                                                                                                                     {{ __("ABET'sSO") }}</a></span></li>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH . '/2') }}">
                                                                                                                     {{ __('SOs') }}</a></span></li>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-xep-hang/' . $x->maCTBaiQH . '/2') }}">
                                                                                                                    {{ __('Rank') }}</a></span></li>
                                                                                                                <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/thong-ke-theo-diem-chu/' . $x->maCTBaiQH . '/2') }}">
                                                                                                                     {{ __('Grate') }}</a></span></li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                    @endif
                                                                                                    
                                                                                                </ul>
                                                                                            </div>
                                                                                    </li>
                                                                                @endif
                                                                                @if ($x->maLoaiHTDG=='T1')  {{-- tu luan --}}
                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-clo/' . $x->maCTBaiQH) }}">
                                                                                        {{ __("CLOs") }}</a></span></li>
                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-abet/' . $x->maCTBaiQH) }}">
                                                                                         {{ __("ABET'sSO") }}</a></span></li>
                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                        href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH) }}">
                                                                                         {{ __('SOs') }}</a></span></li>
                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                       href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-xep-hang/' . $x->maCTBaiQH) }}">
                                                                                        {{ __('Rank') }}</a></span></li>
                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-diem-chu/' . $x->maCTBaiQH) }}">
                                                                                         {{ __('Grate') }}</a></span></li>
                                                                                @else
                                                                                    @if ($x->maLoaiHTDG=='T2'){{-- trac nghiem --}}
                                                                                        <li><span><i class="far fa-circle"></i><a 
                                                                                            href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/trac-nghiem/thong-ke-theo-clo/' . $x->maCTBaiQH) }}">
                                                                                            {{ __("CLOs") }}</a></span></li>
                                                                                        <li><span><i class="far fa-circle"></i><a 
                                                                                            href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/trac-nghiem/thong-ke-theo-abet/' . $x->maCTBaiQH) }}">
                                                                                            {{ __("ABET'sSO") }}</a></span></li>
                                                                                        <li><span><i class="far fa-circle"></i><a 
                                                                                            href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/trac-nghiem/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH) }}">
                                                                                            {{ __('SOs') }}</a></span></li>
                                                                                        <li><span><i class="far fa-circle"></i><a 
                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/trac-nghiem/thong-ke-theo-xep-hang/' . $x->maCTBaiQH) }}">
                                                                                            {{ __('Rank') }}</a></span></li>
                                                                                        <li><span><i class="far fa-circle"></i><a 
                                                                                            href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/trac-nghiem/thong-ke-theo-diem-chu/' . $x->maCTBaiQH) }}">
                                                                                            {{ __('Grate') }}</a></span></li>
                                                                                    @else
                                                                                    @if ($x->maLoaiHTDG=='T3' && $x->maLoaiDG==3) {{-- thuc hanh ket thuc mon--}}
                                                                                        <li>
                                                                                            <span><a style="color:#000; text-decoration:none;"
                                                                                                data-toggle="collapse"
                                                                                                href="#project_{{ $x->maLoaiHTDG }}"
                                                                                                aria-expanded="false"
                                                                                                aria-controls="project_{{ $x->maLoaiHTDG }}"><i
                                                                                                    class="collapsed"><i
                                                                                                        class="fas fa-folder"></i></i>
                                                                                                <i
                                                                                                    class="expanded"><i
                                                                                                        class="far fa-folder-open"></i></i>
                                                                                                {{ __('Granding officer') }}</a></span>
                                                                                                <div class="collapse" id="project_{{ $x->maLoaiHTDG }}">
                                                                                                    <ul>
                                                                                                        <li>
                                                                                                            <span><a style="color:#000; text-decoration:none;"
                                                                                                                data-toggle="collapse"
                                                                                                                href="#project_CP1_{{ $x->maLoaiHTDG }}"
                                                                                                                aria-expanded="false"
                                                                                                                aria-controls="project_{{ $x->maLoaiHTDG }}"><i
                                                                                                                    class="collapsed"><i
                                                                                                                        class="fas fa-folder"></i></i>
                                                                                                                <i
                                                                                                                    class="expanded"><i
                                                                                                                        class="far fa-folder-open"></i></i>
                                                                                                                1</a></span>
                                                                                                            <div class="collapse" id="project_CP1_{{ $x->maLoaiHTDG }}">
                                                                                                                <ul>
                                                                                                                    <li> <span><i class="far fa-circle"></i><a 
                                                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-clo/' . $x->maCTBaiQH. '/1') }}">
                                                                                                                        {{ __("CLOs") }}</a></span></li>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-abet/' . $x->maCTBaiQH) }}">
                                                                                                                        {{ __("ABET'sSO") }}</a></span></li>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                        href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH) }}">
                                                                                                                        {{ __('SOs') }}</a></span></li>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-xep-hang/' . $x->maCTBaiQH) }}">
                                                                                                                        {{ __('Rank') }}</a></span></li>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-diem-chu/' . $x->maCTBaiQH) }}">
                                                                                                                        {{ __('Grate') }}</a></span></li>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        </li>
                                                                                                        @if ($x->maGV_2!='00000')
                                                                                                        <li> 
                                                                                                            <span><a style="color:#000; text-decoration:none;"
                                                                                                            data-toggle="collapse"
                                                                                                            href="#project_CP2_{{ $x->maLoaiHTDG }}"
                                                                                                            aria-expanded="false"
                                                                                                            aria-controls="project_{{ $x->maLoaiHTDG }}"><i
                                                                                                                class="collapsed"><i
                                                                                                                    class="fas fa-folder"></i></i>
                                                                                                            <i
                                                                                                                class="expanded"><i
                                                                                                                    class="far fa-folder-open"></i></i>
                                                                                                            2</a></span>
                                                                                                            <div class="collapse" id="project_CP2_{{ $x->maLoaiHTDG }}">
                                                                                                                <ul>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-clo2/' . $x->maCTBaiQH.'/'.$x->maGV_2) }}">
                                                                                                                        {{ __("CLOs") }}</a></span></li>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-abet/' . $x->maCTBaiQH. '/'.$x->maGV_2) }}">
                                                                                                                        {{ __("ABET'sSO") }}</a></span></li>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                        href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH. '/'.$x->maGV_2) }}">
                                                                                                                        {{ __('SOs') }}</a></span></li>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                    href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-xep-hang/' . $x->maCTBaiQH. '/'.$x->maGV_2) }}">
                                                                                                                        {{ __('Rank') }}</a></span></li>
                                                                                                                    <li><span><i class="far fa-circle"></i><a 
                                                                                                                        href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-diem-chu/' . $x->maCTBaiQH. '/'.$x->maGV_2) }}">
                                                                                                                        {{ __('Grate') }}</a></span></li>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        </li>
                                                                                                        @endif
                                                                                                        
                                                                                                    </ul>
                                                                                                </div>
                                                                                        </li>

                                                                                        @endif
                                                                                        @if ($x->maLoaiHTDG=='T3' && $x->maLoaiDG!=3){{-- thuc hanh qua trinh --}}
                                                                                            <li><span><i class="far fa-circle"></i><a 
                                                                                                href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-clo/' . $x->maCTBaiQH) }}">
                                                                                                {{ __("CLOs") }}</a></span></li>
                                                                                            <li><span><i class="far fa-circle"></i><a 
                                                                                                href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-abet/' . $x->maCTBaiQH) }}">
                                                                                                {{ __("ABET'sSO") }}</a></span></li>
                                                                                            <li><span><i class="far fa-circle"></i><a 
                                                                                                href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-tieu-chi/' . $x->maCTBaiQH) }}">
                                                                                                {{ __('SOs') }}</a></span></li>
                                                                                            <li><span><i class="far fa-circle"></i><a 
                                                                                            href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-xep-hang/' . $x->maCTBaiQH) }}">
                                                                                                {{ __('Rank') }}</a></span></li>
                                                                                            <li><span><i class="far fa-circle"></i><a 
                                                                                                href="{{ asset('giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-diem-chu/' . $x->maCTBaiQH) }}">
                                                                                                {{ __('Grate') }}</a></span></li>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </ul>        
                                                                    </li>
                                                                </div>
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                    
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    {{-- end div tree --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
