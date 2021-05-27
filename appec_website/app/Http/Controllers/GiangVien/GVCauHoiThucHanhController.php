<?php

namespace App\Http\Controllers\giangvien;

use session;
use App\Models\muc;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\noiDungQH;
use App\Models\cau_hoi_ndqh;
use Illuminate\Http\Request;
use App\Models\dethi_cauhoituluan;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

class GVCauHoiThucHanhController extends Controller
{
    
    public function index(Request $request,$maMuc,$maCTBaiQH) //-OK
    {
        //luu session
        $request->session()->put('maMuc', $maMuc);
        $request->session()->put('maCTBaiQH', $maCTBaiQH);

        //select muc & chuong
        $muc=muc::where('id',$maMuc)->first();  
        $chuong=chuong::where('id',$muc->id_chuong)->first();
        Session::put('maChuong',$muc->id_chuong);

        $hocphan=hocPhan::where('maHocPhan',$chuong->maHocPhan)->first();
        $cauhoi=cauHoi::where('id_muc',$maMuc)->where('maGV',session::get('maGV'))->where('maLoaiHTDG','T3')->with('kqht')->get();

        $kqht=kqHTHP::get_kqht_by_mahocphan($chuong->maHocPhan);
        //$ct_bqh=ct_bai_quy_hoach::where('maBaiQH',$maBaiQH)->where('maLoaiHTDG','T3')->first();
        if($maCTBaiQH){
            $ndqh=noiDungQH::where('isDelete',false)->where('maCTBaiQH',$maCTBaiQH)->get();
        }else{
            $ndqh=[];
        }
        foreach ($cauhoi as $value) {
            $ch_ndqh=cau_hoi_ndqh::where('maCauHoi',$value->maCauHoi)->first();
            if ($ch_ndqh) {
                $value->maNoiDungQH=$ch_ndqh->maNoiDungQH;
            } else {
                $value->maNoiDungQH=null;
            }
        }
        return view('giangvien.quyhoach.cauhoithuchanh.index_thuchanh',
        compact('hocphan','cauhoi','kqht','chuong','muc','ndqh'));
    }

    public function them(Request $request)  //--OK
    {
        if($request->maNoiDungQH==null){
            CommonController::warning_notify('Cần chọn nội dung quy hoạch', 'Please choise assessment content');
        }
        $ndqh=noiDungQH::where('maNoiDungQH',$request->maNoiDungQH)->first();
      
        if ($ndqh) {
             //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
            cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$ndqh->maKQHT,
            'maLoaiHTDG'=>'T3','id_loaiCH'=>'1','id_muc'=>Session::get('maMuc'),'maGV'=>Session::get('maGV')]);
            $ch=cauHoi::orderBy('maCauHoi','desc')->first();
            if($ch){
                cau_hoi_ndqh::create(['maCauHoi'=>$ch->maCauHoi,'maNoiDungQH'=>$request->maNoiDungQH]);
            }
            CommonController::success_notify("Thêm thành công!",'Added successfully');
        } else {
            CommonController::warning_notify("Không tìm thấy nội dung quy hoạch !",'can not found assement content');
        }
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-thuc-hanh/'.Session::get('maMuc').'/'.session::get('maCTBaiQH')); 
    }

    public function sua(Request $request)  //--OK
    {
        $ndqh=noiDungQH::where('maNoiDungQH',$request->maNoiDungQH)->first();
        if ($ndqh) {
            cauHoi::updateOrCreate(['isDelete'=>false,'maCauHoi'=>$request->maCauHoi],
            ['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$ndqh->maKQHT,'maGV'=>Session::get('maGV')]);

            cau_hoi_ndqh::updateOrCreate(['maCauHoi'=>$request->maCauHoi],['maNoiDungQH'=>$request->maNoiDungQH]);
            CommonController::success_notify('Sửa thành công','Edited successfully');
        }else{
            CommonController::warning_notify("Không tìm thấy nội dung quy hoạch !",'can not found assement content');
        }
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-thuc-hanh/'.Session::get('maMuc').'/'.Session::get('maCTBaiQH'));
    }

    public function xoa($maCauHoi)
    {
        if(dethi_cauhoituluan::where('maCauHoi',$maCauHoi)->count('maCauHoi')>0){
            CommonController::warning_notify('Câu hỏi đã được sử dụng trong đề thi, không thể xóa','The question was used in an examination!');
        }else{
            cau_hoi_ndqh::where('maCauHoi',$maCauHoi)->delete();
            cauHoi::where('maCauHoi',$maCauHoi)->delete();
            CommonController::success_notify('Xóa thành công!','Deleted successfully');
        }
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/ngan-hang-cau-hoi-thuc-hanh/'.Session::get('maMuc').'/'.Session::get('maCTBaiQH'));
    }

}
