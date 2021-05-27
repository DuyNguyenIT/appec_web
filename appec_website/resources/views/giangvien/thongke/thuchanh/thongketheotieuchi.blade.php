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
                        <h1 class="m-0 text-dark">Thống kê theo CDIO<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item "><a href="#">Thống kê</a></li>
                          
                            <li class="breadcrumb-item active">Thống kê theo CDIO</li>
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
                                    <a href="{{ asset('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.session::get('maHocPhan').'/'.session::get('maBaiQH').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop')) }}" class="btn btn-secondary">
                                          <i class="fas fa-arrow-left"></i>
                                    </a>
                            </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">{{ __('No.') }}</th>
                                            <th rowspan="2">CĐR</th>
                                            <th rowspan="2">Chuẩn đầu ra CDIO</th>
                                            <th colspan="4">Đạt</th>
                                            <th rowspan="2" title="">Chưa đạt</th>
                                            <th rowspan="2">Tổng</th>
                                        </tr>
                                        <tr>
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>D</th>
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
                url: '/giang-vien/thong-ke/thong-ke-theo-hoc-phan/tu-luan/get-tieu-chi',
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
                                label: 'achieve(A)',
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
                                label: 'achieve(B)',
                                backgroundColor: 'rgba(0, 255, 0, 0.7)',
                                borderColor: 'rgba(0, 255, 0, 0.7)',
                                pointRadius: false,
                                pointColor: 'rgba(210, 214, 222, 1)',
                                pointStrokeColor: '#c1c7d1',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: kha
                            }, {
                                label: 'achieve(C)',
                                backgroundColor: 'rgba(255, 255, 0, 1)',
                                borderColor: 'rgba(255, 255, 0, 1)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: tb
                            }, {
                                label: 'achieve(D)',
                                backgroundColor: 'rgba(255,128,0, 0.8)',
                                borderColor: 'rgba(255,128,0, 0.8)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: yeu
                            }, {
                                label: 'Fail',
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
                                display: true,
                                //stacked: true,
                            }],
                            yAxes: [{
                                display: true,
                                //stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    steps: 10,
                                    stepValue: 5,
                                    max: 100
                                },
                                steps: 1
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
