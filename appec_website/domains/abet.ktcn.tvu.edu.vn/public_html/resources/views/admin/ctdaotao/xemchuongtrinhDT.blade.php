@extends('admin.master')
@section('content')

<link rel="stylesheet" href="{{ asset('dist/css/foldertree.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/hortreebootstrap.css') }}">

    <div class="content-wrapper" style="min-height: 22px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            {{ __('Curriculum') }}<noscript></noscript>
                            <nav></nav>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('/quan-ly') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Curriculum') }}</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

        
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{-- <a href="{{ asset('quan-ly/bien-soan-va-phan-bien-de-cuong/excel') }}">Xuất excel</a> --}}
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_bien_soan">
                                        <i class="fas fa-clock"></i> Thời gian biên soạn đề cương
                                    </button>
                                    
                                    <!-- Modal thoi gian bien soan de cuong-->
                                    <div class="modal fade" id="edit_bien_soan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong/dieu-chinh-thoi-gian-bien-soan') }}" method="post">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Điều chỉnh</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="from-group">
                                                        <label for="">Ngày bắt đầu:</label>
                                                        <input id="listingDateOpen" type="datetime-local" name="thoiGianBatDau" class="form-control" required>
                                                    </div>
                                                    <div class="from-group">
                                                        <label for="">Ngày kết thúc</label>
                                                        <input id="listingDateClose" type="datetime-local" name="thoiGianKetThuc" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>


                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_phan_bien">
                                        <i class="fas fa-clock"></i> Thời gian phản biện đề cương
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit_phan_bien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <form action="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong/dieu-chinh-thoi-gian-phan-bien') }}" method="post">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Điều chỉnh</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="from-group">
                                                    <label for="">Ngày bắt đầu:</label>
                                                    <input id="listingDateOpen" type="datetime-local" name="thoiGianBatDau" class="form-control" required>
                                                </div>
                                                <div class="from-group">
                                                    <label for="">Ngày kết thúc</label>
                                                    <input id="listingDateClose" type="datetime-local" name="thoiGianKetThuc" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                            </div>
                                        </div>
                                        </form>
                                        
                                        </div>
                                    </div>

                                </h3>
                                <div class="card-tools">
                                    <a href="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong') }}" class="btn btn-secondary">
                                           <i class="fas fa-arrow-left"></i>
                                     </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                        <script>
                            $("#listingDateOpen").change(function(){
                                openDate = $("#listingDateOpen").val();
                                let maxCloseDate = new Date(openDate);    
                                document.getElementById("listingDateClose").setAttribute("min", openDate);
                                document.getElementById("listingDateClose").setAttribute("value", openDate);        
                            });
                        </script>
                            
        <div class="card-body">   
            <div class="tree">                                 
            <ul>
                @foreach ($XemctDaoTao as $ct)    
                <li>     
                    <span>            
                        <a style="color:rgb(141, 5, 5); text-decoration:none;" data-toggle="collapse" href="#CT_{{$ct->maCT}}"  aria-expanded="false" aria-controls="CT_{{$ct->maCT}}" onclick="SaveCT('CT_'+{{ $ct->maCT }})">
                            <i class="collapsed">
                                <i class="fas fa-folder"> </i>
                            </i>
                            <i class="expanded">
                                <i class="far fa-folder-open"> </i>
                            </i>       
                            {{ $ct->tenCT}} -- {{ $ct->soHocKy }} {{ __('Semester') }} 
                        </a>
                    </span>
                <div id="CT_{{$ct->maCT}}" class="collapse">  
                <ul>                   
                @for($i=1;$i<=$ct->soHocKy;$i++)
                    <li>                          
                            <span>
                                    <a style="color:#080808; text-decoration:none;" data-toggle="collapse" href="#HK_{{$ct->maCT.$i}}"  aria-expanded="false" aria-controls="HK_{{$ct->maCT.$i}}" onclick="SaveHK('HK_'+{{ $ct->maCT.$i }})">
                                    <i class="collapsed"><i class="fas fa-folder"></i></i>
                                    <i class="expanded"><i class="far fa-folder-open"></i></i>                        
                                        <b> Hoc Ky: {{$i}}   </b>
                                    </a>                      
                            </span>   
                            <div id="HK_{{$ct->maCT.$i}}" class="collapse"> 

                            <ul> 
                                <li>                          
                                    <span>
                                            <a style="color:#080808; text-decoration:none;" data-toggle="collapse" href="#BB_{{$ct->maCT.$i}}"  aria-expanded="false" aria-controls="BB_{{$ct->maCT.$i}}" onclick="SaveLHP('BB_'+{{ $ct->maCT.$i }})">
                                    
                                            <i class="collapsed"><i class="fas fa-folder"></i></i>
                                            <i class="expanded"><i class="far fa-folder-open"></i></i>                        
                                                <b> HỌC PHAN BB   </b>
                                            </a>                      
                                    </span>   
                                    <div id="BB_{{$ct->maCT.$i}}" class="collapse"> 

                                        <ul> @foreach ($hocphan as $hp)
                                            @if($ct->maCT == $hp->maCT && $hp->phanPhoiHocKy==$i)
                                                @foreach ($hocphan_ten as $hpt)                               
                                                    @if($hp->maHocPhan == $hpt->maHocPhan && $hp->maLoaiHocPhan=="BB")
                                                        <li>                                      
                                                            <i class="far fa-circle"></i>
                                                            <a href="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/' . $hp->maHocPhan) }}" >
                                                                {{ $hpt->tenHocPhan}}  ({{ __('Thoery') }}:{{  $hpt->tinChiLyThuyet }} & {{ __('Practice') }}: {{ $hpt->tinChiThucHanh }})
                                                            </a>
                                                        </li>
                                                    @endif                                 
                                                @endforeach
                                            @endif                
                                        @endforeach    
        
                                        </ul>

                                    </div>
                                </li>

                                <li>                          
                                    <span>
                                            <a style="color:#080808; text-decoration:none;" data-toggle="collapse" href="#TC_{{$ct->maCT.$i}}"  aria-expanded="false" aria-controls="TC_{{$ct->maCT.$i}}" onclick="SaveLHP('TC_'+{{ $ct->maCT.$i }})">
                                    
                                            <i class="collapsed"><i class="fas fa-folder"></i></i>
                                            <i class="expanded"><i class="far fa-folder-open"></i></i>                        
                                                <b> HỌC PHAN TC   </b>
                                            </a>                      
                                    </span>   
                                    <div id="TC_{{$ct->maCT.$i}}" class="collapse"> 

                                        <ul> @foreach ($hocphan as $hp)
                                            @if($ct->maCT == $hp->maCT && $hp->phanPhoiHocKy==$i)
                                                @foreach ($hocphan_ten as $hpt)                               
                                                    @if($hp->maHocPhan == $hpt->maHocPhan && $hp->maLoaiHocPhan=="TC")
                                                        <li>                                      
                                                            <i class="far fa-circle"></i>
                                                            <a href="{{ asset('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/' . $hp->maHocPhan) }}" >
                                                                {{ $hpt->tenHocPhan}}  ({{ __('Thoery') }}:{{  $hpt->tinChiLyThuyet }} & {{ __('Practice') }}: {{ $hpt->tinChiThucHanh }})
                                                            </a>
                                                        </li>
                                                    @endif                                 
                                                @endforeach
                                            @endif                
                                        @endforeach    
        
                                        </ul>

                                    </div>
                                </li>
                                
                                                    </div> 
                                                                            
                                            </li>
                                            @endfor
                                    </ul>
                                    </div>            
                                </li> 
                                
                                @endforeach
                            
                            </ul>    
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
    <!-- /.content -->
    </div>
    <script src="{{ asset('dist/js/foldertree.js') }}"></script>
    <script>
          $(document).ready(function() {
            checkTree()
            });

        function checkTree(){
            console.log('checkTree run');
            if (localStorage.getItem("CT")) { 
                $("div[id="+localStorage.getItem("CT")+"]").removeClass("collapse");
                $("div[id="+localStorage.getItem("CT")+"]").addClass("expanded");
                if(localStorage.getItem("HK")){
                    $("div[id="+localStorage.getItem("HK")+"]").removeClass("collapse");
                    $("div[id="+localStorage.getItem("HK")+"]").addClass("expanded");
                    if(localStorage.getItem("LHP")){
                        $("div[id="+localStorage.getItem("LHP")+"]").removeClass("collapse");
                        $("div[id="+localStorage.getItem("LHP")+"]").addClass("expanded");
                    }
                }
            }
        }
        function SaveCT(maCT){
            console.log('save CT run');
            localStorage.setItem('CT', maCT); 
        }
        function SaveHK(hk){
            console.log('save HK run');
            localStorage.setItem('HK', hk); 
        }
        function SaveLHP(lhp){
            console.log('save LHP run');
            localStorage.setItem('LHP', lhp); 
        }

    </script>
@endsection
