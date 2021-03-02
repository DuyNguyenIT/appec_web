<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\sinhVien;
use App\Models\giangVien;
use App\Models\noiDungQH;
use App\Models\phieu_cham;
use App\Models\baiQuyHoach;
use App\Models\chuong_ndqh;
use App\Models\loaiDanhGia;
use App\Models\mucDoDanhGia;
use Illuminate\Http\Request;
use App\Models\chuong_cauhoi;
use App\Models\loaiHTDanhGia;
use App\Models\phanBoNoiDung;
use App\Models\hocPhan_kqHTHP;
use App\Models\tieuChiChamDiem;
use App\Models\ct_bai_quy_hoach;
use App\Models\quyHoach_hocPhan;
use App\Models\tieuChuanDanhGia;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;
use App\Models\cauHoi_tieuChiChamDiem;


class quyhoachController extends Controller
{

    ///giang-vien/quy-hoach-danh-gia
    public function index(Type $var = null)
    {
        $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })->groupBy('maBaiQH')->distinct()->get();
        return view('giangvien.quyhoach.quyhoach',['gd'=>$gd]);
    }

    ///giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/220104/1/HK1/2020-2021/DA16TT
    public function quy_hoach_ket_qua_hoc_tap(Request $request,$maHocPhan,$maBaiQH,$maHK,$namHoc,$maLop)
    {
       try {
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
        
           return view('giangvien.quyhoach.quyhoachketqua',['qh'=>$qh,'hp'=>$hp,
           'ldg'=>$ldg,'lhtdg'=>$lhtdg]);

       } catch (\Throwable $th) {
           return $th;
       }
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
        $kqht=kqHTHP::where('isDelete',false)->get();
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

    public function them_cau_hoi_tu_luan(Type $var = null)
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
                return view('giangvien.quyhoach.noidungdanhgia.xemnddanhgiatuluan',['dethi'=>$dethi]);
            }


            //------------------------------trắc nghiệm
            if ($maLoaiHTDG->maLoaiHTDG=="T2") { 
                return view('giangvien.quyhoach.noidungdanhgia.xemnddanhgiatracnghiem');
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
     public function them_de_thi_tu_luan(Type $var = null)
     { 
         return view('giangvien.quyhoach.noidungdanhgia.themdethituluan');
     }
    
    public function them_de_thi_tu_luan_submit(Request $request)  //thêm tiêu đèn, ngày thi, giờ thi,...
    {
        try {
            deThi::create(['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,'tenDe'=>$request->tenDe,'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
            alert()->success('Thêm thành công', 'Thông báo');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        } catch (\Throwable $th) {
            return  $th;
        }
    }

    public function cau_truc_de_luan(Request $request,$maDe) //hàm này tạm không dùng
    {
        $kqht=kqHTHP::all();
        $pb=phanBoNoiDung::where('maDe',$maDe)->with('kqht')->get();
        
        return view('giangvien.quyhoach.noidungdanhgia.tuluan.cautrucde',['maDe'=>$maDe,'kqht'=>$kqht,'phanBo'=>$pb]);
    }

    public function them_cau_truc_de_luan(Request $request) //hàm này tạm không dùng
    {
        try {
            //code...
            phanBoNoiDung::create(['maDe'=>$request->maDe,'maKQHT'=>$request->maKQHT,'soCauHoi'=>$request->soCauHoi,'diemNhomKQHT'=>$request->diemNhomKQHT]);
            alert()->success('Thêm thành công!!','Thông báo');
            return back();
        } catch (\Throwable $th) {
            return $th;
        }
       
    }

    public function cau_truc_noi_dung_de_luan(Request $request,$maDe)
    {
        $md=deThi::findOrFail($maDe);
        return view('GiangVien.quyhoach.noidungdanhgia.tuluan.cautrucnoidungdeluan');
    }

    public function them_cau_truc_noi_dung_de_luan_submit(Request $request)
    {
        
    }

    
    //////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////KHU VỰC HÀM CHO TRẮC NGHIỆM///////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////

    public function them_de_thi_trac_nghiem(Type $var = null)
    {
        return view('giangvien.quyhoach.noidungdanhgia.themdethitracnghiem');
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
        if(!$ct_bqh->maGV_2){
            $ct_bqh->maGV_2=$request->maGV_2;
            $ct_bqh->update();
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Mời chấm báo cáo thành công!');
        }else{
            return back()->with('warning!','Đã mời 1 giảng viên cộng tác, không thể mời thêm!');
        }
        //nếu chưa được mời thì tiến hành lưu dữ liệu
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
                phieuCham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
                //cb2
                phieuCham::create(['maGV'=>$ct_bqh->maGV_2,'loaiCB'=>2,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
                alert()->success('Thêm thành công!!','Thông báo');
                return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            }
            else{
                //cb1
                phieuCham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
                //cb2
                phieuCham::create(['maGV'=>$request->maGV_2,'loaiCB'=>2,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
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

        $cdr3=giangDay::where('giangday.isDelete',false)
        ->where('giangday.maBaiQH',Session::get('maBaiQH'))
        ->leftjoin('cdr_cd3',function($x){
            $x->on('cdr_cd3.maCDR3','=','giangday.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        //->get();
        ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
     
        //kqht
        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',Session::get('maHocPhan'))
        ->groupBy('hocphan_kqht_hp.maKQHT')->distinct()
        ->join('kqht_hp',function($x){
            $x->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })->get(['kqht_hp.maKQHT','kqht_hp.tenKQHT']);
        
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
        tieuChiChamDiem::create(['tenTCDG'=>$request->tenTCDG,'maNoiDungQH'=>$request->maNoiDungQH,'diem'=>$request->diemTCDG]);
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
    
}
