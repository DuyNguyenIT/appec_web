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
use App\Models\danhgia_tuluan;
use App\Models\phuongAnTuLuan;
use App\Models\tieuChiChamDiem;
use App\Models\ct_bai_quy_hoach;
use App\Models\dethi_cauhoituluan;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;


//controller dieu khien chuc nang cham diem phieu cham
class chamDiemBCController extends Controller
{
    public function index()
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
        ->where('loaiCB',2)
        ->get();
        if($pc->count()>0){
            //phiếu chấm ->đề thi
            $deThi=[];
            foreach ($pc as $x) {
                $dt=deThi::where('isDelete',false)->where('maDe',$x->maDe)->first();
                array_push($deThi,$dt);
            }
            $ctqh=[];
            //đề thi->ct bài qh
            foreach ($deThi as $dt) {
                $temp=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',$dt->maCTBaiQH)->first();
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
            if($y){
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
        ->where('ct_bai_quy_hoach.maLoaiDG',3)    //chi lay cuoi ki
        //->where('ct_bai_quy_hoach.maLoaiHTDG','T8')
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
        //1234
      //  $phieucham=phieu_cham::where('maGV','00251')->where('loaiCB',2)->delete();
      //  return 1;
       
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
         
            $deThi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();        
            
            $phieucham=deThi::getPhieuChamByCTBQH($maCTBaiQH,Session::get('maGV_2'));           

         
            return view('giangvien.chambc.thuchanh.ketquathuchanh',['deThi'=>$deThi,'phieucham'=>$phieucham]);
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
         $deTai=deThi::get_de_thi_by_made($maDe);

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
         $sv=sinhVien:: get_sv_by_massv($maSSV);

         //ct_bai-quy_hoach->noi_dung_quy_hoach
         $ndQh=noiDungQH::where('noi_dung_quy_hoach.isDelete',false)
         ->where('noi_dung_quy_hoach.maCTBaiQH',Session::get('maCTBaiQH'))
             ->join('tieuchuan_danhgia',function($x){
                 $x->on('tieuchuan_danhgia.maNoiDungQH','=','noi_dung_quy_hoach.maNoiDungQH')
                 ->where('tieuchuan_danhgia.isDelete',false);
             })
             ->orderBy('tieuchuan_danhgia.tenTCDG','asc')
             ->join('cau_hoi_tcchamdiem',function($y){
                 $y->on('cau_hoi_tcchamdiem.maTCDG','=','tieuchuan_danhgia.maTCDG')
                 ->where('cau_hoi_tcchamdiem.isDelete',false);
             })
             ->orderBy('cau_hoi_tcchamdiem.maTCCD')
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
    public function xem_sua_diem_do_an($maPhieuCham)
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
             ->orderBy('tieuchuan_danhgia.tenTCDG','asc')
             ->join('cau_hoi_tcchamdiem',function($y){
                 $y->on('cau_hoi_tcchamdiem.maTCDG','=','tieuchuan_danhgia.maTCDG')
                 ->where('cau_hoi_tcchamdiem.isDelete',false);
             })
             ->orderBy('cau_hoi_tcchamdiem.maTCCD')
             ->join('tieu_chi_cham_diem',function($z){
                 $z->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                 ->where('tieu_chi_cham_diem.isDelete',false);
             })
           
            // ->get(['tieu_chi_cham_diem.maTCCD','tenTCCD','tieu_chi_cham_diem.maCDR3']);
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
                ->where('danh_gia.maTCCD',$tc->maTCCD);
                })
            ->get(['danh_gia.maTCCD','danh_gia.diemDG']);

            if(count($pc)>0){
                $tc->diemDG=$pc[0]->diemDG;
            }
            else{
                $tc->diemDG=0;
            }
        }
        // return $ndQh;
        return view('giangvien.chambc.suadiemchamdoan',['tieuchi'=>$ndQh,'deTai'=>$deTai,'gv'=>$gv,'sv'=>$sv]);
    }
    public function cham_diem_submit(Request $request)
    {
        $st2= count($request->chamdiem1);
        $mangdiemcham = array();        
         $spt=0;   
         for($i=0; $i<$st2; $i++)
            if($request->chamdiem1[$i]>0)
            {
                $mangdiemcham[$spt]= $request->chamdiem1[$i];
                $spt++;               
            } 
        $diem=0;
        // foreach ($request->chamdiem as $maTCCD) {
        //     $dg=new danhGia();
        //     $tccd=tieuChiChamDiem::where('maTCCD',$maTCCD)
        //     ->first();
        //     $dg->maTCCD=$maTCCD;
        //     $dg->diemDG=$tccd->diemTCCD;
        //     $dg->maPhieuCham=$request->maPhieuCham;
        //     $dg->save();
        //     $diem=$diem+$tccd->diemTCCD;
        // }
        danhGia::where('maPhieuCham',$request->maPhieuCham)->delete();           
       
        for($i=0; $i<$spt; $i++)
         {
            $dg=new danhGia();           
            $dg->maTCCD=$request->chamdiem[$i];
            $dg->diemDG=$mangdiemcham[$i];
            $dg->maPhieuCham=$request->maPhieuCham;
            $dg->save();
            $diem=$diem+ $mangdiemcham[$i];
        }
      
        $dg=danhGia::where('maPhieuCham',$request->maPhieuCham)->sum('diemDG');

        $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)->first();
        
        $pc->diemChu=CommonController::tinh_diem_chu($diem);
        $pc->xepHang=CommonController::tinh_xep_hang($diem);
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
             ->orderBy('tieuchuan_danhgia.tenTCDG','asc')
             ->join('cau_hoi_tcchamdiem',function($y){
                 $y->on('cau_hoi_tcchamdiem.maTCDG','=','tieuchuan_danhgia.maTCDG')
                 ->where('cau_hoi_tcchamdiem.isDelete',false);
             })
             ->orderBy('cau_hoi_tcchamdiem.maTCCD')
             ->join('tieu_chi_cham_diem',function($z){
                 $z->on('tieu_chi_cham_diem.maTCCD','=','cau_hoi_tcchamdiem.maTCCD')
                 ->where('tieu_chi_cham_diem.isDelete',false);
             })
           
            // ->get(['tieu_chi_cham_diem.maTCCD','tenTCCD','tieu_chi_cham_diem.maCDR3']);
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


    //cham diem cho phan thuc hanh cuoi ki
    public function nhap_diem_thuc_hanh($maDe,$maSSV)  //CHẠY --ĐÃ TEST
    {
        
         //đề thi
         $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
         //giảng viên
         $gv=phieu_cham::where('phieu_cham.isDelete',false)
         ->where('maDe',$maDe)
         ->where('phieu_cham.maGV',Session::get('maGV_2'))
         ->where('maSSV',$maSSV)
         ->join('giang_vien',function($x){
             $x->on('giang_vien.maGV','=','phieu_cham.maGV')
             ->where('giang_vien.isDelete',false);
         })
         ->first(['giang_vien.maGV','hoGV','tenGV','phieu_cham.maPhieuCham']);
       //  return $gv;
        
         //sinh viên
        $sv=sinhVien::where('isDelete',false)->where('maSSV',$maSSV)->first();

        //noi dung de thi thuc  hanh
        if($dethi){
            $noidung=dethi_cauhoituluan::where('de_thi_cauhoi_tuluan.maDe',$dethi->maDe)
            ->orderBy('de_thi_cauhoi_tuluan.maCauHoi')
            ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->get();

            foreach ($noidung as $tc) {
                $cdr3=CDR3::where('isDelete',false)
                    ->where('maCDR3', $tc->maCDR3)
                    ->get(['maCDR3VB', 'tenCDR3']);
                $tc->tenCDR3=$cdr3[0]["tenCDR3"];
                $tc->maCDR3VB=$cdr3[0]["maCDR3VB"];
           }
        }else{
            alert()->warning("Can't found examination",'Warning');
            CommonController::warning_notify("Không tìm thấy đề thi!","Can't found examination");
            return back();
        }
        
        
        return view('giangvien.chambc.thuchanh.nhapdiemthuchanh',compact('dethi','gv','sv','noidung'));

    }

    public function cham_diem_thuc_hanh_submit(Request $request)
    {
        $st2= count($request->chamdiem1);
        $mangdiemcham = array();        
         $spt=0;   
         for($i=0; $i<$st2; $i++)
            if($request->chamdiem1[$i]>0)
            {
                $mangdiemcham[$spt]= $request->chamdiem1[$i];
                $spt++;
            }         
        $diem=0;
        danhgia_tuluan::where('maPhieuCham',$request->maPhieuCham)->delete();
        for($i=0;$i<$spt;$i++)      
        {
            $dg=new danhgia_tuluan();
            $dg->maPATL=$request->chamdiem[$i]; 
            $dg->diemDG= $mangdiemcham[$i];
            $dg->maPhieuCham=$request->maPhieuCham;
            $dg->save();
            $diem=$diem+$mangdiemcham[$i];
        }

        $dg=danhgia_tuluan::where('maPhieuCham',$request->maPhieuCham)->sum('diemDG');
        
        $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)->first();

        $pc->diemChu=CommonController::tinh_diem_chu($diem);
        $pc->xepHang=CommonController::tinh_xep_hang($diem);

        $pc->trangThai=true;
        $pc->diemSo=$diem;
       
       
        $pc->loaiCB=2;

        //Hết Mai sửa
        $pc->yKienDongGop=$request->yKienDongGop;
        $pc->save();

        CommonController::success_notify('Thêm thành công','Adding successfully');
        
        return redirect('/giang-vien/cham-diem-bao-cao/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Chấm điểm thành công!');
    }

    
    public function xem_ket_qua_thuc_hanh($maDe,$maSSV)
    {
         //đề thi
         $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)
         ->first();
         //giảng viên
         $gv=phieu_cham::where('phieu_cham.isDelete',false)
         ->where('maDe',$maDe)
         ->where('phieu_cham.maGV',Session::get('maGV'))
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

        if($dethi){
            $noidung=dethi_cauhoituluan::where('de_thi_cauhoi_tuluan.maDe',$dethi->maDe)
            ->orderBy('de_thi_cauhoi_tuluan.maCauHoi')
            ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->get();

            foreach ($noidung as $tc) {
                $cdr3=CDR3::where('isDelete',false)
                    ->where('maCDR3', $tc->maCDR3)
                    ->get(['maCDR3VB', 'tenCDR3']);
                $tc->tenCDR3=$cdr3[0]["tenCDR3"];
                $tc->maCDR3VB=$cdr3[0]["maCDR3VB"];

                //lay diem cham trong phieu cham. Mai thêm magv để tách gv1, gv2
                $diemCham=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->join('danhgia_tuluan',function($x) use ($tc){
                    $x->on('phieu_cham.maPhieuCham','=','danhgia_tuluan.maPhieuCham')
                    ->where('danhgia_tuluan.maPATL',$tc->maPATL);
                    })
                ->get(['danhgia_tuluan.maPATL','danhgia_tuluan.diemDG']);
                
                if(count($diemCham)>0){
                    $tc->diemDG=$diemCham[0]->diemDG;
                }
                else{
                    $tc->diemDG=0;
                }
           }
        }else{
            CommonController::warning_notify('Không tìm thấy bài thi',"Can't found examination");
            return back();
        }

        $pc=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->first();
        return view('giangvien.chambc.thuchanh.xemketquachamthuchanh',compact('dethi','gv','sv','noidung','pc'));
    }

    public function sua_diem_thuc_hanh($maDe,$maSSV)
    {
        //đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)
        ->first();
        //giảng viên
        $gv=phieu_cham::where('phieu_cham.isDelete',false)
        ->where('maDe',$maDe)
        ->where('phieu_cham.maGV',Session::get('maGV'))
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

        if($dethi){
            $noidung=dethi_cauhoituluan::where('de_thi_cauhoi_tuluan.maDe',$dethi->maDe)
            ->orderBy('de_thi_cauhoi_tuluan.maCauHoi')
            ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->get();
            foreach ($noidung as $tc) {
                $cdr3=CDR3::where('isDelete',false)
                    ->where('maCDR3', $tc->maCDR3)
                    ->get(['maCDR3VB', 'tenCDR3']);
                $tc->tenCDR3=$cdr3[0]["tenCDR3"];
                $tc->maCDR3VB=$cdr3[0]["maCDR3VB"];

                //lay diem cham trong phieu cham.  Mai có thêm phần session gv để lấy điểm của đúng gv chấm (do có trường hợp 2 gv chấm cho 1 sv)
                $diemCham=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.maGV',Session::get('maGV'))
                ->where('phieu_cham.loaiCB',2)
                ->join('danhgia_tuluan',function($x) use ($tc){
                    $x->on('phieu_cham.maPhieuCham','=','danhgia_tuluan.maPhieuCham')
                        ->where('danhgia_tuluan.maPATL',$tc->maPATL);
                    })
                ->get(['danhgia_tuluan.maPATL','danhgia_tuluan.diemDG']);
                
                if(count($diemCham)>0){
                    $tc->diemDG=$diemCham[0]->diemDG;
                }
                else{
                    $tc->diemDG=0;
                }
            }
             
        }else{
            CommonController::warning_notify('Không tìm thấy bài thi',"Can't found examination");
            return back();
        }
        $pc=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->first();
        return view('giangvien.chambc.thuchanh.suadiemthuchanh',compact('dethi','gv','sv','noidung','pc'));
    }

    public function sua_diem_thuc_hanh_submit(Request $request)
    {
        $st2= count($request->chamdiem1);
        $mangdiemcham = array();        
        $spt=0;   
        for($i=0; $i<$st2; $i++)
            if($request->chamdiem1[$i]>0)
            {
                $mangdiemcham[$spt]= $request->chamdiem1[$i];
                $spt++;
            }         
        $diem=0;
        danhgia_tuluan::where('maPhieuCham',$request->maPhieuCham)->delete();

        for($i=0;$i<$spt;$i++)      
        {
            $dg=new danhgia_tuluan();
            $dg->maPATL=$request->chamdiem[$i]; 
            $dg->diemDG= $mangdiemcham[$i];
            $dg->maPhieuCham=$request->maPhieuCham;
            $dg->save();
            $diem=$diem+$mangdiemcham[$i];
        }

        $dg=danhgia_tuluan::where('maPhieuCham',$request->maPhieuCham)->sum('diemDG');
        
        $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)->first();

        $pc->diemChu=CommonController::tinh_diem_chu($diem);
        $pc->xepHang=CommonController::tinh_xep_hang($diem);

        $pc->trangThai=true;
        $pc->diemSo=$diem;
        $pc->loaiCB=2;

        $pc->yKienDongGop=$request->yKienDongGop;
        $pc->save();

        CommonController::success_notify('Thêm thành công','Adding successfully');

        return redirect('/giang-vien/cham-diem-bao-cao/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
    }

}
