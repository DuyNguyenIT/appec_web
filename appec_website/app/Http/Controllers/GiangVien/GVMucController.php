<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\muc;
use App\Models\CDR2;
use App\Models\CDR3;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\cdr2_abet;
use App\Models\noiDungQH;
use App\Models\cau_hoi_ndqh;
use App\Models\deThi_cauHoi;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\ct_bai_quy_hoach;
use App\Models\dethi_cauhoituluan;
use App\Models\phuongAnTracNghiem;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

class GVMucController extends Controller
{
    public function index($maChuong)
    {
        return $maChuong;
        Session::put('maChuong',$maChuong);
        $chuong=chuong::get_one_chuong_by_id($maChuong);
        $muc=muc::where('id_chuong',$maChuong)->with('chuong')->get();
        $hocphan=hocPhan::where('maHocPhan',session::get('maChuong'))->first();
        return view('giangvien.hocphan.chuong.muc.index',compact('muc','chuong','hocphan'));
    }

    //-------------ajax function
    public function get_muc_by_ma_chuong($maChuong)
    {
        if($maChuong!=-1){
            return muc::get_by_machuong($maChuong);
        }else{
            return muc::get_all();
        }
        
    }

    public function get_cau_hoi_trac_nghiem_by_mamuc($maMuc)
    {
        if($maMuc!=-1){
             return cauHoi::get_cau_hoi_trac_nghiem_by_mamuc_distinct(Session::get('maDe'),$maMuc);
        }
        else{
            return cauHoi::get_cau_hoi_trac_nghiem(Session::get('maHocPhan'));
        }
       
    }

    public function get_cau_hoi_tu_luan_by_mamuc($maMuc)
    {
        if($maMuc!=-1){ //chọn mục cụ thể
            return cauHoi::get_cau_hoi_tu_luan_by_mamuc_distinct(Session::get('maDe'),$maMuc);
        }else{//chọn tât cả
            return cauHoi::get_cau_hoi_tu_luan(Session::get('maHocPhan'));
        }
    }

    public function get_cau_hoi_thuc_hanh_by_mamuc($maMuc)
    {
        if($maMuc!=-1){ //chọn mục cụ thể
            return cauHoi::get_cau_hoi_thuc_hanh_by_mamuc_distinct(Session::get('maDe'),$maMuc);
        }else{//chọn tât cả
            return cauHoi::get_cau_hoi_thuc_hanh(Session::get('maHocPhan'));
        }
    }

    
    ///////////////////////////CÂU HỎI TỰ LUẬN///////////////////////////////////////////
    public function cau_hoi_tu_luan($maMuc,$maCTBaiQH)
    {
        Session::put('maMuc',$maMuc);
        $muc=muc::get_by_id($maMuc);  
        $chuong=chuong::get_one_chuong_by_id($muc->id_chuong);
        Session::put('maChuong',$muc->id_chuong);
        $hocphan=hocPhan::where('maHocPhan',$chuong->maHocPhan)->first();
        //$ct_bqh=ct_bai_quy_hoach::where('maBaiQH',$maBaiQH)->where('maLoaiHTDG','T1')->first();
        if($maCTBaiQH){
            $ndqh=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        }else{
            $ndqh=[];
        }
        $kqht=kqHTHP::get_kqht_by_mahocphan($chuong->maHocPhan);
        $cauhoi =cauHoi::where('id_muc',$maMuc)->where('maGV',session::get('maGV'))->where('maLoaiHTDG','T1')->get();
      
        return view('giangvien.hocphan.chuong.muc.cauhoi.index_tuluan',
        compact('hocphan','kqht','cauhoi','muc','chuong','ndqh'));
    }

    public function them_tu_luan(Request $request)
    {
         //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
         cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,
         'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T1','id_loaiCH'=>'1',
         'id_muc'=>Session::get('maMuc'),'maGV'=>Session::get('maGV')]);
           
         $ch=cauHoi::orderBy('maCauHoi','desc')->first();
         if($ch){
             cau_hoi_ndqh::create(['maCauHoi'=>$ch->maCauHoi,'maNoiDungQH'=>$request->maNoiDungQH]);
         }
         alert()->success('Added successfully', 'Message');
         return back();
    }

    public function sua_tu_luan(Request $request)
    {
        cauHoi::updateOrCreate(['isDelete'=>false,'maCauHoi'=>$request->maCauHoi],
        ['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,
        'maKQHT'=>$request->maKQHT,'maGV'=>Session::get('maGV')]);
        alert()->success('Editing successfully', 'Message');
        $chuong=chuong::findOrFail($request->maChuong);
        return back();
    }

    //xoa noi dung
    public function xoa_tu_luan($maCauHoi)
    {
        if(dethi_cauhoituluan::where('maCauHoi',$maCauHoi)->count('maCauHoi')>0){
            CommonController::warning_notify('Câu hỏi đã được sử dụng trong đề thi, không thể xóa','The question was used in an examination!');
            return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/'.Session::get('maMuc'));
        }else{
            cau_hoi_ndqh::where('maCauHoi',$maCauHoi)->delete();
            cauHoi::where('maCauHoi',$maCauHoi)->delete();
            alert()->success('Deleted','Message');
            CommonController::success_notify('xóa thành công!','Deleted successfully');
            return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/'.Session::get('maMuc'));
        }
    }

    ///////////////////////////CÂU HỎI TRẮC NGHIỆM///////////////////////////////////////////
    public function cau_hoi_trac_nghiem(Request $request,$maMuc)  //show
    {
        $request->session()->put('maMuc', $maMuc);
        $muc=muc::where('id',$maMuc)->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();
        Session::put('maChuong',$muc->id_chuong);
        # hocphan.
        $hocphan=hocPhan::where('maHocPhan',$chuong->maHocPhan)->first();
        //cau hoi
        $cauHoi=cauHoi::where('id_muc',$maMuc)->where('maLoaiHTDG','T2')->with('phuong_an_trac_nghiem')->get();
        foreach ($cauHoi as $key => $value) {
            $temp=kqHTHP::where('maKQHT',$value->maKQHT)->first();
            if($temp){
                $value->maKQHTVB=$temp->maKQHTVB;
                $value->tenKQHT=$temp->tenKQHT;
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
    
    public function view_them_trac_nghiem()
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

    public function get_abet_by_cdr3($maCDR3)
    {
        $cdr3=CDR3::find($maCDR3);
        $cdr2=CDR2::where('maCDR2',$cdr3->maCDR2)->first();
        return cdr2_abet::where('maCDR2',$cdr2->maCDR2)
        ->join('chuan_abet',function($x){
            $x->on('cdr_cd2_chuan_abet.maChuanAbet','=','chuan_abet.maChuanAbet');
        })
        ->get();
    }

    public function them_trac_nghiem(Request $request)
    {
        //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12 vi diem thật được chuyển sang cauhoi_noidung
        cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,
        'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T2','id_muc'=>Session::get('maMuc'),'maGV'=>Session::get('maGV')]);
        //thêm phương án trắc nghiệm
        $cauhoi=cauHoi::where('isDelete',false)->orderBy('maCauHoi','desc')->first();
        for ($i=0; $i <count($request->phuongAn) ; $i++) { 
            if($request->choice==$i){
                phuongAnTracNghiem::create(['noiDungPA'=>$request->phuongAn[$i],'isCorrect'=>true,'diemPA'=>12,
                'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$request->maChuanAbet]);
            }
            else{
                phuongAnTracNghiem::create(['noiDungPA'=>$request->phuongAn[$i],'isCorrect'=>false,'diemPA'=>12,
                'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$request->maChuanAbet]);
            }
        }
        
        if($cauhoi){
            cau_hoi_ndqh::create(['maCauHoi'=>$cauhoi->maCauHoi,'maNoiDungQH'=>$request->maNoiDungQH]);
        }
        CommonController::success_notify('Thêm mới thành công!','Added successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/'.Session::get('maMuc'));
    }

    public function view_sua_trac_nghiem($maCauHoi)
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
        //return $cauhoi;
        return view('giangvien.quyhoach.cauhoitracnghiem.sua_trac_nghiem',compact('kqht','abet','cdr3','cauhoi'));
    }

    public function sua_trac_nghiem(Request $request)
    {
        //return $request;
         $cauhoi=cauHoi::where('isDelete',false)->where('maCauHoi',$request->maCauHoi)->first();
         //cập nhật câu hỏi
         cauHoi::updateOrCreate(['maCauHoi'=>$cauhoi->maCauHoi],['noiDungCauHoi'=>$request->noiDungCauHoi,
         'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,
         'maLoaiHTDG'=>'T2','id_loaiCH'=>'1',
         'id_muc'=>Session::get('maMuc'),'maGV'=>Session::get('maGV')]);
         //cập nhật phương án
         for ($i=0; $i <count($request->phuongAn) ; $i++) { 
            $correct=false;
            if($request->choice==$i){
                $correct=true;
            }
            phuongAnTracNghiem::updateOrCreate(['id'=>$request->maPhuongAn[$i]],['noiDungPA'=>$request->phuongAn[$i],
            'isCorrect'=>$correct,'diemPA'=>$request->diemPA[$i],'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$request->maChuanAbet]);
         }
         alert()->success('Edited successfully', 'Message');
         return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/'.Session::get('maMuc'));
    }

    public function xoa_trac_nghiem($maCauHoi)
    {
        //maCauHoi->cauhoi
        $cauhoi=cauHoi::where('isDelete',false)->where('maCauHoi',$maCauHoi)->first();
        //kiem tra cau hoi co duoc su dung trong de thi
        $count_cauhoi_dethi=deThi_cauHoi::where('isDelete',false)->where('maCauHoi',$maCauHoi)->count();
        if($count_cauhoi_dethi>0){
            CommonController::warning_notify('Câu hỏi đã được sử dụng trong bài thi, không thể xóa!','This question is used in examination!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/'.Session::get('maMuc'));
        }
        //xoa cau hoi noi dung quy hoach
        cau_hoi_ndqh::where('maCauHoi',$maCauHoi)->delete();
        //xoa
        $cauhoi->delete();
        CommonController::success_notify('Đã xóa','Deleted successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/'.Session::get('maMuc'));
    }
    ///////////////////////////CÂU HỎI THỰC HÀNH///////////////////////////////////////////
    public function cau_hoi_thuc_hanh(Request $request,$maMuc,$maCTBaiQH)
    {
        $request->session()->put('maMuc', $maMuc);
        $muc=muc::where('id',$maMuc)->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();
        Session::put('maChuong',$muc->id_chuong);
        # code...
        $hocphan=hocPhan::where('maHocPhan',$chuong->maHocPhan)->first();
        $cauhoi=cauHoi::where('id_muc',$maMuc)->where('maLoaiHTDG','T3')->with('kqht')->get();
        $kqht=kqHTHP::get_kqht_by_mahocphan($chuong->maHocPhan);
        //$ct_bqh=ct_bai_quy_hoach::where('maBaiQH',$maBaiQH)->where('maLoaiHTDG','T3')->first();
        if($maCTBaiQH){
            $ndqh=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        }else{
            $ndqh=[];
        }
        return view('giangvien.hocphan.chuong.muc.cauhoi.index_thuchanh',
        compact('hocphan','cauhoi','kqht','chuong','muc','ndqh'));
    }

    public function them_thuc_hanh(Request $request)
    {

        if($request->maNoiDungQH==null){
            CommonController::warning_notify('Cần chọn nội dung quy hoạch', 'Please choise assessment content');
        }
       //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
       cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,
       'maLoaiHTDG'=>'T3','id_loaiCH'=>'1','id_muc'=>Session::get('maMuc'),'maGV'=>Session::get('maGV')]);

       $ch=cauHoi::orderBy('maCauHoi','desc')->first();
       if($ch){
           cau_hoi_ndqh::create(['maCauHoi'=>$ch->maCauHoi,'maNoiDungQH'=>$request->maNoiDungQH]);
       }
       CommonController::success_notify("Thêm thành công!",'Added successfully');
       return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-thuc-hanh/'.Session::get('maMuc')); 
    }

    public function sua_thuc_hanh(Request $request)
    {
        cauHoi::updateOrCreate(['isDelete'=>false,'maCauHoi'=>$request->maCauHoi],
        ['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,'maGV'=>Session::get('maGV')]);
        alert()->success('Editing successfully', 'Message');
        CommonController::success_notify('','');
        $chuong=chuong::findOrFail($request->maChuong);
        return back();
    }

    public function xoa_thuc_hanh($maCauHoi)
    {
        if(dethi_cauhoituluan::where('maCauHoi',$maCauHoi)->count('maCauHoi')>0){
            CommonController::warning_notify('Câu hỏi đã được sử dụng trong đề thi, không thể xóa','The question was used in an examination!');
            return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-thuc-hanh/'.Session::get('maMuc'));
        }else{
            cau_hoi_ndqh::where('maCauHoi',$maCauHoi)->delete();
            cauHoi::where('maCauHoi',$maCauHoi)->delete();
            CommonController::success_notify('Xóa thành công!','Deleted successfully');
            return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-thuc-hanh/'.Session::get('maMuc'));
        }
    }
}
