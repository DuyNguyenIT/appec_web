<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\lop;
use App\Models\CDR3;
use App\Models\deThi;
use App\Models\danhGia;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\sinhVien;
use App\Models\giangVien;
use App\Models\noiDungQH;
use App\Models\phieu_cham;
use App\Models\loaiDanhGia;
use Illuminate\Http\Request;
use App\Models\loaiHTDanhGia;
use App\Models\tieuChiChamDiem;
use App\Models\ct_bai_quy_hoach;
use App\Http\Controllers\Controller;

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
        Session::put('maCTBaiQH',$maCTBaiQH);
        //kiểm loại ht đánh giá
        $loaiHTDG=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->first('maLoaiHTDG');

        $ctbqh=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->first();
        
        Session::put('maGV_2',$ctbqh->maGV_2);

        $gv2=giangVien::where('isDelete',false)
        ->where('maGV',Session::get('maGV_2'))
        ->first();

        if($gv2==null){
            $gv2= new giangVien();
            $gv2->hoGV="";
            $gv2->tenGV="Nhiều giảng viên";
        }

        if($loaiHTDG->maLoaiHTDG=="T1"){ //kết quả tự luận
            //thông tin học phần
            $hp=hocPhan::where('maHocPhan',Session::get('maHocPhan'))
            ->where('isDelete',false)->first();
            //danh sách đề thi
            $deThi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
            //danh sách sinh viên
            $dssv=sinhVien::where('isDelete',false)->where('maLop',Session::get('maLop'))->get();
            //
            return view('giangvien.ketqua.tuluan.ketquatuluan',compact('hp','dssv','deThi'));
        }

        if($loaiHTDG->maLoaiHTDG=="T2"){ //kết quả trắc nghiệm
            return view('giangvien.ketqua.tracnghiem.ketquatracnghiem');
        }
        
        if($loaiHTDG->maLoaiHTDG=="T3"){ //kết quả thực hành
            return view('giangvien.ketqua.thuchanh.ketquathuchanh');
        }

        if($loaiHTDG->maLoaiHTDG=="T8") /// nếu kết quả là đồ án
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
                 ->where('phieu_cham.maGV',Session::get('maGV'))
                 ->where('phieu_cham.isDelete',false);
             })
             ->leftJoin('sinh_vien',function($y){
                 $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                 ->where('sinh_vien.isDelete',false);
             })
             ->orderBy('phieu_cham.maDe','desc')
             ->get(['de_thi.maDeVB','de_thi.maDe','de_thi.tenDe','sinh_vien.maSSV','sinh_vien.HoSV','sinh_vien.TenSV','phieu_cham.maPhieuCham','phieu_cham.trangThai','phieu_cham.diemSo']);
            
            
            foreach ($maDe as $md) {
                $temp=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maCTBaiQH',$maCTBaiQH)
                ->where('de_thi.maDe',$md->maDe)
                ->Join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',2)
                    ->where('phieu_cham.isDelete',false);
                })->first();
                $md->diemCB2=$temp->diemSo;
            }
            
             //ct_bai_QH
            return view('giangvien.ketqua.ketquadoan',['hp'=>$hp,'gv'=>$gv,'gv2'=>$gv2,
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
        $pc->loaiCB=1;
        $pc->yKienDongGop=$request->yKienDongGop;
        $pc->update();
        return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Chấm điểm thành công!');
    }

    public function xem_ket_qua_danh_gia($maDe,$maSSV,$maCanBo)
    {

        if($maCanBo==1){
            $deTai=phieu_cham::where('phieu_cham.isDelete',false)
            ->where('phieu_cham.maDe',$maDe)
            ->where('phieu_cham.maSSV',$maSSV)
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->join('de_thi',function($x){
                $x->on('de_thi.maDe','=','phieu_cham.maDe')
                ->where('de_thi.isDelete',false);
            })
            ->first();

             //giảng viên
            $gv=phieu_cham::where('phieu_cham.isDelete',false)
            ->where('phieu_cham.maDe',$maDe)
            ->where('phieu_cham.maSSV',$maSSV)
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->join('giang_vien',function($x){
                $x->on('giang_vien.maGV','=','phieu_cham.maGV')
                ->where('giang_vien.isDelete',false);
            })
            ->first(['giang_vien.maGV','hoGV','tenGV','phieu_cham.maPhieuCham']);
            

            //sinh viên
            $sv=phieu_cham::where('phieu_cham.isDelete',false)
            ->where('phieu_cham.maDe',$maDe)
            ->where('phieu_cham.maSSV',$maSSV)
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->join('sinh_vien',function($y){
                $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                ->where('sinh_vien.isDelete',false);
            })
            ->first();
            
        }
        else{
           

             //giảng viên
            if(Session::get('maGV_2')!='00000'){
                $deTai=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->join('de_thi',function($x){
                    $x->on('de_thi.maDe','=','phieu_cham.maDe')
                    ->where('de_thi.isDelete',false);
                })
                ->first();
                $gv=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->join('giang_vien',function($x){
                    $x->on('giang_vien.maGV','=','phieu_cham.maGV')
                    ->where('giang_vien.isDelete',false);
                })
                ->first(['giang_vien.maGV','hoGV','tenGV','phieu_cham.maPhieuCham']);
                //sinh viên
                $sv=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.maGV',Session::get('maGV_2'))
                ->join('sinh_vien',function($y){
                    $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                    ->where('sinh_vien.isDelete',false);
                })
                ->first();
            }else{
                $deTai=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.loaiCB',$maCanBo)
                ->join('de_thi',function($x){
                    $x->on('de_thi.maDe','=','phieu_cham.maDe')
                    ->where('de_thi.isDelete',false);
                })
                ->first();
                $gv=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.loaiCB',$maCanBo)
                ->join('giang_vien',function($x){
                    $x->on('giang_vien.maGV','=','phieu_cham.maGV')
                    ->where('giang_vien.isDelete',false);
                })
                ->first(['giang_vien.maGV','hoGV','tenGV','phieu_cham.maPhieuCham']);
                //sinh viên
                $sv=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.loaiCB',$maCanBo)
                ->join('sinh_vien',function($y){
                    $y->on('phieu_cham.maSSV','=','sinh_vien.maSSV')
                    ->where('sinh_vien.isDelete',false);
                })
                ->first();
            }

            
        }
        
        

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
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.loaiCB',$maCanBo)
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
    
        return view('giangvien.ketqua.xemKetQuaCham',['tieuchi'=>$ndQh,'sv'=>$sv,'gv'=>$gv,'deTai'=>$deTai]);

    }

    ####-----------------------------TỰ LUẬN---------------
    public function them_phieu_cham_tu_luan(Request $request)
    {
        return $request;
        //thêm phiếu châm tự luạn
        //
    }
}
