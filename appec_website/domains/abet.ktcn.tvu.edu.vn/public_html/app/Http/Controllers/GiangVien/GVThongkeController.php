<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\cauHoi;
use App\Models\kqHTHP;
use App\Models\danhGia;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\giangVien;
use App\Models\noiDungQH;
use App\Models\chuan_abet;
use App\Models\baiQuyHoach;
use App\Models\loaiDanhGia;
use App\Models\deThi_cauHoi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\loaiHTDanhGia;
use App\Models\danhgia_tuluan;
use App\Models\ct_bai_quy_hoach;
use App\Models\tieuChuanDanhGia;
use App\Models\danhgia_tracnghiem;
use App\Http\Controllers\Controller;
use App\Models\thongke_abet_hocphan;
use App\Models\cauHoi_tieuChiChamDiem;
use App\Exports\thongke\doan\doAnSOExport;
use App\Http\Controllers\CommonController;
use App\Exports\thongke\doan\doAnCLOExport;
use App\Exports\thongke\doan\doAnAbetExport;
use App\Exports\thongke\doan\doAnRankExport;
use App\Exports\thongke\doan\doAnGrateExport;
use App\Http\Controllers\xuLyThongKeController;
use App\Exports\thongke\thuchanh\thucHanhSOExport;
use App\Exports\thongke\thuchanh\thucHanhCLOExport;
use App\Exports\thongke\thuchanh\thucHanhAbetExport;
use App\Exports\thongke\thuchanh\thucHanhRankExport;
use App\Exports\thongke\thuchanh\thucHanhGrateExport;
use App\Exports\thongke\tracnghiem\tracnghiemSOExport;
use App\Exports\thongke\tracnghiem\tracnghiemCLOExport;
use App\Exports\thongke\tracnghiem\tracnghiemAbetExport;
use App\Exports\thongke\tracnghiem\tracnghiemRankExport;
use App\Exports\thongke\tracnghiem\tracnghiemGrateExport;

class GVThongkeController extends Controller
{

    //______________________________________________________________________
    //----------------------   THỰC HÀNH -----------------------------------
    //_______________________________________________________________________
    //LO
    //ket qua hoc tap
    public function thong_ke_theo_qkht_thuc_hanh($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        $bieuDo=xuLyThongKeController::thong_ke_kqht($maCTBaiQH);
       return view('giangvien.thongke.thuchanh.thongketheokqht',compact('bieuDo'));
    }

    public function get_kqht_thuc_hanh(Type $var = null)
    {
        return xuLyThongKeController::thong_ke_kqht(Session::get('maCTBaiQH'));
    }

    public function export_thong_ke_theo_clo_thuc_hanh(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhCLOExport,'thong_ke_clo_thuc_hanh.xlsx');
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

    public function export_thong_ke_theo_abet_thuc_hanh(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhAbetExport,'thong_ke_abet_thuc_hanh.xlsx');
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
    public function export_thong_ke_theo_xep_hang_thuc_hanh(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhRankExport,'thong_ke_xep_hang_thuc_hanh.xlsx');
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

    public function export_thong_ke_theo_diem_chu_thuc_hanh(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhGrateExport,'thong_ke_diem_chu_thuc_hanh.xlsx');
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

     public function export_thong_ke_theo_tieu_chi_thuc_hanh(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhSOExport,'thong_ke_diem_tieu_chi_hanh.xlsx');
    }

     //______________________________________________________________________
     ///----------------------------------------------TỰ LUẬN----------------
     //______________________________________________________________________
     //ket qua hoc tap
     public function thong_ke_theo_qkht_tu_luan($maCTBaiQH)
     {
         Session::put('maCTBaiQH',$maCTBaiQH);
        $bieuDo=xuLyThongKeController::thong_ke_kqht($maCTBaiQH);
       
        return view('giangvien.thongke.tuluan.thongketheokqht',compact('bieuDo'));
     }

     public function get_kqht_tu_luan(Type $var = null)
     {
         return xuLyThongKeController::thong_ke_kqht(Session::get('maCTBaiQH'));
     }

     public function export_thong_ke_theo_clo_tu_luan(Excel $excel,$maCTBaiQH)
     {
         Session::put('maCTBaiQH',$maCTBaiQH);
         return $excel->download(new thucHanhCLOExport,'thong_ke_clo_tu_luan.xlsx');
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
    public function export_thong_ke_theo_abet_tu_luan(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhAbetExport,'thong_ke_abet_tu_luan.xlsx');
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

    public function export_thong_ke_theo_tieu_chi_tu_luan(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhSOExport,'thong_ke_diem_tieu_chi_tu_luan.xlsx');
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
             CommonController::warning_notify('Không có đề thi nào','There are not examination');
             return redirect()->back();
         } 
        
        $xepHang=xuLyThongKeController::thong_ke_xep_hang($maCTBaiQH,Session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_ke_ti_le_xep_hang($maCTBaiQH,Session::get('maGV'));

        return view('giangvien.thongke.tuluan.thongkexephang',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);


    }

    public function get_xep_hang_tu_luan() // chạy
    {
        return response()->json(xuLyThongKeController::thong_ke_xep_hang(session::get('maCTBaiQH'),Session::get('maGV')));
    }

    public function export_thong_ke_theo_xep_hang_tu_luan(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhRankExport,'thong_ke_xep_hang_tu_luan.xlsx');
    }
    //diem chu
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
    public function export_thong_ke_theo_diem_chu_tu_luan(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new thucHanhGrateExport,'thong_ke_diem_chu_tu_luan.xlsx');
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

    public function export_thong_ke_theo_xep_hang_trac_nghiem(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new tracnghiemRankExport,'thong_ke_xep_hang_trac_nghiem.xlsx');
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
            CommonController::warning_notity('Không có đề thi nào!','There are no examination!');
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

    public function export_thong_ke_theo_diem_chu_trac_nghiem(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new tracnghiemGrateExport,'thong_ke_diem_chu_trac_nghiem.xlsx');
    }
    //tieu chi  -- SO --- CDR3
    public function thong_ke_theo_tieu_chi_trac_nghiem($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        //check de thi
        $ds_de_thi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        if($ds_de_thi->count()==0)
        {
            CommonController::warning_notity('Không có đề thi nào!','There are no examination!');
            return redirect()->back();
        } 
        
        $chuan_dau_ra3_array=[];
        $chuan_dau_ra3=[];
        $i=0;
        //tach tieu chi da duoc  su dung
        foreach($ds_de_thi as $dt){      
            //de_thi->de_thi_cauhoi-->cau_hoi
            //              |____________>phuong_an_tu_luan-->cdr_cd3
            $cdr3=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maDe',$dt->maDe)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('de_thi_cau_hoi',function($x){
                $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
            })
            ->join('phuong_an_trac_nghiem',function($x){
                $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
            })
            ->join('cdr_cd3',function($x){
                $x->on('cdr_cd3.maCDR3','=','phuong_an_trac_nghiem.maCDR3');
            })
            ->orderBy('cdr_cd3.maCDR3')
            ->get('cdr_cd3.maCDR3');
           
            //tach maCDR3 tu nhieu de thi thanh 1 mang
            foreach ($cdr3 as $value) {
                if(!in_array($value['maCDR3'],$chuan_dau_ra3_array)){
                   $chuan_dau_ra3_array[$i]=$value['maCDR3'];
                   $i++;
                }
            }
        }
        
        $chuan_dau_ra3=CDR3::whereIn('maCDR3',$chuan_dau_ra3_array)->get();
       
        //phieuCham
        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
       
        //duyet qua tieu chi
        $bieuDo=[];
        foreach ($chuan_dau_ra3 as $cdr3) {
            
            $temp=[];
            //lay noi dung cdr3
            array_push($temp,$cdr3->maCDR3VB);
            array_push($temp,$cdr3->tenCDR3);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            //duyet qua phieu cham
            foreach ($phieuCham as $pc) {
                $t=$cdr3->maCDR3;
                 //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cau_hoi',function($x){
                   $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
                })
                ->join('phuong_an_trac_nghiem',function($x){
                    $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
                })
                ->distinct(['de_thi.maDe','de_thi_cau_hoi.maCauHoi'])
                ->get(['de_thi.maDe','de_thi_cau_hoi.maCauHoi','de_thi_cau_hoi.diem','phuong_an_trac_nghiem.maCDR3']);
                
                ////tinh diem tieu chi cua phieu cham
                ////phuongan->diem_tieu_chi
                $diem_tieu_chi=$phuongan->where('maCDR3',$cdr3->maCDR3)->sum('diem');
              
                // tinh diem sinh vien dat duoc tren tieu chi
                //điếm theo phiếu chấm
                $dem=danhgia_tracnghiem::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_trac_nghiem',function($x) use ($t){
                    $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA')
                    ->where('phuong_an_trac_nghiem.maCDR3',$t);
                })
                ->sum('danhgia_tracnghiem.diem');
                
                /// tinnh ti le
                $tile=number_format($dem/$diem_tieu_chi,2);

                if($tile<0.4){
                    $cdat++;
                }else{
                    if($tile>=0.4 && $tile<0.54){
                        $dat_D++;
                    }else{
                        if($tile>=0.55 && $tile<0.69){
                            $dat_C++;
                        }else{
                            if($tile>=0.70 && $tile<0.89){
                                $dat_B++;
                            }else{
                                $dat_A++;
                            }
                        }
                    }
                }
            }
            array_push($temp,$dat_A);
            array_push($temp,$dat_B);
            array_push($temp,$dat_C);
            array_push($temp,$dat_D);
            array_push($temp,$cdat);
            array_push($bieuDo,$temp);
            $t=new xuLyThongKeController();
            $t->cap_nhat_thongke_so_hocphan($maCTBaiQH,$cdr3->maCDR3,$dat_A,$dat_B,$dat_C,$dat_D,$cdat);

        }

        return view('giangvien.thongke.tracnghiem.thongketheotieuchi',compact('bieuDo'));
    }
    public function get_tieu_chi_trac_nghiem()  //ajax ve bieu do
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        $chuan_dau_ra3_array=[];
        $chuan_dau_ra3=[];
        $i=0;
        $ds_de_thi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        //tach tieu chi da duoc  su dung
        foreach($ds_de_thi as $dt){      
            //de_thi->de_thi_cauhoi-->cau_hoi
            //              |____________>phuong_an_tu_luan-->cdr_cd3
            $cdr3=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maDe',$dt->maDe)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('de_thi_cau_hoi',function($x){
                $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
            })
            ->join('phuong_an_trac_nghiem',function($x){
                $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
            })
            ->join('cdr_cd3',function($x){
                $x->on('cdr_cd3.maCDR3','=','phuong_an_trac_nghiem.maCDR3');
            })
            ->orderBy('cdr_cd3.maCDR3')
            ->get('cdr_cd3.maCDR3');
           
            //tach maCDR3 tu nhieu de thi thanh 1 mang
            foreach ($cdr3 as $value) {
                if(!in_array($value['maCDR3'],$chuan_dau_ra3_array)){
                   $chuan_dau_ra3_array[$i]=$value['maCDR3'];
                   $i++;
                }
            }
        }
        
        $chuan_dau_ra3=CDR3::whereIn('maCDR3',$chuan_dau_ra3_array)->get();
       
        //phieuCham
        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
       
        //duyet qua tieu chi
        $bieuDo=[];
        foreach ($chuan_dau_ra3 as $cdr3) {
            
            $temp=[];
            //lay noi dung cdr3
            array_push($temp,$cdr3->maCDR3VB);
            array_push($temp,$cdr3->tenCDR3);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            //duyet qua phieu cham
            foreach ($phieuCham as $pc) {
                $t=$cdr3->maCDR3;
                 //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cau_hoi',function($x){
                   $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
                })
                ->join('phuong_an_trac_nghiem',function($x){
                    $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
                })
                ->distinct(['de_thi.maDe','de_thi_cau_hoi.maCauHoi'])
                ->get(['de_thi.maDe','de_thi_cau_hoi.maCauHoi','de_thi_cau_hoi.diem','phuong_an_trac_nghiem.maCDR3']);
                
                ////tinh diem tieu chi cua phieu cham
                ////phuongan->diem_tieu_chi
                $diem_tieu_chi=$phuongan->where('maCDR3',$cdr3->maCDR3)->sum('diem');
              
                // tinh diem sinh vien dat duoc tren tieu chi
                //điếm theo phiếu chấm
                $dem=danhgia_tracnghiem::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_trac_nghiem',function($x) use ($t){
                    $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA')
                    ->where('phuong_an_trac_nghiem.maCDR3',$t);
                })
                ->sum('danhgia_tracnghiem.diem');
                
                /// tinnh ti le
                $tile=number_format($dem/$diem_tieu_chi,2);

                if($tile<0.4){
                    $cdat++;
                }else{
                    if($tile>=0.4 && $tile<0.54){
                        $dat_D++;
                    }else{
                        if($tile>=0.55 && $tile<0.69){
                            $dat_C++;
                        }else{
                            if($tile>=0.70 && $tile<0.89){
                                $dat_B++;
                            }else{
                                $dat_A++;
                            }
                        }
                    }
                }
            }
            array_push($temp,$dat_A);
            array_push($temp,$dat_B);
            array_push($temp,$dat_C);
            array_push($temp,$dat_D);
            array_push($temp,$cdat);
            array_push($bieuDo,$temp);
        }
        return $bieuDo;
    }

    public function export_thong_ke_theo_tieu_chi_trac_nghiem(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new tracnghiemSOExport,'thong_ke_SO_trac_nghiem.xlsx');
    }
    //abet
    public function thong_ke_theo_abet_trac_nghiem($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        //check de thi
        $ds_de_thi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        if($ds_de_thi->count()==0)
        {
            CommonController::warning_notify('Không có đề thi nào!','There are no examination!');
            return redirect()->back();
        } 
        
        $chuan_abet_array=[];
        $chuan_abet=[];
        $i=0;
        //tach tieu chi da duoc  su dung
        foreach($ds_de_thi as $dt){      
            //de_thi->de_thi_cauhoi-->cau_hoi
            //              |____________>phuong_an_tu_luan-->cdr_cd3
            $abet=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maDe',$dt->maDe)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('de_thi_cau_hoi',function($x){
                $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
            })
            ->join('phuong_an_trac_nghiem',function($x){
                $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
            })
            ->join('chuan_abet',function($x){
                $x->on('chuan_abet.maChuanAbet','=','phuong_an_trac_nghiem.maChuanAbet');
            })
            ->orderBy('chuan_abet.maChuanAbet')
            ->get('chuan_abet.maChuanAbet');
            //tach maCDR3 tu nhieu de thi thanh 1 mang
            foreach ($abet as $value) {
                if(!in_array($value['maChuanAbet'],$chuan_abet_array)){
                   $chuan_abet_array[$i]=$value['maChuanAbet'];
                   $i++;
                }
            }
        }
        
        $chuan_abet=chuan_abet::whereIn('maChuanAbet',$chuan_abet_array)->orderBy('maChuanAbetVB')->get();
       
       
        //phieuCham
        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
       
        //duyet qua tieu chi
        $bieuDo=[];
        foreach ($chuan_abet as $abet) {
            $temp=[];
            //lay noi dung abet
            array_push($temp,$abet->maChuanAbetVB);
            array_push($temp,$abet->tenChuanAbet);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            //duyet qua phieu cham
            foreach ($phieuCham as $pc) {
                $t=$abet->maChuanAbet;
                 //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cau_hoi',function($x){
                   $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
                })
                ->join('phuong_an_trac_nghiem',function($x){
                    $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
                })
                ->distinct(['de_thi.maDe','de_thi_cau_hoi.maCauHoi'])
                ->get(['de_thi.maDe','de_thi_cau_hoi.maCauHoi','de_thi_cau_hoi.diem','phuong_an_trac_nghiem.maChuanAbet']);
               
                ////tinh diem tieu chi cua phieu cham
                ////phuongan->diem_tieu_chi
                $diem_tieu_chi=$phuongan->where('maChuanAbet',$abet->maChuanAbet)->sum('diem');
                
                // tinh diem sinh vien dat duoc tren tieu chi
                //điếm theo phiếu chấm
                $dem=danhgia_tracnghiem::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_trac_nghiem',function($x) use ($t){
                    $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA')
                    ->where('phuong_an_trac_nghiem.maChuanAbet',$t);
                })
                ->sum('danhgia_tracnghiem.diem');
                
                /// tinnh ti le
                $tile=number_format($dem/$diem_tieu_chi,2);

                if($tile<0.4){
                    $cdat++;
                }else{
                    if($tile>=0.4 && $tile<0.54){
                        $dat_D++;
                    }else{
                        if($tile>=0.55 && $tile<0.69){
                            $dat_C++;
                        }else{
                            if($tile>=0.70 && $tile<0.89){
                                $dat_B++;
                            }else{
                                $dat_A++;
                            }
                        }
                    }
                }
            }
            array_push($temp,$dat_A);
            array_push($temp,$dat_B);
            array_push($temp,$dat_C);
            array_push($temp,$dat_D);
            array_push($temp,$cdat);
            array_push($bieuDo,$temp);

             //cap nhat bang thongke_abet_hocphan
             $tk=thongke_abet_hocphan::where('maCTBaiQH',$maCTBaiQH)->where('maChuanAbet',$abet->maChuanAbet)->first();
             if($tk){  //neu da co thong ke truoc do thi cap nhat lai
                 $tk->dat_A=$dat_A;
                 $tk->dat_B=$dat_B;
                 $tk->dat_C=$dat_C;
                 $tk->dat_D=$dat_D;
                 $tk->chua_dat=$cdat;
                 $tk->update();
             }else{  //neu khong thi tao ra dong du lieu thong ke moi
                 thongke_abet_hocphan::create(['maCTBaiQH'=>$maCTBaiQH,'maChuanAbet'=>$abet->maChuanAbet,
                 'dat_A'=>$dat_A,'dat_B'=>$dat_B,'dat_C'=>$dat_C,'dat_D'=>$dat_D,'chua_dat'=>$cdat]);
             }
        }
        return view('giangvien.thongke.tracnghiem.thongketheoabet',compact('bieuDo'));
    }
    public function get_abet_trac_nghiem() //ajax ve bieu do
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        //check de thi
        $ds_de_thi=deThi::where('de_thi.isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
       
        $chuan_abet_array=[];
        $chuan_abet=[];
        $i=0;
        //tach tieu chi da duoc  su dung
        foreach($ds_de_thi as $dt){      
            //de_thi->de_thi_cauhoi-->cau_hoi
            //              |____________>phuong_an_tu_luan-->cdr_cd3
            $abet=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maDe',$dt->maDe)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->join('de_thi_cau_hoi',function($x){
                $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
            })
            ->join('phuong_an_trac_nghiem',function($x){
                $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
            })
            ->join('chuan_abet',function($x){
                $x->on('chuan_abet.maChuanAbet','=','phuong_an_trac_nghiem.maChuanAbet');
            })
            ->orderBy('chuan_abet.maChuanAbet')
            ->get('chuan_abet.maChuanAbet');
            //tach maCDR3 tu nhieu de thi thanh 1 mang
            foreach ($abet as $value) {
                if(!in_array($value['maChuanAbet'],$chuan_abet_array)){
                   $chuan_abet_array[$i]=$value['maChuanAbet'];
                   $i++;
                }
            }
        }
        
        $chuan_abet=chuan_abet::whereIn('maChuanAbet',$chuan_abet_array)->orderBy('maChuanAbetVB')->get();
       
       
        //phieuCham
        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
       
        //duyet qua tieu chi
        $bieuDo=[];
        foreach ($chuan_abet as $abet) {
            
            $temp=[];
            //lay noi dung abet
            array_push($temp,$abet->maChuanAbetVB);
            array_push($temp,$abet->tenChuanAbet);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            //duyet qua phieu cham
            foreach ($phieuCham as $pc) {
                $t=$abet->maChuanAbet;
                 //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cau_hoi',function($x){
                   $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
                })
                ->join('phuong_an_trac_nghiem',function($x){
                    $x->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
                })
                ->distinct(['de_thi.maDe','de_thi_cau_hoi.maCauHoi'])
                ->get(['de_thi.maDe','de_thi_cau_hoi.maCauHoi','de_thi_cau_hoi.diem','phuong_an_trac_nghiem.maChuanAbet']);
               
                ////tinh diem tieu chi cua phieu cham
                ////phuongan->diem_tieu_chi
                $diem_tieu_chi=$phuongan->where('maChuanAbet',$abet->maChuanAbet)->sum('diem');
                
                // tinh diem sinh vien dat duoc tren tieu chi
                //điếm theo phiếu chấm
                $dem=danhgia_tracnghiem::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_trac_nghiem',function($x) use ($t){
                    $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA')
                    ->where('phuong_an_trac_nghiem.maChuanAbet',$t);
                })
                ->sum('danhgia_tracnghiem.diem');
                
                /// tinnh ti le
                $tile=number_format($dem/$diem_tieu_chi,2);

                if($tile<0.4){
                    $cdat++;
                }else{
                    if($tile>=0.4 && $tile<0.54){
                        $dat_D++;
                    }else{
                        if($tile>=0.55 && $tile<0.69){
                            $dat_C++;
                        }else{
                            if($tile>=0.70 && $tile<0.89){
                                $dat_B++;
                            }else{
                                $dat_A++;
                            }
                        }
                    }
                }
            }
            array_push($temp,$dat_A);
            array_push($temp,$dat_B);
            array_push($temp,$dat_C);
            array_push($temp,$dat_D);
            array_push($temp,$cdat);
            array_push($bieuDo,$temp);
        }
        return $bieuDo;
    }
    public function export_thong_ke_theo_abet_trac_nghiem(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new tracnghiemAbetExport,'thong_ke_ABET_trac_nghiem.xlsx');
    }
    //clo
    public function thong_ke_theo_kqht_trac_nghiem($maCTBaiQH)
    {
  
        Session::put('maCTBaiQH',$maCTBaiQH);
        $ket_qua_ht=[];
        $kqht_array=[];
        $phuongan=[];
        //ds_de_thi 
        $ds_de_thi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        if($ds_de_thi->count()==0)
        {
            CommonController::warning_notity('Không có đề thi nào!','There are no examination!');
            return redirect()->back();
        }
         //tach lay kqht trong de thi
         $i=0;
         foreach($ds_de_thi as $dt){
             //de_thi->de_thi_cauhoi_tuluan-->cau_hoi
             //              |____________>phuong_an_tu_luan-->cdr_cd3
             $kqht=deThi::where('de_thi.isDelete',false)
             ->where('de_thi.maDe',$dt->maDe) 
             ->where('maCTBaiQH',$maCTBaiQH)
             ->join('de_thi_cau_hoi',function($x){
                 $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
             })
             ->join('cau_hoi',function($y){
                 $y->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi');
             })
             ->get(['cau_hoi.maKQHT']);
             //tach ma kqht tu nhieu de thi thanh 1 mang
             foreach ($kqht as $value) {
                 if(!in_array($value['maKQHT'],$kqht_array)){
                     $kqht_array[$i]=$value['maKQHT'];
                     $i++;
                 }
             }
         }
        

         //get thong tin kqht tu csdls
        $ket_qua_ht=kqHTHP::whereIn('maKQHT',$kqht_array)->orderBy('maKQHTVB')->get();
        
         //lay tat ca phieu cham thuoc de_this
         $phieuCham=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->join('phieu_cham',function($x){
             $x->on('phieu_cham.maDe','=','de_thi.maDe')
             ->where('phieu_cham.maGV',Session::get('maGV'))
             ->where('phieu_cham.isDelete',false);
         })->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
        
        //bien du lieu thong ke
        $bieuDo=[];
        foreach ($ket_qua_ht as $kqht) {
            $temp=[];
            array_push($temp,$kqht->maKQHTVB);
            array_push($temp,$kqht->tenKQHT);
 
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            
            foreach ($phieuCham as $pc) {
                $t=$kqht->maKQHT;
                //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cau_hoi',function($x){
                    $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
                })
                ->join('cau_hoi',function($y){
                   $y->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi');
                })
               ->get(['cau_hoi.maCauHoi','cau_hoi.maKQHT','de_thi_cau_hoi.diem']);
               //phuongan->diem_tieu_chi
               $diem_tieu_chi=$phuongan->where('maKQHT',$kqht->maKQHT)->sum('diem');
               
                //điếm theo phiếu chấm
                $dem=danhgia_tracnghiem::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_trac_nghiem',function($x){
                    $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA');
                })
                ->join('de_thi_cau_hoi',function($y){
                    $y->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
                })
                ->join('cau_hoi',function($z) use($t){
                    $z->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi')
                    ->where('cau_hoi.maKQHT',$t);
                 })
                 ->sum('danhgia_tracnghiem.diem');
                
                 
                //$dem=number_format($dem,2);
                 

                $tile=number_format($dem/$diem_tieu_chi,2);
                 
               if($tile<0.4){
                   $cdat++;
               }else{
                   if($tile>=0.4 && $tile<0.54){
                       $dat_D++;
                   }else{
                       if($tile>=0.55 && $tile<0.69){
                           $dat_C++;
                       }else{
                           if($tile>=0.70 && $tile<0.89){
                               $dat_B++;
                           }else{
                               $dat_A++;
                           }
                       }
                   }
               }
            }
            
            array_push($temp,$dat_A);
            array_push($temp,$dat_B);
            array_push($temp,$dat_C);
            array_push($temp,$dat_D);
            array_push($temp,$cdat);
            array_push($bieuDo,$temp);
            $t=new xuLyThongKeController();
            $t->cap_nhat_thongke_clo_hocphan($maCTBaiQH,$kqht->maKQHT,$dat_A,$dat_B,$dat_C,$dat_D,$cdat);

        }
        return view('giangvien.thongke.tracnghiem.thongketheokqht',compact('bieuDo'));
    }
    public function get_kqht_trac_nghiem(Type $var = null)  //ajax ve bieu do
    {
        $maCTBaiQH=Session::get('maCTBaiQH');
        $ket_qua_ht=[];
        $kqht_array=[];
        $phuongan=[];
        //ds_de_thi 
        $ds_de_thi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
      
         //tach lay kqht trong de thi
         $i=0;
         foreach($ds_de_thi as $dt){
             //de_thi->de_thi_cauhoi_tuluan-->cau_hoi
             //              |____________>phuong_an_tu_luan-->cdr_cd3
             $kqht=deThi::where('de_thi.isDelete',false)
             ->where('de_thi.maDe',$dt->maDe) 
             ->where('maCTBaiQH',$maCTBaiQH)
             ->join('de_thi_cau_hoi',function($x){
                 $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
             })
             ->join('cau_hoi',function($y){
                 $y->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi');
             })
             ->get(['cau_hoi.maKQHT']);
             //tach ma kqht tu nhieu de thi thanh 1 mang
             foreach ($kqht as $value) {
                 if(!in_array($value['maKQHT'],$kqht_array)){
                     $kqht_array[$i]=$value['maKQHT'];
                     $i++;
                 }
             }
         }
 
         //get thong tin kqht tu csdls
        $ket_qua_ht=kqHTHP::whereIn('maKQHT',$kqht_array)->orderBy('maKQHTVB')->get();
        
         //lay tat ca phieu cham thuoc de_this
         $phieuCham=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)
         ->join('phieu_cham',function($x){
             $x->on('phieu_cham.maDe','=','de_thi.maDe')
             ->where('phieu_cham.maGV',Session::get('maGV'))
             ->where('phieu_cham.isDelete',false);
         })->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);
        //bien du lieu thong ke
        $bieuDo=[];
      
        foreach ($ket_qua_ht as $kqht) {
            $temp=[];
            array_push($temp,$kqht->maKQHTVB);
            array_push($temp,$kqht->tenKQHT);
            //bien dem
            $dat_A=$dat_B=$dat_C=$dat_D=$cdat=$diem_tieu_chi=0;
            
            foreach ($phieuCham as $pc) {
                $t=$kqht->maKQHT;
                //dethi
                $dethi=deThi::where('isDelete',false)->where('maDe',$pc->maDe)->first();
                //dethi->phuongAn
                $phuongan=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maDe',$dethi->maDe)
                ->where('maCTBaiQH',$maCTBaiQH)
                ->join('de_thi_cau_hoi',function($x){
                    $x->on('de_thi_cau_hoi.maDe','=','de_thi.maDe');
                })
                ->join('cau_hoi',function($y){
                   $y->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi');
                })
               ->get(['cau_hoi.maCauHoi','cau_hoi.maKQHT','de_thi_cau_hoi.diem']);
               
               //phuongan->diem_tieu_chi
               $diem_tieu_chi=$phuongan->where('maKQHT',$kqht->maKQHT)->sum('diem');
               
                //điếm theo phiếu chấm
                $dem=danhgia_tracnghiem::where('maPhieuCham',556)
                ->join('phuong_an_trac_nghiem',function($x){
                    $x->on('phuong_an_trac_nghiem.id','=','danhgia_tracnghiem.maPA');
                })
                ->join('de_thi_cau_hoi',function($y){
                    $y->on('de_thi_cau_hoi.maCauHoi','=','phuong_an_trac_nghiem.maCauHoi');
                })
                ->join('cau_hoi',function($z) use($t){
                    $z->on('de_thi_cau_hoi.maCauHoi','=','cau_hoi.maCauHoi')
                    ->where('cau_hoi.maKQHT',9);
                 })
                 ->sum('danhgia_tracnghiem.diem');
                
                $dem=number_format($dem,2);

                $tile=number_format($dem/$diem_tieu_chi,2);
                 
               if($tile<0.4){
                   $cdat++;
               }else{
                   if($tile>=0.4 && $tile<0.54){
                       $dat_D++;
                   }else{
                       if($tile>=0.55 && $tile<0.69){
                           $dat_C++;
                       }else{
                           if($tile>=0.70 && $tile<0.89){
                               $dat_B++;
                           }else{
                               $dat_A++;
                           }
                       }
                   }
               }
            }
            
            array_push($temp,$dat_A);
            array_push($temp,$dat_B);
            array_push($temp,$dat_C);
            array_push($temp,$dat_D);
            array_push($temp,$cdat);
            array_push($bieuDo,$temp);
        }
        return $bieuDo;
    }
    public function export_thong_ke_theo_clo_trac_nghiem(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new tracnghiemCLOExport,'thong_ke_CLO_trac_nghiem.xlsx');
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

    public function export_thong_ke_theo_xep_hang_do_an(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new doAnRankExport,'thong_ke_xep_hang_do_an.xlsx');
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
    
    public function export_thong_ke_theo_diem_chu_do_an(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new doAnGrateExport,'thong_ke_diem_chu_do_an.xlsx');
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
                if($tile<0.4){
                    $kem++;
                }else{
                    if($tile>=0.4 && $tile<0.54){
                        $yeu++;
                    }else{
                        if($tile>=0.55 && $tile<0.69){
                            $tb++;
                        }else{
                            if($tile>=0.70 && $tile<0.89){
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
            $t=new xuLyThongKeController();
            $t->cap_nhat_thongke_so_hocphan($maCTBaiQH,$cdr3->maCDR3,$gioi,$kha,$tb,$yeu,$kem,$maCanBo);
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
                if($tile<0.4){
                    $kem++;
                }else{
                    if($tile>=0.4 && $tile<0.54){
                        $yeu++;
                    }else{
                        if($tile>=0.55 && $tile<0.69){
                            $tb++;
                        }else{
                            if($tile>=0.70 && $tile<0.89){
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

    public function export_thong_ke_theo_tieu_chi_do_an(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new doAnSOExport,'thong_ke_tieu_chi_do_an.xlsx');
    }

    //abet
    public function thong_ke_theo_abet_doan($maCTBaiQH,$maCanBo) //chạy
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        Session::put('maCanBo',$maCanBo);
        $bieuDo=xuLyThongKeController::thong_ke_abet_do_an($maCTBaiQH,$maCanBo);
        return view('giangvien.thongke.doan.thongketheoabet',['bieuDo'=>$bieuDo]);
    }

    public function get_abet_doan() //chạy
    {
        return xuLyThongKeController::thong_ke_abet_do_an(Session::get('maCTBaiQH'),Session::get('maCanBo'));
    }

    public function export_thong_ke_theo_abet_do_an(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new doAnAbetExport,'thong_ke_abet_do_an.xlsx');
    }

    //clo
    public function thong_ke_theo_kqht_doan($maCTBaiQH,$maCanBo)
    {
        
        Session::put('maCTBaiQH',$maCTBaiQH);
        Session::put('maCanBo',$maCanBo);
        
        $bieuDo=xuLyThongKeController::thong_ke_clo_do_an($maCTBaiQH,$maCanBo);
        return view('giangvien.thongke.doan.thongketheokqht',compact('bieuDo'));
    }

    public function get_clo_doan(Type $var = null)
    {
        return xuLyThongKeController::thong_ke_clo_do_an(Session::get('maCTBaiQH'),Session::get('maCanBo'));
    }

    public function export_thong_ke_theo_clo_do_an(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new doAnCLOExport,'thong_ke_clo_do_an.xlsx');
    }
}
