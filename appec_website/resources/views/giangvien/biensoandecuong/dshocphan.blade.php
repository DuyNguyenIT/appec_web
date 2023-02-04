@extends('giangvien.master')
@section('content')
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Viewing syllabus<noscript></noscript>
                        <nav></nav>
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">Viewing syllabus</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                
                            </h3>
                           
                        </div>
                        <!-- /.card-header -->
                        <!-- PTTMai thêm đồng thời có xóa <div class="card-body"> trước đó của Duy-->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('No.') }}</th>
                                        <th>{{ __('Course ID') }}</th>
                                        <th>{{ __('Course Name') }}</th>
                                        <th>{{ __('Total Credits') }}</th>
                                        <th>{{ __('Knowledge block') }}</th>
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
                                                {{ $hp->tenHocPhan }} - ({{ $hp->tenHocPhanEN }})
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
                                                @foreach ($hp->hocphan_ctdt as $item)
                                                    <li>
                                                        @if (session::has('language') && session::has('language')=='en')
                                                            {{ $item->tenCT_EN }}
                                                        @else
                                                            {{ $item->tenCT }}
                                                        @endif</b> 
                                                    </li>
                                                @endforeach
                                            </td>
                                            <td style='white-space: nowrap'>
                                                
                                                <a href="{{ asset('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.$hp->maHocPhan) }}" class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                    </td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                <tfoot></tfoot>
                            </table>
                    </div>
                    <!-- hết PTTMai thêm-->
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