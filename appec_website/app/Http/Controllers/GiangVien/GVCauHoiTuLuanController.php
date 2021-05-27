<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\muc;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\noiDungQH;
use App\Models\cau_hoi_ndqh;
use Illuminate\Http\Request;
use App\Models\chuong_cauhoi;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

class GVCauHoiTuLuanController extends Controller
{
    public function index($maMuc,$maCTBaiQH)
    {
        Session::put('maMuc',$maMuc);
        Session::put('maCTBaiQH',$maCTBaiQH);
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
        $cauhoi =cauHoi::where('id_muc',$maMuc)->where('maLoaiHTDG','T1')->get();
      
        return view('giangvien.quyhoach.cauhoituluan.index_tuluan',
        compact('hocphan','kqht','cauhoi','muc','chuong','ndqh'));
    }
    public function them(Request $request)
    {
        //select kqht tu noi dung quy hoach
        $ndqh=noiDungQH::where($request->maNoiDungQH)->first();
        if($ndqh){
            //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
            cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,
            'maKQHT'=>$ndqh->maKQHT,'maLoaiHTDG'=>'T1','id_loaiCH'=>'1',
            'id_muc'=>Session::get('maMuc'),'maGV'=>Session::get('maGV')]);
            $ch=cauHoi::orderBy('maCauHoi','desc')->first();
            if($ch){
                cau_hoi_ndqh::create(['maCauHoi'=>$ch->maCauHoi,'maNoiDungQH'=>$request->maNoiDungQH]);
            }
            CommonController::success_notify('Thêm thành công!','Added successfully');
        }else{
            CommonController::success_notify('Không tìm thấy nội dung quy hoạch!','Can not found assesment contents');
        }
        return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/'.Session::get('maMuc'));
    }

    public function sua(Request $request)
    {
        $ndqh=noiDungQH::where($request->maNoiDungQH)->first();
        if($ndqh){
            cauHoi::updateOrCreate(['maCauHoi'=>$request->maCauHoi],
            ['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,
            'maKQHT'=>$ndqh->maKQHT,'maGV'=>Session::get('maGV')]);
            $chuong=chuong::findOrFail($request->maChuong);
            CommonController::success_notify('Sửa thành công!','Edited successfully');
        }else{
            CommonController::success_notify('Không tìm thấy nội dung quy hoạch!','Can not found assesment contents');
        }
        return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/'.Session::get('maMuc'));
    }

    public function xoa($maCauHoi)
    {
        if(dethi_cauhoituluan::where('maCauHoi',$maCauHoi)->count('maCauHoi')>0){
            CommonController::warning_notify('Câu hỏi đã được sử dụng trong đề thi, không thể xóa','The question was used in an examination!');
            return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/'.Session::get('maMuc'));
        }else{
            cau_hoi_ndqh::where('maCauHoi',$maCauHoi)->delete();
            cauHoi::where('maCauHoi',$maCauHoi)->delete();
            CommonController::success_notify('xóa thành công!','Deleted successfully');
            return redirect('/giang-vien/hoc-phan/chuong/muc/cau-hoi-tu-luan/'.Session::get('maMuc'));
        }
    }
}
