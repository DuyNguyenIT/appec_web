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
            <h1 class="m-0 text-dark">{{$hp->tenHocPhan}}<noscript></noscript><nav></nav></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item "><a href="{{ asset('/giao-vu/thong-ke') }}">Thống kê</a></li>
              <li class="breadcrumb-item "><a href="thongketheohocphan.html">{{$ct_baiQH->tenLoaiHTDG}}</a></li>
              <li class="breadcrumb-item active">Thống kê theo điểm chữ</li>
            
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
                    <th>Điểm chữ</th>
                     <th>Số lượng</th>
                     <th>Tỉ lệ (%)</th>
                     <th>Tỉ lệ tích lũy</th>

                  </tr>
                  </thead>
                 <tbody>

                   @for ($i = 0; $i <8; $i++)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>
                         {{$chu[$i]}}
                        </td>
                        <td>{{$diemChu[$i]}}</td>
                        <td>{{$tiLe[$i]}}%</td>
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
                    <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
        
        $(function () {
          var diemChu=[];
          $.ajax({
            type:'GET',
            url:'/giao-vu/thong-ke/thong-ke-theo-hoc-phan/get-diem-chu',
            success:function(data) {
                console.log(data);
                for (let i = 0; i < data.length; i++) {
                    diemChu.push(data[i]);
                    
                }
                console.log(diemChu);
                var areaChartData = {
                    labels  : ['A', 'B+', 'B', 'C+','C','D+','D','F'],
                    datasets: [
                      {
                        label               : 'số Lượng',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : diemChu
                        
                      },
                    ]
                  }
                  console.log(areaChartData);
                  var barChartData = $.extend(true, {}, areaChartData)
                  var temp1 = areaChartData.datasets[0]
                  barChartData.datasets[0] = temp1
                  var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
                  var stackedBarChartData = $.extend(true, {}, barChartData)
              
                  var stackedBarChartOptions = {
                    responsive              : true,
                    maintainAspectRatio     : false,
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