<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\giangVien;
use App\Models\noiDungQH;
use App\Models\loaiDanhGia;
use Illuminate\Http\Request;
use App\Models\loaiHTDanhGia;
use App\Models\ct_bai_quy_hoach;
use App\Http\Controllers\Controller;
use App\Models\danhGia;
use App\Models\phieu_cham;
use App\Models\sinhVien;
use App\Models\tieuChiChamDiem;

class ketQuaDanhGiaController extends Controller
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
        return view('giangvien.ketqua.ketQuaDanhGia',['gd'=>$gd]);
    }

    public function chi_tiet_quy_hoach_kq_qua_danh_gia($maHocPhan,$maBaiQH,$maHK,$namHoc,$maLop)
    {
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
        
           return view('giangvien.ketqua.ctQHKetQua',['qh'=>$qh,'hp'=>$hp,
           'ldg'=>$ldg,'lhtdg'=>$lhtdg]);
    }

    public function nhap_ket_qua_danh_gia($maCTBaiQH)
    {
        //kiểm loại ht đánh giá
        $loaiHTDG=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->first('maLoaiHTDG');
        if($loaiHTDG->maLoaiHTDG=="T8")
        {

            $hp=hocPhan::where('maHocPhan',Session::get('maHocPhan'))
            ->where('isDelete',false)->first();
            $gv=giangVien::where('isDelete',false)
            ->where('maGV',Session::get('maGV'))
            ->first();

             //?maCTBaiQH->maDe
             $maDe=deThi::where('de_thi.isDelete',false)
             ->where('de_thi.maCTBaiQH',$maCTBaiQH)
             ->Join('phieu_cham',function($x){
                 $x->on('phieu_cham.maDe','=','de_thi.maDe')
                 ->where('phieu_cham.isDelete',false);
             })
             ->leftJoin('sinh_vien',function($y){
                 $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                 ->where('sinh_vien.isDelete',false);
             })
             ->orderBy('phieu_cham.maDe','desc')
             ->get(['de_thi.maDe','de_thi.tenDe','sinh_vien.maSSV','sinh_vien.HoSV','sinh_vien.TenSV','phieu_cham.trangThai','phieu_cham.diemSo']);
         
            
             //ct_bai_QH
            return view('giangvien.ketqua.ketquadoan',['hp'=>$hp,'gv'=>$gv,
            'deThi'=>$maDe]);
        }

        return view('giangvien.error');
    }

    public function nhap_diem_do_an($maDe,$maSSV)
    {
        //đề tài
        $deTai=deThi::where('isDelete',false)
        ->where('maDe',$maDe)
        ->first();
        //giảng viên
        $gv=phieu_cham::where('phieu_cham.isDelete',false)
        ->where('maDe',$maDe)
        ->where('maSSV',$maSSV)
        ->join('giang_vien',function($x){
            $x->on('giang_vien.maGV','=','phieu_cham.maGV')
            ->where('giang_vien.isDelete',false);
        })
        ->first(['giang_vien.maGV','hoGV','tenGV','phieu_cham.maPhieuCham']);
        //sinh viên
        $sv=sinhVien::where('isDelete',false)
        ->where('maSSV',$maSSV)
        ->first();
        //ct_bai-quy_hoach->noi_dung_quy_hoach
        $ndQh=noiDungQH::where('noi_dung_quy_hoach.isDelete',false)
        ->where('noi_dung_quy_hoach.maCTBaiQH',Session::get('maCTBaiQH'))
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

       

       return view('giangvien.ketqua.nhapDiemDoan',['tieuchi'=>$ndQh,'deTai'=>$deTai,'gv'=>$gv,'sv'=>$sv]);
    }

    public function cham_diem_submit(Request $request)
    {
        $diem=0;
        foreach ($request->chamdiem as $maTCCD) {
            $dg=new danhGia();
            $tccd=tieuChiChamDiem::where('maTCCD',$maTCCD)
            ->first();
            $dg->maTCCD=$maTCCD;
            $dg->diemDG=$tccd->diemTCCD;
            $dg->maPhieuCham=$request->maPhieuCham;
            $dg->save();
            $diem=$diem+$tccd->diemTCCD;
        }
        $dg=danhGia::where('maPhieuCham',$request->maPhieuCham)->sum('diemDG');
        
        $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)
        ->first();
        $pc->trangThai=true;
        $pc->diemSo=$diem;
        $pc->update();
        return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Chấm điểm thành công!');
    }
}
