<?php

namespace App\Http\Controllers\GiangVien;

use App\Models\giangDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\baiQuyHoach;
use App\Models\CDR3;
use App\Models\ct_bai_quy_hoach;
use App\Models\deThi;
use App\Models\hocPhan;
use App\Models\hocPhan_loaiHTDanhGia;
use App\Models\loaiDanhGia;
use App\Models\loaiHTDanhGia;
use App\Models\noiDungQH;
use App\Models\phieu_cham;
use App\Models\quyHoach_hocPhan;
use App\Models\sinhVien;
use Session;

class quyhoachController extends Controller
{
    public function index(Type $var = null)
    {
        $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))

        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
        })
        ->groupBy('maBaiQH')->distinct()
        ->get();
        

        return view('giangvien.quyhoach.quyhoach',['gd'=>$gd]);
    }

    public function quy_hoach_ket_qua_hoc_tap($maHocPhan,$maBaiQH,$maHK,$namHoc,$maLop)
    {
       try {
           Session::put('maHocPhan',$maHocPhan);
           Session::put('maHK',$maHK);
           Session::put('namHoc',$namHoc);  
           Session::put('maLop',$maLop);

           $ldg=loaiDanhGia::where('isDelete',false)->get();
           $lhtdg=loaiHTDanhGia::where('isDelete',false)->get();
           
           $hp=hocPhan::where('maHocPhan',$maHocPhan)
           ->where('isDelete',false)->first();

           $qh=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
           ->where('ct_bai_quy_hoach.maBaiQH',$maBaiQH)
           ->join('loai_danh_gia',function($x){
               $x->on('loai_danh_gia.maLoaiDG','=','ct_bai_quy_hoach.maLoaiDG')
               ->where('loai_danh_gia.isDelete',false);
           })
           ->join('loai_ht_danhgia',function($x){
            $x->on('loai_ht_danhgia.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
            ->where('loai_ht_danhgia.isDelete',false);
            })
           ->get();
        
           return view('giangvien.quyhoach.quyhoachketqua',['qh'=>$qh,'hp'=>$hp,
           'ldg'=>$ldg,'lhtdg'=>$lhtdg]);
       } catch (\Throwable $th) {
           return $th;
       }
    }

    public function them_quy_hoach(Request $request)
    {
       
        try {
            //tạo bai_quy_hoach==>maBaiQH
            $bhq=new baiQuyHoach();
            $bhq->save();
            $maBaiQH=baiQuyHoach::where('isDelete',false)->get('maBaiQH')->first();
            //maHocPhan+maLoaiDG+=maLoaiHTDG+trongSo===>hocphan_loai_hinhthuc_dg
            $hp_lhtdg=new hocPhan_loaiHTDanhGia();
            $hp_lhtdg->maHocPhan=$request->maHocPhan;
            $hp_lhtdg->maLoaiDG=$request->maLoaiDG;
            $hp_lhtdg->maLoaiHTDG=$request->maLoaiHTDG;
            $hp_lhtdg->trongSo=$request->trongSo;
            $hp_lhtdg->save();
            //maHocPhan+maLoaiDG+maLoaiHTDG+maBaiQH+maGV==>quyhoach_hocphan
            $qh_hp=new quyHoach_hocPhan();
            $qh_hp->maHocPhan=$request->maHocPhan;
            $qh_hp->maLoaiDG=$request->maLoaiDG;
            $qh_hp->maLoaiHTDG=$request->maLoaiHTDG;
            $qh_hp->maBaiQH=$maBaiQH;
            $qh_hp->maGV=Session::get('maGV');
            $qh_hp->save();
            return redirect('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.$request->maHocPhan)->with('success','thêm thành công');

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function xem_noi_dung_danh_gia($maCTBaiQH)
    {
        try {
            Session::put('maCTBaiQH',$maCTBaiQH);
            //maCTBaiQH->ct_bai-quy_hoach
            $maLoaiHTDG=ct_bai_quy_hoach::where('isDelete',false)
            ->where('maCTBaiQH',$maCTBaiQH)
            ->first('maLoaiHTDG');
          
            //?maCTBaiQH->maDe
            $maDe=deThi::where('de_thi.isDelete',false)
            ->where('de_thi.maCTBaiQH',$maCTBaiQH)
            ->leftJoin('phieu_cham',function($x){
                $x->on('phieu_cham.maDe','=','de_thi.maDe')
                ->where('phieu_cham.isDelete',false);
            })
            ->leftJoin('sinh_vien',function($y){
                $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                ->where('sinh_vien.isDelete',false);
            })
            ->get(['de_thi.maDe','de_thi.tenDe','sinh_vien.maSSV','sinh_vien.HoSV','sinh_vien.TenSV']);
 


           
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

                $dsLop=sinhVien::where('isDelete',false)
                ->where('maLop',Session::get('maLop'))
                ->whereNotIn('maSSV',$massv)
                ->get();
               



                return view('giangvien.quyhoach.xemnddanhgia',['deThi'=>$maDe,
                'maCTBaiQH'=>$maCTBaiQH,
                'dsLop'=>$dsLop]);
            }   
            
            
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function them_de_tai(Request $request)
    {
      
            $dt=new deThi();
            $dt->maDe=$request->maDe;
            $dt->tenDe=$request->tenDe;
            $dt->maCTBaiQH=Session::get('maCTBaiQH');
            $dt->save();
            return redirect('/giang-vien/quy-hoach-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Thêm thành công!');

        
    }
    public function them_phieu_cham(Request $request)
    {
        //noiDungDe+maSSV->phieuCham
        
        $pc=new phieu_cham();
        $pc->maGV=Session::get('maGV');
        $pc->maSSV=$request->maSSV;
        $pc->maDe=$request->maDe;
        $pc->save();
        return redirect('giang-vien/quy-hoach-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Thêm thành công!');

    }

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
   
    
}
