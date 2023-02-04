@extends('giangvien.master')
@section('content')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Phiếu đánh giá đồ án<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item "><a href="#">Tên môn</a></li>
                            <li class="breadcrumb-item "><a href="#">Đồ án</a></li>
                            <li class="breadcrumb-item active">Phiếu chấm</li>
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
                        <!-- /.card -->
                        <form action="{{ asset('/giang-vien/cham-diem-bao-cao/cham-diem-submit') }}" method="post">
                            @csrf
                            <input type="text" name="maPhieuCham" hidden value={{ $gv->maPhieuCham }}>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="">
                                        1. Họ và tên (thành viên chấm): {{ $gv->hoGV }} {{ $gv->tenGV }} <br>
                                        2. Chức danh: <br>
                                        3. Đơn vị công tác: <br>
                                        4. Tên đề tài: {{ $deTai->tenDe }} <br>
                                        5. Học và tên sinh viên bảo vệ: {{ $sv->HoSV }} {{ $sv->TenSV }} <br>
                                    </h5>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <i>(Thành viên chấm chọn tiêu chí tương ứng với mức độ mà sinh viên đạt được)</i>
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tiêu chuẩn</th>
                                                <th>Chuẩn đầu ra</th>
                                                <th>Tiêu chí</th>
                                                <th>Điểm</th>
                                                <th>Chọn<input type="checkbox" name="" id="selectAll"></th>
                                                <script>
                                                    $("#selectAll").click(function(e) 
                                                    {
                                                        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
                                                        if ($("input[id=selectAll]").is(':checked'))
                                                           {                                  
                                                             var A=$( "select" );
                                                             for(t=0;t< A.length; t++)
                                                              {                                                   
                                                                $( "select")[t].value=  $( "select")[t][$( "select")[t].length-1].value; 
                                                              }
                                                           }
                                                           else
                                                           {
                                                            var A=$( "select" );
                                                              for(t=0;t< A.length; t++)
                                                              {                 
                                                                  $( "select")[t].value= 0;                                                       
                                                             }                                              
                                                           }                                                 
                                                       
                                                    });
                                                    </script>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                                $chayTieuChuan = 0;
                                                $chayCDR_TCDG = 0;
                                                $tieuChuanHienTai = "";
                                                $cdrHienTai = 0;
                                                $cdcheck=1;
                                            @endphp
                                            @foreach ($tieuchi as $tc)
                                                @php
                                                    
                                                    if ($cdrHienTai != $tc->maCDR3) {
                                                        //kiểm tra nếu chuẩn đầu ra thay đổi thì chuyển biến chạy về 1
                                                        $cdrHienTai = $tc->maCDR3;
                                                        $chayCDR_TCDG = 1;
                                                    } else {
                                                        //nếu không tăng biến chạy lên
                                                        $chayCDR_TCDG += 1;
                                                    }
                                                    
                                                    if ($tieuChuanHienTai != $tc->tenTCDG) {
                                                        //đặt kiểm tiêu chuẩn ở dưới vì khi khác tiêu chuẩn thì biến chayCDR phải trở về 1
                                                        $tieuChuanHienTai = $tc->tenTCDG;
                                                        $chayTieuChuan = 1;
                                                        $chayCDR_TCDG = 1;
                                                    } else {
                                                        $chayTieuChuan += 1;
                                                    }
                                                    
                                                    $demTCDG = $tieuchi->groupBy('tenTCDG')->count();
                                                    $demCDR_TCDG = $tieuchi
                                                        ->where('maTCDG', $tc->maTCDG)
                                                        ->groupBy('tenCDR3')
                                                        ->count();
                                                    $demTieuChi_TCDG = $tieuchi->where('tenTCDG', $tc->tenTCDG)->count('tenTCCD');
                                                    $demTC_CDR = $tieuchi
                                                        ->where('maTCDG', $tc->maTCDG)
                                                        ->where('maCDR3', $tc->maCDR3)
                                                        ->count('tenTCCD');
                                                @endphp
                                                @if ($chayTieuChuan == 1)
                                                    <tr>
                                                        <td rowspan={{ $demTieuChi_TCDG }}>{{ $i++ }}</td>
                                                        <td rowspan={{ $demTieuChi_TCDG }}>{{ $tc->tenTCDG }}
                                                            <b>({{ $tc->diem }} điểm)</b>
                                                        </td>
                                                        @if ($chayCDR_TCDG == 1)
                                                            <td rowspan={{ $demTC_CDR }}>{{ $tc->maCDR3VB }}:
                                                                {{ $tc->tenCDR3 }}</td>
                                                            <td>{{ $tc->tenTCCD }} <b>({{ $tc->diemTCCD }} điểm)</b>
                                                            </td>
                                                        @else
                                                            <td>{{ $tc->tenTCCD }} <b>({{ $tc->diemTCCD }} điểm)</b>
                                                            </td>
                                                        @endif
                                                        <td><select name="chamdiem1[]" id ="cd{{$cdcheck}}" >
                                                            @for($ii=0; $ii<=$tc->diemTCCD ; $ii=$ii+0.25)                                             
    
                                                            @if($tc->diemDG==$ii)
                                                                     <option value="{{$ii}}" selected > {{$ii}}</option> 
                                                            @else 
                                                                 <option value="{{$ii}}"> {{$ii}}</option>                                                           
                                                            @endif 
                                                            @endfor
                                                            </select>
                                                            <script>                                                     
                                                                document.getElementById('cd{{$cdcheck}}').onchange = function(e)
                                                                {
                                                                   if(document.getElementById('cd{{$cdcheck}}').value==0)
                                                                   document.getElementById('cd1{{$cdcheck}}').checked=false;
                                                                   else
                                                                   {
                                                                    document.getElementById('cd1{{$cdcheck}}').checked=true;
                                                                   }
                                                                      
                                                                };                    
                                                                </script>  
                                                    </td>
                                                    <td> <input type="checkbox" name="chamdiem[]" id= "cd1{{$cdcheck}}"
                                                            value="{{ $tc->maTCCD }}" />
                                                            <script>                                                     
                                                                document.getElementById('cd1{{$cdcheck}}').onchange = function(e)
                                                                {
                                                                                                                  
                                                                   if(document.getElementById('cd1{{$cdcheck}}').checked)
                                                                   document.getElementById('cd{{$cdcheck}}').value= {{$tc->diemTCCD}};
                                                                   else
                                                                   document.getElementById('cd{{$cdcheck}}').value= 0;                                              
                                                                    
                                                                };
                                                           </script>
                                                    </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        @if ($chayCDR_TCDG == 1)
                                                            <td rowspan={{ $demTC_CDR }}>{{ $tc->maCDR3VB }}:
                                                                {{ $tc->tenCDR3 }}</td>
                                                            <td>{{ $tc->tenTCCD }} <b>({{ $tc->diemTCCD }} điểm)</b>
                                                            </td>
                                                        @else
                                                            <td>{{ $tc->tenTCCD }} <b>({{ $tc->diemTCCD }} điểm)</b>
                                                            </td>
                                                        @endif
                                                        <td><select name="chamdiem1[]" id ="cd2{{$cdcheck}}" >
                                                            @for($ii=0; $ii<=$tc->diemTCCD ; $ii=$ii+0.25)                                             
    
                                                            @if($tc->diemDG==$ii)
                                                                     <option value="{{$ii}}" selected > {{$ii}}</option> 
                                                            @else 
                                                                 <option value="{{$ii}}"> {{$ii}}</option>                                                           
                                                            @endif 
                                                            @endfor
                                                            </select>
                                                            <script>                                                     
                                                                document.getElementById('cd2{{$cdcheck}}').onchange = function(e)
                                                                {
                                                                
                                                                    if(document.getElementById('cd2{{$cdcheck}}').value==0)
                                                                        document.getElementById('cd11{{$cdcheck}}').checked=false;
                                                                    else
                                                                    {
                                                                                    document.getElementById('cd11{{$cdcheck}}').checked=true;
        
                                                                    }                                                      
                                                                };             
                                                                </script> 
                                                            </td>

                                                        <td><input type="checkbox" name="chamdiem[]" id= "cd11{{$cdcheck}}" value="{{ $tc->maTCCD }}" />
                                                                <script>                                                            
                                                                    document.getElementById('cd11{{$cdcheck}}').onchange = function(e)
                                                                    {
                                                                    
                                                                    if(document.getElementById('cd11{{$cdcheck}}').checked)
                                                                    document.getElementById('cd2{{$cdcheck}}').value= {{$tc->diemTCCD}};
                                                                    else
                                                                    document.getElementById('cd2{{$cdcheck}}').value= 0;                                                                                
                                                                    };
                                                                </script>
                                                            </td>
                                                    </tr>
                                                @endif
                                                @php
                                                $cdcheck++;
                                                   @endphp   
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <h5><b>Ý kiến đóng góp</b></h5>
                                        <input type="text" name="yKienDongGop" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Chấm điểm</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </form>
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
