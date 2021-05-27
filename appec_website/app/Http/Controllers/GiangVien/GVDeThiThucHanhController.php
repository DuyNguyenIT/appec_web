<?php

namespace App\Http\Controllers\giangvien;

use Session;
use App\Models\raDe;
use App\Models\deThi;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\hocPhan;
use App\Models\chuan_abet;
use Illuminate\Http\Request;
use App\Models\phuongAnTuLuan;
use App\Models\dethi_cauhoituluan;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

class GVDeThiThucHanhController extends Controller
{
    
    public function them_de_thi_thuc_hanh_submit(Request $request) //thêm tiêu đèn, ngày thi, giờ thi,...
    {
        deThi::create(['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,'tenDe'=>$request->tenDe,'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
        $dethi=deThi::orderBy('maDe','desc')->first();
        raDe::create(['maDe'=>$dethi->maDe,'maGV'=>session::get('maGV'),'maHocPhan'=>session::get('maHocPhan'),'maLop'=>session::get('maLop')]);
        CommonController::success_notify('Thêm thành công!!','Added successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function cau_truc_de_thuc_hanh(Request $request,$maDe) //dẫn đến view cấu trúc đề thi
    {
        Session::put('maDe',$maDe);
        #thông tin học phần
        $hocphan=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();
        #thông tin đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
        #thông tin mục
        $muc=hocPhan::get_muc_by_maHocPhan(Session::get('maHocPhan'));
       
        #thông tin chuẩn đầu ra  
        $cdr3=hocPhan::where('hoc_phan.maHocPhan',Session::get('maHocPhan'))
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
          #nội dung đề thi thực hành
          $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
          ->Leftjoin('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
          ->Leftjoin('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
          //->Leftjoin('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
          ->distinct('cau_hoi.maCauHoi')
          ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
          
  
          ##tính điểm câu hỏi
          for ($i=0; $i < count($noidung); $i++) { 
              $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
              ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
              ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
              ->sum('phuong_an_tu_luan.diemPA');
              $phuongAnTL=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
              ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
              ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
              ->join('cdr_cd3','phuong_an_tu_luan.maCDR3','=','cdr_cd3.maCDR3')
              ->join('chuan_abet','phuong_an_tu_luan.maChuanAbet','=','chuan_abet.maChuanAbet')
              ->get();
              $noidung[$i]->diem=$diem;  
              $noidung[$i]->phuongAn=$phuongAnTL;
            }
        ##tạo mảng các câu hỏi đã chọn->chỉ duyệt những câu hỏi chưa được chọn
        $cauhoidachon=dethi_cauhoituluan::where('maDe',$maDe)->distinct('maCauHoi')->pluck('maCauHoi');
         #thông tin câu hỏi
        $cauhoi=[];
        foreach ($muc as  $value) {
             $temp=cauHoi::where('isdelete',false)->where('maGV',session::get('maGV'))->where('id_muc',$value->id)
             ->where('maLoaiHTDG','T3')->whereNotIn('maCauHoi',$cauhoidachon)->get();
             foreach ($temp as $ch) {
                 array_push($cauhoi,$ch);
             }
        }
        #combobox abet
        $abet=chuan_abet::all();
        #dem cau hoi
        //dem cau hoi
        $dem_cau_hoi=dethi_cauhoituluan::where('maDe',$maDe)->distinct('maCauHoi')->count('maCauHoi');
        
        #thong tin chuong
        $chuong=chuong::get_chuong_by_maHocPhan($hocphan->maHocPhan);
          
        #thông tin mục
        $muc=hocPhan::get_muc_by_maHocPhan(Session::get('maHocPhan'));
         #phản hồi kết quả
        return view('giangvien.quyhoach.noidungdanhgia.thuchanh.cautrucde',
        compact('dethi','hocphan','cauhoi','cdr3','abet','noidung','dem_cau_hoi','chuong','muc'));
    }

    public function xoa_de_thuc_hanh($maDe)
    {
        return view('giangvien.error');
    }
    
    public function them_cau_hoi_de_thuc_hanh(Request $request) //nhấn nút thêm câu hỏi
    {
        if($request->maCauHoi==null){  //chua chon cau hoi
            CommonController::warning_notify('Đề thi đã đủ số câu hỏi!','The examination is enough question');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$request->maDe);
        }
        //kiem tra cau hoi da them roi
        if(dethi_cauhoituluan::where('maDe',$request->maDe)->where('maCauHoi',$request->maCauHoi)->count('maCauHoi')>0){
            CommonController::warning_notify('Câu hỏi đã tồn tại!','The question is exist');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$request->maDe);
        }
        $dethi=deThi::where('maDe',$request->maDe)->first();
        //kiem tra neu de thi du so cau hoi thi khong them
        if($dethi->soCauHoi==dethi_cauhoituluan::where('maDe',$request->maDe)->count('maCauHoi')){
            CommonController::warning_notify('Đề thi đã đủ số câu hỏi!','The examination is enough question');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$request->maDe);
        }
        //kiem tra de thi da du diem thi khong them

        $index=0;
        //duyêt mảng phương án
        for ($i=0; $i < count($request->phuongAn); $i++) { 
            # lưu phương án tự luận
            phuongAnTuLuan::create(['noiDungPA'=>$request->phuongAn[$i],'diemPA'=>$request->diem[$i],'maCDR3'=>$request->maCDR3]);
            # lưu maCauHoi, maDe, maPhuongAn vào nội dung đề thi
            $pa=phuongAnTuLuan::orderBy('id','desc')->first();
            dethi_cauhoituluan::create(['maDe'=>$request->maDe,'maCauHoi'=>$request->maCauHoi,'maPATL'=>$pa->id]);
                  }
        alert()->success('Adding successfully','Message');
        return back();
    }

    public function xoa_cau_hoi_de_thuc_hanh(Request $request,$maDe,$maCauHoi)
    {
        $cauhoi=dethi_cauhoituluan::where('maDe',$maDe)->where('maCauHoi',$maCauHoi)->first();
        if($cauhoi){
            $pa=phuongAnTuLuan::where('id',$cauhoi->maPATL)->first();
            if($pa){
                $pa->delete();
             }
            $cauhoi->delete(); 
            CommonController::warning_notify('Xóa thành công!!','Deleting successfully!!');
            return back();
        }
        alert()->warning("Can't found question",'Warning!');
        return back();
    }

    public function chinh_sua_phuong_an_thuc_hanh(Request $request)
    {
        $patl=phuongAnTuLuan::find($request->id);
        if($patl){
            $patl->noiDungPA=$request->noiDungPA;
            $patl->diemPA=$request->diemPA;
            $patl->maCDR3=$request->maCDR3;
            $patl->maChuanAbet=$request->maChuanAbet;
            $patl->update();
        }
        return back();
    }
}
