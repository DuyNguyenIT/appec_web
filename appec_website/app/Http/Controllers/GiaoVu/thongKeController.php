<?php

namespace App\Http\Controllers\GiaoVu;
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


class thongKeController extends Controller
{
    ///giao-vu/thong-ke
    public function index()
    {
        $gd=giangDay::where('giangday.isDelete',false)
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
        })
        ->join('giang_vien',function($y){
            $y->on('giang_vien.maGV','=','giangday.maGV')
            ->where('giang_vien.isDelete',false);
        })
        ->groupBy('giangday.maHocPhan')->distinct()
        ->get();
       
        $gd_data=giangDay::where('giangday.isDelete',false)
        ->get();

        $gd_rs=giangDay::where('giangday.isDelete',false)
        ->join('hoc_phan',function($x){
            $x->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })
        ->distinct()
        ->get(['hoc_phan.maHocPhan','maHK','namHoc','hoc_phan.tenHocPhan','giangday.maLop']);
        
        foreach ($gd_rs as $x) {
            $gv=[];
            foreach ($gd_data as $y) {
                if($y->maHocPhan==$x->maHocPhan && $y->maHK==$x->maHK && $y->namHoc==$x->namHoc && $y->maLop==$x->maLop){
                    if(!array_search($y->maGV,$gv))
                        array_push($gv,$y->maGV);
                }
                $temp=[];
                foreach (array_unique($gv) as $t) { 
                    $temp_gv=giangVien::where('isDelete',false)
                    ->where('maGV',$t)
                    ->first();
                    array_push($temp,$temp_gv);
                }
                $x->GV=$temp;
            }
        }
      
        return view('giaovu.thongke.thongke',['hocPhan'=>$gd,'giangday'=>$gd_rs]);
    }


    //giao-vu/thong-ke/thong-ke-theo-hoc-phan/03546/220060/HK2/2020-2021/Da19tta
    public function thong_ke_theo_hoc_phan($maGV,$maHocPhan,$maHK,$namHoc,$maLop)
    {
        Session::put('maGV',$maGV);
        Session::put('maHocPhan',$maHocPhan);
        Session::put('maHK',$maHK);
        Session::put('namHoc',$namHoc);  
        Session::put('maLop',$maLop);

        $ldg=loaiDanhGia::where('isDelete',false)->get();
        $lhtdg=loaiHTDanhGia::where('isDelete',false)->get();
           
        $hp=hocPhan::where('maHocPhan',$maHocPhan)
        ->where('isDelete',false)->first();

        $baiQH=giangDay::where('isDelete',false)
        //->where('giangday.maGV',$maGV)
        ->where('giangday.maHocPhan',$maHocPhan)
        ->where('giangday.maHK',$maHK)
        ->where('giangday.namHoc',$namHoc)
        ->where('giangday.maLop',$maLop)
        ->get('maBaiQH');    

        $qh=[];

        if($baiQH->count()>1){ //loại đồ án chuyên ngành hoặc  khóa luận
            foreach ($baiQH as  $value) {
                $qh=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
                ->where('ct_bai_quy_hoach.maBaiQH',$value->maBaiQH)
                ->join('loai_danh_gia',function($x){
                    $x->on('loai_danh_gia.maLoaiDG','=','ct_bai_quy_hoach.maLoaiDG')
                    ->where('loai_danh_gia.isDelete',false);
                })
                ->join('loai_ht_danhgia',function($x){
                    $x->on('loai_ht_danhgia.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
                    ->where('loai_ht_danhgia.isDelete',false);
                })
                ->get();
            }
      
            return view('giaovu.thongke.thongketheodoan',['qh'=>$qh,'hp'=>$hp,
            'ldg'=>$ldg,'lhtdg'=>$lhtdg]);
            
        }else{//môn binh thường
            $qh=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
            ->where('ct_bai_quy_hoach.maBaiQH',$baiQH[0]->maBaiQH)
            ->join('loai_danh_gia',function($x){
                $x->on('loai_danh_gia.maLoaiDG','=','ct_bai_quy_hoach.maLoaiDG')
                ->where('loai_danh_gia.isDelete',false);
            })
            ->join('loai_ht_danhgia',function($x){
                $x->on('loai_ht_danhgia.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
                ->where('loai_ht_danhgia.isDelete',false);
            })
            ->get();
            return view('giaovu.thongke.thongketheohocphan',['qh'=>$qh,'hp'=>$hp,
            'ldg'=>$ldg,'lhtdg'=>$lhtdg]);
        }
       
    }

    //_________________________________________________________________________________________________________________________________
    ####-------------------------------------------------------THỐNG KÊ CỦA THỰC HÀNH
    //__________________________________________________________________________________________________________________________________
    //___________________________________________________________THỰC HÀNH theo xếp hạng
    
    //giao-vu/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-xep-hang/37
    public function thong_ke_theo_xep_hang_thuc_hanh($maCTBaiQH)
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
             return redirect('/giao-vu/thong-ke/thong-ke-theo-hoc-phan/'.session::get('maGV').'/'.session::get('maHocPhan').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop'));
         } 
    
        //xếp hạng
        $xepHang=xuLyThongKeController::thong_ke_xep_hang($maCTBaiQH,Session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_ke_ti_le_xep_hang($maCTBaiQH,Session::get('maGV'));
        return view('giaovu.thongke.tuluan.thongkexephang',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);
    }


    public function get_xep_hang_thuc_hanh()
    {
        return response()->json(xuLyThongKeController::thong_ke_xep_hang(Session::get('maCTBaiQH'),Session::get('maGV')));
    }
    //____________________________________________________________THỰC HÀNH theo điểm chữ
    public function thong_ke_theo_diem_chu_thuc_hanh($maCTBaiQH)
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
            return redirect('/giao-vu/thong-ke/thong-ke-theo-hoc-phan/'.session::get('maGV').'/'.session::get('maHocPhan').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop'));
        } 
        $diemChu=[];
        $tiLe=[];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($letter as  $lt) {
            array_push($diemChu,$dethi->where('diemChu',$lt)->count());
            array_push($tiLe,number_format($dethi->where('diemChu',$lt)->count()*100/$dethi->count(),2));
        }
        
        return view('giaovu.thongke.thongketheodiemchu',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
        'hp'=>$hp,'chu'=>$letter,'ct_baiQH'=>$ct_baiQH]);
    }

    public function get_diem_chu_thuc_hanh()
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

    //___________________________________________________________THỰC HÀNH theo tiêu chí
    public function thong_ke_theo_tieu_chi_thuc_hanh($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
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

        $chuan_dau_ra3=[];
        $phuongan=[];

        //ct_baiqh->de_thi->de_thi_cauhoi_tuluan-->cau_hoi
        //                              |____________>phuong_an_tu_luan-->cdr_cd3
        $chuan_dau_ra3=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('de_thi_cauhoi_tuluan',function($x){
            $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
        })
        ->join('phuong_an_tu_luan',function($x){
            $x->on('de_thi_cauhoi_tuluan.maPATL','=','phuong_an_tu_luan.id');
        })
        ->join('cdr_cd3',function($x){
            $x->on('cdr_cd3.maCDR3','=','phuong_an_tu_luan.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->distinct(['cdr_cd3.maCDR3','cdr_cd3.tenCDR3'])
        ->orderBy('cdr_cd3.maCDR3')
        ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
        
        $phuongan=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('de_thi_cauhoi_tuluan',function($x){
            $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
        })
        ->join('phuong_an_tu_luan',function($x){
            $x->on('de_thi_cauhoi_tuluan.maPATL','=','phuong_an_tu_luan.id');
        })
        ->get(['phuong_an_tu_luan.id','phuong_an_tu_luan.noiDungPA','phuong_an_tu_luan.diemPA','phuong_an_tu_luan.maCDR3']);

        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',$maCTBaiQH)
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['phieu_cham.maPhieuCham']);


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
            //tính điểm tương ứng của chuẩn đầu ra 3
            foreach ($phuongan as $tc) {
                if($tc->maCDR3==$cdr3->maCDR3){
                    $diem_tieu_chi=$diem_tieu_chi+$tc->diemPA;
                }
            }


            foreach ($phieuCham as $pc) {
                $t=$cdr3->maCDR3;
                /////////
                //điếm theo phiếu chấm

                $dem=danhgia_tuluan::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_tu_luan',function($x) use ($t){
                    $x->on('phuong_an_tu_luan.id','=','danhgia_tuluan.maPATL')
                    ->where('phuong_an_tu_luan.maCDR3',$t);
                })
                ->sum('danhgia_tuluan.diemDG');
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

        return view('giaovu.thongke.tuluan.thongketheotieuchi',['bieuDo'=>$bieuDo]);

    }
    public function get_tieu_chi_thuc_hanh()
    {
        $ndqh=noiDungQH::where('isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->get();
        //ct bai quy hoach
        $ct_baiQH=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->leftjoin('loai_ht_danhgia',function($x){
            $x->on('ct_bai_quy_hoach.maLoaiHTDG','=','ct_bai_quy_hoach.maLoaiHTDG')
            ->where('ct_bai_quy_hoach.isDelete',false);
        })
        ->first();

        $chuan_dau_ra3=[];
        $phuongan=[];

        //ct_baiqh->de_thi->de_thi_cauhoi_tuluan-->cau_hoi
        //                              |____________>phuong_an_tu_luan-->cdr_cd3
        $chuan_dau_ra3=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->join('de_thi_cauhoi_tuluan',function($x){
            $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
        })
        ->join('phuong_an_tu_luan',function($x){
            $x->on('de_thi_cauhoi_tuluan.maPATL','=','phuong_an_tu_luan.id');
        })
        ->join('cdr_cd3',function($x){
            $x->on('cdr_cd3.maCDR3','=','phuong_an_tu_luan.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->distinct(['cdr_cd3.maCDR3','cdr_cd3.tenCDR3'])
        ->orderBy('cdr_cd3.maCDR3')
        ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
        
        $phuongan=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->join('de_thi_cauhoi_tuluan',function($x){
            $x->on('de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe');
        })
        ->join('phuong_an_tu_luan',function($x){
            $x->on('de_thi_cauhoi_tuluan.maPATL','=','phuong_an_tu_luan.id');
        })
        ->get(['phuong_an_tu_luan.id','phuong_an_tu_luan.noiDungPA','phuong_an_tu_luan.diemPA','phuong_an_tu_luan.maCDR3']);

        $phieuCham=deThi::where('de_thi.isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->join('phieu_cham',function($x){
            $x->on('phieu_cham.maDe','=','de_thi.maDe')
            ->where('phieu_cham.maGV',Session::get('maGV'))
            ->where('phieu_cham.isDelete',false);
        })
        ->get(['phieu_cham.maPhieuCham']);


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
            //tính điểm tương ứng của chuẩn đầu ra 3
            foreach ($phuongan as $tc) {
                if($tc->maCDR3==$cdr3->maCDR3){
                    $diem_tieu_chi=$diem_tieu_chi+$tc->diemPA;
                }
            }


            foreach ($phieuCham as $pc) {
                $t=$cdr3->maCDR3;
                /////////
                //điếm theo phiếu chấm

                $dem=danhgia_tuluan::where('maPhieuCham',$pc->maPhieuCham)
                ->join('phuong_an_tu_luan',function($x) use ($t){
                    $x->on('phuong_an_tu_luan.id','=','danhgia_tuluan.maPATL')
                    ->where('phuong_an_tu_luan.maCDR3',$t);
                })
                ->sum('danhgia_tuluan.diemDG');
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


    //____________________________________________________________________________________________________________________________
    ####---------------------------------------------------THỐNG KÊ CỦA TỰ LUẬN
    //_____________________________________________________________________________________________________________________________
    //__________________________________________________________TỰ LUẬN theo xếp hạng
    ///giao-vu/thong-ke/thong-ke-theo-hoc-phan/tu-luan/thong-ke-theo-xep-hang/37
    public function thong_ke_theo_xep_hang_tu_luan($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        //học phần

         //đề thi
         $dethi=deThi::where('de_thi.isDelete',false)
         ->where('maCTBaiQH',$maCTBaiQH)->get();
         if($dethi->count()==0)
         {
             alert()->warning('There are no examination!','Message');
             return redirect('/giao-vu/thong-ke/thong-ke-theo-hoc-phan/'.session::get('maGV').'/'.session::get('maHocPhan').'/'.session::get('maHK').'/'.session::get('namHoc').'/'.session::get('maLop'));
         } 
        
        $xepHang=xuLyThongKeController::thong_ke_xep_hang($maCTBaiQH,Session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_ke_ti_le_xep_hang($maCTBaiQH,Session::get('maGV'));

        return view('giaovu.thongke.tuluan.thongkexephang',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);


    }

    public function get_xep_hang_tu_luan()
    {
        return response()->json(xuLyThongKeController::thong_ke_xep_hang(session::get('maCTBaiQH'),Session::get('maGV')));
    }

    //____________________________________________________________theo điểm chữ
    public function thong_ke_theo_diem_chu_tu_luan($maCTBaiQH)
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
            if(session::has('language') && session::get('language')='vi'){
                alert()->warning('Không có đề thi nào!','Thong báo');
            }else{
                alert()->warning('There are no examination!','Message');
            }
            return redirect()->back();
        } 

        $diemChu=xuLyThongKeController::thong_ke_diem_chu($maCTBaiQH,session::get('maGV'));
        $tiLe=xuLyThongKeController::thong_le_ti_le_diem_chu($maCTBaiQH,session::get('maGV'));
        $letter=['A','B+','B','C+','C','D+','D','F'];
     
        return view('giaovu.thongke.tuluan.thongketheodiemchu',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
        'hp'=>$hp,'chu'=>$letter]);
    }

    public function get_diem_chu_tu_luan()
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

    //___________________________________________________________TỰ LUẬN theo tiêu chí
    public function thong_ke_theo_tieu_chi_tu_luan($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);

        $bieuDo=xuLyThongKeController::thong_ke_CDR3($maCTBaiQH);
        //infor
        $hp=hocPhan::findOrFail(session::get('maHocPhan'));
        
        return view('giaovu.thongke.tuluan.thongketheotieuchi',['bieuDo'=>$bieuDo,'hocPhan'=>$hp]);

    }
    public function get_tieu_chi_tu_luan()
    {
        $bieuDo=xuLyThongKeController::thong_ke_CDR3(session::get('maCTBaiQH'));
        return response()->json($bieuDo);
    }
//___________________________________________________________TỰ LUẬN theo abet
    public function thong_ke_theo_abet_tu_luan($maCTBaiQH)
    {
        Session::put('maCTBaiQH',$maCTBaiQH);

         //lấy danh sách cdr3
        $bieuDo=xuLyThongKeController::thong_ke_abet($maCTBaiQH);

        return view('giaovu.thongke.tuluan.thongketheoabet',['bieuDo'=>$bieuDo]);

    }

    public function get_abet_tu_luan()
    {
        $bieuDo=xuLyThongKeController::thong_ke_abet(session::get('maCTBaiQH'));
        return response()->json($bieuDo);
    }
    //______________________________________________________TỰ LUẬN theo ket qua hoc tap

    public function thong_ke_theo_kqht_tu_luan($maCTBaiQH)
    {
        # code...
    }

    public function get_kqht_tu_luan()
    {
        # code...
    }
    //______________________________________________________________________________________________________________________________
    ####-----------------------------------------------------THỐNG KÊ CỦA ĐỒ ÁN
    //______________________________________________________________________________________________________________________________
    //________________________________________________________ĐỒ ÁN-theo xếp hạng
    public function thong_ke_theo_xep_hang($maCTBaiQH,$maCanBo)
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

        return view('giaovu.thongke.thongketheoxephang',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);
    }

    public function get_xep_hang()
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

    ///_______________________________________________________ĐỒ ÁN-theo điểm chữ
    public function thong_ke_theo_diem_chu($maCTBaiQH,$maCanBo)
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
        return view('giaovu.thongke.thongketheodiemchu',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
        'hp'=>$hp,'chu'=>$letter,'ct_baiQH'=>$ct_baiQH]);
    }

    public function get_diem_chu()
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

    //_________________________________________________________ĐỒ ÁN-điểm tiêu chí
    public function thong_ke_theo_tieu_chi($maCTBaiQH,$maCanBo)
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
        

        return view('giaovu.thongke.thongketheotieuchi',['bieuDo'=>$bieuDo]);
    }

    public function get_tieu_chi()
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

    //dành cho khóa luận, đồ án cơ sở ngành
    //__________________________________________________________
    public function thong_ke_theo_xep_hang_kl($maCanBo)
    {
        Session::put('maCanBo',$maCanBo);
        //lấy maBaiQH[]
        $baiQH=giangDay::where('isDelete',false)
        //->where('giangday.maGV',$maGV)
        ->where('giangday.maHocPhan',Session::get('maHocPhan'))
        ->where('giangday.maHK',Session::get('maHK'))
        ->where('giangday.namHoc',Session::get('namHoc'))
        ->where('giangday.maLop',Session::get('maLop'))
        ->distinct()
        ->get('maBaiQH');
          
        //lấy ctBaiQH[]
        $ct_bai_qh=[];
        foreach ($baiQH as $key => $bqh) {
            $ct=ct_bai_quy_hoach::where('isDelete',false)
            ->where('maBaiQH',$bqh->maBaiQH)
            ->get();
            foreach ($ct as  $temp) {
                array_push($ct_bai_qh,$temp);
            }
            
        }
        
      
        //thống kê như bình thường
        if($maCanBo==1){
            $dethi=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',1)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['maPhieuCham','xepHang']);
                foreach ($dt as $temp) {
                    array_push($dethi,$temp);
                }
            }
        }
        else{
            $dethi=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',2)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['maPhieuCham','xepHang']);
                foreach ($dt as $temp) {
                    array_push($dethi,$temp);
                }
            }
        }
        
        $xepHang=[0,0,0,0,0];
        $tiLe=[];
        foreach ($dethi as $dt) {
             $xh=$dt->xepHang;
             switch ($xh) {
                 case 1:
                     $xepHang[0]+=1;
                     break;
                case 2:
                    $xepHang[1]+=1;
                    break;
                case 3:
                    $xepHang[2]+=1;
                    break;
                case 4:
                    $xepHang[3]+=1;
                    break;
                case 5:
                    $xepHang[4]+=1;
                    break;
                 default:
                     # code...
                     break;
             }
        }
        $tong=0;
        $tong=count($dethi);
        if ($tong==0) {
            $tong=1;
        }
        for ($i=0; $i <5 ; $i++) { 
            $rate=$xepHang[$i]*100/$tong;
            array_push($tiLe,$rate);
        }

       
        return view('giaovu.thongke.thongkitheoxephangkl',['xepHang'=>$xepHang,'tiLe'=>$tiLe]);

    }

    public function get_xep_hang_kl()
    {
        $baiQH=giangDay::where('isDelete',false)
        //->where('giangday.maGV',$maGV)
        ->where('giangday.maHocPhan',Session::get('maHocPhan'))
        ->where('giangday.maHK',Session::get('maHK'))
        ->where('giangday.namHoc',Session::get('namHoc'))
        ->where('giangday.maLop',Session::get('maLop'))
        ->distinct()
        ->get('maBaiQH');
          
        //lấy ctBaiQH[]
        $ct_bai_qh=[];
        foreach ($baiQH as $key => $bqh) {
            $ct=ct_bai_quy_hoach::where('isDelete',false)
            ->where('maBaiQH',$bqh->maBaiQH)
            ->get();
            foreach ($ct as  $temp) {
                array_push($ct_bai_qh,$temp);
            }
            
        }
        
      
        //thống kê như bình thường
        if(Session::get('maCanBo')==1){
            $dethi=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',1)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['maPhieuCham','xepHang']);
                foreach ($dt as $temp) {
                    array_push($dethi,$temp);
                }
            }
            
        }
        else{
            $dethi=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',2)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['maPhieuCham','xepHang']);
                foreach ($dt as $temp) {
                    array_push($dethi,$temp);
                }
                
            }
            
        }
        
        $xepHang=[0,0,0,0,0];
        $tiLe=[];
        foreach ($dethi as $dt) {
             $xh=$dt->xepHang;
             switch ($xh) {
                 case 1:
                     $xepHang[0]+=1;
                     break;
                case 2:
                    $xepHang[1]+=1;
                    break;
                case 3:
                    $xepHang[2]+=1;
                    break;
                case 4:
                    $xepHang[3]+=1;
                    break;
                case 5:
                    $xepHang[4]+=1;
                    break;
                 default:
                     # code...
                     break;
             }
        }

        $tong=0;
        $tong=count($dethi);
        if ($tong==0) {
            $tong=1;
        }
        for ($i=0; $i <5 ; $i++) { 
            $rate=$xepHang[$i]*100/$tong;
            array_push($tiLe,$rate);
        }
        return response()->json($xepHang);
    }

    //___________________________________________________________
    public function thong_ke_theo_diem_chu_kl($maCanBo)
    {
        Session::put('maCanBo',$maCanBo);
        //học phần 
        $hp=hocPhan::where('isDelete',false)
        ->where('maHocPhan',Session::get('maHocPhan'))
        ->first();
        //lấy maBaiQH[]
        $baiQH=giangDay::where('isDelete',false)
        //->where('giangday.maGV',$maGV)
        ->where('giangday.maHocPhan',Session::get('maHocPhan'))
        ->where('giangday.maHK',Session::get('maHK'))
        ->where('giangday.namHoc',Session::get('namHoc'))
        ->where('giangday.maLop',Session::get('maLop'))
        ->distinct()
        ->get('maBaiQH');
          
        //lấy ctBaiQH[]
        $ct_bai_qh=[];
        foreach ($baiQH as $key => $bqh) {
            $ct=ct_bai_quy_hoach::where('isDelete',false)
            ->where('maBaiQH',$bqh->maBaiQH)
            ->get();
            foreach ($ct as  $temp) {
                array_push($ct_bai_qh,$temp);
            }
            
        }
       
      
        //thống kê như bình thường
        if($maCanBo==1){
            $dethi=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',1)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['maPhieuCham','diemChu']);
                
                foreach ($dt as $temp) {
                    array_push($dethi,$temp);
                }
            }
            
        }
        else{
            $dethi=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',2)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['maPhieuCham','diemChu']);
                foreach ($dt as $temp) {
                    array_push($dethi,$temp);
                }
                
            }
            
        }
      
       
        $diemChu=[0,0,0,0,0,0,0,0];
        $tiLe=[0,0,0,0,0,0,0,0];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($dethi as $dt) {
            $dc=$dt->diemChu;
            
            switch ($dc) {
                case 'A':
                    $diemChu[0]+=1;
                    break;
               case 'B+':
                   $diemChu[1]+=1;
                   break;
               case 'B':
                   $diemChu[2]+=1;
                   break;
               case 'C+':
                   $diemChu[3]+=1;
                   break;
               case 'C':
                   $diemChu[4]+=1;
                   break;
                case 'D+':
                  $diemChu[5]+=1;
                  break;
                case 'D':
                  $diemChu[6]+=1;
                  break;
                case 'F':
                  $diemChu[7]+=1;
                  break;
                default:
                    # code...
                    break;
            }
       }
      
       $tong=0;
       $tong=count($dethi);
       if ($tong==0) {
           $tong=1;
       }
        for ($i=0; $i <5 ; $i++) { 
            $rate=$diemChu[$i]*100/$tong;
            array_push($tiLe,$rate);
        
        }

         return view('giaovu.thongke.thongketheodiemchukl',['diemChu'=>$diemChu,'tiLe'=>$tiLe,
        'hp'=>$hp,'chu'=>$letter]);
    }

    
    public function get_diem_chu_kl()
    {
        //lấy maBaiQH[]
        $baiQH=giangDay::where('isDelete',false)
        //->where('giangday.maGV',$maGV)
        ->where('giangday.maHocPhan',Session::get('maHocPhan'))
        ->where('giangday.maHK',Session::get('maHK'))
        ->where('giangday.namHoc',Session::get('namHoc'))
        ->where('giangday.maLop',Session::get('maLop'))
        ->distinct()
        ->get('maBaiQH');
          
        //lấy ctBaiQH[]
        $ct_bai_qh=[];
        foreach ($baiQH as $key => $bqh) {
            $ct=ct_bai_quy_hoach::where('isDelete',false)
            ->where('maBaiQH',$bqh->maBaiQH)
            ->get();
            foreach ($ct as  $temp) {
                array_push($ct_bai_qh,$temp);
            }
            
        }
        
      
        //thống kê như bình thường
        if(Session::get('maCanBo')==1){
            $dethi=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',1)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['maPhieuCham','diemChu']);
                foreach ($dt as $temp) {
                    array_push($dethi,$temp);
                }
            }
            
        }
        else{
            $dethi=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',2)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['maPhieuCham','diemChu']);
                foreach ($dt as $temp) {
                    array_push($dethi,$temp);
                }
                
            }
            
        }

        $diemChu=[0,0,0,0,0,0,0,0];
        $tiLe=[0,0,0,0,0,0,0,0];
        $letter=['A','B+','B','C+','C','D+','D','F'];
        foreach ($dethi as $dt) {
            $dc=$dt->diemChu;
            switch ($dc) {
                case 'A':
                    $diemChu[0]+=1;
                    break;
               case 'B+':
                   $diemChu[1]+=1;
                   break;
               case 'B':
                   $diemChu[2]+=1;
                   break;
               case 'C+':
                   $diemChu[3]+=1;
                   break;
               case 'C':
                   $diemChu[4]+=1;
                   break;
                case 'D+':
                  $diemChu[5]+=1;
                  break;
                case 'D':
                  $diemChu[6]+=1;
                  break;
                case 'F':
                  $diemChu[7]+=1;
                  break;
                default:
                    # code...
                    break;
            }
       }
       $tong=0;
       $tong=count($dethi);
       if ($tong==0) {
           $tong=1;
       }
        for ($i=0; $i <5 ; $i++) { 
            $rate=$diemChu[$i]*100/$tong;
            array_push($tiLe,$rate);
        
        }

        return response()->json($diemChu);
    }

    //__________________________________________________________________________
    public function thong_ke_theo_tieu_chi_kl($maCanBo) //thóng kê theo tiêu chí
    {
        Session::put('maCanBo',$maCanBo);
        //baiQH
        $baiQH=giangDay::where('isDelete',false)
        ->where('giangday.maHocPhan',Session::get('maHocPhan'))
        ->where('giangday.maHK',Session::get('maHK'))
        ->where('giangday.namHoc',Session::get('namHoc'))
        ->where('giangday.maLop',Session::get('maLop'))
        ->distinct()
        ->get('maBaiQH');

        //ct_bai_quy_hoach[]
        $ct_bai_qh=[];
        foreach ($baiQH as $bqh) {
            $ct=ct_bai_quy_hoach::where('isDelete',false)
            ->where('maBaiQH',$bqh->maBaiQH)
            ->get();
            foreach ($ct as  $temp) {
                array_push($ct_bai_qh,$temp);
            }
            
        }

        //noiDungQH[]
        $noiDungQH=[];
        foreach ($ct_bai_qh as $ct) {
            $ndqh=noiDungQH::where('isDelete',false)
            ->where('maCTBaiQH',$ct->maCTBaiQH)
            ->get();
            foreach ($ndqh as  $nd) {
                array_push($noiDungQH,$nd);
            }
        }

        
        //noiDungQH[]->deThi[]

        //noiDungQH[]=>(tieuchuan+tieuChi+cdr3)
        $chuan_dau_ra3=[];
        $tieuchi=[]; //lấy tất cả các tiêu chí đánh giá
        $checkDup=[];
        foreach ($noiDungQH as $key => $x) {
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
            

            //tiêu chí đánh giá
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
                //khử trùng
                $t->maNoiDungQH=$x->maNoiDungQH;
                array_push($chuan_dau_ra3,$t);
                array_push($checkDup,$t->maCDR3);
            }
            foreach ($temp_tc as $tc) {
                $tc->maNoiDungQH=$x->maNoiDungQH;
                $tc->maCTBaiQH=$x->maCTBaiQH;
                array_push($tieuchi,$tc);
            }
        }

       

         //điếm số phiếu chấm có đủ các tiêu chí trong chuẩn đẩu ra
        ///
        if(Session::get('maCanBo')==1){
            $phieuCham=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',1)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);

                foreach ($dt as $temp) {
                    $temp->maCTBaiQH=$ct->maCTBaiQH;
                    array_push($phieuCham,$temp);
                }
            }

            
        }else{
            $phieuCham=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',2)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);

                foreach ($dt as $temp) {
                    $temp->maCTBaiQH=$ct->maCTBaiQH;
                    array_push($phieuCham,$temp);
                }
            }
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

            foreach ($phieuCham as $pc) {
                
                $diem_tieu_chi=0;
                foreach ($tieuchi as $tc) {
                    if($tc->maCDR3==$cdr3->maCDR3 && $tc->maCTBaiQH==$pc->maCTBaiQH){
                        $diem_tieu_chi=$diem_tieu_chi+$tc->diemTCCD;
                    }
                }

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

                if($diem_tieu_chi==0){
                    continue;
                }

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
        
        return view('giaovu.thongke.thongketheotieuchikl',['bieuDo'=>$bieuDo]);
    }

    public function get_tieu_chi_kl()
    {
        //baiQH
        $baiQH=giangDay::where('isDelete',false)
        //->where('giangday.maGV',$maGV)
        ->where('giangday.maHocPhan',Session::get('maHocPhan'))
        ->where('giangday.maHK',Session::get('maHK'))
        ->where('giangday.namHoc',Session::get('namHoc'))
        ->where('giangday.maLop',Session::get('maLop'))
        ->distinct()
        ->get('maBaiQH');

        //ct_bai_quy_hoach[]
        $ct_bai_qh=[];
        foreach ($baiQH as $bqh) {
            $ct=ct_bai_quy_hoach::where('isDelete',false)
            ->where('maBaiQH',$bqh->maBaiQH)
            ->get();
            foreach ($ct as  $temp) {
                array_push($ct_bai_qh,$temp);
            }
            
        }
        //noiDungQH[]
        $noiDungQH=[];
        foreach ($ct_bai_qh as $ct) {
            $ndqh=noiDungQH::where('isDelete',false)
            ->where('maCTBaiQH',$ct->maCTBaiQH)
            ->get();
            foreach ($ndqh as  $nd) {
                array_push($noiDungQH,$nd);
            }
        }
        //noiDungQH[]=>(tieuchuan+tieuChi+cdr3)
        $chuan_dau_ra3=[];
        $tieuchi=[];
        $checkDup=[];
        
        //noiDungQH[]->deThi[]

        //noiDungQH[]=>(tieuchuan+tieuChi+cdr3)
        $chuan_dau_ra3=[];
        $tieuchi=[]; //lấy tất cả các tiêu chí đánh giá
        $checkDup=[];
        foreach ($noiDungQH as $key => $x) {
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
            

            //tiêu chí đánh giá
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
                //khử trùng
                $t->maNoiDungQH=$x->maNoiDungQH;
                array_push($chuan_dau_ra3,$t);
                array_push($checkDup,$t->maCDR3);
            }
            foreach ($temp_tc as $tc) {
                $tc->maNoiDungQH=$x->maNoiDungQH;
                $tc->maCTBaiQH=$x->maCTBaiQH;
                array_push($tieuchi,$tc);
            }
        }

       

         //điếm số phiếu chấm có đủ các tiêu chí trong chuẩn đẩu ra
        ///
        if(Session::get('maCanBo')==1){
            $phieuCham=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',1)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);

                foreach ($dt as $temp) {
                    $temp->maCTBaiQH=$ct->maCTBaiQH;
                    array_push($phieuCham,$temp);
                }
            }

            
        }else{
            $phieuCham=[];
            foreach ($ct_bai_qh as $ct) {
                $dt=deThi::where('de_thi.isDelete',false)
                ->where('maCTBaiQH',$ct->maCTBaiQH)
                ->join('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.loaiCB',2)
                    ->where('phieu_cham.isDelete',false);
                })
                ->get(['phieu_cham.maPhieuCham','phieu_cham.maDe']);

                foreach ($dt as $temp) {
                    $temp->maCTBaiQH=$ct->maCTBaiQH;
                    array_push($phieuCham,$temp);
                }
            }
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

            foreach ($phieuCham as $pc) {
                
                $diem_tieu_chi=0;
                foreach ($tieuchi as $tc) {
                    if($tc->maCDR3==$cdr3->maCDR3 && $tc->maCTBaiQH==$pc->maCTBaiQH){
                        $diem_tieu_chi=$diem_tieu_chi+$tc->diemTCCD;
                    }
                }

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

                if($diem_tieu_chi==0){
                    continue;
                }

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