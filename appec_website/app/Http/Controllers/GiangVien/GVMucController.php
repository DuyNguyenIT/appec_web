<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\muc;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\deThi_cauHoi;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\phuongAnTracNghiem;
use App\Http\Controllers\Controller;

class GVMucController extends Controller
{
    public function index($maChuong)
    {
        return $maChuong;
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

        return view('giangvien.quyhoach.cauhoitracnghiem.them_trac_nghiem',compact('kqht','abet','cdr3'));
    }

    public function them_trac_nghiem(Request $request)
    {
      
        //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
        cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T2','id_muc'=>Session::get('maMuc')]);
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
       
        alert()->success('Added successfully', 'Message');
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
         cauHoi::updateOrCreate(['maCauHoi'=>$cauhoi->maCauHoi],['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T2','id_loaiCH'=>'1','id_muc'=>Session::get('maMuc')]);
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
            alert()->warning('This question is used in examination!', 'Message');
        }
        //xoa
        $cauhoi->delete();
        alert()->success('Deleted', 'Message');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-trac-nghiem/'.Session::get('maMuc'));
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
