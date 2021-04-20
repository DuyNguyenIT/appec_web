<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use Carbon\Carbon;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\danhGia;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\sinhVien;
use App\Models\giangVien;
use App\Models\noiDungQH;
use App\Models\chuan_abet;
use App\Models\phieu_cham;
use App\Models\baiQuyHoach;
use App\Models\chuong_ndqh;
use App\Models\loaiDanhGia;
use App\Models\deThi_cauHoi;
use App\Models\mucDoDanhGia;
use Illuminate\Http\Request;
use App\Models\chuong_cauhoi;
use App\Models\loaiHTDanhGia;
use App\Models\phanBoNoiDung;
use App\Models\hocPhan_kqHTHP;
use App\Models\phuongAnTuLuan;
use App\Models\tieuChiChamDiem;
use App\Models\ct_bai_quy_hoach;
use App\Models\quyHoach_hocPhan;
use App\Models\tieuChuanDanhGia;
use App\Models\dethi_cauhoituluan;
use App\Models\phuongAnTracNghiem;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;
use App\Models\cauHoi_tieuChiChamDiem;



class quyhoachController extends Controller
{
    ///giang-vien/quy-hoach-danh-gia
    public function index()
    {
        $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
        ->orderBy('giangday.namHoc','desc')
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })->groupBy('maBaiQH')->distinct()->get();
        //tạo combobox  năm học
        $date = new Carbon();   
        $current_year=$date->year;
        $years_array=[];
        for ($i=1; $i<=5 ; $i++) { 
            array_push($years_array,($current_year-1).'-'.($current_year));
            $current_year=$current_year-1;
        }

        return view('giangvien.quyhoach.quyhoach',compact('gd','years_array'));
    }

    public function filter(Request $request)
    { 
        // năm và học kì đều chọn all
        if($request->namHoc=="all" && $request->maHK=="all"){
            $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
            ->orderBy('giangday.namHoc','desc')
            ->join('hoc_phan',function($q){
                $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
            })->groupBy('maBaiQH')->distinct()->get();
        }else{
            if($request->namHoc=="all" && $request->maHK!="all"){//chỉ năm all 
                $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
                    ->where('maHK',$request->maHK)
                    ->orderBy('giangday.namHoc','desc')
                    ->join('hoc_phan',function($q){
                        $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                        ->where('hoc_phan.isDelete',false);
                    })->groupBy('maBaiQH')->distinct()->get();
            }else{
                if($request->namHoc!="all" && $request->maHK=="all"){//chỉ học kì all
                    $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
                    ->where('namHoc',$request->namHoc)
                    ->orderBy('giangday.namHoc','desc')
                    ->join('hoc_phan',function($q){
                        $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                        ->where('hoc_phan.isDelete',false);
                    })->groupBy('maBaiQH')->distinct()->get();
                }else{  //có chọn năm và học kì
                    $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
                    ->where('namHoc',$request->namHoc)->where('maHK',$request->maHK)
                    ->orderBy('giangday.namHoc','desc')
                    ->join('hoc_phan',function($q){
                        $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                        ->where('hoc_phan.isDelete',false);
                    })->groupBy('maBaiQH')->distinct()->get();
                }
            }
        }
        
        //tạo combobox  năm học
        $date = new Carbon();   
        $current_year=$date->year;
        $years_array=[];
        for ($i=1; $i<=5 ; $i++) { 
            array_push($years_array,($current_year-1).'-'.($current_year));
            $current_year=$current_year-1;
        }
        return view('giangvien.quyhoach.quyhoach',compact('gd','years_array'));
    }

    ///giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/220104/1/HK1/2020-2021/DA16TT
    public function quy_hoach_ket_qua_hoc_tap(Request $request,$maHocPhan,$maBaiQH,$maHK,$namHoc,$maLop)
    {
       
           $request->session()->put('maHocPhan', $maHocPhan);
           $request->session()->put('maHK', $maHK);
           $request->session()->put('namHoc', $namHoc);
           $request->session()->put('maLop', $maLop);
           $request->session()->put('maBaiQH', $maBaiQH);

           $ldg=loaiDanhGia::where('isDelete',false)->get();
           $lhtdg=loaiHTDanhGia::where('isDelete',false)->get();
           $hp=hocPhan::where('maHocPhan',$maHocPhan)->where('isDelete',false)->first();

           $qh=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
           ->where('ct_bai_quy_hoach.maBaiQH',$maBaiQH)
           ->join('loai_danh_gia',function($x){
               $x->on('loai_danh_gia.maLoaiDG','=','ct_bai_quy_hoach.maLoaiDG')
               ->where('loai_danh_gia.isDelete',false);
           })
           ->join('loai_ht_danhgia',function($x){
                $x->on('loai_ht_danhgia.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
                ->where('loai_ht_danhgia.isDelete',false);
            })->get();
          //đếm số dòng trong ct bài quy hoach
          $count_ct=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
          ->where('ct_bai_quy_hoach.maBaiQH',$maBaiQH)->sum('ct_bai_quy_hoach.maCTBaiQH');
          //đếm số group trong hocphan_loai_hinhthuc_dg
          $count_groupCT=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$maHocPhan)->distinct('groupCT')->count();
          $hocphan_loai_htdg_array=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$maHocPhan)->get();
            

           return view('giangvien.quyhoach.quyhoachketqua',['qh'=>$qh,'hp'=>$hp,
           'ldg'=>$ldg,'lhtdg'=>$lhtdg,'count_ct'=>$count_ct,'count_groupCT'=>$count_groupCT,
           'hocphan_loai_htdg_array'=>$hocphan_loai_htdg_array]);

    }
    public function chon_nhom_cong_thuc(Request $request)
    {
        $hocphan_loai_htdg_array=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$request->session()->get('maHocPhan'))->where('groupCT',$request->groupCT)->get();

        foreach ($hocphan_loai_htdg_array as $value) {
            ct_bai_quy_hoach::create(['maHocPhan'=>$value->maHocPhan,'maLoaiDG'=>$value->maLoaiDG,'maLoaiHTDG'=>$value->maLoaiHTDG,
            'trongSo'=>$value->trongSo,'maBaiQH'=>$request->session()->get('maBaiQH'),'maGV_2'=>'00000']);
        }
        alert()->success('Adding successfully!', 'Message');
        return back();
    }
    /////////---------NỘI DUNG QUY HOẠCH
    ///giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/1
    public function noi_dung_quy_hoach($maCTBaiQH)
    {
        $ct_bqh=ct_bai_quy_hoach::where('isdelete',false)->where('maCtBaiQH',$maCTBaiQH)->first();
        
        if(!$ct_bqh){
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/noi-dung-quy-hoach/'.$maCTBaiQH)->with('warning','Không thể tìm thất chi tiết bài quy hoạch');
        }
        $ndqh=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        //kết quả học tập
        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',Session::get('maHocPhan'))
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->get();
        
        //mức độ đánh giá
        $mdg=mucDoDanhGia::where('isDelete',false)->get();

        //còn lại là đồ án
        return view('giangvien.quyhoach.noidungquyhoach',['noiDungQH'=>$ndqh,'maCTBaiQH'=>$maCTBaiQH,'ketQuaHT'=>$kqht,
        'mucDoDG'=>$mdg]);
    }

    
    //-----------------thêm nội dung quy hoạch
    ///giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/them_noi_dung_quy_hoach_submit

    public function them_noi_dung_quy_hoach_submit(Request $request)
    {
        noiDungQH::create(['maCTBaiQH'=>$request->maCTBaiQH,'tenNoiDungQH'=>$request->tenNoiDungQH,'maKQHT'=>$request->maKQHT,'maMucDoDG'=>$request->maMucDoDG]);
        alert()->success('Thêm thành công!', 'Thông báo');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.$request->maCTBaiQH);
    }

    public function them_cau_hoi_tu_luan()
    {
        return view('giangvien.quyhoach.noidungdanhgia.tuluan.themcauhoituluan');
    }
  
    ///////---------------------quy hoạch chương----------------
    ///giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/chuong/5
    public function chuong_noidungqh($maNoiDungQH)
    {
        $ndqh=noiDungQH::findOrFail($maNoiDungQH);
        Session::put('maNoiDungQH', $maNoiDungQH);
        $chuong=chuong_ndqh::where('maNoiDungQH',$maNoiDungQH)->get();
        if ($chuong) {
            foreach ($chuong as $key => $value) {
                $ch=chuong::find($value->id_chuong);
                 
                if($ch){
                    $value->tenchuong=$ch->tenchuong;
                }
            }
        }
        $chuong_hp=chuong::where('maHocPhan',Session::get('maHocPhan'))->get();
        return view('giangvien.quyhoach.cauhoituluan.index',['noidungqh'=>$ndqh,
        'chuong'=>$chuong,'chuong_hp'=>$chuong_hp]);
    }

    //----------------thêm chương nội dung quy hoạch---------
    ///giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/chuong/them-chuong-noi-dung-quy-hoach
    public function them_chuong_ndqh(Request $request)
    {   
        //check exits
        $kt=chuong_ndqh::where('maNoiDungQH',Session::get('maNoiDungQH'))->where('id_chuong',$request->id_chuong)->first();
        if ($kt) {
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/noi-dung-quy-hoach/chuong/'.Session::get('maNoiDungQH'))->with('warning','Chương đã được quy hoạch');
        }
        $chuong_ndqh=chuong_ndqh::create(['id_chuong'=>$request->id_chuong,'maNoiDungQH'=>Session::get('maNoiDungQH')]);
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/noi-dung-quy-hoach/chuong/'.Session::get('maNoiDungQH'))->with('success','Thêm thành công');
    }

    public function xem_cau_hoi_trong_chuong(Type $var = null)
    {
        #code...
    }

    ///---------------thêm quy hoạch
    public function them_quy_hoach(Request $request)
    {
            //maHocPhan+maLoaiDG+=maLoaiHTDG+trongSo===>hocphan_loai_hinhthuc_dg
            ct_bai_quy_hoach::create(['maLoaiDG'=>$request->maLoaiDG,'maLoaiHTDG'=>$request->maLoaiHTDG,'trongSo'=>$request->trongSo,'maBaiQH'=>Session::get('maBaiQH')]);
            //get hocphan_loai_ht_dg
            //maHocPhan+maLoaiDG+maLoaiHTDG+maBaiQH+maGV==>quyhoach_hocphan
            $qh_hp=new quyHoach_hocPhan();
            $qh_hp->maHocPhan=$request->maHocPhan;
            $qh_hp->maLoaiDG=$request->maLoaiDG;
            $qh_hp->maLoaiHTDG=$request->maLoaiHTDG;
            $qh_hp->maBaiQH=Session::get('maBaiQH');
            $qh_hp->maGV=Session::get('maGV');
            $qh_hp->save();
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/quy-hoach-ket-qua/'.$request->maHocPhan.'/'.Session::get('maBaiQH').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maLop'))->with('success','thêm thành công');
    }

    // ------------------------NỌI DUNG ĐÁNH GIÁ

    // /giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/3
    public function xem_noi_dung_danh_gia(Request $request,$maCTBaiQH)
    {
        try {
            $request->session()->put('maCTBaiQH', $maCTBaiQH);
            //maCTBaiQH->ct_bai-quy_hoach
            $maLoaiHTDG=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->first('maLoaiHTDG');
         
            //ct_bai_quy_hoach
            $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->first();
            $request->session()->put('maGV_2', $ct_bqh->maGV_2);

            if ($request->session()->get('maGV_2')!='00000') {
                //?maCTBaiQH->maDe
                $maDe=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maCTBaiQH',$maCTBaiQH)
                ->leftJoin('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.maGV','=',Session::get('maGV_2'))
                    ->where('phieu_cham.isDelete',false);
                })
                ->leftJoin('sinh_vien',function($y){
                    $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                    ->where('sinh_vien.isDelete',false);
                })
                ->leftJoin('giang_vien',function($y){
                    $y->on('phieu_cham.maGV','=','giang_vien.maGV')
                    ->where('giang_vien.isDelete',false);
                })
                ->get(['de_thi.maDeVB','de_thi.maDe','de_thi.tenDe','sinh_vien.maSSV','sinh_vien.HoSV','sinh_vien.TenSV','giang_vien.hoGV','giang_vien.tenGV']);
            }else{
                $maDe=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maCTBaiQH',$maCTBaiQH)
                ->leftJoin('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',2)
                    ->where('phieu_cham.isDelete',false);
                })
                ->leftJoin('sinh_vien',function($y){
                    $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                    ->where('sinh_vien.isDelete',false);
                })
                ->leftJoin('giang_vien',function($y){
                    $y->on('phieu_cham.maGV','=','giang_vien.maGV')
                    ->where('giang_vien.isDelete',false);
                })
                ->get(['de_thi.maDeVB','de_thi.maDe','de_thi.tenDe','sinh_vien.maSSV','sinh_vien.HoSV','sinh_vien.TenSV','giang_vien.hoGV','giang_vien.tenGV']);
            }

            //-----------------------------tự luận
            if ($maLoaiHTDG->maLoaiHTDG=="T1") { 
                $dethi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
                return view('giangvien.quyhoach.noidungdanhgia.tuluan.xemnddanhgiatuluan',compact('dethi','maCTBaiQH'));
            }

            //------------------------------trắc nghiệm
            if ($maLoaiHTDG->maLoaiHTDG=="T2") { 
                $dethi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
                return view('giangvien.quyhoach.noidungdanhgia.tracnghiem.xemnddanhgiatracnghiem',compact('dethi','maCTBaiQH'));
            }

            //------------------------------thực hành
            if ($maLoaiHTDG->maLoaiHTDG=="T3") { 
                $dethi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
                return view('giangvien.quyhoach.noidungdanhgia.thuchanh.xemnddanhgiathuchanh',compact('dethi','maCTBaiQH'));
            }

            //-------------------------------cho đồ án
            if($maLoaiHTDG->maLoaiHTDG=="T8"){  
                 //lấy danh sách sinh viên đã có trong phiếu chấm
                 $dssvTrongPC=deThi::where('de_thi.isDelete',false)
                 ->where('de_thi.maCTBaiQH',$maCTBaiQH)
                 ->leftJoin('phieu_cham',function($x){
                     $x->on('phieu_cham.maDe','=','de_thi.maDe')
                     ->where('phieu_cham.isDelete',false);
                 })
                 ->get('maSSV');
                 $massv= [];
                 foreach ($dssvTrongPC as $value) {
                     if($value->maSSV==null)
                        array_push($massv,'null');
                    else
                        array_push($massv, $value->maSSV);
                 }
                
                 
                 //select những sinh viên chưa được gán vào phiếu chấm
                $dsLop=sinhVien::where('isDelete',false)->where('maLop',Session::get('maLop'))->whereNotIn('maSSV',$massv)->orderBy('maSSV')->get();
               
                 //lấy danh sách đề tài
                 $deTai=deThi::where('de_thi.isDelete',false)->where('de_thi.maCTBaiQH',$maCTBaiQH)->get();

                 //giảng viên
                 $gv=giangVien::where('isDelete',false) ->where('maGV','!=',Session::get('maGV'))->get();
                
                 //cb chấm 2
                 $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)->where('ct_bai_quy_hoach.maCTBaiQH',$maCTBaiQH)->first();
                 if($ct_bqh->maGV_2==null){ //chưa mời
                    $cb2=new giangVien();
                    $cb2->maGV="-1";
                    $cb2->hoGV="";
                    $cb2->tenGV="Chưa mời giảng viên";
                 }else{//đã mời
                    $cb2=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
                    ->where('ct_bai_quy_hoach.maCTBaiQH',$maCTBaiQH)
                    ->leftjoin('giang_vien',function($x){
                        $x->on('giang_vien.maGV','=','ct_bai_quy_hoach.maGV_2')
                        ->where('giang_vien.isDelete',false);
                    })
                    ->first();
                    
                    if($cb2->maGV==null){//mời nhiều người
                        $cb2->maGV="00000";
                        $cb2->hoGV="";
                        $cb2->tenGV="Nhiều giảng viên";
                    }
                 }
                 
                
                return view('giangvien.quyhoach.noidungdanhgia.xemnddanhgia',['deThi'=>$maDe,
                'maCTBaiQH'=>$maCTBaiQH,'deTai'=>$deTai,'gv'=>$gv, 'canbo2'=>$cb2,
                'dsLop'=>$dsLop]);
            }   
            
        } catch (\Throwable $th) {
            return $th;
        }

    }

    //////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////KHU VỰC HÀM CHO TỰ LUẬN///////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////
     //thêm đề thi tự luận
     public function them_de_thi_tu_luan()
     { 
         return view('giangvien.quyhoach.noidungdanhgia.themdethituluan');
     }
    
    public function them_de_thi_tu_luan_submit(Request $request)  //thêm tiêu đèn, ngày thi, giờ thi,...
    {
        try {
            deThi::create(['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,'tenDe'=>$request->tenDe,'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
            alert()->success('Added successfully', 'Message');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        } catch (\Throwable $th) {
            return  $th;
        }
    }

    public function cau_truc_de_luan(Request $request,$maDe) //hàm  này hiển thị đề thi dưới dạng cấu hình
    {
        #thông tin học phần
        $hocphan=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();
        #thông tin đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
        #thông tin mục
        $muc=hocPhan::where('hoc_phan.maHocPhan',Session::get('maHocPhan'))
        ->join('chuong',function($x){
            $x->on('chuong.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('chuong.isDelete',false);
        })
        ->join('muc',function($y){
            $y->on('muc.id_chuong','=','chuong.id');
        })
        ->get(['muc.id','muc.tenmuc']);
       
        #thông tin chuẩn đầu ra  
        $cdr3=hocPhan::where('hoc_phan.maHocPhan',Session::get('maHocPhan'))
        ->join('hocphan_kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        })
        ->distinct('hocphan_kqht_hp.maCDR3')
        ->join('cdr_cd3',function($y){ 
            $y->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get(['hocphan_kqht_hp.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);

        #nội dung đề thi tự luận
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->Leftjoin('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
        ->Leftjoin('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        //->Leftjoin('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
        

        ##tính điểm câu hỏi
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->sum('phuong_an_tu_luan.diemPA');
            $phuongAnTL=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->join('cdr_cd3','phuong_an_tu_luan.maCDR3','=','cdr_cd3.maCDR3')
            ->join('chuan_abet','phuong_an_tu_luan.maChuanAbet','=','chuan_abet.maChuanAbet')
            ->get();
            $noidung[$i]->diem=$diem;  
            $noidung[$i]->phuongAn=$phuongAnTL;
        }
        ##tạo mảng các câu hỏi đã chọn->chỉ duyệt những câu hỏi chưa được chọn
        $cauhoidachon=dethi_cauhoituluan::where('maDe',$maDe)->distinct('maCauHoi')->pluck('maCauHoi');
         #thông tin câu hỏi
         $cauhoi=[];
         foreach ($muc as  $value) {
             $temp=cauHoi::where('isdelete',false)->where('id_muc',$value->id)
             ->where('maLoaiHTDG','T1')->whereNotIn('maCauHoi',$cauhoidachon)->get();
             foreach ($temp as $ch) {
                 array_push($cauhoi,$ch);
             }
         }
        #combobox abet
        $abet=chuan_abet::all();
        
         #phản hồi kết quả
        return view('giangvien.quyhoach.noidungdanhgia.tuluan.cautrucde',
        compact('dethi','hocphan','cauhoi','cdr3','noidung','abet'));
    }

    public function them_cau_hoi_de_luan(Request $request) //hàm này thêm câu hỏi vào đề thi tự luận
    {
        if($request->maCauHoi==null){
            alert()->warning('Question ID is null!!','Messange');
            return back();
        }
        $index=0;
        //duyêt mảng phương án
        for ($i=0; $i < count($request->phuongAn); $i++) { 
            # lưu phương án tự luận
            phuongAnTuLuan::create(['noiDungPA'=>$request->phuongAn[$i],'diemPA'=>$request->diem[$i],'maCDR3'=>$request->maCDR3]);
            # lưu maCauHoi, maDe, maPhuongAn vào nội dung đề thi
            $pa=phuongAnTuLuan::orderBy('id','desc')->first();
            dethi_cauhoituluan::create(['maDe'=>$request->maDe,'maCauHoi'=>$request->maCauHoi,'maPATL'=>$pa->id]);
          
        }
        alert()->success('Adding successfully','Message');
        return back();
    }

    public function xoa_cau_hoi_de_tu_luan(Request $request,$maDe,$maCauHoi)
    {
        $cauhoi=dethi_cauhoituluan::where('maDe',$maDe)->where('maCauHoi',$maCauHoi)->first();

        if($cauhoi){
            $pa=phuongAnTuLuan::where('id',$cauhoi->maPATL)->first();
            if($pa){
                $pa->delete();
             }
            $cauhoi->delete(); 
            alert()->success("Deleting successfully",'Message');
            return back();
        }
        alert()->warning("Can't found question",'Warning!');
        return back();
    }

    public function chinh_sua_phuong_an_tu_luan(Request $request)
    {
        $patl=phuongAnTuLuan::find($request->id);
        if($patl){
            $patl->noiDungPA=$request->noiDungPA;
            $patl->diemPA=$request->diemPA;
            $patl->maCDR3=$request->maCDR3;
            $patl->maChuanAbet=$request->maChuanAbet;
            $patl->update();
        }
        return back();
    }
    

    public function cau_truc_noi_dung_de_luan(Request $request,$maDe) //hàm này tạm không dùng
    {
        $md=deThi::findOrFail($maDe);
        return view('GiangVien.quyhoach.noidungdanhgia.tuluan.cautrucnoidungdeluan');
    }
     //////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////KHU VỰC HÀM CHO THỰC HÀNH///////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////

    public function them_de_thi_thuc_hanh_submit(Request $request) //thêm tiêu đèn, ngày thi, giờ thi,...
    {
        deThi::create(['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,'tenDe'=>$request->tenDe,'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
        alert()->success('Added successfully', 'Message');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function cau_truc_de_thuc_hanh(Request $request,$maDe) //dẫn đến view cấu trúc đề thi
    {
        #thông tin học phần
        $hocphan=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();
        #thông tin đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
        #thông tin mục
        $muc=hocPhan::where('hoc_phan.maHocPhan',Session::get('maHocPhan'))
        ->join('chuong',function($x){
            $x->on('chuong.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('chuong.isDelete',false);
        })
        ->join('muc',function($y){
            $y->on('muc.id_chuong','=','chuong.id');
        })
        ->get(['muc.id','muc.tenmuc']);
       
        #thông tin chuẩn đầu ra  
        $cdr3=hocPhan::where('hoc_phan.maHocPhan',Session::get('maHocPhan'))
        ->join('hocphan_kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        })
        ->distinct('hocphan_kqht_hp.maCDR3')
        ->join('cdr_cd3',function($y){ 
            $y->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get(['hocphan_kqht_hp.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
          #nội dung đề thi thực hành
          $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
          ->Leftjoin('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
          ->Leftjoin('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
          //->Leftjoin('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
          ->distinct('cau_hoi.maCauHoi')
          ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
          
  
          ##tính điểm câu hỏi
          for ($i=0; $i < count($noidung); $i++) { 
              $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
              ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
              ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
              ->sum('phuong_an_tu_luan.diemPA');
              $phuongAnTL=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
              ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
              ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
              ->join('cdr_cd3','phuong_an_tu_luan.maCDR3','=','cdr_cd3.maCDR3')
              ->join('chuan_abet','phuong_an_tu_luan.maChuanAbet','=','chuan_abet.maChuanAbet')
              ->get();
              $noidung[$i]->diem=$diem;  
              $noidung[$i]->phuongAn=$phuongAnTL;
          }
        ##tạo mảng các câu hỏi đã chọn->chỉ duyệt những câu hỏi chưa được chọn
        $cauhoidachon=dethi_cauhoituluan::where('maDe',$maDe)->distinct('maCauHoi')->pluck('maCauHoi');
         #thông tin câu hỏi
        $cauhoi=[];
        foreach ($muc as  $value) {
             $temp=cauHoi::where('isdelete',false)->where('id_muc',$value->id)
             ->where('maLoaiHTDG','T3')->whereNotIn('maCauHoi',$cauhoidachon)->get();
             foreach ($temp as $ch) {
                 array_push($cauhoi,$ch);
             }
         }
         #combobox abet
         $abet=chuan_abet::all();
         #phản hồi kết quả
        return view('giangvien.quyhoach.noidungdanhgia.thuchanh.cautrucde',
        compact('dethi','hocphan','cauhoi','cdr3','abet','noidung'));
    }

    public function them_cau_hoi_de_thuc_hanh(Request $request) //nhấn nút thêm câu hỏi
    {
        if($request->maCauHoi==null){
            alert()->warning('Question ID is null!!','Messange');
            return back();
        }
        $index=0;
        //duyêt mảng phương án
        for ($i=0; $i < count($request->phuongAn); $i++) { 
            # lưu phương án tự luận
            phuongAnTuLuan::create(['noiDungPA'=>$request->phuongAn[$i],'diemPA'=>$request->diem[$i],'maCDR3'=>$request->maCDR3]);
            # lưu maCauHoi, maDe, maPhuongAn vào nội dung đề thi
            $pa=phuongAnTuLuan::orderBy('id','desc')->first();
            dethi_cauhoituluan::create(['maDe'=>$request->maDe,'maCauHoi'=>$request->maCauHoi,'maPATL'=>$pa->id]);
          
        }
        alert()->success('Adding successfully','Message');
        return back();
    }

    public function xoa_cau_hoi_de_thuc_hanh(Request $request,$maDe,$maCauHoi)
    {
        $cauhoi=dethi_cauhoituluan::where('maDe',$maDe)->where('maCauHoi',$maCauHoi)->first();

        if($cauhoi){
            $pa=phuongAnTuLuan::where('id',$cauhoi->maPATL)->first();
            if($pa){
                $pa->delete();
             }
            $cauhoi->delete(); 
            alert()->success("Deleting successfully",'Message');
            return back();
        }
        alert()->warning("Can't found question",'Warning!');
        return back();
    }

    public function chinh_sua_phuong_an_thuc_hanh(Request $request)
    {
        $patl=phuongAnTuLuan::find($request->id);
        if($patl){
            $patl->noiDungPA=$request->noiDungPA;
            $patl->diemPA=$request->diemPA;
            $patl->maCDR3=$request->maCDR3;
            $patl->maChuanAbet=$request->maChuanAbet;
            $patl->update();
        }
        return back();
    }
    //////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////KHU VỰC HÀM CHO TRẮC NGHIỆM///////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////

    public function them_de_thi_trac_nghiem()
    {
        return view('giangvien.quyhoach.noidungdanhgia.themdethitracnghiem');
    }

    public function them_de_thi_trac_nghiem_submit (Request $request)//thêm tiêu đèn, ngày thi, giờ thi,...
    {
        deThi::create(['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,'tenDe'=>$request->tenDe,'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
        alert()->success('Added successfully', 'Message');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function cau_truc_de_trac_nghiem(Request $request,$maDe) //dẫn đến view cấu trúc đề thi
    {
          #thông tin học phần
          $hocphan=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();
          #thông tin đề thi
          $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
          #thông tin mục
          $muc=hocPhan::where('hoc_phan.maHocPhan',Session::get('maHocPhan'))
          ->join('chuong',function($x){
              $x->on('chuong.maHocPhan','=','hoc_phan.maHocPhan')
              ->where('chuong.isDelete',false);
          })
          ->join('muc',function($y){
              $y->on('muc.id_chuong','=','chuong.id');
          })
          ->get(['muc.id','muc.tenmuc']);
         
          #thông tin chuẩn đầu ra  
          $cdr3=hocPhan::where('hoc_phan.maHocPhan',Session::get('maHocPhan'))
          ->join('hocphan_kqht_hp',function($x){
              $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
              ->where('hocphan_kqht_hp.isDelete',false);
          })
          ->distinct('hocphan_kqht_hp.maCDR3')
          ->join('cdr_cd3',function($y){ 
              $y->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
              ->where('cdr_cd3.isDelete',false);
          })
          ->get(['hocphan_kqht_hp.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
          #nội dung đề thi tự luận
          $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
          ->join('de_thi_cau_hoi','de_thi_cau_hoi.maDe','=','de_thi.maDe')
          ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
          ->distinct('cau_hoi.maCauHoi')

          ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
          #tính điểm câu hỏi
          $letter=['A','B','C','D'];
          for ($i=0; $i <count($noidung) ; $i++) { 
              # code...
              $diem=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->sum('diemPA');
              $noidung[$i]->diem=$diem;
              $noidung[$i]->phuong_an=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->get();
              for ($j=0; $j <count($noidung[$i]->phuong_an) ; $j++) { 
                $noidung[$i]->phuong_an[$j]->noiDungPA=substr_replace($noidung[$i]->phuong_an[$j]->noiDungPA, $letter[$j].'. ', 3, 0);
              }
          }
          
          ##tạo mảng các câu hỏi đã chọn->chỉ duyệt những câu hỏi chưa được chọn
        $cauhoidachon=deThi_cauHoi::where('maDe',$maDe)->distinct('maCauHoi')->pluck('maCauHoi');
        #thông tin câu hỏi
        $cauhoi=[];
        foreach ($muc as  $value) {
            $temp=cauHoi::where('isdelete',false)->where('id_muc',$value->id)
            ->where('maLoaiHTDG','T2')->whereNotIn('maCauHoi',$cauhoidachon)->with('phuong_an_trac_nghiem')->get();
            for ($i=0; $i < count($temp) ; $i++) { 
                for ($j=0; $j < count($temp[$i]->phuong_an_trac_nghiem); $j++) { 
                    $temp[$i]->phuong_an_trac_nghiem[$j]->noiDungPA=substr_replace($temp[$i]->phuong_an_trac_nghiem[$j]->noiDungPA, $letter[$j].'. ', 3, 0);
                }
            }
           
            foreach ($temp as $ch) {
                array_push($cauhoi,$ch);
            }
        }
        #phản hồi kết quả
        return view('giangvien.quyhoach.noidungdanhgia.tracnghiem.cautrucde',
        compact('dethi','hocphan','cauhoi','cdr3','noidung'));
    }

    public function them_cau_hoi_de_trac_nghiem(Request $request) //nhấn nút thêm câu hỏi vào đề thi
    {
        if($request->maCauHoi==null){
            alert()->warning('Question ID is null!!','Messange');
            return back();
        }   
        deThi_cauHoi::create(['maDe'=>$request->maDe,'maCauHoi'=>$request->maCauHoi]);
        alert()->success('Adding successfully','Message');
        return back();
    }

    //////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////KHU VỰC HÀM CHO BÁO CÁO///////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////
    //-----mời chấm báo cáo
    public function moi_cham_bao_cao(Request $request)
    {
        //kiễm tra đã mời hay chưa
        $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->first();
        if($ct_bqh){
            $ct_bqh->maGV_2=$request->maGV_2;
            $ct_bqh->update();
            alert()->success('Inviting instructor successfully','Messsage');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
        alert()->success('Errors','Warning');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        
    }

    //thêm đề tài mới
    public function them_de_tai(Request $request)
    {
            deThi::create(['maDeVB'=>$request->maDe,'tenDe'=>$request->tenDe,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
            alert()->success('Thêm thành công!!','Thông báo');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }

    //thêm phiếu chấm mới
    public function them_phieu_cham(Request $request)
    {
        //noiDungDe+maSSV->phieuCham
        //kiễm tra đã mời hay chưa
        $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
        if($ct_bqh->maGV_2){
            if($ct_bqh->maGV_2!='00000'){ //nếu không cần mời thêm cán bộ 2 ( mã CB 2 =0000)
                //cb1
                phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
                //cb2
                phieu_cham::create(['maGV'=>$ct_bqh->maGV_2,'loaiCB'=>2,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
                alert()->success('Thêm thành công!!','Thông báo');
                return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            }
            else{
                //cb1
                phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
                //cb2
                phieu_cham::create(['maGV'=>$request->maGV_2,'loaiCB'=>2,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
                return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Thêm thành công!');
            }
        }
        else{
            alert()->error('Chưa mời giảng viên chấm báo cáo!', 'Cảnh báo');
            return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
    }

    //xem tiêu chí đánh giá
    public function xem_tieu_chi_danh_gia($maCTBaiQH)
    {
             //ct_bai-quy_hoach->noi_dung_quy_hoach
             $ndQh=noiDungQH::where('noi_dung_quy_hoach.isDelete',false)
             ->where('noi_dung_quy_hoach.maCTBaiQH',$maCTBaiQH)
             ->join('tieuchuan_danhgia',function($x){
                 $x->on('tieuchuan_danhgia.maNoiDungQH','=','noi_dung_quy_hoach.maNoiDungQH')
                 ->where('tieuchuan_danhgia.isDelete',false);
             })
             ->join('cau_hoi_tcchamdiem',function($y){
                 $y->on('cau_hoi_tcchamdiem.maTCDG','=','tieuchuan_danhgia.maTCDG')
                 ->where('cau_hoi_tcchamdiem.isDelete',false);
             })
             ->join('tieu_chi_cham_diem',function($z){
                 $z->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                 ->where('tieu_chi_cham_diem.isDelete',false);
             })
            // ->get(['tieu_chi_cham_diem.maTCCD','tenTCCD','tieu_chi_cham_diem.maCDR3']);
            ->get();
           

           
            foreach ($ndQh as $tc) {
                 $cdr3=CDR3::where('isDelete',false)
                     ->where('maCDR3', $tc->maCDR3)
                     ->get(['maCDR3VB', 'tenCDR3']);
                 $tc->tenCDR3=$cdr3[0]["tenCDR3"];
                 $tc->maCDR3VB=$cdr3[0]["maCDR3VB"];
            }
           

            // return $ndQh->count('tenTCCD');  //số tiêu chí trong một tiêu chuẩn
            // return $ndQh->groupBy('maCDR3')->count();//số chuẩn đầu ra
            
            return view('giangvien.quyhoach.xemtieuchi',['tieuchi'=>$ndQh]);
       
    }
   
    //thêm tiêu chí đánh giá mới
    public function them_tieu_chi_danh_gia(Request $request,$maCTBaiQH)
    {
        $request->session()->put('maCTBaiQH', $maCTBaiQH);
        
        //Session maBaiQH, hocKi, namHoc, maHocPhan->maCDR3

        // $cdr3=giangDay::where('giangday.isDelete',false)
        // ->where('giangday.maBaiQH',Session::get('maBaiQH'))
        // ->leftjoin('cdr_cd3',function($x){
        //     $x->on('cdr_cd3.maCDR3','=','giangday.maCDR3')
        //     ->where('cdr_cd3.isDelete',false);
        // })
        //->get();
        //->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);


        $cdr3=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',Session::get('maHocPhan'))
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->join('cdr_cd3',function($t){
            $t->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->distinct(['cdr_cd3.maCDR3','hocphan_kqht_hp.maHocPhan'])
        ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3','hocphan_kqht_hp.maHocPhan']);

     

        //kqht
        //kết quả học tập
        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',Session::get('maHocPhan'))
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->get();
        
        //loai ht dg
        $loai_htdg=loaiHTDanhGia::where('isDelete',false)->get();
       
        //noiDung BaiqH
        $ndqh=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();

        $tc=tieuChuanDanhGia::where('isDelete',false)->where('maNoiDungQH',$ndqh[0]->maNoiDungQH)->get();
       
        return view('giangvien.quyhoach.themtieuchi',['cdr3'=>$cdr3,'kqht'=>$kqht,'loai_htdg'=>$loai_htdg,'tieuchuan'=>$tc,
        'ndqh'=>$ndqh,'maCTBaiQH'=>$maCTBaiQH]);
    }

    //
    public function get_tieu_chuan_by_NDQH($maNoiDungQH)
    {
        $tc=tieuChuanDanhGia::where('isDelete',false)->where('maNoiDungQH',$maNoiDungQH)->get();
        $data="";
        foreach ($tc as $x) {
            $data=$data."<option value='".$x->maTCDG."'>".$x->tenTCDG.'-'.$x->diem." điểm</option>";
        }
        return response()->json($data);
    }

    public function them_tieu_chuan_submit(Request $request)
    {
        tieuChuanDanhGia::create(['tenTCDG'=>$request->tenTCDG,'maNoiDungQH'=>$request->maNoiDungQH,'diem'=>$request->diemTCDG]);
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function them_tieu_chi_danh_gian_submit(Request $request) // submit form thêm tiêu chí đánh giá mới
    {
        //tạo câu hỏi noiDungCauHoi
        cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>$request->maLoaiHTDG,'id_loaiCH'=>4,'id_muc'=>1]);
        $ch=cauHoi::where('isDelete',false)->orderBy('maCauHoi','desc')->first();
        //noiDungQH->tieuchuan_danhgia
        $noiDungQH=noiDungQH::where('isDelete',false)->where('maCTBaiQH',Session::get('maCTBaiQH'))->where('maKQHT',$request->maKQHT)->first();
        $tc=tieuChuanDanhGia::where('isDelete',false)->where('maTCDG',$request->maTCDG)->first();
        //duyêt tenTCCD[]
        //duyệt diemTCCD[]
        $tenTCCD=$request->tenTCCD;
        $diemTCCD=$request->diemTCCD;
        for ($i=0; $i < count($tenTCCD); $i++) { 
            tieuChiChamDiem::create(['tenTCCD'=>$tenTCCD[$i],'diemTCCD'=>$diemTCCD[$i],'maCDR3'=>$request->maCDR3]);
            $tccd=tieuChiChamDiem::orderBy('maTCCD','desc')->first();
            $ch_tccd=new cauHoi_tieuChiChamDiem();
            $ch_tccd->maCauHoi=$ch->maCauHoi;
            $ch_tccd->maTCCD=$tccd->maTCCD;
            $ch_tccd->maTCDG=$tc->maTCDG;
            $ch_tccd->save();
        }
        return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function xoa_phieu_cham($maDe,$maSSV)
    {
        $phieucham=phieu_cham::where('maDe',$maDe)->where('maSSV',$maSSV)->get();
        if($phieucham){
            $dg=danhGia::where('isDelete',false)->where('maPhieuCham',$phieucham->maPhieuCham)->get();
            if($dg){
                alert()->warning('Phiêu chấm có dữ liệu không thể xóa!','Message');
                return back();
            }else{
                foreach ($phieucham as $pc) {
                    $pc->delete();
                }
                alert()->success('Xóa thành công!','Message');
                return back();
            }
        }else{
            alert()->warning('Không thấy phiếu chấm!','Message');
            return back();
        }
        return back();
    }

    public function sua_ten_de_tai(Request  $request)
    {
        $dethi=deThi::where('maDe',$request->maDe)->first();
        if($dethi){
            $dethi->tenDe=$request->tenDe;
            $dethi->save();
            alert()->success('Editing  successfully!','Message');
            return back();
        }

    }
    
}
