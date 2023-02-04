@extends('giangvien.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ __('Assessment planing content') }}
                        @if (Session::has('language') && Session::get('language')=='en')
                            ({{ $lht->tenLoaiHTDG_EN  }})
                        @else
                            ({{ $lht->tenLoaiHTDG  }})
                        @endif
                            
                            <noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.Session::get('maHocPhan').'/'.Session::get('maBaiQH').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maLop')) }}"> @if (Session::has('language') && Session::get('language')=='en')
                            ({{ $lht->tenLoaiHTDG_EN  }})
                        @else
                            ({{ $lht->tenLoaiHTDG  }})
                        @endif</a></li>

                            <li class="breadcrumb-item active">{{ __('Assessment planning content') }}</li>
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
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <i class="fas fa-plus"></i>
                                    </button>

                                  
                                    @if (Session::has('language') && Session::get('language')=='en')
                                    <a onclick="return confirm('Delete all data,...Are you sure?')" href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/xoa-toan-bo-du-lieu/'.Session::get('maCTBaiQH')) }}" class="btn btn-danger">
                                        Delete all data 
                                    </a>
                                    @else
                                    <a onclick="return confirm('Xóa hết dữ liệu của nội dung, đề thi, phiếu chấm, phiếu đánh giá,...Bạn có chắc chắn?')" href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/xoa-toan-bo-du-lieu/'.Session::get('maCTBaiQH')) }}" class="btn btn-danger">
                                        Xóa hết dữ liệu
                                    </a>
                                    @endif
                                    <!-- Modal add -->
                                    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <form
                                                action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/them-noi-dung-quy-hoach-submit') }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="text" name="maCTBaiQH" value="{{ $maCTBaiQH }}"
                                                            hidden>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Learning outcomes') }}: </label>
                                                            <select name="maKQHT" id="" class="form-control select2" style="width:100%">
                                                                @php
                                                                    $i = 1;
                                                                @endphp
                                                                @foreach ($ketQuaHT as $kqht)
                                                                    @if ($i == 1)
                                                                        <option value="{{ $kqht->maKQHT }}" selected>
                                                                            {{ $kqht->maKQHTVB }}--{{ $kqht->tenKQHT }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $kqht->maKQHT }}">
                                                                            {{ $kqht->maKQHTVB }}--{{ $kqht->tenKQHT }}
                                                                        </option>
                                                                    @endif
                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Level assessment (Bloom):</label>
                                                            <select name="maMucDoDG" id="" class="form-control select2" style="width:100%">
                                                                @php
                                                                    $i = 1;
                                                                @endphp
                                                                @foreach ($mucDoDG as $md)
                                                                    @if ($i == 1)
                                                                        <option value="{{ $md->maMucDoDG }}" selected>
                                                                            @if (Session::get('language') && Session::get('language')=='en')
                                                                                    {{ $md->tenMucDoDG_EN }}
                                                                                @else
                                                                                    {{ $md->tenMucDoDG }}
                                                                                @endif    
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $md->maMucDoDG }}">
                                                                            @if (Session::get('language') && Session::get('language')=='en')
                                                                                {{ $md->tenMucDoDG_EN }}
                                                                            @else
                                                                                {{ $md->tenMucDoDG }}
                                                                            @endif
                                                                            
                                                                        </option>
                                                                    @endif
                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="hocphan" style="font-size:20px">{{ __('Assessment planing content') }}<span style="color: red">(*)</span></label>
                                                            <!-- Button trigger modal -->
                                                            <input type="text" name="tenNoiDungQH" class="form-control"
                                                                id="" placeholder="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <span style="color: red">(*): {{ __('Force') }}</span>
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

                                    @if (count($noiDungQH)==0)
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#resuse">
                                            {{ __('Resuse data') }}
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="resuse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/su-dung-lai-du-lieu') }}" method="post">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Resuse data') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <div class="form-group">
                                                            <select name="maBaiQH" class="form-control select2" style="width:100%">
                                                                @foreach ($giangday as $gd)
                                                                    <option value="{{ $gd->maBaiQH }}">{{ $gd->namHoc }} -- {{ $gd->maHK }} -- {{ $gd->maLop }}-- ({{ $gd->maHocPhan}})</option>
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
                                    @endif
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/' . Session::get('maHocPhan') . '/' . Session::get('maBaiQH') . '/' . Session::get('maHK').'/' . Session::get('namHoc').'/' . Session::get('maLop')) }}"
                                        class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>{{ __('Assessment planing content') }}</th>
                                            <th>{{ __('Assessment Level') }} (Bloom)</th>
                                            <th>{{ __('CLOs') }}</th>
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @foreach ($noiDungQH as $nd)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $nd->tenNoiDungQH }}</td>
                                                <td>
                                                    @if (Session::has('language') && Session::get('language')=='en')
                                                    {{ $nd->muc_do_dg->tenMucDoDG_EN }}
                                                    @else
                                                    {{ $nd->muc_do_dg->tenMucDoDG }}
                                                    @endif
                                                    </td>
                                                <td>
                                                    @if ($nd->kqht)
                                                    {{ $nd->kqht->maKQHTVB }} - {{ $nd->kqht->tenKQHT }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <!-- Button edit modal -->
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#edit_{{ $nd->maNoiDungQH }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a class="btn btn-danger" onclick=" return confirm('Confirm?')"
                                                            href="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/xoa-noi-dung-quy-hoach/' . $nd->maNoiDungQH) }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                    <!-- Modal edit-->
                                                    <div class="modal fade" id="edit_{{ $nd->maNoiDungQH }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form
                                                                action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/sua-noi-dung-quy-hoach-submit') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            {{ __('Edit') }}</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <input type="text" name="maNoiDungQH"
                                                                            value="{{ $nd->maNoiDungQH }}" hidden>
                                                                        <div class="form-group">
                                                                            <label for="">Assessment planing content</label>
                                                                            <input type="text" name="tenNoiDungQH"
                                                                                class="form-control"
                                                                                value="{{ $nd->tenNoiDungQH }}" required>
                                                                        </div></div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label for="">{{ __('Level Assessment') }}</label>
                                                                            <select name="maMucDoDG" id="" class="form-control select2" style="width:100%">
                                                                                @foreach ($mucDoDG as $md)
                                                                                    @if ($md->maMucDoDG==$nd->maMucDoDG)
                                                                                        <option value="{{ $md->maMucDoDG }}" selected>
                                                                                            @if (Session::has('language') && Session::get('language')=='en')
                                                                                            {{ $md->tenMucDoDG_EN }}
                                                                                            @else
                                                                                            {{ $md->tenMucDoDG }}
                                                                                            @endif
                                                                                           
                                                                                        </option>
                                                                                    @else
                                                                                        <option value="{{ $md->maMucDoDG }}">
                                                                                            @if (Session::has('language') && Session::get('language')=='en')
                                                                                                {{ $md->tenMucDoDG_EN }}
                                                                                            @else
                                                                                                {{ $md->tenMucDoDG }}
                                                                                            @endif
                                                                                    @endif
                                                                                    @php
                                                                                        $i++;
                                                                                    @endphp
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Learning outcomes:</label> 
                                                                            <select name="maKQHT" id="" class="form-control select2" style="width:100%">
                                                                              
                                                                                @foreach ($ketQuaHT as $kqht)
                                                                                    @if ($kqht->maKQHT==$nd->maKQHT)
                                                                                        <option value="{{ $kqht->maKQHT }}" selected>
                                                                                            {{ $kqht->maKQHTVB }}--{{ $kqht->tenKQHT }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option value="{{ $kqht->maKQHT }}">
                                                                                            {{ $kqht->maKQHTVB }}--{{ $kqht->tenKQHT }}
                                                                                        </option>
                                                                                    @endif
                                                                                    @php
                                                                                        $i++;
                                                                                    @endphp
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                   
                                                                    <div class="modal-footer">
                                                                        <button type="sumbit"
                                                                            class="btn btn-primary">{{ __('Save') }}</button>
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">{{ __('Cancel') }}</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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
