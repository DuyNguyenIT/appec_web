<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\danhGia;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\sinhVien;
use App\Models\giangVien;
use App\Models\noiDungQH;
use App\Models\phieu_cham;
use App\Models\baiQuyHoach;
use Illuminate\Http\Request;
use App\Models\tieuChiChamDiem;
use App\Models\ct_bai_quy_hoach;
use App\Http\Controllers\Controller;

class chamDiemBCController extends Controller
{
    public function index(Type $var = null)
    {
        //maGV->ct_bai_quy_hoach[]
        $ct_bai_quy_hoach=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maGV_2',Session::get('maGV'))
        ->get();
       
        //ct_bai_quy_hoach->bai-quy-hoach[]
        $baiQH=[];
        $checkDup=[];
        foreach ($ct_bai_quy_hoach as $x) {
            $bqh=baiQuyHoach::where('isDelete',false)
            ->where('maBaiQH',$x->maBaiQH)
            ->first();
            array_push($baiQH,$bqh);
            array_push($checkDup,$bqh->maBaiQH);
        }

        
        

        //kiểm tra được mời trong các đồ án, khóa luận
        $pc=phieu_cham::where('isDelete',false)
        ->where('diemSo',0)
        ->where('maGV',Session::get('maGV'))
        ->get();

        if($pc->count()>0){
            //phiếu chấm ->đề thi
            $deThi=[];
            foreach ($pc as $x) {
                $dt=deThi::where('isDelete',false)
                ->where('maDe',$x->maDe)
                ->first();
                array_push($deThi,$dt);
            }
            $ctqh=[];
            //đề thi->ct bài qh
            foreach ($deThi as $dt) {
                $temp=ct_bai_quy_hoach::where('isDelete',false)
                ->where('maCTBaiQH',$dt->maCTBaiQH)
                ->first();
                array_push($ctqh,$temp);
            }
            foreach ($ctqh as $x) {
                $bqh=baiQuyHoach::where('isDelete',false)
                ->where('maBaiQH',$x->maBaiQH)
                ->whereNotIn('maBaiQH',$checkDup)
                ->first();
                array_push($baiQH,$bqh);
            }
        }
       
        $gd=[];
        foreach ($baiQH as $y) {
            $temp=giangDay::where('giangday.isDelete',false)
            ->where('giangday.maBaiQH',$y->maBaiQH)
            ->groupBy('giangday.maBaiQH')
            ->distinct()
            ->join('hoc_phan',function($x){
                $x->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
            })
            ->join('giang_vien',function($x){
                $x->on('giang_vien.maGV','=','giangday.maGV')
                ->where('giang_vien.isDelete',false);
            })
            ->get();
            array_push($gd,$temp);
        }
        
        
        
        return view('giangvien.chambc.chamdiembc',['hocPhan'=>$gd]);
    }

    public function noi_dung_danh_gia($maBaiQH,$maHocPhan)
    {
        //học phần
        $hp=hocPhan::where('isDelete',false)
        ->where('maHocPhan',$maHocPhan)
        ->first();
        //maBaiQH->maCTBaiQH
        $ctqh=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
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

        return view('giangvien.chambc.noidungdanhgia',['qh'=>$ctqh,'hocPhan'=>$hp]);
    }

    public function nhap_ket_qua_danh_gia($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        //kiểm loại ht đánh giá
        $loaiHTDG=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->first('maLoaiHTDG');

        $gv2=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->first();
        Session::put('maGV_2',$gv2->maGV_2);


        // nhập kết quả cho tự luận
        if ($loaiHTDG->maLoaiHTDG=="T1") {
            # code...
            return view('giangvien.ketqua.tuluan.ketquatuluan');
        }
        //nhập kết quả cho thực hành
        if ($loaiHTDG->maLoaiHTDG=="T3") {
            # code...
            return view('giangvien.ketqua.thuchanh.ketquathuchanh');
        }
        //nhập kết quả cho trắc nghiệm
        if ($loaiHTDG->maLoaiHTDG=="T2") {
            return view('giangvien.ketqua.tracnghiem.ketquatracnghiem');
        }
        //nhập kết quả cho đồ án
        if($loaiHTDG->maLoaiHTDG=="T8")
        {

            $gv=giangVien::where('isDelete',false)
            ->where('maGV',Session::get('maGV'))
            ->first();

             //?maCTBaiQH->maDe
             $maDe=deThi::where('de_thi.isDelete',false)
             ->where('de_thi.maCTBaiQH',$maCTBaiQH)
             ->Join('phieu_cham',function($x){
                 $x->on('phieu_cham.maDe','=','de_thi.maDe')
                 ->where('phieu_cham.loaiCB',2)
                 ->where('phieu_cham.maGV',Session::get('maGV'))
                 ->where('phieu_cham.isDelete',false);
             })
             ->leftJoin('sinh_vien',function($y){
                 $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                 ->where('sinh_vien.isDelete',false);
             })
             ->orderBy('phieu_cham.maDe','desc')
             ->get(['de_thi.maDeVB','de_thi.maDe','de_thi.tenDe','sinh_vien.maSSV','sinh_vien.HoSV','sinh_vien.TenSV','phieu_cham.maPhieuCham','phieu_cham.trangThai','phieu_cham.diemSo']);
         
             //ct_bai_QH
            return view('giangvien.chambc.ketquadoan',['gv'=>$gv,
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
         ->where('phieu_cham.maGV',Session::get('maGV'))
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
 
        return view('giangvien.chambc.nhapdiemdoan',['tieuchi'=>$ndQh,'deTai'=>$deTai,'gv'=>$gv,'sv'=>$sv]);
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
        if($diem>=0 && $diem<4){
            $pc->diemChu="F";
            $pc->xepHang=5;
        }
        
        if($diem>=4 && $diem<=4.9){
             $pc->diemChu="D";
             $pc->xepHang=4;
        }
        if($diem>=5 && $diem<=5.4){
            $pc->diemChu="D+";
            $pc->xepHang=4;
        }
        

        if($diem>=5.5 && $diem<=6.4){
            $pc->diemChu="C";
            $pc->xepHang=3;
        }
        if($diem>=6.5 && $diem<=6.9){
            $pc->diemChu="C+";
            $pc->xepHang=3;
        }
        

        if($diem>=7 && $diem<=7.9){
            $pc->diemChu="B";
            $pc->xepHang=2;
        }
        if($diem>=8.0 && $diem<=8.9){
            $pc->diemChu="B+";
            $pc->xepHang=2;
        }
        
        if($diem>=9.0 && $diem<=10){
            $pc->diemChu="A";
            $pc->xepHang=1;
        }

        
        $pc->trangThai=true;
        $pc->diemSo=$diem;
        $pc->loaiCB=2;
        $pc->yKienDongGop=$request->yKienDongGop;
        $pc->update();
        return redirect('/giang-vien/cham-diem-bao-cao/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Chấm điểm thành công!');
    }

    public function xem_ket_qua_danh_gia($maPhieuCham)
    {
       
        $deTai=phieu_cham::where('phieu_cham.isDelete',false)
        ->where('phieu_cham.maPhieuCham',$maPhieuCham)
        ->where('phieu_cham.maGV',Session::get('maGV'))
        ->join('de_thi',function($x){
            $x->on('de_thi.maDe','=','phieu_cham.maDe')
            ->where('de_thi.isDelete',false);
        })
        ->first();
        

         //giảng viên
         $gv=phieu_cham::where('phieu_cham.isDelete',false)
         ->where('phieu_cham.maPhieuCham',$maPhieuCham)
         ->join('giang_vien',function($x){
             $x->on('giang_vien.maGV','=','phieu_cham.maGV')
             ->where('giang_vien.isDelete',false);
         })
         ->first(['giang_vien.maGV','hoGV','tenGV','phieu_cham.maPhieuCham']);
        

        //sinh viên
        $sv=phieu_cham::where('phieu_cham.isDelete',false)
        ->where('phieu_cham.maPhieuCham',$maPhieuCham)
        ->join('sinh_vien',function($y){
            $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
            ->where('sinh_vien.isDelete',false);
        })
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
        ->get();
        //phiếu chấm
        
       //lọc chuẩn đầu ra và hiện điểm chấm
        foreach ($ndQh as $tc) {
            $cdr3=CDR3::where('isDelete',false)
                ->where('maCDR3', $tc->maCDR3)
                ->get(['maCDR3VB', 'tenCDR3']);
            $tc->tenCDR3=$cdr3[0]["tenCDR3"];
            $tc->maCDR3VB=$cdr3[0]["maCDR3VB"];


            $pc=phieu_cham::where('phieu_cham.isDelete',false)
            ->where('phieu_cham.maPhieuCham',$maPhieuCham)
            ->join('danh_gia',function($x) use ($tc){
                $x->on('phieu_cham.maPhieuCham','=','danh_gia.maPhieuCham')
                ->where('danh_gia.maTCCD',$tc->maTCCD)
                ->where('danh_gia.isDelete',false);
                })
            ->get(['danh_gia.maTCCD','danh_gia.diemDG']);

            if(count($pc)>0){
                $tc->diemDG=$pc[0]->diemDG;
            }
            else{
                $tc->diemDG=0;
            }
        }
        return view('giangvien.chambc.xemketquabc',['tieuchi'=>$ndQh,'sv'=>$sv,'gv'=>$gv,'deTai'=>$deTai]);
    }
}
