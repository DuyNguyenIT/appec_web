<?php

namespace App\Http\Controllers\giangvien;

use Session;
use App\Models\muc;
use App\Models\CDR3;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\cdr3_abet;
use App\Models\noiDungQH;
use App\Models\chuan_abet;
use App\Models\cau_hoi_ndqh;
use App\Models\deThi_cauHoi;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\ct_bai_quy_hoach;
use App\Models\phuongAnTracNghiem;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

class GVCauHoiTracNghiemController extends Controller
{
    public function index(Request $request,$maMuc,$maCTBaiQH)  //show ---OK
    {
        $request->session()->put('maMuc', $maMuc);
        $request->session()->put('maCTBaiQH', $maCTBaiQH);
        $muc=muc::where('id',$maMuc)->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();
        Session::put('maChuong',$muc->id_chuong);
        # hocphan.
        $hocphan=hocPhan::where('maHocPhan',$chuong->maHocPhan)->first();
        //cau hoi
        $cauHoi=cauHoi::where('id_muc',$maMuc)->where('maGV',session::get('maGV'))->where('maLoaiHTDG','T2')->with('phuong_an_trac_nghiem')->get();
        foreach ($cauHoi as $key => $value) {
            $temp=kqHTHP::where('maKQHT',$value->maKQHT)->first();
            if($temp){
                $value->maKQHTVB=$temp->maKQHTVB;
                $value->tenKQHT=$temp->tenKQHT;
            }
            $cdr3=CDR3::where('maCDR3',$value->phuong_an_trac_nghiem[0]->maCDR3)->first();
            $abet=chuan_abet::where('maChuanAbet',$value->phuong_an_trac_nghiem[0]->maChuanAbet)->first();
            if($cdr3 && $abet){
                $value->maCDR3VB=$cdr3->maCDR3VB;
                $value->tenCDR3=$cdr3->tenCDR3;
                $value->maChuanAbetVB=$abet->maChuanAbetVB;
                $value->tenChuanAbet=$abet->tenChuanAbet;
            }
        }
        //combobox cdr
        $cdr3=hocPhan::where('hoc_phan.maHocPhan',$chuong->maHocPhan)
        ->join('hocphan_kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        })
        ->distinct('hocphan_kqht_hp.maCDR3')
        ->join('cdr_cd3',function($y){ 
            $y->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get(['hocphan_kqht_hp.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);
        
        //comboxbox kqht
        $kqht_arr=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',$chuong->maHocPhan)
        ->distinct('hocphan_kqht_hp.maKQHT')
        ->join('kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maKQHT','=','kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->pluck('hocphan_kqht_hp.maKQHT');
        $kqht=kqHTHP::whereIn('maKQHT',$kqht_arr)->get();
        return view('giangvien.quyhoach.cauhoitracnghiem.index',
        compact('chuong','muc','hocphan','cauHoi','cdr3','kqht'));
    }
    
    public function view_them()  //----OK
    {
       
        $muc=muc::where('id',Session::get('maMuc'))->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();

        //combobox cdr3
        $cdr3=hocPhan::where('hoc_phan.maHocPhan',$chuong->maHocPhan)
        ->join('hocphan_kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        })
        ->distinct('hocphan_kqht_hp.maCDR3')
        ->join('cdr_cd3',function($y){ 
            $y->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get(['hocphan_kqht_hp.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3','cdr_cd3.tenCDR3EN']);

        //combobox abet
        $abet=hocPhan::where('hoc_phan.maHocPhan',$chuong->maHocPhan)
        ->join('hocphan_kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        })
        ->distinct('hocphan_kqht_hp.maChuanAbet')
        ->join('chuan_abet',function($y){ 
            $y->on('chuan_abet.maChuanAbet','=','hocphan_kqht_hp.maChuanAbet')
            ->where('chuan_abet.isDelete',false);
        })
        ->get(['hocphan_kqht_hp.maChuanAbet','chuan_abet.maChuanAbetVB','chuan_abet.tenChuanAbet','chuan_abet.tenChuanAbet_EN']);
       
        //combobox kqht
        $kqht_arr=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',$chuong->maHocPhan)
        ->distinct('hocphan_kqht_hp.maKQHT')
        ->join('kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maKQHT','=','kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->pluck('hocphan_kqht_hp.maKQHT');
        $kqht=kqHTHP::whereIn('maKQHT',$kqht_arr)->get();

        $ct_bqh=ct_bai_quy_hoach::where('maBaiQH',Session::get('maBaiQH'))->where('maLoaiHTDG','T2')->first();
        if($ct_bqh){
            $ndqh=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get();
        }else{
            $ndqh=[];
        }
        return view('giangvien.quyhoach.cauhoitracnghiem.them_trac_nghiem',
        compact('kqht','abet','cdr3','ndqh'));
    }

    public function them(Request $request)   //--OK
    {
        //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12 vi diem thật được chuyển sang cauhoi_noidung

        //noi dung quy hoach ->kqht
        $ndqh=noiDungQH::where('maNoiDungQH',$request->maNoiDungQH)->first();
       
        if ($ndqh) {
            cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,
            'maKQHT'=>$ndqh->maKQHT,'maLoaiHTDG'=>'T2','id_muc'=>Session::get('maMuc'),'maGV'=>Session::get('maGV')]);
            //thêm phương án trắc nghiệm
            $cauhoi=cauHoi::where('isDelete',false)->orderBy('maCauHoi','desc')->first();
            for ($i=0; $i <count($request->phuongAn) ; $i++) { 
                $cdr3_abet=cdr3_abet::where('maCDR3',$request->maCDR3)->first();
                $maChuanAbet = ($cdr3_abet) ? $cdr3_abet->maChuanAbet : 1 ;
                if($request->choice==$i){
                    phuongAnTracNghiem::create(['noiDungPA'=>$request->phuongAn[$i],'isCorrect'=>true,'diemPA'=>12,
                    'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$maChuanAbet]);
                }
                else{
                    phuongAnTracNghiem::create(['noiDungPA'=>$request->phuongAn[$i],'isCorrect'=>false,'diemPA'=>12,
                    'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$maChuanAbet]);
                }
            }
            if($cauhoi){
                cau_hoi_ndqh::create(['maCauHoi'=>$cauhoi->maCauHoi,'maNoiDungQH'=>$request->maNoiDungQH]);
            }
            CommonController::success_notify('Thêm mới thành công!','Added successfully');
        } else {
            CommonController::warning_notify('Không tìm thấy nội dung quy hoạch','Can not found assesment content!!');
        }
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/'.Session::get('maMuc').'/'.Session::get('maCTBaiQH'));

    }

    public function view_sua($maCauHoi)  //--OK
    {
        $muc=muc::where('id',Session::get('maMuc'))->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();

        //combobox cdr3
        $cdr3=hocPhan::where('hoc_phan.maHocPhan',$chuong->maHocPhan)
        ->join('hocphan_kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        })
        ->distinct('hocphan_kqht_hp.maCDR3')
        ->join('cdr_cd3',function($y){ 
            $y->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get(['hocphan_kqht_hp.maCDR3','cdr_cd3.maCDR3VB','cdr_cd3.tenCDR3']);

        //combobox abet
        $abet=hocPhan::where('hoc_phan.maHocPhan',$chuong->maHocPhan)
        ->join('hocphan_kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        })
        ->distinct('hocphan_kqht_hp.maChuanAbet')
        ->join('chuan_abet',function($y){ 
            $y->on('chuan_abet.maChuanAbet','=','hocphan_kqht_hp.maChuanAbet')
            ->where('chuan_abet.isDelete',false);
        })
        ->get(['hocphan_kqht_hp.maChuanAbet','chuan_abet.maChuanAbetVB','chuan_abet.tenChuanAbet']);
        
        $kqht_arr=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',$chuong->maHocPhan)
        ->distinct('hocphan_kqht_hp.maKQHT')
        ->join('kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maKQHT','=','kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->pluck('hocphan_kqht_hp.maKQHT');
        $kqht=kqHTHP::whereIn('maKQHT',$kqht_arr)->get();
      
        $cauhoi=cauHoi::where('isDelete',false)->where('maCauHoi',$maCauHoi)->with('phuong_an_trac_nghiem')->first();
        $ndqh=cau_hoi_ndqh::where('maCauHoi',$cauhoi->maCauHoi)->with('noi_dung_quy_hoach')->first();
        
        $ct_bqh=ct_bai_quy_hoach::where('maBaiQH',Session::get('maBaiQH'))->where('maLoaiHTDG','T2')->first();
        if($ct_bqh){
            $ndqh_dropdownlist=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$ct_bqh->maCTBaiQH)->get();
        }else{
            $ndqh_dropdownlist=[];
        }
        //return $cauhoi;
        return view('giangvien.quyhoach.cauhoitracnghiem.sua_trac_nghiem',compact('kqht','abet','cdr3','cauhoi','ndqh','ndqh_dropdownlist'));
    }

    public function sua(Request $request)  //--OK
    {
        //return $request;
        $ndqh=noiDungQH::where('maNoiDungQH',$request->maNoiDungQH)->first();
        if ($ndqh) {
            $cauhoi=cauHoi::where('isDelete',false)->where('maCauHoi',$request->maCauHoi)->first();
            //cập nhật câu hỏi
            cauHoi::updateOrCreate(['maCauHoi'=>$cauhoi->maCauHoi],['noiDungCauHoi'=>$request->noiDungCauHoi,
            'diemCauHoi'=>12,'maKQHT'=>$ndqh->maKQHT,
            'maLoaiHTDG'=>'T2','id_loaiCH'=>'1',
            'id_muc'=>Session::get('maMuc'),'maGV'=>Session::get('maGV')]);
            //cập nhật phương án
            for ($i=0; $i <count($request->phuongAn) ; $i++) { 
               $correct=false;
               if($request->choice==$i){
                   $correct=true;
               }
               $cdr3_abet=cdr3_abet::where('maCDR3',$request->maCDR3)->first();
               $maChuanAbet = ($cdr3_abet) ? $cdr3_abet->maChuanAbet : 1 ;
               phuongAnTracNghiem::updateOrCreate(['id'=>$request->maPhuongAn[$i]],['noiDungPA'=>$request->phuongAn[$i],
               'isCorrect'=>$correct,'diemPA'=>$request->diemPA[$i],'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$maChuanAbet]);
            }
            CommonController::success_notify('Sửa thành công','Edited successfully');
        } else {
            CommonController::success_notify('Không thể tìm thấy nội dung quy hoạch','Can not found assesment content');
        }
    
         return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/'.Session::get('maMuc').'/'.Session::get('maCTBaiQH'));
    }

    public function xoa($maCauHoi)  //--OK
    {
        //maCauHoi->cauhoi
        $cauhoi=cauHoi::where('isDelete',false)->where('maCauHoi',$maCauHoi)->first();
        //kiem tra cau hoi co duoc su dung trong de thi
        $count_cauhoi_dethi=deThi_cauHoi::where('isDelete',false)->where('maCauHoi',$maCauHoi)->count();
        if($count_cauhoi_dethi>0){
            CommonController::warning_notify('Câu hỏi đã được sử dụng trong bài thi, không thể xóa!','This question is used in examination!');
        }else{
            //xoa cau hoi noi dung quy hoach
            cau_hoi_ndqh::where('maCauHoi',$maCauHoi)->delete();
            //xoa
            $cauhoi->delete();
            CommonController::success_notify('Đã xóa','Deleted successfully');
        }
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/'.Session::get('maMuc').'/'.Session::get('maCTBaiQH'));

    }
}
