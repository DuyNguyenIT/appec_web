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
                        <h1 class="m-0 text-dark">Phiếu đánh giá tự luận<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item "><a href="#">Tên môn</a></li>
                            <li class="breadcrumb-item "><a href="#">Tự luận</a></li>
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
                        <form action="{{ asset('/giang-vien/ket-qua-danh-gia/tu-luan/sua-diem-submit') }}"
                        method="post">
                        @csrf

                        <!-- /.card -->
                        <input type="text" name="maPhieuCham" hidden value={{ $gv->maPhieuCham }}>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="">
                                    1. Giảng viên chấm: {{ $gv->hoGV }} {{ $gv->tenGV }} <br>
                                    2. Chức danh: <br>
                                    3. Đơn vị công tác: <br>
                                    4. Đề thi: {{ $dethi->tenDe }} <br>
                                    5. Học và tên sinh viên: {{ $sv->HoSV }} {{ $sv->TenSV }} <br>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Câu hỏi</th>
                                            <th>Phương án</th>
                                            <th>chấm Tay</th>
                                            <th>Chọn <input type="checkbox" name="" id="selectAll"></th>
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
                                        </tr>
                                       
                                    </thead>
                                    <tbody>
                                        @php
                                            $i1 = 1;
                                            $chayCauHoi = 0;
                                            $chayCDR_PATL = 0;
                                            $cauHoiHienTai = 0;
                                            $cdrHienTai = 0;                                      
                                            $cdcheck=1;
                                    @endphp
                                        @foreach ($noidung as $tc)
                                            @php
                                                
                                                if ($cdrHienTai != $tc->maCDR3) {
                                                    //kiểm tra nếu chuẩn đầu ra thay đổi thì chuyển biến chạy về 1
                                                    $cdrHienTai = $tc->maCDR3;
                                                    $chayCDR_PATL = 1;
                                                } else {
                                                    //nếu không tăng biến chạy lên
                                                    $chayCDR_PATL += 1;
                                                }
                                                
                                                if ($cauHoiHienTai != $tc->maCauHoi) {
                                                    //đặt kiểm tiêu chuẩn ở dưới vì khi khác tiêu chuẩn thì biến chayCDR phải trở về 1
                                                    $cauHoiHienTai = $tc->maCauHoi;
                                                    $chayCauHoi = 1;
                                                    $chayCDR_PATL = 1;
                                                } else {
                                                    $chayCauHoi += 1;
                                                }
                                                
                                                $demTCDG = $noidung->groupBy('noiDungCauHoi')->count();
                                                $demCDR_TCDG = $noidung
                                                    ->where('maCauHoi', $tc->maCauHoi)
                                                    ->groupBy('tenCDR3')
                                                    ->count();
                                                $demPA_CauHoi = $noidung->where('maCauHoi', $tc->maCauHoi)->count('maPATL');
                                                $diemCauHoi = $noidung->where('maCauHoi', $tc->maCauHoi)->sum('diemPA');
                                                $demTC_CDR = $noidung
                                                    ->where('maPATL', $tc->maPATL)
                                                    ->where('maCDR3', $tc->maCDR3)
                                                    ->count('noiDungPA');
                                                
                                            @endphp

                                            @if ($chayCauHoi == 1)
                                                <tr>
                                                    <td rowspan={{ $demPA_CauHoi }}>{{ $i1++ }}</td>
                                                    <td rowspan={{ $demPA_CauHoi }}>{!! $tc->noiDungCauHoi !!} <b>(
                                                            {{ $diemCauHoi }} điểm)</b></td>
                                                    @if ($chayCDR_PATL == 1)
                                                        <td>
                                                        {!! $tc->noiDungPA !!} 
                                                        <b>
                                                        ({{ $tc->diemPA }} điểm)</b>
                                                        
                                                        </td>
                                                    @else
                                                        <td>{!! $tc->noiDungPA !!} <b>

                                                        ({{ $tc->diemPA }} điểm)</b></td>
                                                    @endif                     
                                                @else
                                                <tr>
                                                    @if ($chayCDR_PATL == 1)
                                                        <td>{!! $tc->noiDungPA !!} <b>({{ $tc->diemPA }} điểm)</b></td>
                                                    @else
                                                        <td>{!! $tc->noiDungPA !!} <b>({{ $tc->diemPA }} điểm)</b></td>
                                                    @endif                                                             
                                                
                                                   
                                               
                                            @endif
                                            <td> 
                                                <select name="chamdiem1[]" id ="slb{{$cdcheck}}" >
                                                    @for($i=0; $i<=$tc->diemPA; $i=$i+0.25)                                                  

                                                    @if($tc->diemDG==$i)
                                                             <option value="{{$i}}" selected > {{$i}}</option> 
                                                    @else 
                                                         <option value="{{$i}}"> {{$i}}</option> 
                                                  
                                                    @endif 
                                                    @endfor
                                                    </select>                                                        
                                            </td>
                                            <script>  
                                                     document.getElementById('slb{{$cdcheck}}').onchange = function(e)
                                                        {
                                                         
                                                           if(document.getElementById('slb{{$cdcheck}}').value==0)
                                                           document.getElementById('ck{{$cdcheck}}').checked=false;
                                                           else
                                                           {
                                                            document.getElementById('ck{{$cdcheck}}').checked=true;
                                                           }
                                                              
                                                        };       
                                                       </script>      
                                               <td> 
                                                @if($tc->diemDG>0)
                                                    <input id= "ck{{$cdcheck}}" type="checkbox" name="chamdiem[]" checked
                                                        value="{{ $tc->maPATL }}" />điểm                                                            
                                                @else 
                                                    <input  id= "ck{{$cdcheck}}" type="checkbox" name="chamdiem[]"
                                                                value="{{ $tc->maPATL }}" /> điểm
                                                    @endif
                                                 </td>
                                                 <script>                                                                               
                       
                                                    document.getElementById('ck{{$cdcheck}}').onchange = function(e)
                                                    {                                                                        
                                                        if(document.getElementById('ck{{$cdcheck}}').checked)
                                                            document.getElementById('slb{{$cdcheck}}').value= {{$tc->diemPA}};
                                                        else
                                                         document.getElementById('slb{{$cdcheck}}').value= 0;                                                                                
                                                    };
                                                    </script>   
                                                    </tr>

                                            @php
                                                 $cdcheck++
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
                    </div>
                </form>
                    <!-- /.col -->
                </div>

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
