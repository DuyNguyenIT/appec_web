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
                        <h1 class="m-0 text-dark">Thống kê theo ABET<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item "><a href="thongke.html">Thống kê</a></li>
                            <li class="breadcrumb-item "><a href="thongketheohocphan.html">Hệ quản trị cơ sở dữ liệu</a>
                            </li>
                            <li class="breadcrumb-item active">Thống kê theo ABET</li>
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
                                            <th>CĐR</th>
                                            <th>ABET</th>
                                            <th>85-100%</th>
                                            <th>75-85%</th>
                                            <th>50-75%</th>
                                            <th>25-50%</th>
                                            <th>0-25%</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($bieuDo as $bd)
                                            @php
                                                $sum = 0;
                                                for ($t = 1; $t < 7; $t++) {
                                                    # code...
                                                    $sum += intval($bd[$t]);
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $bd[0] }}</td>
                                                <td>{{ $bd[1] }}</td>
                                                <td>{{ $bd[2] }}</td>
                                                <td>{{ $bd[3] }}</td>
                                                <td>{{ $bd[4] }}</td>
                                                <td>{{ $bd[5] }}</td>
                                                <td>{{ $bd[6] }}</td>
                                                <td>{{ $sum }}</td>
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
                                    <canvas id="barChart"
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
    </div>
    <script>
        $(function() {
            console.log('hello');
            var label = [];
            var gioi = [];
            var kha = [];
            var tb = [];
            var yeu = [];
            var kem = [];
            $.ajax({
                type: 'GET',
                url: '/giao-vu/thong-ke/thong-ke-theo-hoc-phan/tu-luan/get-abet',
                success: function(data) {
                    for (let i = 0; i < data.length; i++) {
                        label.push(data[i][0]);
                        gioi.push(data[i][2]);
                        kha.push(data[i][3]);
                        tb.push(data[i][4]);
                        yeu.push(data[i][5]);
                        kem.push(data[i][6]);
                    }
                    var areaChartData = {
                        labels: label,
                        datasets: [{
                                label: '85-100%',
                                backgroundColor: 'rgba(60,141,188,0.9)',
                                borderColor: 'rgba(60,141,188,0.8)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: gioi
                            },
                            {
                                label: '75-85%',
                                backgroundColor: 'rgba(0, 255, 0, 0.7)',
                                borderColor: 'rgba(0, 255, 0, 0.7)',
                                pointRadius: false,
                                pointColor: 'rgba(210, 214, 222, 1)',
                                pointStrokeColor: '#c1c7d1',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: kha
                            }, {
                                label: '50-75%',
                                backgroundColor: 'rgba(255, 255, 0, 1)',
                                borderColor: 'rgba(255, 255, 0, 1)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: tb
                            }, {
                                label: '25-50%',
                                backgroundColor: 'rgba(255,128,0, 0.8)',
                                borderColor: 'rgba(255,128,0, 0.8)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: yeu
                            }, {
                                label: '0-25%',
                                backgroundColor: 'rgba(240,47,47, 1)',
                                borderColor: 'rgba(240,47,47, 1)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: kem
                            }
                        ]
                    }
                    var barChartData = $.extend(true, {}, areaChartData)
                    var temp1 = areaChartData.datasets[0]
                    barChartData.datasets[0] = temp1
                    var barChartCanvas = $('#barChart').get(0).getContext('2d')
                    var barChartData = $.extend(true, {}, areaChartData)
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
                    var barChartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false
                    }
                    var barChart = new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                    })
                }
            })
        })

    </script>
@endsection
