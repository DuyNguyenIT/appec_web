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
use App\Models\deThi_cauHoi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\loaiHTDanhGia;
use App\Models\danhgia_tuluan;
use App\Models\phuongAnTuLuan;
use App\Exports\diemDoAnExport;
use App\Models\tieuChiChamDiem;
use App\Models\ct_bai_quy_hoach;
use App\Models\sinhvien_hocphan;
use App\Models\danhgia_tracnghiem;
use App\Models\dethi_cauhoituluan;
use App\Models\phuongAnTracNghiem;
use App\Exports\diemThucHanhExport;
use App\Http\Controllers\Controller;
use App\Exports\diemTracNghiemExport;
use App\Http\Controllers\CommonController;

class ketQuaDanhGiaController extends Controller
{
    public function index()
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
           
           $hp=hocPhan::getHocPhanByMaHocPhan($maHocPhan);

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
        //kiểm loại ht đánh giá (tu luan, trac nghiem, thuc hanh, do an,...)
        $loaiHTDG=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->first(['maLoaiHTDG','maLoaiDG']);//Mai thêm để lấy thêm loại đánh giá

        $ctbqh=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->first();
        
        Session::put('maGV_2',$ctbqh->maGV_2);

        $gv2=giangVien::where('isDelete',false)->where('maGV',Session::get('maGV_2'))->first();

        if($gv2==null){
            $gv2= new giangVien();
            $gv2->maGV='00000';
            $gv2->hoGV="";
            $gv2->tenGV="Nhiều giảng viên";
        }        

        if($loaiHTDG->maLoaiHTDG=="T1"){ //kết quả tự luận
            //thông tin học phần
            $hp=hocPhan::getHocPhanByMaHocPhan(Session::get('maHocPhan'));
            //danh sách đề thi
            $deThi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
            //check sinh vien da chon
            $svdachon=deThi::where('de_thi.isDelete',false)->where('de_thi.maCTBaiQH',$maCTBaiQH)
            ->join('phieu_cham','phieu_cham.maDe','=','de_thi.maDe')
            //->Leftjoin('sinh_vien','sinh_vien.maSSV','=','phieu_cham.maSSV')
            ->pluck('phieu_cham.maSSV');

            //danh sách sinh viên
            $dssv=sinhvien_hocphan::where('sinhvien_hocphan.maLop',Session::get('maLop'))
            ->where('sinhvien_hocphan.maHocPhan',Session::get('maHocPhan'))
            ->where('maHK',Session::get('maHK'))
            ->where('namHoc',Session::get('namHoc'))
            ->whereNotIn('sinhvien_hocphan.maSSV',$svdachon)
            ->join('sinh_vien','sinh_vien.maSSV','=','sinhvien_hocphan.maSSV')
            ->get();

            //phiếu chấm
            $phieucham=deThi::getPhieuChamByCTBQH($maCTBaiQH,Session::get('maGV'));
            //return $phieucham;
            return view('giangvien.ketqua.tuluan.ketquatuluan',compact('hp','dssv','deThi','phieucham'));
        }

        if($loaiHTDG->maLoaiHTDG=="T2"){ //kết quả trắc nghiệm
             //thông tin học phần
             $hp=hocPhan::getHocPhanByMaHocPhan(Session::get('maHocPhan'));
             //danh sách đề thi
             $deThi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
             //check sinh vien da chon
             $svdachon=deThi::where('de_thi.isDelete',false)->where('de_thi.maCTBaiQH',$maCTBaiQH)
             ->join('phieu_cham','phieu_cham.maDe','=','de_thi.maDe')
             //->Leftjoin('sinh_vien','sinh_vien.maSSV','=','phieu_cham.maSSV')
             ->pluck('phieu_cham.maSSV');
 
             //danh sách sinh viên
             //danh sách sinh viên
            $dssv=sinhvien_hocphan::where('sinhvien_hocphan.maLop',Session::get('maLop'))
            ->where('sinhvien_hocphan.maHocPhan',Session::get('maHocPhan'))
            ->where('maHK',Session::get('maHK'))
            ->where('namHoc',Session::get('namHoc'))
            ->whereNotIn('sinhvien_hocphan.maSSV',$svdachon)
            ->join('sinh_vien','sinh_vien.maSSV','=','sinhvien_hocphan.maSSV')
            ->get();
 
             //phiếu chấm
             $phieucham=deThi::getPhieuChamByCTBQH($maCTBaiQH,Session::get('maGV'));
             
            return view('giangvien.ketqua.tracnghiem.ketquatracnghiem',compact('hp','dssv','deThi','phieucham'));
        }
         //Mai sửa để mời gv chấm 2 cho thi thực hành
        if($loaiHTDG->maLoaiHTDG=="T3"){ //kết quả thực hành
            $loaidanhgia=$loaiHTDG->maLoaiDG;//Mai thêm để xác định loại đánh giá là thi kết thúc hay quá trình 
            //giảng viên
            $gv=giangVien::where('isDelete',false) ->where('maGV','!=',Session::get('maGV'))->get(); //Mai thêm để lấy ds gv
            //thông tin học phần
            $hp=hocPhan::getHocPhanByMaHocPhan(Session::get('maHocPhan'));
            //danh sách đề thi
            $deThi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
            //check sinh vien da chon
            $svdachon=deThi::where('de_thi.isDelete',false)->where('de_thi.maCTBaiQH',$maCTBaiQH)
            ->join('phieu_cham','phieu_cham.maDe','=','de_thi.maDe')
            //->Leftjoin('sinh_vien','sinh_vien.maSSV','=','phieu_cham.maSSV')
            ->pluck('phieu_cham.maSSV');

            //danh sách sinh viên. Mai thêm phần join để hiện được tên SV trong danh sách chọn
            $dssv=sinhvien_hocphan::where('sinhvien_hocphan.maLop',Session::get('maLop'))
            ->where('sinhvien_hocphan.maHocPhan',Session::get('maHocPhan'))
            ->where('maHK',Session::get('maHK'))
            ->where('namHoc',Session::get('namHoc'))
            ->whereNotIn('sinhvien_hocphan.maSSV',$svdachon)
            ->join('sinh_vien','sinh_vien.maSSV','=','sinhvien_hocphan.maSSV')
            ->get();

            //phiếu chấm
            $phieucham=deThi::getPhieuChamByCTBQH($maCTBaiQH,Session::get('maGV'));
           // return $phieucham;
            //Mai thêm để hiện điểm CB2
            if($loaidanhgia==3){
                foreach ($phieucham as $pc2) {
                    $temp=deThi::where('de_thi.isDelete',false)
                    ->where('de_thi.maCTBaiQH',$maCTBaiQH)
                    ->where('de_thi.maDe',$pc2->maDe)
                    ->join('phieu_cham',function($z){
                        $z->on('phieu_cham.maDe','=','de_thi.maDe')
                        ->where('phieu_cham.loaiCB',2)
                        ->where('phieu_cham.isDelete',false);
                    })
                    ->where('phieu_cham.maSSV',$pc2->maSSV)
                    ->first();
                    if($temp){
                        $pc2->diemCB2=$temp->diemSo;
                        $pc2->trangThaiGV2=$temp->trangThai;
                    }else{
                        $pc2->diemCB2=0;
                        $pc2->trangThaiGV2=false;
                    }
                    
                }
                return view('giangvien.ketqua.thuchanh.ketquathuchanh_CuoiKi',compact('hp','dssv','deThi','phieucham','loaidanhgia','gv','gv2'));
            }
            
            //return $phieucham;
            return view('giangvien.ketqua.thuchanh.ketquathuchanh',compact('hp','dssv','deThi','phieucham','loaidanhgia','gv','gv2'));
        }

        if($loaiHTDG->maLoaiHTDG=="T8"  || $loaiHTDG->maLoaiHTDG=="T6") /// neu ket qua la do an hoac hoi thao
        {
            //danh gia cuoi ki co 2 giao vien cham
            
            $hp=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();
            
            $gv=giangVien::where('isDelete',false)
            ->where('maGV',Session::get('maGV'))
            ->first();
            $maDe=deThi::getPhieuChamByCTBQH($maCTBaiQH,Session::get('maGV'));
             //kiem tra loai danh gia (giua ki, cuoi ki,...)
             if($ctbqh->maLoaiDG<3){ //(loai danh gia la qua trinh 1,2)
                   //ct_bai_QH
                return view('giangvien.ketqua.ketquadoan_giuaki',['hp'=>$hp,'gv'=>$gv,'deThi'=>$maDe]);
             }else{ ///loai danh gia là cuoi kì, co 2 nguoi cham, tien hanh lay diem cham cua cb2
                if($maDe){
                    foreach ($maDe as $md) {
                        $temp=deThi::where('de_thi.isDelete',false)
                        ->where('de_thi.maCTBaiQH',$maCTBaiQH)
                        ->where('de_thi.maDe',$md->maDe)
                        
                        ->orderBy('de_thi.maDe')
                        ->Join('phieu_cham',function($x) use ($md){
                            $x->on('phieu_cham.maDe','=','de_thi.maDe')
                            ->where('phieu_cham.maSSV',$md->maSSV)
                            ->where('phieu_cham.loaiCB',2)
                            ->where('phieu_cham.isDelete',false);
                        })->first(); //lay diem cham cua can bo 2
                        
                        if($temp){
                            $md->diemCB2=$temp->diemSo;
                        }
                    }
                }
             }
             //ct_bai_QH
            return view('giangvien.ketqua.ketquadoan',['hp'=>$hp,'gv'=>$gv,'gv2'=>$gv2,
            'deThi'=>$maDe]);
        }
        return view('giangvien.error');
    }

      ####-----------------------------ĐỒ ÁN---------------
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

       return view('giangvien.ketqua.nhapDiemDoan',['tieuchi'=>$ndQh,'deTai'=>$deTai,'gv'=>$gv,'sv'=>$sv]);
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
        $dg=danhGia::where('maPhieuCham',$request->maPhieuCham)->sum('diemDG');
        

        $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)->first();
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
            //---code nay kiem tra neu loai danh gia la giua ki thi khong hien thi ket qua cua can bo 2
            $ctbqh=ct_bai_quy_hoach::where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
            if($ctbqh){
                if($ctbqh->maLoaiDG<3){
                    CommonController::warning_notify('Loại giữa kì không có cán bộ 2','Midterm  exam has not granding officer 2');
                    return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
                    
                }
            }
            //----end----------------------------------------------------------------------------------

             //giảng viên
            if(Session::get('maGV_2')!='00000'){   //neu khong co giang vien cham 2
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
    //viet
    public function sua_ket_qua_danh_gia_do_an($maDe,$maSSV,$maCanBo)
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

                 //---code nay kiem tra neu loai danh gia la giua ki thi khong hien thi ket qua cua can bo 2
                $ctbqh=ct_bai_quy_hoach::where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
                if($ctbqh){
                    if($ctbqh->maLoaiDG<3){
                        CommonController::warning_notify('Loại giữa kì không có cán bộ 2','Midterm  exam has not granding officer 2');
                        return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
                        
                    }
                }
                //------------------------------------------------------------------------------------------

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

                $pc=phieu_cham::where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->where('phieu_cham.loaiCB',$maCanBo)
                ->join('danh_gia',function($x) use ($tc){
                    $x->on('phieu_cham.maPhieuCham','=','danh_gia.maPhieuCham')
                     ->where('danh_gia.maTCCD',$tc->maTCCD);
                    // ->where('danh_gia.maTCCD',532);
                    })
                ->get(['danh_gia.maTCCD','danh_gia.diemDG']);  
                
              
                if(count($pc)>0){
                    $tc->diemDG=$pc[0]->diemDG;
                }
                else{
                    $tc->diemDG=0;
                }
            }
            
            return view('giangvien.ketqua.suadiemchamdoan',['tieuchi'=>$ndQh,'sv'=>$sv,'gv'=>$gv,'deTai'=>$deTai]);

    }

    public function export_bang_diem_do_an(Excel $excel,$maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new diemDoAnExport,'bang_diem_do_an.xlsx');
    }

    ####-----------------------------THỰC HÀNH---------------
    public function them_mot_phieu_cham_thuc_hanh(Request $request)  // CHẠY--ĐÃ TEST
    {
        //kiem tra de thi da du cau hoi
        $deThi=deThi::find($request->maDe);
        $soCauHoi=dethi_cauhoituluan::where('maDe',$request->maDe)
        ->distinct(['maDe','maCauHoi'])
        ->get(['maDe','maCauHoi']);
        if($deThi->soCauHoi>$soCauHoi->count('maCauHoi')){
            CommonController::warning_notify('Đề thi chưa đủ câu hỏi','The examination don not enough question');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
        $noidung=dethi_cauhoituluan::where('de_thi_cauhoi_tuluan.maDe',$request->maDe)
        ->orderBy('de_thi_cauhoi_tuluan.maCauHoi')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
        ->get(['de_thi_cauhoi_tuluan.maDe','cau_hoi.maCauHoi','diemPA']);

        $dct=0.0;
        foreach ($noidung as $tc)         
        {
                   $dct= $dct+ $tc->diemPA;
        }
        if(number_format($dct,2) !=10.00)
        {
            CommonController::warning_notify('Đề thi khác 10 điểm','Another exam 10 points');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
        if($request->dssv==null){
            CommonController::warning_notify('Không tìm thấy sinh viên','Do not found students');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
        //tien hanh them
        //Mai bổ sung để thực hiện cho 2 trường hợp thi và kiểm tra
        $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
        if($ct_bqh!=null && $ct_bqh->maLoaiDG !=3 && $ct_bqh->maLoaiHTDG=='T3'){//dạng thực hành làm quá trình nên cho phép 1 người chấm
            foreach ($request->dssv as $sv) {
                phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$sv,'maDe'=>$request->maDe]);
            }
            CommonController::success_notify('Thêm thành công','Adding successfully');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }

        //kiễm tra đã mời hay chưa -- đối với dạng thi thực hành 2 người chấm 
        if($ct_bqh->maGV_2){
            if($ct_bqh->maGV_2!='00000'){ //nếu không cần mời thêm cán bộ 2 ( mã CB 2 =0000) (đã mời cán bộ chấm rồi)
                foreach ($request->dssv as $sv) {
                    //cb1
                    phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$sv,'maDe'=>$request->maDe]);
                    //cb2
                    phieu_cham::create(['maGV'=>$ct_bqh->maGV_2,'loaiCB'=>2,'maSSV'=>$sv,'maDe'=>$request->maDe]);
                }
                CommonController::success_notify('Thêm thành công','Adding successfully');
                return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
            }
            else{
                foreach ($request->dssv as $sv) {
                    //cb1
                    phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$sv,'maDe'=>$request->maDe]);
                    //cb2
                    phieu_cham::create(['maGV'=>$request->maGV_2,'loaiCB'=>2,'maSSV'=>$sv,'maDe'=>$request->maDe]);
                }
                CommonController::success_notify('Thêm thành công','Adding successfully');
                return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
            }
        }
        else{
            CommonController::warning_notify('Chưa mời giảng viên chấm báo cáo!','Dont have instructor');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
    }


     //Mai khóa, chạy cái của Mai để kiểm soát thêm phiếu chấm cho thi thực hành kết thúc hoặc kiểm tra quá trình thực hành    

    // public function them_nhieu_phieu_cham_thuc_hanh(Request $request)  //CHƯA CHẠY
    // {

    //     $deThi=deThi::find($request->maDe);
    //     $soCauHoi=dethi_cauhoituluan::where('maDe',$request->maDe)
    //     ->distinct(['maDe','maCauHoi'])
    //     ->get(['maDe','maCauHoi']);
    //     if($deThi->soCauHoi>$soCauHoi->count('maCauHoi')){
    //         CommonController::warning_notify('Đề thi chưa đủ câu hỏi','The examination don not enough question');
    //         return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
    //     }
    //     //     $dssv=sinhvien_hocphan::where('isDelete',false)->where('maLop',Session::get('maLop'))
    //     //     ->where('maHocPhan',Session::get('maHocPhan'))
    //     //     ->where('maHK',Session::get('maHK'))
    //     //     ->where('namHoc',Session::get('namHoc'))
    //     //     ->get('maSSV');
    //     //   foreach ($dssv as $data)
    //     //    {
    //     //      $svtam1 = phieu_cham::where('maGV',Session::get('maGV'))->where('maSSV',$data->maSSV)->where('maDe',$request->maDetam)->first();
    //     //      $svtam1->isDelete= true;
    //     //      $svtam1->update();

    //     //    $svtam = phieu_cham::where('maGV',Session::get('maGV'))->where('maSSV',$data->maSSV)->where('maDe',$request->maDe)->first();
    //     //    if($svtam)
    //     //    {
            
    //     //       $svtam->isDelete= false;
    //     //       $svtam->update();
    //     //    }
    //     //    else
    //     //    {
    //     //       phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$data->maSSV,'maDe'=>$request->maDe]);           
    //     //   }
    //     // }
    //     //danh sach sinh vien da co ma de
    //     // $svdachon=deThi::where('de_thi.isDelete',false)->where('de_thi.maCTBaiQH',Session::get('maCTBaiQH'))
    //     // ->join('phieu_cham','phieu_cham.maDe','=','de_thi.maDe')
    //     // ->pluck('phieu_cham.maSSV');

    //     // if($svdachon){
    //     //     //danh sách sinh viên
    //     //     $dssv=sinhvien_hocphan::where('isDelete',false)->where('maLop',Session::get('maLop'))
    //     //     ->where('maHocPhan',Session::get('maHocPhan'))
    //     //     ->where('maHK',Session::get('maHK'))
    //     //     ->where('namHoc',Session::get('namHoc'))
    //     //     ->whereNotIn('maSSV',$svdachon)->get();
    //     // }else{  
    //     //     //danh sách sinh viên
    //     //     $dssv=sinhvien_hocphan::where('isDelete',false)->where('maLop',Session::get('maLop'))
    //     //     ->where('maHocPhan',Session::get('maHocPhan'))
    //     //     ->where('maHK',Session::get('maHK'))
    //     //     ->where('namHoc',Session::get('namHoc'))
    //     //     ->get();
    //     // }

    //     // foreach ($dssv as $data) {
    //     //     phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$data->maSSV,'maDe'=>$request->maDe]);
    //     // }

    //     //thay viet code
        
    //     $noidung=dethi_cauhoituluan::where('de_thi_cauhoi_tuluan.maDe',$request->maDe)
    //     ->orderBy('de_thi_cauhoi_tuluan.maCauHoi')
    //     ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
    //     ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
    //     ->get(['de_thi_cauhoi_tuluan.maDe','cau_hoi.maCauHoi','diemPA']);

    //     $dct=0.0;
    //     //kiem tra diem da du 10
    //     foreach ($noidung as $tc)         
    //     {
    //         $dct= $dct+ $tc->diemPA;
    //     }
    //     if(number_format($dct,2) !=10)
    //     {
    //         CommonController::warning_notify('Đề thi khác 10 điểm chọn lại đề khác nhé!!!','The examination don not enough question');
    //         return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
    //     }
    //     //doi de thi
    //     $dssv=sinhvien_hocphan::where('isDelete',false)->where('maLop',Session::get('maLop'))
    //     ->where('maHocPhan',Session::get('maHocPhan'))
    //     ->where('maHK',Session::get('maHK'))
    //     ->where('namHoc',Session::get('namHoc'))
    //     ->get('maSSV');  
        
    //     foreach ($dssv as $data)
    //     { 
    //         if($request->maDetam) //neu da co phieu cham thi doi de
    //         {
    //             // if($request->maDetam== $request->maDe)
    //             // {
    //             //     CommonController::warning_notify('Trùng đề củ. chọn lại đề khác nhé!!!','The examination don not enough question');
    //             //     return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
    //             // }
    //             if($request->maDetam!= $request->maDe){
    //                 foreach ($request->maDetam as $mdt) {
    //                     $mpcham=phieu_cham::where('maGV',Session::get('maGV'))->where('maSSV',$data->maSSV)->where('maDe',$mdt)->get();
    //                     if($mpcham){
    //                         foreach($mpcham as $pc){
    //                             //xoa danh gia
    //                             danhgia_tuluan::where('maPhieuCham',$pc->maPhieuCham)->delete();
    //                             ///tao phieu danh gia moi
    //                             phieu_cham::create(['maGV'=>$pc->maGV,'maSSV'=>$data->maSSV,'maDe'=>$request->maDe,'loaiCB'=>$pc->maCanBo]);
    //                             //xoa phieu cham cu
    //                             phieu_cham::where('maPhieuCham',$pc->maPhieuCham)->delete();
    //                         }
    //                     }
    //                 }
    //             }
                
    //         }
    //         else{//neu chua co thi them phieu cham moi
    //             phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$data->maSSV,'maDe'=>$request->maDe]);           
    //         }
    //     }

    //     //thay viet code
    //     CommonController::success_notify('Thêm thành công','Adding successfully');
    //     return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
    // }


    public function them_nhieu_phieu_cham_thuc_hanh(Request $request)  //đã CHẠY Code Mai sửa
    {
        $deThi=deThi::find($request->maDe);
        $soCauHoi=dethi_cauhoituluan::where('maDe',$request->maDe)
        ->distinct(['maDe','maCauHoi'])
        ->get(['maDe','maCauHoi']);
        if($deThi->soCauHoi>$soCauHoi->count('maCauHoi'))
        {
            CommonController::warning_notify('Đề thi chưa đủ câu hỏi','The examination don not enough question');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
        $noidung=dethi_cauhoituluan::where('de_thi_cauhoi_tuluan.maDe',$request->maDe)
        ->orderBy('de_thi_cauhoi_tuluan.maCauHoi')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
        ->get(['de_thi_cauhoi_tuluan.maDe','cau_hoi.maCauHoi','diemPA']);
        $dct=0.0;
        foreach ( $noidung as $tc)         
        {
            $dct= $dct + $tc->diemPA;
        }      
        if(number_format($dct,2) !=10)
        {
            CommonController::warning_notify('Đề thi khác 10 điểm','Another exam 10 points');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }  

        /*


        //danh sach sinh vien da co ma de
        $svdachon=deThi::where('de_thi.isDelete',false)->where('de_thi.maCTBaiQH',Session::get('maCTBaiQH'))
        ->join('phieu_cham','phieu_cham.maDe','=','de_thi.maDe')
        ->pluck('phieu_cham.maSSV');
        
        if(count($svdachon)>0){
            //danh sách sinh viên
            $dssv=sinhvien_hocphan::where('isDelete',false)->where('maLop',Session::get('maLop'))
            ->where('maHocPhan',Session::get('maHocPhan'))
            ->where('maHK',Session::get('maHK'))
            ->where('namHoc',Session::get('namHoc'))
            ->whereNotIn('maSSV',$svdachon)->get('maSSV');
        }
        else{  
            //danh sách sinh viên
            $dssv=sinhvien_hocphan::where('isDelete',false)->where('maLop',Session::get('maLop'))
            ->where('maHocPhan',Session::get('maHocPhan'))
            ->where('maHK',Session::get('maHK'))
            ->where('namHoc',Session::get('namHoc'))->get('maSSV');
        }
        */

        $dssv=sinhvien_hocphan::where('isDelete',false)
        ->where('maLop',Session::get('maLop'))
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->where('maHK',Session::get('maHK'))
        ->where('namHoc',Session::get('namHoc'))
        ->get();    
        //return $dssv;
        if(count($dssv)==0)
        {
            CommonController::warning_notify('Không tìm thấy sinh viên','Do not found students');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
       
        //tien hanh them
        $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
      
        if($ct_bqh!=null && $ct_bqh->maLoaiDG !=3 && $ct_bqh->maLoaiHTDG=='T3')     
        {
       
            foreach ($dssv as $data)
            { 
                if($request->maDetam)
                 {
                   foreach ($request->maDetam as $mdt)
                   {
                        if($mdt != $request->maDe)
                        {
                            $mpcham=phieu_cham::where('maGV',Session::get('maGV'))->where('maSSV',$data->maSSV)->where('maDe',$mdt)->get();
                            if($mpcham)
                             {
                                 foreach($mpcham as $pc)
                                 {
                                    //xoa danh gia
                                    danhgia_tuluan::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                    ///tao phieu danh gia moi
                                    phieu_cham::create(['maGV'=>$pc->maGV,'maSSV'=>$data->maSSV,'maDe'=>$request->maDe,'loaiCB'=>$pc->maCanBo]);
                                    //xoa phieu cham cu
                                    phieu_cham::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                 }
                             }
                        }
                    }
                }
                else
                {
                    phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$data->maSSV,'maDe'=>$request->maDe]);           
                } 
            }
            CommonController::success_notify('Thêm thành công','Adding successfully');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }

    
         //kiễm tra đã mời hay chưa -- đối với dạng thi thực hành 2 người chấm 
        if($ct_bqh->maGV_2)
        {
            if($ct_bqh->maGV_2!='00000')
            { 
               //nếu không cần mời thêm cán bộ 2 ( mã CB 2 =0000) (đã mời cán bộ chấm rồi)
               if($request->maDetam) //neu da co phieu cham thi doi de
                 {
                    for ($i1=0; $i1< count($request->maDetam);$i1++)
                    {
                            if($request->maDetam[$i1] != $request->maDe)
                            {
                                    $mpcham1=phieu_cham::where('maGV',Session::get('maGV'))->where('maSSV',$request->Dssvtam[$i1])->where('maDe',$request->maDetam[$i1])->get();
                                   
                                    $mpcham2=phieu_cham::where('maGV',$ct_bqh->maGV_2)->where('maSSV',$request->Dssvtam[$i1])->where('maDe',$request->maDetam[$i1])->get();
                                   
                                  
                                  foreach($mpcham1 as $mp1)
                                  {
                                    danhgia_tuluan::where('maPhieuCham',$mp1->maPhieuCham)->delete();                                    
                                    phieu_cham::where('maPhieuCham',$mp1->maPhieuCham)->delete();
                                   // return 123;
                                  }
                                  foreach($mpcham2 as $mp2)
                                  {
                                    danhgia_tuluan::where('maPhieuCham',$mp2->maPhieuCham)->delete();
                                    phieu_cham::where('maPhieuCham',$mp2->maPhieuCham)->delete();
                                  }                              
                                  phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$request->Dssvtam[$i1],'maDe'=>$request->maDe]);
                                  phieu_cham::create(['maGV'=>$ct_bqh->maGV_2,'loaiCB'=>2,'maSSV'=>$request->Dssvtam[$i1],'maDe'=>$request->maDe]);                             
                            }

                         }                                           

                 }
                else
                 {  
                   
                     foreach($dssv as $ms)
                     {                    
                       phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$ms->maSSV,'maDe'=>$request->maDe]);                       
                       phieu_cham::create(['maGV'=>$ct_bqh->maGV_2,'loaiCB'=>2,'maSSV'=>$ms->maSSV,'maDe'=>$request->maDe]);
                      }
                }
                
                CommonController::success_notify('Thêm thành công','Adding successfully');
                return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
            }
            else
            {
                foreach ($dssv as $data) 
                {
                    //cb1
                    phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$data->maSSV,'maDe'=>$request->maDe]);
                    //cb2
                    phieu_cham::create(['maGV'=>$ct_bqh->maGV_2,'loaiCB'=>2,'maSSV'=>$data->maSSV,'maDe'=>$request->maDe]);
                }
                CommonController::success_notify('Thêm thành công','Adding successfully');
                return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH')); 
            }
        }
        else
        {
            CommonController::warning_notify('Chưa mời giảng viên chấm báo cáo!','Dont have instructor');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
        
    }
    //Mời chấm thi thực hành. Mai thêm
    //-----mời chấm thi thực hành
    public function moi_cham_thuc_hanh(Request $request)
    {
        //kiễm tra đã mời hay chưa
        $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->first();
        if($ct_bqh){
            $ct_bqh->maGV_2=$request->maGV_2;
            $ct_bqh->update();
            alert()->success('Inviting instructor successfully','Messsage');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));

        }
        alert()->success('Errors','Warning');
        return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
    }

    //Hết Mai thêm 

    public function nhap_diem_thuc_hanh($maDe,$maSSV)  //CHẠY --ĐÃ TEST
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
            return back();
        }
        
        return view('giangvien.ketqua.thuchanh.nhapdiemthuchanh',compact('dethi','gv','sv','noidung'));

    }

    public function cham_diem_thuc_hanh_submit(Request $request) //CHẠY -- ĐÃ TEST
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
        //Mai sửa
        if(Session::get('maGV')==Session::get('maGV_1'))
            $pc->loaiCB=1;
        else if(Session::get('maGV')==Session::get('maGV_2'))
            $pc->loaiCB=2;
        else
            $pc->loaiCB=1;
        //Hết Mai sửa
        $pc->yKienDongGop=$request->yKienDongGop;
        $pc->save();

        CommonController::success_notify('Thêm thành công','Adding successfully');
        //Mai điều hướng cho 2 loại GV
        if(Session::get('maGV')==Session::get('maGV_2'))
            return redirect('/giang-vien/cham-diem-bao-cao/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
        else
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
        //Hết Mai sửa
        
    }

    public function cham_diem_thuc_hanh_submit1(Request $request) 
    {
        $diem=0;
        danhgia_tuluan::where('maPhieuCham',$request->maPhieuCham)->delete();
        foreach ($request->chamdiem as $maPATL) 
        { 
            $dg=new danhgia_tuluan();
            $patl=phuongAnTuLuan::where('id',$maPATL)
            ->first();
            $dg->maPATL=$maPATL;
            $dg->diemDG=$patl->diemPA;
            $dg->maPhieuCham=$request->maPhieuCham;
            $dg->update();
            $diem=$diem+$patl->diemPA;
        }

        $dg=danhgia_tuluan::where('maPhieuCham',$request->maPhieuCham)->sum('diemDG');
        
        $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)->first();

        $pc->diemChu=CommonController::tinh_diem_chu($diem);
        $pc->xepHang=CommonController::tinh_xep_hang($diem);

        $pc->trangThai=true;
        $pc->diemSo=$diem;
        $pc->loaiCB=1;
        $pc->yKienDongGop=$request->yKienDongGop;
        $pc->update();

        CommonController::success_notify('Cập nhật thành công','Adding successfully');
        return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
    }
    public function sua_diem_thuc_hanh(Type $var = null)
    {
        return 'Đang tiến hành...';
    }

    public function sua_diem_thuc_hanh_submit($maDe,$maSSV)
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

        return view('giangvien.ketqua.thuchanh.suadiemthuchanh',compact('dethi','gv','sv','noidung','pc'));
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
        return view('giangvien.ketqua.thuchanh.xemketquachamthuchanh',compact('dethi','gv','sv','noidung','pc'));

    }

    public function export_diem_thuc_hanh(Excel $excel, $maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new diemThucHanhExport,'bang_diem_thuc_hanh.xlsx');
    }

    ###-----------------------------tuc luan----------------
    public function them_mot_phieu_cham_tu_luan(Request $request)
    {
        $deThi=deThi::find($request->maDe);
        $soCauHoi=dethi_cauhoituluan::where('maDe',$request->maDe)
        ->distinct(['maDe','maCauHoi'])
        ->get(['maDe','maCauHoi',]);
        if($deThi->soCauHoi>$soCauHoi->count('maCauHoi')){
            CommonController::warning_notify('Đề thi chưa đủ câu hỏi','The examination don not enough question');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
       
        $noidung=dethi_cauhoituluan::where('de_thi_cauhoi_tuluan.maDe',$request->maDe)
        ->orderBy('de_thi_cauhoi_tuluan.maCauHoi')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
        ->get(['de_thi_cauhoi_tuluan.maDe','cau_hoi.maCauHoi','diemPA']);
        

        $dct=0.0;
        foreach ($noidung as $tc)         
          {
                   $dct= $dct+ $tc->diemPA;
          }
            if(number_format($dct,2) !=10)
            {
               CommonController::warning_notify('Đề thi khác 10 điểm','Another exam 10 points');
               return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
            }  
        //--thay viet code

        if($request->dssv==null){
            CommonController::warning_notify('Không tìm thấy sinh viên','Do not found students');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
        foreach ($request->dssv as $sv) {
            phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$sv,'maDe'=>$request->maDe]);
        }
        alert()->success('Adding successfully','Message');
        return back();
        //thêm phiếu châm tự luạn
    }

    public function them_nhieu_phieu_cham_tu_luan(Request $request)
    {
       
        $deThi=deThi::find($request->maDe);
        $soCauHoi=dethi_cauhoituluan::where('maDe',$request->maDe)
        ->distinct(['maDe','maCauHoi'])
        ->get(['maDe','maCauHoi']);
        if($deThi->soCauHoi>$soCauHoi->count('maCauHoi')){
            CommonController::warning_notify('Đề thi chưa đủ câu hỏi','The examination don not enough question');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }
        $noidung=dethi_cauhoituluan::where('de_thi_cauhoi_tuluan.maDe',$request->maDe)
        ->orderBy('de_thi_cauhoi_tuluan.maCauHoi')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
        ->get(['de_thi_cauhoi_tuluan.maDe','cau_hoi.maCauHoi','diemPA']);
        $dct=0.0;
        foreach ( $noidung as $tc)         
        {
            $dct= $dct + $tc->diemPA;
        }
      
        if(number_format($dct,2) !=10)
        {
            CommonController::warning_notify('Đề thi khác 10 điểm','Another exam 10 points');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }  

       
        //danh sách sinh viên
        $dssv=sinhvien_hocphan::where('isDelete',false)
        ->where('maLop',Session::get('maLop'))
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->where('maHK',Session::get('maHK'))
        ->where('namHoc',Session::get('namHoc'))
        ->get();    
        foreach ($dssv as $data)
        { 
            if($request->maDetam)
            {
                foreach ($request->maDetam as $mdt)
                   {
                        if($mdt != $request->maDe)
                        {
                            $mpcham=phieu_cham::where('maGV',Session::get('maGV'))->where('maSSV',$data->maSSV)->where('maDe',$mdt)->get();
                            if($mpcham)
                             {
                                 foreach($mpcham as $pc)
                                 {
                                    //xoa danh gia
                                    danhgia_tuluan::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                    ///tao phieu danh gia moi
                                    phieu_cham::create(['maGV'=>$pc->maGV,'maSSV'=>$data->maSSV,'maDe'=>$request->maDe,'loaiCB'=>$pc->maCanBo]);
                                    //xoa phieu cham cu
                                    phieu_cham::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                 }
                             }
                        }
                    }
                }
                else
                {
                    phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$data->maSSV,'maDe'=>$request->maDe]);           
                } 
            }           
        alert()->success('Adding successfully','Message');
        return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
    }    
    public function nhap_diem_tu_luan($maDe,$maSSV)
    {
         //đề thi
         $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
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
            return back();
        }
        return view('giangvien.ketqua.tuluan.nhapdiemtuluan',compact('dethi','gv','sv','noidung'));

    }

    public function cham_diem_tu_luan_submit(Request $request)
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
        
        $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)
        ->first();

        $pc->diemChu=CommonController::tinh_diem_chu($diem);
        $pc->xepHang=CommonController::tinh_xep_hang($diem);

        $pc->trangThai=true;
        $pc->diemSo=$diem;
        $pc->loaiCB=1;
        $pc->yKienDongGop=$request->yKienDongGop;
        $pc->update();

        alert()->success('Successfull','Message');
        return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
    }
    //viet
    public function sua_diem_tu_luan($maDe,$maSSV)
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

            //lay diem cham trong phieu cham
            $diemCham=phieu_cham::where('phieu_cham.isDelete',false)
            ->where('phieu_cham.maDe',$maDe)
            ->where('phieu_cham.maSSV',$maSSV)
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
        alert()->warning("Can't found examination",'Warning');
        return back();
        }

        $pc=phieu_cham::where('phieu_cham.isDelete',false)
            ->where('phieu_cham.maDe',$maDe)
            ->where('phieu_cham.maSSV',$maSSV)
            ->first();
        return view('giangvien.ketqua.tuluan.suadiemtuluan',compact('dethi','gv','sv','noidung','pc'));

    }

    public function sua_diem_tu_luan_submit(Request $request)
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
     $pc->loaiCB=1;
     $pc->yKienDongGop=$request->yKienDongGop;
     $pc->save();        
    

     alert()->success('Successfull','Message');
     return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));
 }

    public function xem_ket_qua_tu_luan($maDe,$maSSV)
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

                //lay diem cham trong phieu cham
                $diemCham=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
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
            alert()->warning("Can't found examination",'Warning');
            return back();
        }

        $pc=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->first();
        return view('giangvien.ketqua.tuluan.xemketquachamtuluan',compact('dethi','gv','sv','noidung','pc'));

    }

    public function export_diem_tu_luan(Excel $excel, $maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new diemTracNghiemExport,'bang_diem_tu_luan.xlsx');
    }

    ###--------------------------trac nghiem-------------------
    public function them_mot_phieu_cham_trac_nghiem(Request $request)
    {
        $deThi=deThi::find($request->maDe);
        $soCauHoi=deThi_cauHoi::where('maDe',$request->maDe)
        ->distinct(['maDe','maCauHoi'])
        ->get(['maDe','maCauHoi','diem']);
        if($deThi->soCauHoi>$soCauHoi->count('maCauHoi')){
            CommonController::warning_notify('Đề thi chưa đủ câu hỏi','The examination don not enough question');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }     

        $dct=0.0;
        foreach ($soCauHoi as $tc)         
        {
                   $dct= $dct+ $tc->diem;
        }
        if(number_format($dct,2) !=10.00)
        {
            CommonController::warning_notify('Đề thi khác 10 điểm','Another exam 10 points');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }

        if($request->dssv==null){
            CommonController::warning_notify('Không tìm thấy sinh viên','Do not found students');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }

        foreach ($request->dssv as $sv) {
            phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$sv,'maDe'=>$request->maDe]);
        }
        commonController::success_notify('Thêm thành công','Adding successfully');
        return back();
    }

    public function them_nhieu_phieu_cham_trac_nghiem(Request $request)
    {
        $deThi=deThi::find($request->maDe);
        $soCauHoi=deThi_cauHoi::where('maDe',$request->maDe)
        ->distinct(['maDe','maCauHoi'])
        ->get(['maDe','maCauHoi','diem']);      
       
       
        if($deThi->soCauHoi>$soCauHoi->count('maCauHoi')){
            CommonController::warning_notify('Đề thi chưa đủ câu hỏi','The examination don not enough question');
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }         
             
        $dct=0.0;
        foreach ($soCauHoi as $tc)         
        {
                   $dct = $dct + $tc->diem;
        }
     //  return $dct;
        if( number_format($dct,2) !=10 )
        {
               CommonController::warning_notify('Đề thi khác 10 điểm','Another exam 10 points');
               return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
        }       
        $dssv=sinhvien_hocphan::where('isDelete',false)->where('maLop',Session::get('maLop'))
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->where('maHK',Session::get('maHK'))
        ->where('namHoc',Session::get('namHoc'))
        ->get('maSSV');  

        foreach ($dssv as $data)
        {              
                if($request->maDetam){

                    foreach ($request->maDetam as $mdt) {
                        //kiem tra trung lai $mdt và $request->maDe 
                        if($mdt != $request->maDe)
                        {
                            //lay phieu co trong he thong
                            $mpcham=phieu_cham::where('maGV',Session::get('maGV'))->where('maSSV',$data->maSSV)->where('maDe',$mdt)->get();
                            if($mpcham){
                                foreach($mpcham as $pc){
                                    //xoa danh gia
                                    danhgia_tracnghiem::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                    ///tao phieu danh gia moi
                                    phieu_cham::create(['maGV'=>$pc->maGV,'maSSV'=>$data->maSSV,'maDe'=>$request->maDe,'loaiCB'=>$pc->maCanBo]);
                                    //xoa phieu cham cu
                                    phieu_cham::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                }
                            }
                        }
                        
                    }
                }
                else{
                    phieu_cham::create(['maGV'=>Session::get('maGV'),'maSSV'=>$data->maSSV,'maDe'=>$request->maDe]);           
                } 
                           
         }

         //---thay viet code
        alert()->success('Adding successfully','Message');
        return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.session::get('maCTBaiQH'));
    }

    public function nhap_diem_trac_nghiem($maDe,$maSSV)
    {
        Session::put('maDe',$maDe);
        Session::put('maSSV',$maSSV);
        //đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
        
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
       $sv=sinhVien::where('isDelete',false)->where('maSSV',$maSSV)->first();
      
        //noi dung de thi thuc  hanh
        if($dethi){
            $noidung=deThi_cauHoi::where('de_thi_cau_hoi.maDe',$dethi->maDe)
            ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
            ->join('phuong_an_trac_nghiem','phuong_an_trac_nghiem.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
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
            return back();
        }
       return view('giangvien.ketqua.tracnghiem.nhapdiemtracnghiem',compact('dethi','gv','sv','noidung'));
    }

    public function cham_diem_trac_nghiem_submit(Request $request)
    {
       
        //Session maDe--> dethi--> noidung
        //đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',Session::get('maDe'))->first();
        if($dethi){
            $noidung=deThi_cauHoi::where('de_thi_cau_hoi.maDe',$dethi->maDe)->get();
            $diemTong=0;
            //foreach noidung->them vao danh_gia_trac_nghiem
            foreach ($noidung as $nd) {
                //(maCauHoi+diem)-->(maPA+isCorrect)+tinh diemTong
                $index='chon_'.$nd->maCauHoi;
                $pa=phuongAnTracNghiem::find($request[$index]);
                $diemPA=($pa->isCorrect==true)?$nd->diem:0;
                danhgia_tracnghiem::create(['maPhieuCham'=>$request->maPhieuCham,
                "maPA"=>$request[$index],"diem"=>$diemPA]);
                $diemTong+=$diemPA;
            }
            
            //phieuCham:
            $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)->first();
            //---tinh diemSo
            $pc->diemChu=CommonController::tinh_diem_chu($diemTong);
            //---tinh diemChu
            $pc->xepHang=CommonController::tinh_xep_hang($diemTong);
            $pc->trangThai=true;
            $pc->diemSo=$diemTong;
            $pc->loaiCB=1;
            $pc->yKienDongGop=$request->yKienDongGop;
            $pc->update();
            if (Session::has('language') && Session::get('language')=='vi') {
                alert()->success("Chấm điểm thành công",'Warning');
            }else{
                alert()->success("Successfully",'Message');
            }
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));

        }else{
            if (Session::has('language') && Session::get('language')=='vi') {
                alert()->warning("Không tìm thấy đề thi",'Warning');
            }else{
                alert()->warning("Can't found examination",'Warning');
            }
            return redirect('/giang-vien/ket-qua-danh-gia/trac-nghiem/nhap-diem-trac-nghiem/'.Session::get('maDe').'/'.Session::get('maSSV'));
        }
    }

    public function sua_ket_qua_trac_nghiem(Request $request)
    {
       // return "dfgfd";
       
        //Session maDe--> dethi--> noidung
        //đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',Session::get('maDe'))->first();
        if($dethi){
            $noidung=deThi_cauHoi::where('de_thi_cau_hoi.maDe',$dethi->maDe)->get();
            $diemTong=0;

            danhgia_tracnghiem::where('maPhieuCham',$request->maPhieuCham)->delete();
           
            //foreach noidung->them vao danh_gia_trac_nghiem
            foreach ($noidung as $nd) {
                //(maCauHoi+diem)-->(maPA+isCorrect)+tinh diemTong
                $index='chon_'.$nd->maCauHoi;
                $pa=phuongAnTracNghiem::find($request[$index]);
                $diemPA=($pa->isCorrect==true)?$nd->diem:0;
                danhgia_tracnghiem::create(['maPhieuCham'=>$request->maPhieuCham,
                "maPA"=>$request[$index],"diem"=>$diemPA]);
                $diemTong+=$diemPA;
            }
            
            //phieuCham:
            $pc=phieu_cham::where('maPhieuCham',$request->maPhieuCham)->first();
            //---tinh diemSo
            $pc->diemChu=CommonController::tinh_diem_chu($diemTong);
            //---tinh diemChu
            $pc->xepHang=CommonController::tinh_xep_hang($diemTong);
            $pc->trangThai=true;
            $pc->diemSo=$diemTong;
            $pc->loaiCB=1;
            $pc->yKienDongGop=$request->yKienDongGop;
            $pc->update();
            if (Session::has('language') && Session::get('language')=='vi') {
                alert()->success("Cập nhật điểm thành công",'Warning');
            }else{
                alert()->warning("Successfully",'Message');
            }
            return redirect('/giang-vien/ket-qua-danh-gia/nhap-ket-qua-danh-gia/'.Session::get('maCTBaiQH'));

        }else{
            if (Session::has('language') && Session::get('language')=='vi') {
                alert()->warning("Không tìm thấy đề thi",'Warning');
            }else{
                alert()->warning("Can't found examination",'Warning');
            }
            return redirect('/giang-vien/ket-qua-danh-gia/trac-nghiem/nhap-diem-trac-nghiem/'.Session::get('maDe').'/'.Session::get('maSSV'));
        }
    }

    public function xem_ket_qua_trac_nghiem($maDe,$maSSV)
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
         //noi dung de thi thuc  hanh
         if($dethi){
            $noidung=deThi_cauHoi::where('de_thi_cau_hoi.maDe',$dethi->maDe)
            ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
            ->join('phuong_an_trac_nghiem','phuong_an_trac_nghiem.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
            ->get();
            foreach ($noidung as $tc) {
                $cdr3=CDR3::where('isDelete',false)
                    ->where('maCDR3', $tc->maCDR3)
                    ->get(['maCDR3VB', 'tenCDR3']);
                $tc->tenCDR3=$cdr3[0]["tenCDR3"];
                $tc->maCDR3VB=$cdr3[0]["maCDR3VB"];

                 //lay diem cham trong phieu cham
                 $diemCham=phieu_cham::where('phieu_cham.isDelete',false)
                 ->where('phieu_cham.maDe',$maDe)
                 ->where('phieu_cham.maSSV',$maSSV)
                  ->join('danhgia_tracnghiem',function($x) use ($tc){
                     $x->on('phieu_cham.maPhieuCham','=','danhgia_tracnghiem.maPhieuCham')
                        ->where('danhgia_tracnghiem.maPA',$tc->id);
                     })
                ->get(['danhgia_tracnghiem.maPA','danhgia_tracnghiem.diem']);
               

                 if(count($diemCham)>0){
                     $tc->diemDG=$diemCham[0]->diem; 
                     $tc->chon=$diemCham[0]->maPA;
                 }
                 else{
                     $tc->diemDG=0;
                 }
                 
            }
        }else{
            alert()->warning("Can't found examination",'Warning');
            return back();
        } 
        
        $pc=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->first();
        return view('giangvien.ketqua.tracnghiem.xemketquachamtracnghiem',compact('dethi','gv','sv','noidung','pc'));
    }

    public function xem_sua_ket_qua_trac_nghiem($maDe,$maSSV)
    {
        Session::put('maDe',$maDe);
        Session::put('maSSV',$maSSV);
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
         //noi dung de thi thuc  hanh
         if($dethi){
            $noidung=deThi_cauHoi::where('de_thi_cau_hoi.maDe',$dethi->maDe)
            ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
            ->join('phuong_an_trac_nghiem','phuong_an_trac_nghiem.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
            ->get();
            foreach ($noidung as $tc) {
                $cdr3=CDR3::where('isDelete',false)
                    ->where('maCDR3', $tc->maCDR3)
                    ->get(['maCDR3VB', 'tenCDR3']);
                $tc->tenCDR3=$cdr3[0]["tenCDR3"];
                $tc->maCDR3VB=$cdr3[0]["maCDR3VB"];

                 //lay diem cham trong phieu cham
                 $diemCham=phieu_cham::where('phieu_cham.isDelete',false)
                 ->where('phieu_cham.maDe',$maDe)
                 ->where('phieu_cham.maSSV',$maSSV)
                  ->join('danhgia_tracnghiem',function($x) use ($tc){
                     $x->on('phieu_cham.maPhieuCham','=','danhgia_tracnghiem.maPhieuCham')
                        ->where('danhgia_tracnghiem.maPA',$tc->id);
                     })
                ->get(['danhgia_tracnghiem.maPA','danhgia_tracnghiem.diem']);
               

                 if(count($diemCham)>0){
                     $tc->diemDG=$diemCham[0]->diem; 
                     $tc->chon=$diemCham[0]->maPA;
                 }
                 else{
                     $tc->diemDG=0;
                 }
                 
            }
        }else{
            alert()->warning("Can't found examination",'Warning');
            return back();
        } 
        
        $pc=phieu_cham::where('phieu_cham.isDelete',false)
                ->where('phieu_cham.maDe',$maDe)
                ->where('phieu_cham.maSSV',$maSSV)
                ->first();
        return view('giangvien.ketqua.tracnghiem.suadiemtracnghiem',compact('dethi','gv','sv','noidung','pc'));
    }

    public function export_diem_trac_nghiem(Excel $excel, $maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        return $excel->download(new diemTracNghiemExport,'bang_diem_trac_nghiem.xlsx');
    }   


}
