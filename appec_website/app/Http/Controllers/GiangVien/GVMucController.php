<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\muc;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\phuongAnTracNghiem;
use App\Http\Controllers\Controller;

class GVMucController extends Controller
{
    public function index($maChuong)
    {
        Session::put('maChuong',$maChuong);
        $chuong=chuong::where('id',$maChuong)->first();
        $muc=muc::where('id_chuong',$maChuong)->with('chuong')->get();
        $hocphan=hocPhan::where('maHocPhan',session::get('maChuong'))->first();
        return view('giangvien.hocphan.chuong.muc.index',compact('muc','chuong','hocphan'));
    }

    ///////////////////////////CÂU HỎI TỰ LUẬN///////////////////////////////////////////
    public function cau_hoi_tu_luan($maMuc)
    {
        Session::put('maMuc',$maMuc);
        $muc=muc::where('id',$maMuc)->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();
        Session::put('maChuong',$muc->id_chuong);
        $hocphan=hocPhan::where('maHocPhan',$chuong->maHocPhan)->first();
        $kqht_arr=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',$chuong->maHocPhan)
        ->distinct('hocphan_kqht_hp.maKQHT')
        ->join('kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maKQHT','=','kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->pluck('hocphan_kqht_hp.maKQHT');
        $kqht=kqHTHP::whereIn('maKQHT',$kqht_arr)->get();
        $cauhoi =cauHoi::where('id_muc',$maMuc)->where('maLoaiHTDG','T1')->get();
      
        return view('giangvien.hocphan.chuong.muc.cauhoi.index_tuluan',
        compact('hocphan','kqht','cauhoi','muc','chuong'));
    }


    public function them_tu_luan(Request $request)
    {
        try {
             //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
            cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T1','id_loaiCH'=>'1','id_muc'=>Session::get('maMuc')]);
            alert()->success('Added successfully', 'Message');
            return back();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function sua_tu_luan(Request $request)
    {
        cauHoi::updateOrCreate(['isDelete'=>false,'maCauHoi'=>$request->maCauHoi],
        ['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT]);
        alert()->success('Editing successfully', 'Message');
        $chuong=chuong::findOrFail($request->maChuong);
        return back();
    }

    ///////////////////////////CÂU HỎI TRẮC NGHIỆM///////////////////////////////////////////
    public function cau_hoi_trac_nghiem(Request $request,$maMuc)
    {
        $request->session()->put('maMuc', $maMuc);
        $muc=muc::where('id',$maMuc)->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();
        Session::put('maChuong',$muc->id_chuong);
        # code...
        $hocphan=hocPhan::where('maHocPhan',$chuong->maHocPhan)->first();
        $cauHoi=cauHoi::where('id_muc',$maMuc)->where('maLoaiHTDG','T2')->with('phuong_an_trac_nghiem')->get();
        
      
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
        
        $kqht_arr=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',$chuong->maHocPhan)
        ->distinct('hocphan_kqht_hp.maKQHT')
        ->join('kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maKQHT','=','kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->pluck('hocphan_kqht_hp.maKQHT');
        $kqht=kqHTHP::whereIn('maKQHT',$kqht_arr)->get();
        
        return view('giangvien.hocphan.chuong.muc.cauhoi.index_tracnghiem',
        compact('chuong','muc','hocphan','cauHoi','cdr3','kqht'));
    }
    
    public function them_trac_nghiem(Request $request)
    {
        //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
        cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T2','id_loaiCH'=>'1','id_muc'=>Session::get('maMuc')]);
        //thêm phương án trắc nghiệm
        $cauhoi=cauHoi::where('isDelete',false)->orderBy('maCauHoi','desc')->first();
        $diem=0;
        for ($i=0; $i <count($request->phuongAn) ; $i++) { 
            $diem+=$request->diemPA[$i];
            if($request->choise==$i){
                phuongAnTracNghiem::create(['noiDungPA'=>$request->phuongAn[$i],'isCorrect'=>true,'diemPA'=>$request->diemPA[$i],'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3]);
            }
            else{
                phuongAnTracNghiem::create(['noiDungPA'=>$request->phuongAn[$i],'isCorrect'=>false,'diemPA'=>$request->diemPA[$i],'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3]);
            }
        }
        cauHoi::updateOrCreate(['maCauHoi'=>$cauhoi->maCauHoi],['diemCauHoi'=>$diem]);
        alert()->success('Added successfully', 'Message');
        return back();
    }

    public function sua_trac_nghiem(Request $request)
    {
         $cauhoi=cauHoi::where('isDelete',false)->where('maCauHoi',$request->maCauHoi)->first();
         //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
         cauHoi::updateOrCreate(['maCauHoi'=>$cauhoi->maCauHoi],['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T2','id_loaiCH'=>'1','id_muc'=>Session::get('maMuc')]);
         //thêm phương án trắc nghiệm
         
         $diem=0;
         for ($i=0; $i <count($request->phuongAn) ; $i++) { 
            $diem+=$request->diemPA[$i];
            if($request->choice==$i){
                phuongAnTracNghiem::updateOrCreate(['id'=>$request->maPhuongAn[$i]],['noiDungPA'=>$request->phuongAn[$i],'isCorrect'=>true,'diemPA'=>$request->diemPA[$i],'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3]);
            }
            else{
                phuongAnTracNghiem::updateOrCreate(['id'=>$request->maPhuongAn[$i]],['noiDungPA'=>$request->phuongAn[$i],'isCorrect'=>false,'diemPA'=>$request->diemPA[$i],'maCauHoi'=>$cauhoi->maCauHoi,'maCDR3'=>$request->maCDR3]);
            }
         }
         cauHoi::updateOrCreate(['maCauHoi'=>$cauhoi->maCauHoi],['diemCauHoi'=>$diem]);
         alert()->success('Added successfully', 'Message');
         return back();
    }

    ///////////////////////////CÂU HỎI THỰC HÀNH///////////////////////////////////////////
    public function cau_hoi_thuc_hanh(Request $request,$maMuc)
    {
        $request->session()->put('maMuc', $maMuc);
        $muc=muc::where('id',$maMuc)->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();
        Session::put('maChuong',$muc->id_chuong);
        # code...
        $hocphan=hocPhan::where('maHocPhan',$chuong->maHocPhan)->first();
        $cauhoi=cauHoi::where('id_muc',$maMuc)->where('maLoaiHTDG','T3')->with('kqht')->get();
        $kqht_arr=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',$chuong->maHocPhan)
        ->distinct('hocphan_kqht_hp.maKQHT')
        ->join('kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maKQHT','=','kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->pluck('hocphan_kqht_hp.maKQHT');
        $kqht=kqHTHP::whereIn('maKQHT',$kqht_arr)->get();
      
        
        return view('giangvien.hocphan.chuong.muc.cauhoi.index_thuchanh',
        compact('hocphan','cauhoi','kqht','chuong','muc'));
    }

    public function them_thuc_hanh(Request $request)
    {
        try {
            //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
            cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,
            'maLoaiHTDG'=>'T3','id_loaiCH'=>'1','id_muc'=>Session::get('maMuc')]);
            alert()->success('Added successfully', 'Message');
            return back();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function sua_thuc_hanh(Request $request)
    {
        cauHoi::updateOrCreate(['isDelete'=>false,'maCauHoi'=>$request->maCauHoi],
        ['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT]);
        alert()->success('Editing successfully', 'Message');
        $chuong=chuong::findOrFail($request->maChuong);
        return back();
    }
}
