<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\cauHoi;
use App\Models\danhGia;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\giangVien;
use App\Models\noiDungQH;
use App\Models\baiQuyHoach;
use App\Models\loaiDanhGia;
use App\Models\deThi_cauHoi;
use Illuminate\Http\Request;
use App\Models\loaiHTDanhGia;
use App\Models\danhgia_tuluan;
use App\Models\ct_bai_quy_hoach;
use App\Models\tieuChuanDanhGia;
use App\Http\Controllers\Controller;
use App\Http\Controllers\xuLyThongKeController;

class GVThongkeController extends Controller
{

    //______________________________________________________________________
    //----------------------   THỰC HÀNH -----------------------------------
    //_______________________________________________________________________
    //LO
    public function thong_ke_theo_kqht_thuc_hanh($maCTBaiQH)
    {
        # code...
        Session::put('maCTBaiQH',$maCTBaiQH);

    }

    public function get_kqht_thuc_hanh(Type $var = null)
    {
        # code...
    }
    
    //abet
    public function thong_ke_theo_abet_thuc_hanh($maCTBaiQH) //chay
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        //lấy danh sách cdr3
        $bieuDo=xuLyThongKeController::thong_ke_abet($maCTBaiQH);
        return view('giangvien.thongke.thuchanh.thongketheoabet',['bieuDo'=>$bieuDo]);
    }
    public function get_abet_thuc_hanh() // chạy
    {
          $bieuDo=xuLyThongKeController::thong_ke_abet(session::get('maCTBaiQH'));
          return response()->json($bieuDo);
    }
    //xep hang
    public function thong_ke_theo_xep_hang_thuc_hanh($maCTBaiQH) //chạy
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        //học phần
         //đề thi
         $dethi=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)->get();
         if($dethi->count()==0)
         {
             if(session::has('language') && session::get('language')=='vi'){
                alert()->warning('There are no examination!','Message');
             }else{
                alert()->warning('Không có bài thi nào!','Thông báo');
             }
             return redirect('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/'.session::get('maGV').'/'.session::get('maHocPhan').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop'));
         } 
    
        //xếp hạng
        $xepHang=xuLyThongKeController::thong_ke_xep_hang($maCTBaiQH,Session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_ke_ti_le_xep_hang($maCTBaiQH,Session::get('maGV'));
        return view('giangvien.thongke.thuchanh.thongkexephang',['xepHang'=>$xepHang,
        'tiLe'=>$tiLe]);
    }

    public function get_xep_hang_thuc_hanh() //chạy
    {
        return response()->json(xuLyThongKeController::thong_ke_xep_hang(Session::get('maCTBaiQH'),Session::get('maGV')));
    }   

    //diem chu
    public function thong_ke_theo_diem_chu_thuc_hanh($maCTBaiQH) //chạy
    {

        Session::put('maCTBaiQH',$maCTBaiQH);

        //học phần 
        $hp=hocPhan::where('isDelete',false)
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->first();
       
        
        //đề thi
        $dethi=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['maPhieuCham','diemChu']);
        if($dethi->count()==0)
        {
            alert()->warning('There are no examination!','Message');
            return redirect('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/'.session::get('maGV').'/'.session::get('maHocPhan').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop'));
        } 
        $diemChu=[];
        $tiLe=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
            array_push($tiLe,number_format($dethi->where('diemChu',$lt)->count()*100/$dethi->count(),2));
        }
        
        return view('giangvien.thongke.thuchanh.thongketheodiemchu',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
        'hp'=>$hp,'chu'=>$letter]);
    }

    public function get_diem_chu_thuc_hanh() //chạy
    {
        $diemChu=[];
        $dethi=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['maPhieuCham','diemChu']);
       
        $diemChu=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
        }
        return response()->json($diemChu);
    }

    //tieu chí
     public function thong_ke_theo_tieu_chi_thuc_hanh($maCTBaiQH)
     {
        Session::put('maCTBaiQH',$maCTBaiQH);

        $bieuDo=xuLyThongKeController::thong_ke_CDR3($maCTBaiQH);
        //infor
        $hp=hocPhan::findOrFail(session::get('maHocPhan'));
 
         return view('giangvien.thongke.thuchanh.thongketheotieuchi',['bieuDo'=>$bieuDo,'hocPhan'=>$hp]);
 
     }

     public function get_tieu_chi_thuc_hanh()
     {
        $bieuDo=xuLyThongKeController::thong_ke_CDR3(session::get('maCTBaiQH'));
         return response()->json($bieuDo);
     }

     //______________________________________________________________________
     ///----------------------------------------------TỰ LUẬN----------------
     //______________________________________________________________________
     //ket qua hoc tap
     public function thong_ke_theo_qkht_tu_luan(Type $var = null)
     {
         # code...
     }

     public function get_kqht_tu_luan(Type $var = null)
     {
         # code...
     }

     //tieu chí
      public function thong_ke_theo_tieu_chi_tu_luan($maCTBaiQH) //chạy
      {
         Session::put('maCTBaiQH',$maCTBaiQH);
 
         $bieuDo=xuLyThongKeController::thong_ke_CDR3($maCTBaiQH);
         //infor
         $hp=hocPhan::findOrFail(session::get('maHocPhan'));
  
          return view('giangvien.thongke.tuluan.thongketheotieuchi',['bieuDo'=>$bieuDo,'hocPhan'=>$hp]);
  
      }
      public function get_tieu_chi_tu_luan() //chạy
      {
         $bieuDo=xuLyThongKeController::thong_ke_CDR3(session::get('maCTBaiQH'));
          return response()->json($bieuDo);
      }

      //abet
      public function thong_ke_theo_abet_tu_luan($maCTBaiQH) //chạy
      {
          Session::put('maCTBaiQH',$maCTBaiQH);
           //lấy danh sách cdr3
          $bieuDo=xuLyThongKeController::thong_ke_abet($maCTBaiQH);
          return view('giangvien.thongke.tuluan.thongketheoabet',['bieuDo'=>$bieuDo]);
  
      }
      public function get_abet_tu_luan() // chạy
      {
          $bieuDo=xuLyThongKeController::thong_ke_abet(session::get('maCTBaiQH'));
          return response()->json($bieuDo);
      }

      //xếp hạng
    public function thong_ke_theo_xep_hang_tu_luan($maCTBaiQH) // chạy
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        //học phần

         //đề thi
         $dethi=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)->get();
         if($dethi->count()==0)
         {
             alert()->warning('There are no examination!','Message');
             return redirect('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/'.session::get('maGV').'/'.session::get('maHocPhan').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop'));
         } 
        
        $xepHang=xuLyThongKeController::thong_ke_xep_hang($maCTBaiQH,Session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_ke_ti_le_xep_hang($maCTBaiQH,Session::get('maGV'));

        return view('giangvien.thongke.tuluan.thongkexephang',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);


    }

    public function get_xep_hang_tu_luan() // chạy
    {
        return response()->json(xuLyThongKeController::thong_ke_xep_hang(session::get('maCTBaiQH'),Session::get('maGV')));
    }
    //tiêu chí
    public function thong_ke_theo_diem_chu_tu_luan($maCTBaiQH) //chay
    {

        Session::put('maCTBaiQH',$maCTBaiQH);

        //học phần 
        $hp=hocPhan::where('isDelete',false)
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->first();
    
        //check de thi
        $dethi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        
        if($dethi->count()==0)
        {
            if(session::has('language') && session::get('language')=='vi'){
                alert()->warning('Không có đề thi nào!','Thong báo');
            }else{
                alert()->warning('There are no examination!','Message');
            }
            return redirect()->back();
        } 

        $diemChu=xuLyThongKeController::thong_ke_diem_chu($maCTBaiQH,session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_le_ti_le_diem_chu($maCTBaiQH,session::get('maGV'));
        $letter=['A','B+','B','C+','C','D+','D','F'];
     
        return view('giangvien.thongke.tuluan.thongketheodiemchu',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
        'hp'=>$hp,'chu'=>$letter]);
    }

    public function get_diem_chu_tu_luan() //chay
    {
        $diemChu=[];
        $dethi=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['maPhieuCham','diemChu']);
       
        $diemChu=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
        }
        return response()->json($diemChu);
    }

    //__________________________________________________________________
    //------------------------------------------------TRẮC NGHIỆM------
    //___________________________________________________________________
    //xep hang
    public function thong_ke_theo_xep_hang_trac_nghiem($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
         //đề thi
         $dethi=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)->get();
         if($dethi->count()==0)
         {
             alert()->warning('There are no examination!','Message');
             return redirect('/giang-vien/thong-ke/thong-ke-theo-hoc-phan/'.session::get('maGV').'/'.session::get('maHocPhan').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop'));
         } 
        
        $xepHang=xuLyThongKeController::thong_ke_xep_hang($maCTBaiQH,Session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_ke_ti_le_xep_hang($maCTBaiQH,Session::get('maGV'));

        return view('giangvien.thongke.tracnghiem.thongkexephang',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);
    }
    
    public function get_xep_hang_trac_nghiem()
    {
        return response()->json(xuLyThongKeController::thong_ke_xep_hang(session::get('maCTBaiQH'),Session::get('maGV')));
    }

    //diem chu
    public function thong_ke_theo_diem_chu_trac_nghiem($maCTBaiQH) //chạy
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        //check de thi
        $dethi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        
        if($dethi->count()==0)
        {
            if(session::has('language') && session::get('language')=='vi'){
                alert()->warning('Không có đề thi nào!','Thong báo');
            }else{
                alert()->warning('There are no examination!','Message');
            }
            return redirect()->back();
        } 

        $diemChu=xuLyThongKeController::thong_ke_diem_chu($maCTBaiQH,session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_le_ti_le_diem_chu($maCTBaiQH,session::get('maGV'));
        $letter=['A','B+','B','C+','C','D+','D','F'];
        return view('giangvien.thongke.tracnghiem.thongketheodiemchu',['diemChu'=>$diemChu,
        'tiLe'=>$tiLe,'chu'=>$letter]);
    }
    public function get_diem_chu_trac_nghiem() //chạy
    {
        $diemChu=[];
        $dethi=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['maPhieuCham','diemChu']);
       
        $diemChu=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
        }
        return response()->json($diemChu);
    }

    //tieu chi
    public function thong_ke_theo_tieu_chi_trac_nghiem($maCTBaiQH)
    {
        # code...
    }
    public function get_tieu_chi_trac_nghiem()
    {
        # code...
    }
    //abet
    public function thong_ke_theo_abet_trac_nghiem($maCTBaiQH)
    {
        # code...
    }
    public function get_abet_trac_nghiem()
    {
        # code...
    }
    //____________________________________________________________________
    //------------------------------------------------ĐỒ ÁN---------------
    //____________________________________________________________________
    //xep hang
    public function thong_ke_theo_xep_hang_doan($maCTBaiQH,$maCanBo)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        Session::put('maCanBo',$maCanBo);

        //ct bai quy hoach
        $ct_baiQH=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->leftjoin('loai_ht_danhgia',function($x){
            $x->on('ct_bai_quy_hoach.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
            ->where('ct_bai_quy_hoach.isDelete',false);
        })
        ->first();

        
        Session::put('maGV_2',$ct_baiQH->maGV_2);

        if($maCanBo==1){
            $dethi=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['maPhieuCham','xepHang']);
            if($dethi->count()==0)
            {
                alert()->warning('There are no examination!','Message');
                return redirect()->back();
            } 
        }
        else{
            $dethi=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['maPhieuCham','xepHang']);
            if($dethi->count()==0)
            {
                alert()->warning('There are no examination!','Message');
                return redirect()->back();
            } 
        }
       

        $xepHang=[];
        $tiLe=[];
        for ($i=1; $i <=5 ; $i++) { 
            array_push($xepHang,$dethi->where('xepHang',$i)->count());
            $rate=$dethi->where('xepHang',$i)->count()*100/$dethi->count('maPhieuCham');
            array_push($tiLe,$rate);
        }

        return view('giangvien.thongke.doan.thongketheoxephang',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);
    }

    public function get_xep_hang_doan()
    {
        if(Session::get('maCanBo')==1){
            $dethi=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['maPhieuCham','xepHang']);
        }
        else{
            $dethi=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['maPhieuCham','xepHang']);
        }
        $xepHang=[];
        $tiLe=[];
        for ($i=1; $i <=5 ; $i++) { 
            array_push($xepHang,$dethi->where('xepHang',$i)->count());
            $rate=$dethi->where('xepHang',$i)->count()*100/$dethi->count('maPhieuCham');
            array_push($tiLe,$rate);
        }
        return response()->json($xepHang);
    }

    //diem chu
    public function thong_ke_theo_diem_chu_doan($maCTBaiQH,$maCanBo) //chạy
    {

        Session::put('maCTBaiQH',$maCTBaiQH);
        Session::put('maCanBo',$maCanBo);
        //học phần 
        $hp=hocPhan::where('isDelete',false)
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->first();
        //ct bai quy hoach
        $ct_baiQH=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->leftjoin('loai_ht_danhgia',function($x){
            $x->on('ct_bai_quy_hoach.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
            ->where('ct_bai_quy_hoach.isDelete',false);
        })
        ->first();
        
        Session::put('maGV_2',$ct_baiQH->maGV_2);
        
        if ($maCanBo==1) {
           //phiếu chấm
            $dethi=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['maPhieuCham','diemChu']);
        } else {
             //phiếu chấm
             $dethi=deThi::where('de_thi.isDelete',false)
             ->where('maCTBaiQH',$maCTBaiQH)
             ->join('phieu_cham',function($x){
                 $x->on('phieu_cham.maDe','=','de_thi.maDe')
                 ->where('phieu_cham.maGV',Session::get('maGV_2'))
                 ->where('phieu_cham.isDelete',false);
             })
             ->get(['maPhieuCham','diemChu']);
        }
    
        $diemChu=[];
        $tiLe=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
            array_push($tiLe,$dethi->where('diemChu',$lt)->count()*100/$dethi->count());
        }
        return view('giangvien.thongke.doan.thongketheodiemchu',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
        'hp'=>$hp,'chu'=>$letter,'ct_baiQH'=>$ct_baiQH]);
    }

    public function get_diem_chu_doan() //chạy
    {
        $diemChu=[];
        if (Session::get('maCanBo')==1) {
            //phiếu chấm
             $dethi=deThi::where('de_thi.isDelete',false)
             ->where('maCTBaiQH',Session::get('maCTBaiQH'))
             ->join('phieu_cham',function($x){
                 $x->on('phieu_cham.maDe','=','de_thi.maDe')
                 ->where('phieu_cham.maGV',Session::get('maGV'))
                 ->where('phieu_cham.isDelete',false);
             })
             ->get(['maPhieuCham','diemChu']);
         } else {
              //phiếu chấm
              $dethi=deThi::where('de_thi.isDelete',false)
              ->where('maCTBaiQH',Session::get('maCTBaiQH'))
              ->join('phieu_cham',function($x){
                  $x->on('phieu_cham.maDe','=','de_thi.maDe')
                  ->where('phieu_cham.maGV',Session::get('maGV_2'))
                  ->where('phieu_cham.isDelete',false);
              })
              ->get(['maPhieuCham','diemChu']);
         }
       
        $diemChu=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
        }
        return response()->json($diemChu);
    }


    //tiêu chí
    public function thong_ke_theo_tieu_chi_doan($maCTBaiQH,$maCanBo) //chạy
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        Session::put('maCanBo',$maCanBo);
        //lấy danh sách cdr3
        ////maCTBaiQH-->noiDungQH
        $ndqh=noiDungQH::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->get();
         //ct bai quy hoach
         $ct_baiQH=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->leftjoin('loai_ht_danhgia',function($x){
             $x->on('ct_bai_quy_hoach.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
             ->where('ct_bai_quy_hoach.isDelete',false);
         })
         ->first();
        Session::put('maGV_2',$ct_baiQH->maGV_2);

        $chuan_dau_ra3=[];
        $tieuchi=[];
        foreach ($ndqh as $key => $x) {
            ////noiDungQh->(tieuchuan+tieuChi+cdr3)
            $temp=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })
            ->join('cdr_cd3',function($y){
                $y->on('cdr_cd3.maCDR3','=','tieu_chi_cham_diem.maCDR3')
                ->where('cdr_cd3.isDelete',false);
            })
            ->distinct(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3'])
            ->orderBy('cdr_cd3.maCDR3')
            ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
            
            $temp_tc=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })->get(['tieu_chi_cham_diem.maTCCD','tieu_chi_cham_diem.diemTCCD','tieu_chi_cham_diem.maCDR3']);
            foreach ($temp as $t) {
                array_push($chuan_dau_ra3,$t);
            }
            foreach ($temp_tc as $tc) {
                array_push($tieuchi,$tc);
            }
        }

        //điếm số phiếu chấm có đủ các tiêu chí trong chuẩn đẩu ra
        ///
        if($maCanBo==1){
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }else{
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }
        $bieuDo=[];
        foreach ($chuan_dau_ra3 as $cdr3) {
            $temp=[];
            array_push($temp,$cdr3->maCDR3VB);
            array_push($temp,$cdr3->tenCDR3);
           
            $gioi=0;
            $kha=0;
            $tb=0;
            $yeu=0;
            $kem=0;

            $diem_tieu_chi=0;
            foreach ($tieuchi as $tc) {
                if($tc->maCDR3==$cdr3->maCDR3){
                    $diem_tieu_chi=$diem_tieu_chi+$tc->diemTCCD;
                }
            }
        
            foreach ($phieuCham as $pc) {
                $t=$cdr3->maCDR3;
                /////////
                //điếm theo phiếu chấm
                $dem=danhGia::where('danh_gia.isDelete',false)
                ->where('maPhieuCham',$pc->maPhieuCham)
                ->join('tieu_chi_cham_diem',function($x) use ($t){
                    $x->on('danh_gia.maTCCD','=','tieu_chi_cham_diem.maTCCD')
                    ->where('tieu_chi_cham_diem.maCDR3',$t)
                    ->where('tieu_chi_cham_diem.isDelete',false);
                })
                ->sum('danh_gia.diemDG');
                $tile=$dem/$diem_tieu_chi;
                if($tile<0.25){
                    $kem++;
                }else{
                    if($tile>=0.25 && $tile<0.5){
                        $yeu++;
                    }else{
                        if($tile>=0.5 && $tile<0.75){
                            $tb++;
                        }else{
                            if($tile>=0.75 && $tile<0.85){
                                $kha++;
                            }else{
                                $gioi++;
                            }
                        }
                    }
                }
            }


            array_push($temp,$gioi);
            array_push($temp,$kha);
            array_push($temp,$tb);
            array_push($temp,$yeu);
            array_push($temp,$kem);
            array_push($bieuDo,$temp);
        }
        

        return view('giangvien.thongke.doan.thongketheotieuchi',['bieuDo'=>$bieuDo]);
    }

    public function get_tieu_chi_doan() //chạy
    {
        $ndqh=noiDungQH::where('isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->get();
        ////noiDungQh->(tieuchuan+tieuChi+cdr3)
        $chuan_dau_ra3=[];
        $tieuchi=[];
 
        foreach ($ndqh as $key => $x) {
            ////noiDungQh->(tieuchuan+tieuChi+cdr3)
            $temp=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })
            ->join('cdr_cd3',function($y){
                $y->on('cdr_cd3.maCDR3','=','tieu_chi_cham_diem.maCDR3')
                ->where('cdr_cd3.isDelete',false);
            })
            ->distinct(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3'])
            ->orderBy('cdr_cd3.maCDR3')
            ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);


            $temp_tc=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })->get(['tieu_chi_cham_diem.maTCCD','tieu_chi_cham_diem.diemTCCD','tieu_chi_cham_diem.maCDR3']);
            foreach ($temp as $t) {
                array_push($chuan_dau_ra3,$t);
            }
            foreach ($temp_tc as $tc) {
                array_push($tieuchi,$tc);
            }
        }
        //điếm số phiếu chấm có đủ các tiêu chí trong chuẩn đẩu ra
        ///
        if(Session::get('maCanBo')==1){
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }else{
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }
        $bieuDo=[];
        foreach ($chuan_dau_ra3 as $cdr3) {
            $temp=[];
            array_push($temp,$cdr3->maCDR3VB);
            array_push($temp,$cdr3->tenCDR3);

            $gioi=0;
            $kha=0;
            $tb=0;
            $yeu=0;
            $kem=0;
           
            $diem_tieu_chi=0;
            foreach ($tieuchi as $tc) {
                if($tc->maCDR3==$cdr3->maCDR3){
                    $diem_tieu_chi=$diem_tieu_chi+$tc->diemTCCD;
                }
            }

            foreach ($phieuCham as $pc) {
                $t=$cdr3->maCDR3;
                /////////
                //điếm theo phiếu chấm
                $dem=danhGia::where('danh_gia.isDelete',false)
                ->where('maPhieuCham',$pc->maPhieuCham)
                ->join('tieu_chi_cham_diem',function($x) use ($t){
                    $x->on('danh_gia.maTCCD','=','tieu_chi_cham_diem.maTCCD')
                    ->where('tieu_chi_cham_diem.maCDR3',$t)
                    ->where('tieu_chi_cham_diem.isDelete',false);
                })
                ->sum('danh_gia.diemDG');
                $tile=$dem/$diem_tieu_chi;
                if($tile<0.25){
                    $kem++;
                }else{
                    if($tile>=0.25 && $tile<0.5){
                        $yeu++;
                    }else{
                        if($tile>=0.5 && $tile<0.75){
                            $tb++;
                        }else{
                            if($tile>=0.75 && $tile<0.85){
                                $kha++;
                            }else{
                                $gioi++;
                            }
                        }
                    }
                }
            }
            array_push($temp,$gioi);
            array_push($temp,$kha);
            array_push($temp,$tb);
            array_push($temp,$yeu);
            array_push($temp,$kem);
            array_push($bieuDo,$temp);
        }
        

        return response()->json($bieuDo);
    }


    //abet
    public function thong_ke_theo_abet_doan($maCTBaiQH,$maCanBo) //chạy
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        Session::put('maCanBo',$maCanBo);
        //lấy danh sách cdr3
        ////maCTBaiQH-->noiDungQH
        $ndqh=noiDungQH::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->get();
         //ct bai quy hoach
         $ct_baiQH=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->leftjoin('loai_ht_danhgia',function($x){
             $x->on('ct_bai_quy_hoach.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
             ->where('ct_bai_quy_hoach.isDelete',false);
         })
         ->first();
        Session::put('maGV_2',$ct_baiQH->maGV_2);

        $chuan_abet=[];
        $tieuchi=[];
        foreach ($ndqh as $key => $x) {
            ////noiDungQh->(tieuchuan+tieuChi+cdr3)
            $temp=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })
            ->join('chuan_abet',function($y){
                $y->on('chuan_abet.maChuanAbet','=','tieu_chi_cham_diem.maChuanAbet')
                ->where('chuan_abet.isDelete',false);
            })
            ->distinct(['chuan_abet.maChuanAbet','chuan_abet.maChuanAbetVB','chuan_abet.tenChuanAbet'])
            ->orderBy('chuan_abet.maChuanAbet')
            ->get(['chuan_abet.maChuanAbet','chuan_abet.maChuanAbetVB','chuan_abet.tenChuanAbet']);
            
            $temp_tc=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })->get(['tieu_chi_cham_diem.maTCCD','tieu_chi_cham_diem.diemTCCD','tieu_chi_cham_diem.maChuanAbet']);
            foreach ($temp as $t) {
                array_push($chuan_abet,$t);
            }
            foreach ($temp_tc as $tc) {
                array_push($tieuchi,$tc);
            }
        }

        //điếm số phiếu chấm có đủ các tiêu chí trong chuẩn đẩu ra
        ///
        if($maCanBo==1){
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }else{
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }

        $bieuDo=[];
        foreach ($chuan_abet as $abet) {
            $temp=[];
            array_push($temp,$abet->maChuanAbetVB);
            array_push($temp,$abet->tenChuanAbet);
           
            $gioi=0;
            $kha=0;
            $tb=0;
            $yeu=0;
            $kem=0;

            $diem_tieu_chi=0;
            foreach ($tieuchi as $tc) {
                if($tc->maChuanAbet==$abet->maChuanAbet){
                    $diem_tieu_chi=$diem_tieu_chi+$tc->diemTCCD;
                }
            }
        
            foreach ($phieuCham as $pc) {
                $t=$abet->maChuanAbet;
                /////////
                //điếm theo phiếu chấm
                $dem=danhGia::where('danh_gia.isDelete',false)
                ->where('maPhieuCham',$pc->maPhieuCham)
                ->join('tieu_chi_cham_diem',function($x) use ($t){
                    $x->on('danh_gia.maTCCD','=','tieu_chi_cham_diem.maTCCD')
                    ->where('tieu_chi_cham_diem.maChuanAbet',$t)
                    ->where('tieu_chi_cham_diem.isDelete',false);
                })
                ->sum('danh_gia.diemDG');
               
                $tile=$dem/$diem_tieu_chi;
                if($tile<0.25){
                    $kem++;
                }else{
                    if($tile>=0.25 && $tile<0.5){
                        $yeu++;
                    }else{
                        if($tile>=0.5 && $tile<0.75){
                            $tb++;
                        }else{
                            if($tile>=0.75 && $tile<0.85){
                                $kha++;
                            }else{
                                $gioi++;
                            }
                        }
                    }
                }
            }


            array_push($temp,$gioi);
            array_push($temp,$kha);
            array_push($temp,$tb);
            array_push($temp,$yeu);
            array_push($temp,$kem);
            array_push($bieuDo,$temp);
        }
        

        return view('giangvien.thongke.doan.thongketheoabet',['bieuDo'=>$bieuDo]);
    }


    public function get_abet_doan() //chạy
    {
        $ndqh=noiDungQH::where('isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->get();
        ////noiDungQh->(tieuchuan+tieuChi+cdr3)
        $chuan_abet=[];
        $tieuchi=[];
        foreach ($ndqh as $key => $x) {
            ////noiDungQh->(tieuchuan+tieuChi+cdr3)
            $temp=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })
            ->join('chuan_abet',function($y){
                $y->on('chuan_abet.maChuanAbet','=','tieu_chi_cham_diem.maChuanAbet')
                ->where('chuan_abet.isDelete',false);
            })
            ->distinct(['chuan_abet.maChuanAbet','chuan_abet.maChuanAbetVB','chuan_abet.tenChuanAbet'])
            ->orderBy('chuan_abet.maChuanAbet')
            ->get(['chuan_abet.maChuanAbet','chuan_abet.maChuanAbetVB','chuan_abet.tenChuanAbet']);
            
            $temp_tc=tieuChuanDanhGia::where('tieuchuan_danhgia.isDelete',false)
            ->where('tieuchuan_danhgia.maNoiDungQH',$x->maNoiDungQH)
            ->join('cau_hoi_tcchamdiem',function($x){
                $x->on('tieuchuan_danhgia.maTCDG','=','cau_hoi_tcchamdiem.maTCDG')
                ->where('cau_hoi_tcchamdiem.isDelete',false);
            })
            ->groupBy('cau_hoi_tcchamdiem.maTCCD')
            ->join('tieu_chi_cham_diem',function($q){
                $q->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                ->where('tieu_chi_cham_diem.isDelete',false);
            })->get(['tieu_chi_cham_diem.maTCCD','tieu_chi_cham_diem.diemTCCD','tieu_chi_cham_diem.maChuanAbet']);
            foreach ($temp as $t) {
                array_push($chuan_abet,$t);
            }
            foreach ($temp_tc as $tc) {
                array_push($tieuchi,$tc);
            }
        }

        //điếm số phiếu chấm có đủ các tiêu chí trong chuẩn đẩu ra
        ///
        if(Session::get('maCanBo')==1){
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }else{
            $phieuCham=deThi::where('de_thi.isDelete',false)
            ->where('maCTBaiQH',Session::get('maCTBaiQH'))
            ->join('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->where('phieu_cham.isDelete',false);
            })
            ->get(['phieu_cham.maPhieuCham']);
        }

        $bieuDo=[];
        foreach ($chuan_abet as $abet) {
            $temp=[];
            array_push($temp,$abet->maChuanAbetVB);
            array_push($temp,$abet->tenChuanAbet);
           
            $gioi=0;
            $kha=0;
            $tb=0;
            $yeu=0;
            $kem=0;

            $diem_tieu_chi=0;
            foreach ($tieuchi as $tc) {
                if($tc->maChuanAbet==$abet->maChuanAbet){
                    $diem_tieu_chi=$diem_tieu_chi+$tc->diemTCCD;
                }
            }
        
            foreach ($phieuCham as $pc) {
                $t=$abet->maChuanAbet;
                /////////
                //điếm theo phiếu chấm
                $dem=danhGia::where('danh_gia.isDelete',false)
                ->where('maPhieuCham',$pc->maPhieuCham)
                ->join('tieu_chi_cham_diem',function($x) use ($t){
                    $x->on('danh_gia.maTCCD','=','tieu_chi_cham_diem.maTCCD')
                    ->where('tieu_chi_cham_diem.maChuanAbet',$t)
                    ->where('tieu_chi_cham_diem.isDelete',false);
                })
                ->sum('danh_gia.diemDG');
                $tile=$dem/$diem_tieu_chi;
                if($tile<0.25){
                    $kem++;
                }else{
                    if($tile>=0.25 && $tile<0.5){
                        $yeu++;
                    }else{
                        if($tile>=0.5 && $tile<0.75){
                            $tb++;
                        }else{
                            if($tile>=0.75 && $tile<0.85){
                                $kha++;
                            }else{
                                $gioi++;
                            }
                        }
                    }
                }
            }


            array_push($temp,$gioi);
            array_push($temp,$kha);
            array_push($temp,$tb);
            array_push($temp,$yeu);
            array_push($temp,$kem);
            array_push($bieuDo,$temp);
        }

        return response()->json($bieuDo);
    }
}
