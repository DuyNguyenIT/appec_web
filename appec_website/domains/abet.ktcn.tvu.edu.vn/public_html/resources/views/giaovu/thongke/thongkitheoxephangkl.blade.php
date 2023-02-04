@extends('giaovu.master')
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
                        <h1 class="m-0 text-dark">Hệ quản trị cơ sở dữ liệu<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item "><a href="thongke.html">Thống kê</a></li>
                            <li class="breadcrumb-item "><a href="thongketheohocphan.html">Hệ quản trị cơ sở dữ liệu</a>
                            </li>
                            <li class="breadcrumb-item active">Thống kê theo xếp hạng</li>
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
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Xếp loại</th>
                                            <th>Số lượng</th>
                                            <th>Tỉ lệ (%)</th>
                                            <th>Tỉ lệ tích lũy</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < count($xepHang); $i++)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    @switch($i+1)
                                                        @case(1)
                                                            Giỏi
                                                        @break
                                                        @case(2)
                                                            Khá
                                                        @break
                                                        @case(3)
                                                            Trung bình
                                                        @break
                                                        @case(4)
                                                            Yếu
                                                        @break
                                                        @case(5)
                                                            Kém
                                                        @break
                                                        @default
                                                    @endswitch
                                                </td>
                                                <td>{{ $xepHang[$i] }}</td>
                                                <td>{{ $tiLe[$i] }}%</td>
                                                <td></td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- STACKED BAR CHART -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Biểu đồ</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="stackedBarChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
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
        <script>
            $(function() {
                var xepHang = [];
                $.ajax({
                    type: 'GET',
                    url: '/giao-vu/thong-ke/thong-ke-theo-hoc-phan/get-xep-hang-kl',
                    success: function(data) {
                        console.log(data);
                        for (let i = 0; i < data.length; i++) {
                            xepHang.push(data[i]);
                            console.log(xepHang);
                        }
                        var areaChartData = {
                            labels: ['Giỏi', 'Khá', 'Trung Bình', 'Yếu', 'Kém'],
                            datasets: [{
                                label: 'số Lượng',
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
                        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
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
