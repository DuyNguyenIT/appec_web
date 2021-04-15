@extends('admin.master')
@section('content')
     <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <style type="text/css">
     
    </style>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$ctdt->tenCT}}<noscript></noscript><nav></nav></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">Home</a></li>
              <li class="breadcrumb-item "><a href="{{ asset('/quan-ly/thong-ke') }}">Statistics</a></li>
              <li class="breadcrumb-item active">{{$ctdt->tenCT}}</li>
            
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
                  Satisfy SOs of the ABET
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="" class="table table-bordered table-hover table-responsive table-striped">
                  
                  <thead>  
                <tr bgcolor="#28a745">
                  <th width="5%">No.</th>
                  <th>Course Name</th>
                  
                  @foreach ($chuan_abet as $x)
                        <th width="10%" class="tieude{{$x->maChuanAbet}}"> {{$x->maChuanAbetVB}} </th>
                        @php
                        $tongmon_dapung[$x->maChuanAbet]=0;
                        @endphp
                  @endforeach
                  <th>Total</th>
                </tr>
                </thead>
                 
                 <tbody>
                    @php
                      $i=1;
                      $tongcong=0;//bi&#7871;n l&#432;u t&#7893;ng c&#7911;a c&#7897;t t&#7893;ng
                    @endphp
                    @foreach ($hp_ctdt as $y)
                        @php
                        $tongabet_cuamon=0;
                        @endphp
                        <tr>
                            <td class="ndunga">{{$i++}} </td>
                            <td class="ndungb">{{$y->tenHocPhan}}</td>
                             @foreach ( $chuan_abet as $x)
                                <td class="ndung{{$x->maChuanAbet}}">
                                @foreach ( $hp_kqhthp as $z)
                                    
                                    @if($z->maHocPhan==$y->maHocPhan && $z->maChuanAbet==$x->maChuanAbet)
                                      @php
                                        $tongabet_cuamon++;
                                        $tongmon_dapung[$x->maChuanAbet]++;
                                      @endphp
                                        {{$z->maCDR3VB}} ({{$z->maKQHTVB}}), 
                                    @endif
                                @endforeach
                                </td>

                              @endforeach   
                              <td>{{$tongabet_cuamon}}</td>
                              @php
                                $tongcong=$tongcong+$tongabet_cuamon;
                              @endphp 
                        </tr>
                    @endforeach
                 </tbody>
                  <tfoot>
                    <tr bgcolor="#28a745">
                      <td>&nbsp;</td>
                      <td align="center" ><font color="white"><b>Total</b></font></td>
                      @foreach ($chuan_abet as $x)
                        <td ><font color="white"><b>{{$tongmon_dapung[$x->maChuanAbet]}}</b></font></td>
                      @endforeach
                      <td ><font color="yellow"><b>{{$tongcong}}</b></font></td>
                
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- STACKED BAR CHART -->
            <div class="card card-success">
                <div class="card-header">
                <h3 class="card-title">Chart</h3>

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
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
        console.log('hello');
                var label=[];
                var sl=[];
               
        $.ajax({
            type:'GET',
            url:'/quan-ly/thong-ke/thong-ke-cap-chuong-trinh/thong-ke-abet',
            success:function(data) {
               n=data[0].length;
                for (let i = 0; i < n; i++) {
                    label.push(data[0][i]);
                    sl.push(data[1][i]);
                   
                }
                
                var areaChartData = {
                labels  : label,
                datasets: [
                    {
                    label               : 'The number of courses satisfy SOs of the ABET',
                    backgroundColor     : 'rgba(255,165,0,0.9)',
                    borderColor         : 'rgba(255,165,0,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : sl
                    }
                ]
                }
                var barChartData = $.extend(true, {}, areaChartData)
                var temp1 = areaChartData.datasets[0]
                barChartData.datasets[0] = temp1
                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChartData = $.extend(true, {}, areaChartData)

                var stackedBarChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    xAxes: [{
                    stacked: true,
                    }],
                    yAxes: [{
                      stacked: true,
                      ticks: {
                          min: 0,
                          max: 80,
                          stepSize: 1
                      }
                    }]
                }
                }
                var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false
                }

                var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: stackedBarChartOptions
                })



            }

        })
       
     })
       
      </script> 
  </div>
@endsection