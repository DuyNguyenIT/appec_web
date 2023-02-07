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
                        <h1 class="m-0 text-dark">Statictis of grate <noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">Home</a></li>
                            <li class="breadcrumb-item "><a href="#">Statictis</a></li>
                            <li class="breadcrumb-item active">Statictis of grate</li>
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
                                    <a href="{{ asset('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/xuat-thong-ke-xep-hang/'.Session::get('maCTBaiQH')) }}" class="btn btn-success">
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
                                            <th>No.</th>
                                            <th>Range</th>
                                            <th>Quantity</th>
                                            <th>Ratio (%)</th>
                                            <th>Cumulative rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $tongXepHang=0;
                                        $tongTiLe=0;
                                    @endphp
                                    @for ($i = 0; $i < count($xepHang); $i++)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                @switch($i+1)
                                                    @case(1)
                                                        Excellent
                                                    @break
                                                    @case(2)
                                                        Good
                                                    @break
                                                    @case(3)
                                                        Average
                                                    @break
                                                    @case(4)
                                                        Below Average
                                                    @break
                                                    @case(5)
                                                        Weak
                                                    @break
                                                    @default
                                                @endswitch
                                            </td>
                                            <td>{{ $xepHang[$i] }}</td>
                                            <td>{{ $tiLe[$i] }}%</td>
                                            <td></td>
                                        </tr>
                                        @php
                                            $tongXepHang+=$xepHang[$i];
                                            $tongTiLe+=$tiLe[$i];
                                        @endphp
                                    @endfor
                                        <tr>
                                            <td colspan="2"><b>Total</b></td>
                                            <td>
                                                {{ $tongXepHang }}
                                            </td>
                                            <td>
                                                {{ $tongTiLe }}%
                                            </td>
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
                var xepHang = [];
                $.ajax({
                    type: 'GET',
                    url: '/giang-vien/thong-ke/thong-ke-theo-hoc-phan/do-an/get-xep-hang',
                    success: function(data) {
                        console.log(data);
                        for (let i = 0; i < data.length; i++) {
                            xepHang.push(data[i]);
                            console.log(xepHang);
                        }
                        var areaChartData = {
                            labels: ['Excellent', 'Good', 'Average', 'Below Average', 'Weak'],
                            datasets: [{
                                label: 'Quantity',
                                backgroundColor: 'rgba(60,141,188,0.9)',
                                borderColor: 'rgba(60,141,188,0.8)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: xepHang
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