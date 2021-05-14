@extends('admin.master')
@section('content')
     <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <style type="text/css">
       
      .first {
        position:absolute;
        /*position: relative;*/
        width:60px;
        left: auto;
        display: block;
        z-index: 3;
       background-color:  #28a745;
      }

      .second {
          position:absolute;
          /*position: relative;*/
          width:300px;
          left:80px;
          z-index: 3;
         background-color: #28a745;
      }
      .third {
          position:absolute;
          width:inherit;
          display:block;
          top:auto;
          background-color:#28a745;
      }
      .fourth{
          position:relative;
          width:100%;
          left:360px;
          top:0px;
          background-color:#28a745;
    
      }
      .fifth{
        top:0px;
        left: 360px;
        position: relative;
        z-index: 2;

      }
      .table-fixed {
          width:100%;
          height:720px;
          overflow:scroll;  
      }
     
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
                  Satisfy Level-3 Student Outcomes (SOs) of the program 
             
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="" class="table table-bordered table-hover table-responsive table-striped">
                  
                  <thead>  
                <tr>
                  <th class="first" >No.</th>
                  <th class="second" >Course Name</th>
                  @php
                      $tongmon_dapung=[];//biến lưu tổng theo cột CDR3
                    @endphp
                  @foreach ($ctdt_cdr as $x)
                        <th class="fourth"> {{$x->maCDR3VB}} </th>
                        @php
                        $tongmon_dapung[$x->maCDR3]=0;
                        @endphp
                  @endforeach
                  <th class="fourth">Total</th>
                </tr>
                </thead>
                 
                 <tbody>
                    @php
                      $i=1;
                      $tongcong=0;//biến lưu tổng của cột tổng
                    @endphp
                    @foreach ($hp_ctdt as $y)
                        <tr>
                            <th class="first" >{{$i++}} </th>
                            <th class="second">{{$y->tenHocPhan}}</th>
                            @php
                            $tongcdr_cuamon=0;
                            $ktra=0;//kiểm tra xem môn học có được nhập CDR3 chưa
                            @endphp
                            @foreach ($hp_cdr3 as $z)
                              
                              @if ($y->maHocPhan==$z->maHocPhan )
                                @php //Nếu học phần đang xét mà có trong bảng học phần-chuẩn đầu ra 3
                                $ktra=1; // môn học đã có chuẩn đầu ra
                                break;
                                @endphp
                              @endif
                            @endforeach
                            @if ($ktra==1)
                              @foreach ($ctdt_cdr as $x)
                                @php //nếu học phần có đáp ứng chuẩn đầu ra thì kiểm tra xem đáp ứng CDR3 nào
                                $dapung=0;
                                
                                @endphp
                                @foreach ( $hp_cdr3 as $z)
                                  @if($z->maCDR3==$x->maCDR3 && $y->maHocPhan==$z->maHocPhan)
                                    @php
                                    $dapung=1; // môn học đáp ứng chuẩn đầu ra 3 tương ứng với cột CDR3
                                    $tongcdr_cuamon++;
                                    $tongmon_dapung[$x->maCDR3]++;
                                    break;
                                    @endphp 
                                  @endif
                                @endforeach
                                @if ($dapung==1)
                                  <td class="fifth">x</td>
                                @else
                                  <td class="fifth">&nbsp;</td>
                                @endif
                              @endforeach  
                            @else
                              @foreach ($ctdt_cdr as $x)
                                
                                <td class="fifth">&nbsp;</td>
                              @endforeach
                            @endif
                          <td class="fifth">{{$tongcdr_cuamon}}</td>
                          @php
                            $tongcong=$tongcong+$tongcdr_cuamon;
                          @endphp  
                        </tr>
                    @endforeach
                 </tbody>
                  <tfoot>
                    <tr>
                      <td class="first">&nbsp;</td> 
                      <td class="second" align="center" ><font color="white"><b>Total</b></font></td>
                      @foreach ($ctdt_cdr as $x)
                      <td class="fifth" bgcolor="#28a745"><font color="white"><b>{{$tongmon_dapung[$x->maCDR3]}}</b></font></td>
                    @endforeach
                      <td class="fifth" bgcolor="#28a745"><font color="yellow"><b>{{$tongcong}}</b></font></td>
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


    {{-- <script>
        
        $(function () {
        console.log('hello');
        var label=[];
                var gioi=[];
                var kha=[];
                var tb=[];
                var yeu=[];
                var kem=[];
        $.ajax({
            type:'GET',
            url:'/quan-ly/thong-ke/thong-ke-cap-chuong-trinh/get-chuan-dau-ra-3-chuong-trinh',
            success:function(data) {
               
                for (let i = 0; i < data.length; i++) {
                    label.push(data[i][0]);
                    gioi.push(data[i][2]);
                    kha.push(data[i][3]);
                    tb.push(data[i][4]);
                    yeu.push(data[i][5]);
                    kem.push(data[i][6]);
                }
                
                var areaChartData = {
                labels  : label,
                datasets: [
                    {
                    label               : 'Giỏi',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : gioi
                    },
                    {
                    label               : 'Khá',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : kha
                    },{
                    label               : 'Trung bình',
                    backgroundColor     : 'rgba(193,110,25, 0.8)',
                    borderColor         : 'rgba(193,110,25, 0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : tb
                    },{
                    label               : 'yếu',
                    backgroundColor     : 'rgba(30,124,137, 0.8)',
                    borderColor         : 'rgba(30,124,137, 0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : yeu
                    },{
                    label               : 'kém',
                    backgroundColor     : 'rgba(255,12,73, 0.8)',
                    borderColor         : 'rgba(255,12,73, 0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : kem
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
                    stacked: true
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
                options: barChartOptions
                })



            }

        })
       
     })
       
      </script> --}}
  </div>
@endsection