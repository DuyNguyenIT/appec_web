<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use Carbon\Carbon;
use App\Models\CDR3;
use App\Models\raDe;
use App\Models\deThi;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\danhGia;
use App\Models\hocPhan;
use App\Models\giangDay;
use App\Models\sinhVien;
use App\Models\cdr3_abet;
use App\Models\giangVien;
use App\Models\noiDungQH;
use App\Models\chuan_abet;
use App\Models\phieu_cham;
use App\Models\baiQuyHoach;
use App\Models\chuong_ndqh;
use App\Models\loaiDanhGia;
use App\Models\cau_hoi_ndqh;
use App\Models\deThi_cauHoi;
use App\Models\mucDoDanhGia;
use Illuminate\Http\Request;
use App\Models\chuong_cauhoi;
use App\Models\loaiHTDanhGia;
use App\Models\phanBoNoiDung;
use App\Models\danhgia_tuluan;
use App\Models\hocPhan_kqHTHP;
use App\Models\phuongAnTuLuan;
use App\Models\tieuChiChamDiem;
use App\Models\ct_bai_quy_hoach;
use App\Models\quyHoach_hocPhan;
use App\Models\sinhvien_hocphan;
use App\Models\tieuChuanDanhGia;
use App\Models\danhgia_tracnghiem;
use App\Models\dethi_cauhoituluan;
use App\Models\phuongAnTracNghiem;
use App\Models\thongke_so_hocphan;
use App\Models\thongke_clo_hocphan;
use App\Http\Controllers\Controller;
use App\Models\thongke_abet_hocphan;
use App\Models\hocPhan_loaiHTDanhGia;
use App\Models\cauHoi_tieuChiChamDiem;
use App\Http\Controllers\CommonController;

class quyhoachController extends Controller
{
    ///giang-vien/quy-hoach-danh-gia
    public function index()
    {
        $gd=giangDay::where('giangday.isDelete',false)
        ->where('maGV',Session::get('maGV'))
        ->orderBy('giangday.namHoc','desc')
        ->distinct(['namHoc'])->get('namHoc'); //dung bien nay hien thi len table

        $gd_full=giangDay::where('giangday.isDelete',false)
        ->where('maGV',Session::get('maGV'))->get();  //dung bien nay de diem mon hoc

        //return $gd_full;
        return view('giangvien.quyhoach.nam_hocki',compact('gd','gd_full'));
    }

    public function nam_hocki($namHoc,$maHK)
    {
        Session::put('namHoc',$namHoc);
        Session::put('maHK',$maHK);
        $gd=giangDay::where('giangday.isDelete',false)
        ->where('maGV',Session::get('maGV'))
         ->where('namHoc',$namHoc)
         ->where('maHK',$maHK)
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })
        ->groupBy(['maBaiQH','giangday.maLop'])->get();

       // return $gd;
     
        //tạo combobox  năm học
        $date = new Carbon();   
        $current_year=$date->year;
        $years_array=[];
        for ($i=1; $i<=5 ; $i++) { 
            array_push($years_array,($current_year-1).'-'.($current_year));
            $current_year=$current_year-1;
        }

        return view('giangvien.quyhoach.quyhoach',compact('gd','years_array'));
    }

    //giang-vien/quy-hoach-danh-gia
    public function filter(Request $request)  //------OK
    { 
        // năm và học kì đều chọn all
        if($request->namHoc=="all" && $request->maHK=="all"){
            $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
            ->orderBy('giangday.namHoc','desc')
            ->join('hoc_phan',function($q){
                $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
            })->groupBy('maBaiQH')->distinct()->get();
        }else{
            if($request->namHoc=="all" && $request->maHK!="all"){//chỉ năm all 
                $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
                    ->where('maHK',$request->maHK)
                    ->orderBy('giangday.namHoc','desc')
                    ->join('hoc_phan',function($q){
                        $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                        ->where('hoc_phan.isDelete',false);
                    })->groupBy('maBaiQH')->distinct()->get();
            }else{
                if($request->namHoc!="all" && $request->maHK=="all"){//chỉ học kì all
                    $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
                    ->where('namHoc',$request->namHoc)
                    ->orderBy('giangday.namHoc','desc')
                    ->join('hoc_phan',function($q){
                        $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                        ->where('hoc_phan.isDelete',false);
                    })->groupBy('maBaiQH')->distinct()->get();
                }else{  //có chọn năm và học kì
                    $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
                    ->where('namHoc',$request->namHoc)->where('maHK',$request->maHK)
                    ->orderBy('giangday.namHoc','desc')
                    ->join('hoc_phan',function($q){
                        $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                        ->where('hoc_phan.isDelete',false);
                    })->groupBy('maBaiQH')->distinct()->get();
                }
            }
        }
        
        //luu lai lua chon cua bo loc filter
        $maHK_filter=$request->maHK;
        $namHoc_filter=$request=$request->namHoc;
        //tạo combobox  năm học
        $date = new Carbon();   
        $current_year=$date->year;
        $years_array=[];
        for ($i=1; $i<=5 ; $i++) { 
            array_push($years_array,($current_year-1).'-'.($current_year));
            $current_year=$current_year-1;
        }
        return view('giangvien.quyhoach.quyhoach',compact('gd','years_array','maHK_filter','namHoc_filter'));
    }

    ///giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/220104/1/HK1/2020-2021/DA16TT
    public function quy_hoach_ket_qua_hoc_tap(Request $request,$maHocPhan,$maBaiQH,$maHK,$namHoc,$maLop)
    {
       
        Session::put('maHK',$maHK);
        Session::get('namHoc',$namHoc);
        $request->session()->put('maHocPhan', $maHocPhan);
        $request->session()->put('maLop', $maLop);
        $request->session()->put('maBaiQH', $maBaiQH);

           $ldg=loaiDanhGia::where('isDelete',false)->get();
           $lhtdg=loaiHTDanhGia::where('isDelete',false)->get();
           $hp=hocPhan::where('maHocPhan',$maHocPhan)->where('isDelete',false)->first();
           $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
           ->where('giangday.maLop',$maLop)
           ->where('giangday.namHoc',$namHoc)
           ->where('giangday.maHK',$maHK)
           ->where('giangday.maHocPhan',$maHocPhan)
           ->join('hoc_phan',function($q){
               $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
               ->where('hoc_phan.isDelete',false);
           })->get(['giangday.namHoc','giangday.maHK','giangday.maLop','hoc_phan.tenHocPhan','hoc_phan.tenHocPhanEN','hoc_phan.maHocPhan']);
        
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

          //đếm số dòng trong ct bài quy hoach
          $count_ct=ct_bai_quy_hoach::where('ct_bai_quy_hoach.isDelete',false)
          ->where('ct_bai_quy_hoach.maBaiQH',$maBaiQH)->sum('ct_bai_quy_hoach.maCTBaiQH');
          $count_ndqh=0;
            foreach ($qh as $value) {
                $count_ndqh+=noiDungQH::where('maCTBaiQH',$value->maCTBaiQH)->sum('maNoiDungQH');
            }
          //đếm số group trong hocphan_loai_hinhthuc_dg
          $count_groupCT=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$maHocPhan)->distinct('groupCT')->count();
          $hocphan_loai_htdg_array=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$maHocPhan)->get();
        ///chương
        $chuong=chuong::where('isdelete',false)->where('maHocPhan',$maHocPhan)->orderBy('id','asc')->with('muc')->get(); 
            
       
        //    return view('giangvien.quyhoach.quyhoachketqua',['qh'=>$qh,'hp'=>$hp,
        //    'ldg'=>$ldg,'lhtdg'=>$lhtdg,'count_ct'=>$count_ct,'count_groupCT'=>$count_groupCT,
        //    'hocphan_loai_htdg_array'=>$hocphan_loai_htdg_array]);

       
        return view('giangvien.quyhoach.quyhoach2',compact('hp','gd','qh','ldg','count_ndqh','lhtdg','count_ct','count_groupCT','hocphan_loai_htdg_array','chuong'));
        

    }


    public function chon_nhom_cong_thuc(Request $request)  //---OK
    {
        $hocphan_loai_htdg_array=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$request->session()->get('maHocPhan'))->where('groupCT',$request->groupCT)->get();

        foreach ($hocphan_loai_htdg_array as $value) {
            ct_bai_quy_hoach::create(['maHocPhan'=>$value->maHocPhan,'maLoaiDG'=>$value->maLoaiDG,'maLoaiHTDG'=>$value->maLoaiHTDG,
            'trongSo'=>$value->trongSo,'maBaiQH'=>$request->session()->get('maBaiQH'),'maGV_2'=>'00000']);
        }
        alert()->success('Adding successfully!', 'Message');
        return back();
    }


    public function xoa_nhom_cong_thuc($maBaiQH)
    {
        ct_bai_quy_hoach::where('maBaiQH',$maBaiQH)->delete();
        CommonController::success_notify('Xóa thành công!','Deleted successfully!');
        return redirect('/giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.Session::get('maHocPhan').'/'.Session::get('maBaiQH').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maLop'));
    }
    /////////---------NỘI DUNG QUY HOẠCH
    ///giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/1
    public function noi_dung_quy_hoach($maCTBaiQH) //-----OK
    {
        Session::put('maCTBaiQH',$maCTBaiQH);
        $ct_bqh=ct_bai_quy_hoach::where('isdelete',false)->where('maCTBaiQH',$maCTBaiQH)->first();
        
        if(!$ct_bqh){
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/noi-dung-quy-hoach/'.$maCTBaiQH)->with('warning','Không thể tìm thất chi tiết bài quy hoạch');
        }
        $ndqh=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)
        ->with('muc_do_dg')
        ->with('cauhoi_ndqh')
        ->with('kqht')
        ->get();
        
        //kết quả học tập
        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',Session::get('maHocPhan'))
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->distinct(['hocphan_kqht_hp.maHocPhan','hocphan_kqht_hp.maKQHT'])
        ->orderBy('kqht_hp.maKQHT','asc')
        ->get(['hocphan_kqht_hp.maHocPhan','hocphan_kqht_hp.maKQHT','kqht_hp.maKQHTVB','kqht_hp.tenKQHT']);
        
        //mức độ đánh giá
        $mdg=mucDoDanhGia::all();

        //luu loai danh gia va loai hinh thuc danh gia
        Session::put('maLoaiHTDG',$ct_bqh->maLoaiHTDG);
        Session::put('maLoaiDG',$ct_bqh->maLoaiDG);

        $lht=loaiHTDanhGia::find($ct_bqh->maLoaiHTDG);

        $gd=giangDay::where('maHocPhan',Session::get('maHocPhan'))
        ->where('maGV',Session::get('maGV'))
        ->orderBy('namHoc','desc')
        ->get();

        
        return view('giangvien.quyhoach.noidungquyhoach',['noiDungQH'=>$ndqh,'maCTBaiQH'=>$maCTBaiQH,'ketQuaHT'=>$kqht,
        'mucDoDG'=>$mdg,'giangday'=>$gd,'lht'=>$lht]);
    }

    // $request->maBaiQH
    public function su_dung_lai_du_lieu(Request $request) 
    {
        $count_ct_bqh=ct_bai_quy_hoach::where('maBaiQH',$request->maBaiQH)->where('maLoaiHTDG',Session::get('maLoaiHTDG'))->count('maCTBaiQH');

        $ct_bqh=ct_bai_quy_hoach::where('maBaiQH',$request->maBaiQH)->where('maLoaiHTDG',Session::get('maLoaiHTDG'))->first();
        
        //neu có hai dòng của ct_bai_quy_hoach xuất hiện, thì lấy dòng có maLoaiDG đúng với phần đang sử dụng
        if($count_ct_bqh>1){
            $ct_bqh=ct_bai_quy_hoach::where('maBaiQH',$request->maBaiQH)->where('maLoaiDG',Session::get('maLoaiDG'))->where('maLoaiHTDG',Session::get('maLoaiHTDG'))->first();
        }
        if($ct_bqh){
            //su dung lai du lieu o day
            if(Session::get('maLoaiHTDG')=='T1' || Session::get('maLoaiHTDG')=='T3'){  //tu luan || thực hành ---  Test: OK
                //maCTBaiQH-->noiDungQH array --> cau_hoi_ndqh
                $ndqh=noiDungQH::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get(); ///lay ra noi dung quy hoach
                foreach ($ndqh as  $nd) {
                    //luu noi dung quy hoach moi
                    noiDungQH::create(['tenNoiDungQH'=>$nd->tenNoiDungQH,'noiDungQH'=>$nd->noiDungQH,'maMucDoDG'=>$nd->maMucDoDG,
                    'maKQHT'=>$nd->maKQHT,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
                    //lay id cua noi dung quy hoach vua luu
                    $ndqh_new=noiDungQH::orderBy('maNoiDungQH','desc')->first();
                    //tien hanh luu cau hoi theo noi dung quy hoach
                    $ch_ndqh=cau_hoi_ndqh::where('maNoiDungQH',$nd->maNoiDungQH)->get(); //lay cac cau hoi tu noi dung quy hoach cu tuong ung
                   
                    if($ch_ndqh){ //neu co cau hoi, lưu lai trong bang cauhoi_ndqh
                        foreach($ch_ndqh as $ch){
                            cau_hoi_ndqh::create(['maNoiDungQH',$ndqh_new->maNoiDungQH,'maCauHoi'=>$ch->maCauHoi]);
                        }
                    }
                }
                // tien hanh lưu de thi moi
                $dethi=deThi::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get();//lay cac de thi tu noi dung quy hoach cu tuong ung
                if($dethi){
                    foreach($dethi as $dt){ //chay qua tat ca cac de thi
                        //tao de thi moi tuong ung voi maCTBaiQH moi
                        deThi::create(['maDeVB'=>$dt->maDeVB,'soCauHoi'=>$dt->soCauHoi,'tenDe'=>$dt->tenDe,'thoiGian'=>$dt->thoiGian,
                        'maCTBaiQH'=>Session::get('maCTBaiQH'),'ghiChu'=>$dt->ghiChu]);
                        //lay de thi moi vua tao
                        $dethi_new=deThi::orderBy('maDe','desc')->first();
                        //lay noi dung de thi cua phien ban cu
                        $ct_dethi_old=dethi_cauhoituluan::where('maDe',$dt->maDe)->get();
                        if($ct_dethi_old){//neu de thi co noi dung thi them noi dung do vao de thi moi
                            foreach($ct_dethi_old as $ct){
                                //tim phuong an trong de thi cu
                                $phuong_an_old=phuongAnTuLuan::where('id',$ct->maPATL)->first();
                                if($phuong_an_old){
                                    //tao phuong an cho phien ban moi
                                    phuongAnTuLuan::create(['noiDungPA'=>$phuong_an_old->noiDungPA,'diemPA'=>$phuong_an_old->diemPA,
                                'maCDR3'=>$phuong_an_old->maCDR3,'maChuanAbet'=>$phuong_an_old->maChuanAbet]);
                                 //lay phuong an vua moi them
                                 $phuong_an_new=phuongAnTuLuan::orderBy('id','desc')->first();
                                 //them vao chi tiet cho de thi moi
                                 dethi_cauhoituluan::create(['maDe'=>$dethi_new->maDe,'maCauHoi'=>$ct->maCauHoi,'maPATL'=>$phuong_an_new->id]);
                                }
                            }
                        }

                            //-----------------------------------------------------------------------------------------------------
                            //----------lấy lại điểm phiếu chấm, khi không dùng thì tắt đi vì người dùng sẽ lạm dụng chức năng này
                            //------------------------------------------------------------------------------------------------------
                            //lấy toan bộ phiếu chấm có mã đề $dt->maDe
                            // $phieuCham_old=phieu_cham::where('maDe',$dt->maDe)->get();
                            
                            // //duyệt qua phiếu chấm
                            // foreach($phieuCham_old as $old){
                            //     //lưu lại phieus chấm mới
                            //     $phieuCham_new= new phieu_cham();
                            //     $phieuCham_new->maGV=Session::get('maGV');
                            //     $phieuCham_new->maDe=$dethi_new->maDe; //mã đề mới
                            //     $phieuCham_new->maSSV=$old->maSSV;
                            //     $phieuCham_new->diemSo=$old->diemSo;
                            //     $phieuCham_new->diemChu=$old->diemChu;
                            //     $phieuCham_new->ngayCham=$old->ngayCham;
                            //     $phieuCham_new->trangThai=$old->trangThai;
                            //     $phieuCham_new->xepHang=$old->xepHang;
                            //     $phieuCham_new->loaiCB=$old->loaiCB;
                            //     $phieuCham_new->save();
                            //     //lấy phiếu chấm vừa lưu
                            //     $phieuCham_new=phieu_cham::orderBy('maPhieuCham','desc')->first();
                            //     //lấy chi tiết phiếu chấm
                            //     $ct_pc=danhgia_tuluan::where('maPhieuCham',$old->maPhieuCham)->get();
                            //     //duyệt qua chi tiết phiếu chấm cũ\
                            //     foreach($ct_pc as $x){
                            //         //lưu lại chi thiết phiếu chấm cho phiếu chấm mới
                            //         $ct_new=new danhgia_tuluan();
                            //         $ct_new->maPhieuCham=$phieuCham_new->maPhieuCham; //lấy mã của pc mới
                            //         $ct_new->maPATL=$x->maPATL;
                            //         $ct_new->diemDG=$x->diemDG;
                            //         $ct_new->lanDG=$x->lanDG;
                            //         $ct_new->save();
                            //     }
                            // }
                            //------------------------------------------------------------------------------------------------------
                            //------------------------------------------------------------------------------------------------------
                            //------------------------------------------------------------------------------------------------------          
                        
                    }
                }
            }else{
                if(Session::get('maLoaiHTDG')=='T2'){  //trac nghiem  --- OK
                     //maCTBaiQH-->noiDungQH array --> cau_hoi_ndqh
                    $ndqh=noiDungQH::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get(); ///lay ra noi dung quy hoach
                    foreach ($ndqh as  $nd) {
                        //luu noi dung quy hoach moi
                        noiDungQH::create(['tenNoiDungQH'=>$nd->tenNoiDungQH,'noiDungQH'=>$nd->noiDungQH,'maMucDoDG'=>$nd->maMucDoDG,
                        'maKQHT'=>$nd->maKQHT,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
                        //lay id cua noi dung quy hoach vua luu
                        $ndqh_new=noiDungQH::orderBy('maNoiDungQH','desc')->first();
                        //tien hanh luu cau hoi theo noi dung quy hoach
                        $ch_ndqh=cau_hoi_ndqh::where('maNoiDungQH',$nd->maNoiDungQH)->get(); //lay cac cau hoi tu noi dung quy hoach cu tuong ung
                        if($ch_ndqh){ //neu co cau hoi, lưu lai trong bang cauhoi_ndqh
                            foreach($ch_ndqh as $ch){
                                cau_hoi_ndqh::create(['maNoiDungQH',$ndqh_new->maNoiDungQH,'maCauHoi'=>$ch->maCauHoi]);
                            }
                        }
                        
                    }
                    // tien hanh lưu de thi moi
                    $dethi=deThi::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get();//lay cac de thi tu noi dung quy hoach cu tuong ung
                    
                    if($dethi){
                        foreach($dethi as $dt){ //chay qua tat ca cac de thi
                            //tao de thi moi tuong ung voi maCTBaiQH moi
                            deThi::create(['maDeVB'=>$dt->maDeVB,'soCauHoi'=>$dt->soCauHoi,'tenDe'=>$dt->tenDe,'thoiGian'=>$dt->thoiGian,
                            'maCTBaiQH'=>Session::get('maCTBaiQH'),'ghiChu'=>$dt->ghiChu]);
                            //lay de thi moi vua tao
                            $dethi_new=deThi::orderBy('maDe','desc')->first();
                            //lay noi dung de thi cua phien ban cu
                            $ct_dethi_old=deThi_cauHoi::where('maDe',$dt->maDe)->get();
                            if($ct_dethi_old){//neu de thi co noi dung thi them noi dung do vao de thi moi
                                foreach($ct_dethi_old as $ct){
                                    //tao chi tiet moi cho de thi
                                    deThi_cauHoi::create(['maDe'=>$dethi_new->maDe,'maCauHoi'=>$ct->maCauHoi,'diem'=>$ct->diem]);

                            }

                            //-----------------------------------------------------------------------------------------------------
                            //----------lấy lại điểm phiếu chấm, khi không dùng thì tắt đi vì người dùng sẽ lạm dụng chức năng này
                            //------------------------------------------------------------------------------------------------------
                            
                            // //lấy toan bộ phiếu chấm có mã đề $dt->maDe
                            // $phieuCham_old=phieu_cham::where('maDe',$dt->maDe)->get();
                            // //duyệt qua phiếu chấm
                            // foreach($phieuCham_old as $old){
                            //     //lưu lại phieus chấm mới
                            //     $phieuCham_new= new phieu_cham();
                            //     $phieuCham_new->maGV=Session::get('maGV'); //mã giảng viên của người đang đăng nhập
                            //     $phieuCham_new->maDe=$dethi_new->maDe; //lưu lại phiếu chấm theo đề thi mới
                            //     $phieuCham_new->maSSV=$old->maSSV;
                            //     $phieuCham_new->diemSo=$old->diemSo;
                            //     $phieuCham_new->diemChu=$old->diemChu;
                            //     $phieuCham_new->ngayCham=$old->ngayCham;
                            //     $phieuCham_new->trangThai=$old->trangThai;
                            //     $phieuCham_new->xepHang=$old->xepHang;
                            //     $phieuCham_new->loaiCB=$old->loaiCB;
                            //     $phieuCham_new->save();
                            //     //lấy phiếu chấm vừa lưu
                            //     $phieuCham_new=phieu_cham::orderBy('maPhieuCham','desc')->first();
                            //     //lấy chi tiết phiếu chấm
                            //     $ct_pc=danhgia_tracnghiem::where('maPhieuCham',$old->maPhieuCham)->get();
                            //     //duyệt qua chi tiết phiếu chấm cũ\
                            //     foreach($ct_pc as $x){
                            //         //lưu lại chi thiết phiếu chấm cho phiếu chấm mới
                            //         $ct_new=new danhgia_tracnghiem();
                            //         $ct_new->maPhieuCham=$phieuCham_new->maPhieuCham; //lấy mã pc mới
                            //         $ct_new->maPA=$x->maPA;
                            //         $ct_new->diem=$x->diem;
                            //         $ct_new->save();
                            //     }
                            // }
                            //------------------------------------------------------------------------------------------------------
                            //------------------------------------------------------------------------------------------------------
                            //------------------------------------------------------------------------------------------------------
                            }
                            
                        }
                    }
                }else{
                    if(Session::get('maLoaiHTDG')=='T6' || Session::get('maLoaiHTDG')=='T8'){ //do an hoac seminar
                        //maCTBaiQH-->noiDungQH array --> cau_hoi_ndqh
                          ///lay ra noi dung quy hoach
                        //**Vấn đề phát sinh: vì nội dung quy hoạch đã được xếp từ đầu nên phiếu chấm sẽ được 
                        //xếp theo thứ tự của nội dung quy hoạch--> cần lấy thứ tự nội dung quy hoạch theo thứ tự phiếu chấm */
                        $ndQh=noiDungQH::where('noi_dung_quy_hoach.isDelete',false)
                        ->where('noi_dung_quy_hoach.maCTBaiQH',$ct_bqh->maCTBaiQH)
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
                       ->distinct('noi_dung_quy_hoach.maNoiDungQH')
                       ->pluck('noi_dung_quy_hoach.maNoiDungQH');
                       

                       $ndqh=[];
                        foreach($ndQh as $x){
                            array_push($ndqh,noiDungQH::where('maNoiDungQH',$x)->first());
                        }

                        foreach ($ndqh as  $nd) {
                               //luu noi dung quy hoach moi
                                noiDungQH::create(['tenNoiDungQH'=>$nd->tenNoiDungQH,'noiDungQH'=>$nd->noiDungQH,'maMucDoDG'=>$nd->maMucDoDG,
                                'maKQHT'=>$nd->maKQHT,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
                                //lay id cua noi dung quy hoach vua luu
                                $ndqh_new=noiDungQH::orderBy('maNoiDungQH','desc')->first();
                                //lay tieu chuan danh gia
                                $tieuchuan_old=tieuChuanDanhGia::where('maNoiDungQH',$nd->maNoiDungQH)->get();
                                if($tieuchuan_old){//tien hanh luu tieu chuan va tieu chi
                                    foreach ($tieuchuan_old as $tc) {
                                        tieuChuanDanhGia::create(['tenTCDG'=>$tc->tenTCDG,'diem'=>$tc->diem,'maNoiDungQH'=>$ndqh_new->maNoiDungQH]);
                                        //lay tieu chuan moi nhat vua them
                                        $tieuchuan_new=tieuChuanDanhGia::orderBy('maTCDG','desc')->first();
                                        if($tieuchuan_new){
                                            //lay tat ca cau_hoi_tcchamdiem
                                            $cau_hoi_tcchamdiem=cauHoi_tieuChiChamDiem::where('maTCDG',$tc->maTCDG)->orderBy('maTCCD')->get();
                                            if(count($cau_hoi_tcchamdiem)>0){
                                                $cauhoi_old=cauHoi::where('maCauHoi',$cau_hoi_tcchamdiem[0]->maCauHoi)->first();
                                                cauHoi::create(['noiDungCauHoi'=>$cauhoi_old->noiDungCauHoi,'diemCauHoi'=>$cauhoi_old->diemCauHoi,
                                                'maKQHT'=>$cauhoi_old->maKQHT,'maLoaiHTDG'=>$cauhoi_old->maLoaiHTDG,'maGV'=>Session::get('maGV'),
                                                'id_muc'=>$cauhoi_old->id_muc,'isDelete'=>$cauhoi_old->isDelete]);
                                                $cauhoi_new=cauHoi::orderBy('maCauHoi','desc')->first();
                                                
                                                foreach($cau_hoi_tcchamdiem as $ct_tieu_chuan){
                                                    $tieuchi_old=tieuChiChamDiem::where('maTCCD',$ct_tieu_chuan->maTCCD)->first();
                                                    if($tieuchi_old){// tien hanh them moi tieu chi =>$tieuchi_old->
                                                        tieuChiChamDiem::create(['tenTCCD'=>$tieuchi_old->tenTCCD,
                                                        'diemTCCD'=>$tieuchi_old->diemTCCD,'isDelete'=>$tieuchi_old->isDelete,
                                                        'maCDR3'=>$tieuchi_old->maCDR3,'maChuanAbet'=>$tieuchi_old->maChuanAbet]);
                                                        $tieuchi_new=tieuChiChamDiem::orderBy('maTCCD','desc')->first();
                                                        cauHoi_tieuChiChamDiem::create(['maCauHoi'=>$cauhoi_new->maCauHoi,'maTCCD'=>$tieuchi_new->maTCCD,
                                                        'maTCDG'=>$tieuchuan_new->maTCDG]);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        //them de tai(de_thi)
                        // tien hanh lưu de thi moi
                        $dethi=deThi::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get();//lay cac de thi tu noi dung quy hoach cu tuong ung
                      
                        if($dethi){
                            foreach($dethi as $dt){ //chay qua tat ca cac de thi
                                //tao de thi moi tuong ung voi maCTBaiQH moi
                                deThi::create(['maDeVB'=>$dt->maDeVB,'soCauHoi'=>$dt->soCauHoi,'tenDe'=>$dt->tenDe,'thoiGian'=>$dt->thoiGian,
                                'maCTBaiQH'=>Session::get('maCTBaiQH'),'ghiChu'=>$dt->ghiChu]);

                                //-----------------------------------------------------------------------------------------------------
                                //----------lấy lại điểm phiếu chấm, khi không dùng thì tắt đi vì người dùng sẽ lạm dụng chức năng này
                                //------------------------------------------------------------------------------------------------------
                                // //lấy toan bộ phiếu chấm có mã đề $dt->maDe
                                // $phieuCham_old=phieu_cham::where('maDe',$dt->maDe)->get();
                                // //lấy maDe đề thi mới được thêm
                                // $dethi_new=deThi::orderBy('maDe','desc')->first();

                                // $ct=ct_bai_quy_hoach::where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
                                // $ct->maGV_2=$ct_bqh->maGV_2;
                                // $ct->save();
                                // //duyệt qua phiếu chấm
                                // foreach($phieuCham_old as $old){
                                //     //lưu lại phieus chấm mới
                                //     $phieuCham_new= new phieu_cham();
                                //     if($old->maGV=='03546'){
                                //         $phieuCham_new->maGV=11111;
                                //         //luu lại cán bộ hai trong chi tiết bài quy hoạch
                                //     }else{
                                //         $phieuCham_new->maGV=$old->maGV;
                                //     }
                                //     $phieuCham_new->maDe=$dethi_new->maDe; 
                                //     $phieuCham_new->maSSV=$old->maSSV;
                                //     $phieuCham_new->diemSo=$old->diemSo;
                                //     $phieuCham_new->diemChu=$old->diemChu;
                                //     $phieuCham_new->ngayCham=$old->ngayCham;
                                //     $phieuCham_new->trangThai=$old->trangThai;
                                //     $phieuCham_new->xepHang=$old->xepHang;
                                //     $phieuCham_new->loaiCB=$old->loaiCB;
                                //     $phieuCham_new->save();
                                //     //lấy phiếu chấm vừa lưu
                                //     $phieuCham_new=phieu_cham::orderBy('maPhieuCham','desc')->first();
                                //     //lấy chi tiết phiếu chấm của phiếu chấm cũ
                                //     $ct_pc=danhGia::where('maPhieuCham',$old->maPhieuCham)->get();
                                   
                                //     //duyệt qua chi tiết phiếu chấm cũ để tạo chi tiết cho phiếu chấm mới
                                //     foreach($ct_pc as $x){
                                //         //lưu lại chi thiết phiếu chấm cho phiếu chấm mới
                                //         $ct_new=new danhGia();
                                //         $ct_new->maPhieuCham=$phieuCham_new->maPhieuCham; //mã phiếu chấm mới
                                //         $ct_new->maTCCD=$x->maTCCD;
                                //         $ct_new->diemDG=$x->diemDG;
                                //         $ct_new->lanDG=$x->lanDG;
                                //         $ct_new->save();
                                //     }
                                // }
                                //------------------------------------------------------------------------------------------------------
                                //------------------------------------------------------------------------------------------------------
                                //------------------------------------------------------------------------------------------------------
                            }
                        }
                    
                        
                    }
                }
            }
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.Session::get('maCTBaiQH'));
        }else{
            CommonController::warning_notify('Không có loại hình thức đánh giá phù hợp','No one is suitable');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.Session::get('maCTBaiQH'));
        }
        return $request->maBaiQH;
    }

    public function xoa_toan_bo_du_lieu($maCTBaiQH)
    {
        $ct_bqh=ct_bai_quy_hoach::where('maCTBaiQH',$maCTBaiQH)->where('maLoaiHTDG',Session::get('maLoaiHTDG'))->first();
        //xoa thong ke
        if($ct_bqh){
            thongke_abet_hocphan::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->delete();
            thongke_clo_hocphan::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->delete();
            thongke_so_hocphan::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->delete();
        }

        if($ct_bqh){
            if(Session::get('maLoaiHTDG')=='T1' || Session::get('maLoaiHTDG')=='T3'){  //tu luan || thực hành
                //maCTBaiQH-->noiDungQH array --> cau_hoi_ndqh
                $ndqh=noiDungQH::where('maCTBaiQH',$maCTBaiQH)->get(); ///lay ra noi dung quy hoach
                foreach ($ndqh as  $nd) {
                    //tien xoa cau hoi theo noi dung quy hoach
                    $ch_ndqh=cau_hoi_ndqh::where('maNoiDungQH',$nd->maNoiDungQH)->get(); //lay cac cau hoi tu noi dung quy hoach cu tuong ung
                    if($ch_ndqh){ 
                        foreach($ch_ndqh as $ch){
                            $ch->delete();
                        }
                    }
                    $nd->delete(); //xoa noi dung

                     // tien hanh xoa de thi 
                    $dethi=deThi::where('maCTBaiQH',$maCTBaiQH)->get();//lay cac de thi tu noi dung quy hoach cu tuong ung
                    if($dethi){
                        foreach($dethi as $dt){ //chay qua tat ca cac de thi
                            //lay noi dung de thi cua phien ban cu
                            $ct_dethi_old=dethi_cauhoituluan::where('maDe',$dt->maDe)->get();
                            if($ct_dethi_old){//neu de thi co noi dung thi them noi dung do vao de thi moi
                                foreach($ct_dethi_old as $ct){
                                    //xoa phuong an
                                    $phuong_an_old=phuongAnTuLuan::where('id',$ct->maPATL)->delete();
                                   $ct->delete();
                                }
                            }
                            //xoa phieu cham va noi dung phieu cham
                            $phieucham=phieu_cham::where('maDe',$dt->maDe)->get();
                            foreach($phieucham as $pc){
                                danhgia_tuluan::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                $pc->delete();
                            }
                            $dt->delete();
                        }
                    }
                }

            }else{
                if(Session::get('maLoaiHTDG')=='T2'){    //trac nghiem
                      //maCTBaiQH-->noiDungQH array --> cau_hoi_ndqh
                      $ndqh=noiDungQH::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get(); ///lay ra noi dung quy hoach
                      foreach ($ndqh as  $nd) {
                          $ch_ndqh=cau_hoi_ndqh::where('maNoiDungQH',$nd->maNoiDungQH)->delete(); //lay cac cau hoi tu noi dung quy hoach cu tuong ung
                          $nd->delete();
                      }
                      // tien hanh lưu de thi moi
                      $dethi=deThi::where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get();//lay cac de thi tu noi dung quy hoach cu tuong ung
                      
                      if($dethi){
                          foreach($dethi as $dt){ //chay qua tat ca cac de thi
                            deThi_cauHoi::where('maDe',$dt->maDe)->delete();
                            //xoa phieu cham
                            $phieucham=phieu_cham::where('maDe',$dt->maDe)->get();
                            foreach($phieucham as $pc){
                                danhGia::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                $pc->delete();
                            }
                            $dt->delete();
                          }
                      }
                }else{
                    if(Session::get('maLoaiHTDG')=='T6' || Session::get('maLoaiHTDG')=='T8'){
                        //maCTBaiQH-->noiDungQH array --> cau_hoi_ndqh
                        $ndqh=noiDungQH::where('maCTBaiQH',$maCTBaiQH)->get(); ///lay ra noi dung quy hoach
                        foreach ($ndqh as  $nd) {
                            //lay tieu chuan danh gia
                            $tieuchuan_old=tieuChuanDanhGia::where('maNoiDungQH',$nd->maNoiDungQH)->get();
                            if($tieuchuan_old){//tien hanh luu tieu chuan va tieu chi
                                foreach ($tieuchuan_old as $tc) {
                                    //lay tat ca cau_hoi_tcchamdiem
                                    $cau_hoi_tcchamdiem=cauHoi_tieuChiChamDiem::where('maTCDG',$tc->maTCDG)->get();
                                    if(count($cau_hoi_tcchamdiem)>0){
                                        $cauhoi_old=cauHoi::where('maCauHoi',$cau_hoi_tcchamdiem[0]->maCauHoi)->first();
                                        foreach($cau_hoi_tcchamdiem as $ct_tieu_chuan){
                                            $tieuchi_old=tieuChiChamDiem::where('maTCCD',$ct_tieu_chuan->maTCCD)->first();
                                            $ct_tieu_chuan->delete();
                                            $tieuchi_old->delete();
                                        }
                                        $cauhoi_old->delete();
                                    }
                                    $tc->delete();
                                }
                            }
                            $nd->delete();
                        }
                        //them de tai(de_thi)
                        // tien hanh lưu de thi moi
                        $dethi=deThi::where('maCTBaiQH',$maCTBaiQH)->get();//lay cac de thi tu noi dung quy hoach cu tuong ung
                        if($dethi){
                            foreach($dethi as $dt){ //chay qua tat ca cac de thi
                                //xoa phieu cham
                                $phieucham=phieu_cham::where('maDe',$dt->maDe)->get();
                                foreach($phieucham as $pc){
                                    danhGia::where('maPhieuCham',$pc->maPhieuCham)->delete();
                                    $pc->delete();
                                }
                                $dt->delete();
                            }
                        }
                    }else{
                        'Không tìm thấy!!!';
                    }
                }
            }
        }
        
        CommonController::success_notify('Xóa thành công','Deleted successful!');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.Session::get('maCTBaiQH'));
    }
    
    ///giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/them_noi_dung_quy_hoach_submit
    public function them_noi_dung_quy_hoach(Request $request)  //--OK
    {
        noiDungQH::create($request->all());
        CommonController::success_notify('Thêm thành công!','Added successfully!');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.session::get('maCTBaiQH'));
    }

    public function sua_noi_dung_quy_hoach(Request $request)
    {
        if($request){
            noiDungQH::updateOrCreate(['maNoiDungQH'=>$request->maNoiDungQH],['tenNoiDungQH'=> $request->tenNoiDungQH,
            'maMucDoDG'=>$request->maMucDoDG,'maKQHT'=>$request->maKQHT]);
            CommonController::success_notify('Sửa thành công!','Edited successfully!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.session::get('maCTBaiQH'));
        }else{
            CommonController::success_notify('Có lỗi, vui lòng thực hiện lại!','Please do again!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.session::get('maCTBaiQH'));
        }
       
    }

    public function xoa_moi_dung_quy_hoach($maNoiDungQH)
    {
        //kiem tra neu noi dung da duoc su dung thi khong thhe xoa
        if(cau_hoi_ndqh::where('maNoiDungQH',$maNoiDungQH)->count()>0){
            CommonController::warning_notify('Nội dung đã được sử dụng, không thể xóa!','Content is used, can not delete!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.session::get('maCTBaiQH'));
        }
        //tien hanh xoa
        noiDungQH::where('maNoiDungQH',$maNoiDungQH)->delete();
        //phan hoi
        CommonController::success_notify('Xóa thành công!','Deleted successfully!');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/'.session::get('maCTBaiQH'));
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

    ///---------------thêm quy hoạch
    public function them_quy_hoach(Request $request)
    {
            //maHocPhan+maLoaiDG+=maLoaiHTDG+trongSo===>hocphan_loai_hinhthuc_dg
            ct_bai_quy_hoach::create(['maLoaiDG'=>$request->maLoaiDG,'maLoaiHTDG'=>$request->maLoaiHTDG,'trongSo'=>$request->trongSo,'maBaiQH'=>Session::get('maBaiQH')]);
            //get hocphan_loai_ht_dg
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
            $request->session()->put('maCTBaiQH', $maCTBaiQH);
            //maCTBaiQH->ct_bai-quy_hoach
            $maLoaiHTDG=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->first(['maLoaiHTDG','maLoaiDG']);

            //ct_bai_quy_hoach
            $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->first();
            $request->session()->put('maGV_2', $ct_bqh->maGV_2);
            
            //Mai thêm để lấy ra tên loại hình thức đánh giá hiện trên heading của trang
            $hinhthucDanhGia=loaiHTDanhGia::where('isDelete',false)->where('maLoaiHTDG',$maLoaiHTDG->maLoaiHTDG)->first();
            //Hết Mai thêm

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
                foreach ($dethi as  $dt) {
                    $sch=dethi_cauhoituluan::where('maDe',$dt->maDe)->distinct(['maCauHoi','maDe'])->count('maCauHoi');
                    $dt->cauHoiHienCo=$sch;
                }
                return view('giangvien.quyhoach.noidungdanhgia.tuluan.xemnddanhgiatuluan',compact('dethi','maCTBaiQH'));
            }

            //------------------------------trắc nghiệm
            if ($maLoaiHTDG->maLoaiHTDG=="T2") { 
                $dethi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
                foreach($dethi as $dt){
                    $sch=deThi_cauHoi::where('maDe',$dt->maDe)->count('maCauHoi');
                    $dt->cauHoiHienCo=$sch;
                }
                return view('giangvien.quyhoach.noidungdanhgia.tracnghiem.xemnddanhgiatracnghiem',compact('dethi','maCTBaiQH'));
            }

            //------------------------------thực hành
            if ($maLoaiHTDG->maLoaiHTDG=="T3") { 
                $dethi=deThi::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
                foreach ($dethi as  $dt) {
                    $sch=dethi_cauhoituluan::where('maDe',$dt->maDe)->distinct(['maCauHoi','maDe'])->count('maCauHoi');
                    $dt->cauHoiHienCo=$sch;
                }
                return view('giangvien.quyhoach.noidungdanhgia.thuchanh.xemnddanhgiathuchanh',compact('dethi','maCTBaiQH'));
            }

            //loai hoi thao ceminar, đồ án làm KTL1 hoặc KTL2
            if( $maLoaiHTDG->maLoaiDG != 3 &&  ($maLoaiHTDG->maLoaiHTDG=="T6" || $maLoaiHTDG->maLoaiHTDG=="T8")){
            // if($maLoaiHTDG->maLoaiHTDG=="T6"){                  
                Session::put('maLoaiHTDG',$maLoaiHTDG->maLoaiHTDG); 
                //lấy danh sách sinh viên đã có trong phiếu chấm
                $dssvTrongPC=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maCTBaiQH',$maCTBaiQH)
                ->leftJoin('phieu_cham',function($x){
                    $x->on('phieu_cham.maDe','=','de_thi.maDe')
                    ->where('phieu_cham.maGV','=',Session::get('maGV'))
                    ->where('phieu_cham.isDelete',false);
                })
                ->join('sinh_vien',function($y){
                    $y->on('sinh_vien.maSSV','=','phieu_cham.maSSV')
                    ->where('sinh_vien.isDelete',false);
                })
                //->get('maSSV');
                ->get();
                
                $massv= [];
                foreach ($dssvTrongPC as $value) {
                    if($value->maSSV==null)
                        array_push($massv,'null');
                    else
                        array_push($massv, $value->maSSV);
                }
                
                $dssv_hocphan=sinhvien_hocphan::where('maHK',session::get('maHK'))->where('namHoc',session::get('namHoc'))
                ->where('maLop',session::get('maLop'))->whereNotIn('maSSV',$massv)->pluck('maSSV');
                //select những sinh viên chưa được gán vào phiếu chấm
                $dsLop=sinhVien::where('isDelete',false)->where('maLop',Session::get('maLop'))->whereNotIn('maSSV',$massv)->orderBy('maSSV')->get();
                
                //lấy danh sách đề tài
                $deTai=deThi::where('de_thi.maCTBaiQH',$maCTBaiQH)->get();
               
                foreach($deTai as $value){
                   //Code cũ đang chạy hiện danh sách mỗi đề tài 1 người của Duy
                    /* $phieuCham=phieu_cham::where('maDe',$value->maDe)->first();
                    if($phieuCham){
                        $value->maSSV=$phieuCham->maSSV;
                        $sv=sinhVien::where('maSSV',$phieuCham->maSSV)->first();
                        $HoSV = ($sv) ? $sv->HoSV : "" ;
                        $TenSV = ($sv) ? $sv->TenSV : "" ;
                        $value->HoSV=$HoSV;
                        $value->tenSV=$TenSV;
                    }*/
                    //Code mới Mai viết để hiện danh sách theo nhóm
                    $phieuCham=phieu_cham::where('maDe',$value->maDe)->get();
                    
                   $value->soLuongSV=count($phieuCham);
                    
                    //hết code Mai viết
                   
                }
               
                //giảng viên
                $gv=giangVien::where('isDelete',false) ->where('maGV','!=',Session::get('maGV'))->get();
                return view('giangvien.quyhoach.noidungdanhgia.hoithao.index',['deThi'=>$maDe,
                'maCTBaiQH'=>$maCTBaiQH,'deTai'=>$deTai,'gv'=>$gv,'dsLop'=>$dsLop, 'dssvTrongPC'=>$dssvTrongPC, 'hinhthucDanhGia'=>$hinhthucDanhGia]);
            }
            //-------------------------------cho đồ án, seminar kết thúc môn
            if($maLoaiHTDG->maLoaiDG == 3 && ($maLoaiHTDG->maLoaiHTDG=="T6" || $maLoaiHTDG->maLoaiHTDG=="T8")){ 
                //if($maLoaiHTDG->maLoaiHTDG=="T8"){   
                    Session::put('maLoaiHTDG',$maLoaiHTDG->maLoaiHTDG); 
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
                    
                    $dssv_hocphan=sinhvien_hocphan::where('maHK',session::get('maHK'))->where('namHoc',session::get('namHoc'))
                    ->where('maLop',session::get('maLop'))->whereNotIn('maSSV',$massv)->pluck('maSSV');
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
            
        

    }

    
    ///////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////KHU VỰC HÀM CHO TRẮC NGHIỆM/////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////
    public function cau_truc_de_trac_nghiem(Request $request,$maDe) //dẫn đến view cấu trúc đề thi
    {
        Session::put('maDe',$maDe);
        #thông tin học phần
        $hocphan=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();

        #thong tin chuong
        $chuong=chuong::get_chuong_by_maHocPhan($hocphan->maHocPhan);
          
        #thông tin mục
        $muc=hocPhan::get_muc_by_maHocPhan(Session::get('maHocPhan'));
         
        #thông tin đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
        #thông tin chuẩn đầu ra  
        $cdr3=hocPhan::get_cdr_by_maHocPhan(Session::get('maHocPhan'));
          #nội dung đề thi tự luận
          $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
          ->join('de_thi_cau_hoi','de_thi_cau_hoi.maDe','=','de_thi.maDe')
          ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
          ->distinct('cau_hoi.maCauHoi')

          ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
          #tính điểm câu hỏi
          $letter=['A','B','C','D'];
          for ($i=0; $i <count($noidung) ; $i++) { 
              # code...
              $diem=deThi_cauHoi::where('maCauHoi',$noidung[$i]->maCauHoi)->where('maDe',$maDe)->get('diem');
              $noidung[$i]->diem=$diem[0]['diem'];
              $noidung[$i]->phuong_an=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->get();
              for ($j=0; $j <count($noidung[$i]->phuong_an) ; $j++) { 
                if(substr($noidung[$i]->phuong_an[$j]->noiDungPA, 0, 3) === '<p>'){
                    $noidung[$i]->phuong_an[$j]->noiDungPA=substr_replace($noidung[$i]->phuong_an[$j]->noiDungPA, $letter[$j].'. ', 3, 0);
                }else{
                    $noidung[$i]->phuong_an[$j]->noiDungPA = $letter[$j].'. '.$noidung[$i]->phuong_an[$j]->noiDungPA;
                }            
              }
          }
          #dem so cau hoi hien co
          $dem_cau_hoi=deThi_cauHoi::where('maDe',$maDe)->count('maCauHoi');
          ##tạo mảng các câu hỏi đã chọn->chỉ duyệt những câu hỏi chưa được chọn
        $cauhoidachon=deThi_cauHoi::where('maDe',$maDe)->distinct('maCauHoi')->pluck('maCauHoi');
        #thông tin câu hỏi
        $cauhoi=[];
        foreach ($muc as  $value) {
            $temp=cauHoi::where('isdelete',false)->where('id_muc',$value->id)
            ->where('maLoaiHTDG','T2')->whereNotIn('maCauHoi',$cauhoidachon)->with('phuong_an_trac_nghiem')->get();
            for ($i=0; $i < count($temp) ; $i++) { 
                for ($j=0; $j < count($temp[$i]->phuong_an_trac_nghiem); $j++) { 
                    $temp[$i]->phuong_an_trac_nghiem[$j]->noiDungPA=substr_replace($temp[$i]->phuong_an_trac_nghiem[$j]->noiDungPA, $letter[$j].'. ', 3, 0);
                }
            }
           
            foreach ($temp as $ch) {
                array_push($cauhoi,$ch);
            }
        }
       
        #phản hồi kết quả
        return view('giangvien.quyhoach.noidungdanhgia.tracnghiem.cautrucde',
        compact('dethi','hocphan','cauhoi','cdr3','noidung','chuong','muc','dem_cau_hoi'));
    }

    //them de thi trac nghiem moi
    public function them_de_thi_trac_nghiem()
    {
        return view('giangvien.quyhoach.quyhoach2');
    }
   

    public function them_de_thi_trac_nghiem_submit (Request $request)//thêm tiêu đèn, ngày thi, giờ thi,...
    {
        deThi::create(['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,'tenDe'=>$request->tenDe,'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
        $dethi=deThi::orderBy('maDe','desc')->first();
        raDe::create(['maDe'=>$dethi->maDe,'maGV'=>session::get('maGV'),'maHocPhan'=>session::get('maHocPhan'),'maLop'=>session::get('maLop')]);
        CommonController::success_notify('Thêm thành công!!','Added successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function xoa_cau_hoi_de_trac_nghiem($maCauHoi)
    {
        $maDe=Session::get('maDe');
        $ch=deThi_cauHoi::where('maCauHoi',$maCauHoi)->where('maDe',$maDe)->first();
        if($ch){
            $ch->delete();
        }
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.$maDe);
    }
    

    public function them_cau_hoi_de_trac_nghiem(Request $request) //nhấn nút thêm câu hỏi vào đề thi
    {
        $maDe=Session::get('maDe');
        if($request==null){  //chua chon cau hoi
            CommonController::warning_notify('Chưa chọn câu hỏi!','Please choice a questions');
            return '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.$request->maDe;
        }
        $dethi=deThi::where('maDe',$maDe)->first();
        if($dethi){
            //kiem tra cau hoi da duoc su dung trong de thi
            $diem=number_format(10/$dethi->soCauHoi,2);
            $dem_cau_hoi=deThi_cauHoi::where('maDe',$maDe)->count();
           
            if($dem_cau_hoi=$dethi->soCauHoi){//de thi da du so cau hoi
                CommonController::warning_notify('Đề thi đã đủ số câu hỏi!','The examination is enough question!');
                return '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.$maDe;
            }else{
                foreach ($request->array as  $value) {
                    //neu cau hoi da duoc su dung thi khong them
                    $check_ques=deThi_cauHoi::where('maDe',$maDe)->where('maCauHoi',$value['id'])->count();
                    if($check_ques>0){
                        continue;
                    }
                    deThi_cauHoi::create(['maDe'=>Session::get('maDe'),'maCauHoi'=>$value['id'],'diem'=>$diem]);
                    $dem_cau_hoi=deThi_cauHoi::where('maDe',$maDe)->count();
                    if($dem_cau_hoi=$dethi->soCauHoi){
                        break;
                    }
                }
            }
        }else{
            CommonController::warning_notify('Không tìm thấy đề thi!','There are not examination!');
        }
        return '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.$request->maDe;
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////KHU VỰC HÀM CHO BÁO CÁO//////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    //-----mời chấm báo cáo
    public function moi_cham_bao_cao(Request $request)
    {
        //kiễm tra đã mời hay chưa
        $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)
        ->where('maCTBaiQH',Session::get('maCTBaiQH'))
        ->first();
        if($ct_bqh){
            $ct_bqh->maGV_2=$request->maGV_2;
            $ct_bqh->update();
            alert()->success('Inviting instructor successfully','Messsage');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
        alert()->success('Errors','Warning');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        
    }

    //thêm đề tài mới
    public function them_de_tai(Request $request)
    {
        deThi::create(['maDeVB'=>$request->maDe,'tenDe'=>$request->tenDe,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
        $dethi=deThi::orderBy('maDe','desc')->first();
        if($dethi){
            raDe::create(['maDe'=>$dethi->maDe,'maGV'=>session::get('maGV'),'maHocPhan'=>session::get('maHocPhan'),'maLop'=>session::get('maLop')]);
            CommonController::success_notify('Thêm thành công!!','Added successfully');
        }else{
           CommonController::warning_notify('Không tìm thấy đề tài','Can not found project'); 
        }
       
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function xoa_de_tai($maDe)
    {
        if(phieu_cham::where('maDe',$maDe)->count('maPhieuCham')>0){
            CommonController::warning_notify('Tên đề tài đang được sử dụng!','The title is useing!'); 
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }else{
            deThi::where('maDe',$maDe)->delete();
            CommonController::success_notify('Xóa thành công!!','Deleted successfully');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
    }

    //thêm phiếu chấm mới
    public function them_phieu_cham(Request $request)
    {
        //noiDungDe+maSSV->phieuCham
        $ct_bqh=ct_bai_quy_hoach::where('isDelete',false)->where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
        if($ct_bqh!=null && $ct_bqh->maLoaiDG !=3 && ($ct_bqh->maLoaiHTDG=='T6'||$ct_bqh->maLoaiHTDG=='T8')){//dạng ceminar hội thảo hoặc đồ án làm quá trình nên cho phép 1 người chấm
            //Mai sửa đoạn này để chọn nhóm SV cho 1 đề tài
            $maSSV=$request->maSSV;
            foreach ($maSSV as $sv)
            {
                phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$sv,'maDe'=>$request->maDe]);
            }
            CommonController::success_notify('Thêm thành công!','Added successfully!');
            return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            /*phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$request->maSSV,'maDe'=>$request->maDe]);
            CommonController::success_notify('Thêm thành công!','Added successfully!');
            return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            */
            //Hết đoạn Mai sửa
        }
        //kiễm tra đã mời hay chưa -- đối với dạng đồ án 2 người chấm (đồ án, khóa luận,...)
        if($ct_bqh->maGV_2){
            
            if($ct_bqh->maGV_2!='00000'){ //nếu không cần mời thêm cán bộ 2 ( mã CB 2 =0000) (đã mời cán bộ chấm rồi)
                foreach($request->maSSV as $ms){
                    //cb1
                    phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$ms,'maDe'=>$request->maDe]);
                    //cb2
                    phieu_cham::create(['maGV'=>$ct_bqh->maGV_2,'loaiCB'=>2,'maSSV'=>$ms,'maDe'=>$request->maDe]);
                }
                CommonController::success_notify('Thêm thành công!!','Added successfully');
                return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            }
            else{
                foreach($request->maSSV as $ms){
                    //cb1
                    phieu_cham::create(['maGV'=>Session::get('maGV'),'loaiCB'=>1,'maSSV'=>$ms,'maDe'=>$request->maDe]);
                    //cb2
                    phieu_cham::create(['maGV'=>$request->maGV_2,'loaiCB'=>2,'maSSV'=> $ms,'maDe'=>$request->maDe]);
                }
                CommonController::success_notify('Thêm thành công!!','Added successfully');
                return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'))->with('success','Thêm thành công!');
            }
        }
        else{
            CommonController::warning_notify('Chưa mời giảng viên chấm báo cáo!','Dont have instructor');
            return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
    }

    //xem tiêu chí đánh giá
    ////giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/
    public function xem_tieu_chi_danh_gia($maCTBaiQH)
    {
             Session::put('maCTBaiQH',$maCTBaiQH);
             ///get loaiHTDG
             $lhtdg=ct_bai_quy_hoach::find($maCTBaiQH);
             Session::put('maLoaiHTDG',$lhtdg->maLoaiHTDG);

             //ct_bai-quy_hoach->noi_dung_quy_hoach
             $ndQh=noiDungQH::where('noi_dung_quy_hoach.isDelete',false)
             ->where('noi_dung_quy_hoach.maCTBaiQH',$maCTBaiQH)
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
            
            //return $ndQh;

            foreach ($ndQh as $tc) {
                 $cdr3=CDR3::where('isDelete',false)
                     ->where('maCDR3', $tc->maCDR3)
                     ->get(['maCDR3VB', 'tenCDR3','tenCDR3EN']);
                $abet=chuan_abet::where('isDelete',false)
                ->where('maChuanAbet', $tc->maChuanAbet)
                ->get(['maChuanAbetVB', 'tenChuanAbet','tenChuanAbet_EN']);
                 $tc->tenCDR3=$cdr3[0]["tenCDR3"];
                 $tc->maCDR3VB=$cdr3[0]["maCDR3VB"];
                 $tc->tenCDR3EN=$cdr3[0]["tenCDR3EN"];
                 $tc->tenChuanAbet=$abet[0]['tenChuanAbet'];
                 $tc->tenChuanAbet_EN=$abet[0]['tenChuanAbet_EN'];
                 $tc->maChuanAbetVB=$abet[0]['maChuanAbetVB'];
            }

        
            // return $ndQh->count('tenTCCD');  //số tiêu chí trong một tiêu chuẩn
            // return $ndQh->groupBy('maCDR3')->count();//số chuẩn đầu ra
            $CDR3=CDR3::orderBy('maCDR3VB')->get();//combobox
            $ABET=chuan_abet::orderBy('maChuanAbetVB')->get();//combobox
            $ndqh=noiDungQH::where('maCTBaiQH',$maCTBaiQH)->get();
            return view('giangvien.quyhoach.xemtieuchi',['tieuchi'=>$ndQh,'CDR3'=>$CDR3,'ABET'=>$ABET,'ndqh'=>$ndqh]);
       
    }
   
    //thêm tiêu chí đánh giá mới
    ///giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-tieu-chi-danh-gia
    public function them_tieu_chi_danh_gia(Request $request,$maCTBaiQH)
    {
        $request->session()->put('maCTBaiQH', $maCTBaiQH);

        $cdr3=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',Session::get('maHocPhan'))
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->join('cdr_cd3',function($t){
            $t->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->distinct(['cdr_cd3.maCDR3','hocphan_kqht_hp.maHocPhan'])
        ->orderBy('cdr_cd3.maCDR3VB')
        ->get(['cdr_cd3.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3','cdr_cd3.tenCDR3EN','hocphan_kqht_hp.maHocPhan']);
        
        
        $chuanAbet=chuan_abet::all();

        //kqht
        //kết quả học tập
        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',Session::get('maHocPhan'))
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->distinct(['hocphan_kqht_hp.maHocPhan','kqht_hp.maKQHT'])
        ->orderBy('kqht_hp.maKQHT','asc')
        ->get(['hocphan_kqht_hp.maHocPhan','kqht_hp.maKQHT','kqht_hp.maKQHTVB','kqht_hp.tenKQHT']);
        
        //loai ht dg
        $loai_htdg=loaiHTDanhGia::where('isDelete',false)->get();
       
        $ndqh=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();  //comnbobox
        if(count($ndqh)==0){
            if(Session::has('language') && Session::get('language')=='vi'){
                alert()->warning('Cần thêm nội dung quy hoạch!','Thông báo');
            }else{
                alert()->warning('You must insert planning content first!','Message');
            }
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.$maCTBaiQH);
        }
      
        //noiDung BaiqH
        if (Session::has('maNoiDungQH')) {
            $tc=tieuChuanDanhGia::where('isDelete',false)->where('maNoiDungQH',Session::get('maNoiDungQH'))->orderBy('maNoiDungQH','desc')->get();  //tay tieu chuan
        } else {
            $ndqh_arr=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->pluck('maNoiDungQH');  // lay mang noi dung qh
            $tc=tieuChuanDanhGia::where('isDelete',false)->whereIn('maNoiDungQH',$ndqh_arr)->orderBy('maNoiDungQH','desc')->get();  //tay tieu chuan
        }

        return view('giangvien.quyhoach.themtieuchi',['cdr3'=>$cdr3,'kqht'=>$kqht,'loai_htdg'=>$loai_htdg,'tieuchuan'=>$tc,
        'ndqh'=>$ndqh,'maCTBaiQH'=>$maCTBaiQH,'chuanAbet'=>$chuanAbet]);
    }

    public function sua_tieu_chi_danh_gia_submit(Request $request)
    {
       
        //tieuChiChamDiem::updateOrCreate(['maTCCD'=>$request->maTCCD],['tenTCCD'=>$request->tenTCCD,'diemTCCD'=>$request->diemTCCD]);
        $tc=tieuChiChamDiem::find($request->maTCCD);
        if($tc){
            $tc->tenTCCD=$request->tenTCCD;
            $tc->diemTCCD=$request->diemTCCD;
            $tc->update();
        }
      CommonController::success_notify('Sửa thành công!','Edited successfully');
       return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    //sua chuan abet cua tieu chi
    public function sua_abet_tieu_chi_danh_gia(Request $request)
    {
        if($request){
            //maTCDG->cau_hoi_tcchamdiem->TCCD
            $TCCD=cauHoi_tieuChiChamDiem::where('maTCDG',$request->maTCDG)
            ->join('tieu_chi_cham_diem',function($x) use($request){
                $x->on('cau_hoi_tcchamdiem.maTCCD','=','tieu_chi_cham_diem.maTCCD')
                ->where('tieu_chi_cham_diem.maCDR3',$request->maCDR3);
            })->get();
            //foreach TCCD->(maChuanAbet)
            foreach ($TCCD as $tccd) {
                tieuChiChamDiem::updateOrCreate(['maTCCD'=>$tccd->maTCCD],['maChuanAbet'=>$request->maChuanAbet]);
            }
            
        }
       CommonController::success_notify('Sửa thành công!','Edited successfully');
       return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));

    }

    //xoa tieu chi danh gia
    public function xoa_tieu_chi_danh_gia( $maTCDG,$maTCCD)
    {
        if(danhGia::where('maTCCD',$maTCCD)->count('maDanhGia')>0){
            CommonController::warning_notify('Tiêu chí đang được sử dụng, không thể xóa!','This one is used, can not delete!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
        }
        cauHoi_tieuChiChamDiem::where('maTCDG',$maTCDG)->where('maTCCD',$maTCCD)->delete();
        tieuChiChamDiem::where('maTCCD',$maTCCD)->delete();
        CommonController::success_notify('Sửa thành công!','Edited successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    //chinh sua tieu chi danh gia
    public function sua_tieu_chi_danh_gia(Request $request)
    {
       if($request->tenTCCD =="" || $request->tenTCCD==null){
           CommonController::warning_notify('Chưa nhập tên tiêu chí!','Please add purpose name again!');
           return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
       } 
       tieuChiChamDiem::updateOrCreate(['maTCCD'=>$request->maTCCD],['tenTCCD'=>$request->tenTCCD,'diemTCCD'=>$request->diemTCCD]);
       //phan hoi
       CommonController::success_notify('Thêm thành công!','Added successfully');
       return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function them_tieu_chuan_submit(Request $request)
    {
        Session::put('maNoiDungQH',$request->maNoiDungQH);
        tieuChuanDanhGia::create(['tenTCDG'=>$request->tenTCDG,'maNoiDungQH'=>$request->maNoiDungQH,'diem'=>$request->diemTCDG]);
        CommonController::success_notify('Thêm thành công!','Added successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function sua_tieu_chuan_submit(Request $request)
    {
        $maKQHT=noiDungQH::where('maNoiDungQH',$request->maNoiDungQH)->pluck('maKQHT');
        $hp_kqht=hocPhan_kqHTHP::where('maHocPhan',session::get('maHocPhan'))->where('maKQHT',$maKQHT)->pluck('maCDR3');
        $cdr3=CDR3::whereIn('maCDR3',$hp_kqht)->orderBy('maCDR3VB')->first();

        //sua thong tin tieu chuan
        return $hp_kqht;
        tieuChuanDanhGia::updateOrCreate(['maTCDG'=>$request->maTCDG],['tenTCDG'=>$request->tenTCDG,'maNoiDungQH'=>$request->maNoiDungQH,'diem'=>$request->diem]);
        //sua chuan dau ra và abet cho cac tieu chi lien quan

        $cdr3_abet=($cdr3)?cdr3_abet::where('maCDR3',$cdr3->maCDR3)->first():1;
        $maChuanAbet = ($cdr3_abet) ? $cdr3_abet->maChuanAbet : 1 ;
        $ch_tccd=cauHoi_tieuChiChamDiem::where('maTCDG',$request->maTCDG)->pluck('maTCCD');
        $tieuchi=tieuChiChamDiem::whereIn('maTCCD',$ch_tccd)->get();

        foreach($tieuchi as $tc){
            $tc->maCDR3=($cdr3)?$cdr3->maCDR3:1;
            $tc->maChuanAbet=($maChuanAbet)?$maChuanAbet:1;
            $tc->update();
        }
        CommonController::success_notify('Sửa thành công!','Edited successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function xoa_tieu_chuan_submit($maTCDG)
    {
        if(cauHoi_tieuChiChamDiem::where('maTCDG',$maTCDG)->count()>0){
            CommonController::warning_notify('Tiêu chuẩn đang được sử dụng, vui lòng xóa hết tiêu chí để xóa tiêu chuẩn này!','This one is used, cannot delete!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
        }
        tieuChuanDanhGia::where('maTCDG',$maTCDG)->delete();
        CommonController::success_notify('Xóa thành công!','Added successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/them-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function them_tieu_chi_danh_gian_submit(Request $request) // submit form thêm tiêu chí đánh giá mới
    {

        //luu lai maNoiDungQH de luu lai vi tri chon cua combobox
        Session::put('maNoiDungQH',$request->maNoiDungQH);
        //luu lai maTCDG
        Session::put('maTCDG',$request->maTCDG);
        //tạo câu hỏi noiDungCauHoi
        cauHoi::create(['noiDungCauHoi'=>'text','maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>Session::get('maLoaiHTDG'),'id_loaiCH'=>4,'id_muc'=>1]);
        $ch=cauHoi::where('isDelete',false)->orderBy('maCauHoi','desc')->first();
        //noiDungQH->tieuchuan_danhgia
        $noiDungQH=noiDungQH::where('isDelete',false)->where('maCTBaiQH',Session::get('maCTBaiQH'))->where('maKQHT',$request->maKQHT)->first();
        $tc=tieuChuanDanhGia::where('isDelete',false)->where('maTCDG',$request->maTCDG)->first();
        //duyêt tenTCCD[]
        //duyệt diemTCCD[]
        $tenTCCD=$request->tenTCCD;
        $diemTCCD=$request->diemTCCD;
        $cdr3_abet=cdr3_abet::where('maCDR3',$request->maCDR3)->first();
        $maChuanAbet = ($cdr3_abet) ? $cdr3_abet->maChuanAbet : 1 ;
        Session::put('maCDR3',$request->maCDR3);
        Session::put('maKQHT',$request->maKQHT);

        for ($i=0; $i < count($tenTCCD); $i++) { 
            tieuChiChamDiem::create(['tenTCCD'=>$tenTCCD[$i],'diemTCCD'=>$diemTCCD[$i],'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$maChuanAbet]);
            $tccd=tieuChiChamDiem::orderBy('maTCCD','desc')->first();
            $ch_tccd=new cauHoi_tieuChiChamDiem();
            $ch_tccd->maCauHoi=$ch->maCauHoi;
            $ch_tccd->maTCCD=$tccd->maTCCD;
            $ch_tccd->maTCDG=$tc->maTCDG;
            $ch_tccd->save();
        }
        return redirect('giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-tieu-chi-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function xoa_phieu_cham($maDe,$maSSV)
    {
        $phieucham=phieu_cham::where('maDe',$maDe)->where('maSSV',$maSSV)->get();
        if($phieucham){
            //kiem tra neu phieu cham co du lieu thi khong the xoa
            foreach ($phieucham as $key => $value) {
                $dg=danhGia::where('isDelete',false)->where('maPhieuCham',$value->maPhieuCham)->count('maDanhGia');
                if($dg>0){
                    CommonController::warning_notify('Phiếu chấm có dữ liệu, không thể xóa!','The answer sheet has data!, can not delete');
                    return back();
                }
            }
            //tien hanh xoa phieu cham
            foreach ($phieucham as $pc) {
                $pc->delete();
            }
            alert()->success('Xóa thành công!','Message');
            CommonController::success_notify('Xóa thành công!','Deleted successfuly');
            return back();
           
        }else{
            CommonController::warning_notify('Không tìm thấy phiếu chấm!','Can not found the answer sheet');
            return back();
        }
        return back();
    }

    public function sua_ten_de_tai(Request  $request)
    {
        $dethi=deThi::where('maDe',$request->maDe)->first();
        if($dethi){
            $dethi->tenDe=$request->tenDe;
            $dethi->save();
            if(session::has('language'))
            alert()->success('Editing  successfully!','Message');
            return back();
        }

    }
    //Mai mới thêm
    public function xoa_de_tai_hoi_thao($maDe)
    {
        $phieucham=phieu_cham::where('maDe',$maDe)->get();
        if($phieucham){
            //kiem tra neu phieu cham co du lieu thi khong the xoa
            foreach ($phieucham as $key => $value) {
                $dg=danhGia::where('isDelete',false)->where('maPhieuCham',$value->maPhieuCham)->count('maDanhGia');
                if($dg>0){
                    CommonController::warning_notify('Phiếu chấm có dữ liệu, không thể xóa!','The answer sheet has data!, can not delete');
                    return back();
                }
            }
            //tien hanh xoa phieu cham
            foreach ($phieucham as $pc) {
                $pc->delete();
            }
            $detai=deThi::where('maDe',$maDe)->first();
            if($detai){
                $detai->delete();
            }
            alert()->success('Xóa thành công!','Message');
            CommonController::success_notify('Xóa thành công!','Deleted successfuly');
            return back();
        }
        else{
            CommonController::warning_notify('Không tìm thấy phiếu chấm!','Can not found the answer sheet');
            return back();
        }
        return back();
    }
    
}
