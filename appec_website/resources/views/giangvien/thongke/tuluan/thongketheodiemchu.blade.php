@extends('giangvien.master')
@section('content')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Statistics of alphabet mark<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item ">Statistics</li>
                            
                            <li class="breadcrumb-item active">Statistics of alphabet mark</li>
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

                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/xuat-thong-ke-diem-chu/'.Session::get('maCTBaiQH')) }}" class="btn btn-success">
                                        <i class="fas fa-download"></i> <i class="fas fa-file-excel"></i>
                                    </a>
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.session::get('maHocPhan').'/'.session::get('maBaiQH').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop')) }}" class="btn btn-success">
                                          <i class="fas fa-arrow-left"></i>
                                    </a>
                            </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>Alphabet mark</th>
                                            <th>Quantity</th>
                                            <th>Ratio (%)</th>
                                            <th>Accumulative rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $tongSL=$tongTiLe=0;
                                        @endphp
                                        @for ($i = 0; $i < 8; $i++)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    {{ $chu[$i] }}
                                                </td>
                                                <td>{{ $diemChu[$i] }}</td>
                                                <td>{{ $tiLe[$i] }}%</td>
                                                <td></td>
                                            </tr>
                                            @php
                                                $tongSL+=$diemChu[$i];
                                                $tongTiLe+=$tiLe[$i];
                                            @endphp
                                        @endfor
                                        <tr>
                                            <td colspan="2"><b>Total</b></td>
                                            <td>{{ $tongSL }}</td>
                                            <td>{{ $tongTiLe }}</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        @include('layouts.thongke.bieudo')
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <script>
            $(function() {
                var diemChu = [];
                $.ajax({
                    type: 'GET',
                    url: '/giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/get-diem-chu',
                    success: function(data) {
                        console.log(data);
                        for (let i = 0; i < data.length; i++) {
                            diemChu.push(data[i]);
                        }
                        console.log(diemChu);
                        var areaChartData = {
                            labels: ['A', 'B+', 'B', 'C+', 'C', 'D+', 'D', 'F'],
                            datasets: [{
                                label: 'Quantity',
                                backgroundColor: 'rgba(60,141,188,0.9)',
                                borderColor: 'rgba(60,141,188,0.8)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: diemChu
                            }, ]
                        }
                        console.log(areaChartData);
                        var barChartData = $.extend(true, {}, areaChartData)
                        var temp1 = areaChartData.datasets[0]
                        barChartData.datasets[0] = temp1
                        var stackedBarChartCanvas = $('#barChart').get(0).getContext('2d')
                        var stackedBarChartData = $.extend(true, {}, barChartData)
                        var stackedBarChartOptions = {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                xAxes: [{
                                    stacked: true,
                                }],
                                yAxes: [{
                                    stacked: true
                                }]
                            }
                        }
                        var stackedBarChart = new Chart(stackedBarChartCanvas, {
                            type: 'bar',
                            data: stackedBarChartData,
                            options: stackedBarChartOptions
                        })
                    }
                });
            })

        </script>
    </div>
@endsection
