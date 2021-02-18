<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\chuong_cauhoi;
use App\Models\hocPhan;
use App\Models\kqHTHP;
use Illuminate\Http\Request;
use Session;

class GVCauHoiTuLuanController extends Controller
{
    public function index($idchuong,$tenkhongdau)
    {
        //idchuong->|chuong_cauhoi|->[idchuong_maCauHoi]->|cauhoi|->[idchuong_maCauHoi_noiDungCauHoi]
        $chuong_cauhoi=chuong_cauhoi::where('isDelete',false)->where('maChuong',$idchuong)->get();
        $chuong=chuong::where('isDelete',false)->where('id',$idchuong)->first();
        $hocphan=hocPhan::where('isDelete',false)->where('maHocPhan',Session::get('maHocPhan_chuong'))->first();
        foreach ($chuong_cauhoi as $x) {
            $cauhoi=cauHoi::where('isDelete',false)->where('maCauHoi',$x->maCauHoi)->first();
            $x->noiDungCauHoi=$cauhoi->noiDungCauHoi;
            $x->diemCauHoi=$cauhoi->diemCauHoi;
        }
        $kqht=kqHTHP::where('isdelete',false)->get();
        return view('giangvien.hocphan.chuong.cauhoi.index_tuluan',
        ['cauhoi'=>$chuong_cauhoi,'chuong'=>$chuong,'hocphan'=>$hocphan,'kqht'=>$kqht]);
    }
    public function them(Request $request)
    {
        try {
             //thêm câu hỏi mới, điểm câu hỏi thêm mặc định 12
            cauHoi::create(['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T1']);
            //thêm chuong_cauhoi
            $cauhoi=cauHoi::where('isDelete',false)->orderBy('maCauHoi','desc')->first();
            chuong_cauhoi::create(['maChuong'=>$request->maChuong,'maCauHoi'=>$cauhoi->maCauHoi]);
            $chuong=chuong::where('id',$request->maChuong)->first();
            alert()->success('Thêm thành công', 'Thông báo');
            return back();
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function sua(Request $request)
    {
       try {
        cauHoi::updateOrCreate(['isDelete'=>false,'maCauHoi'=>$request->maCauHoi],
        ['noiDungCauHoi'=>$request->noiDungCauHoi,'diemCauHoi'=>12,'maKQHT'=>$request->maKQHT,'maLoaiHTDG'=>'T1']);
        alert()->success('Sửa thành công', 'Thông báo');
        $chuong=chuong::findOrFail($request->maChuong);
        return back();
       } catch (\Throwable $th) {
           return $th;
       }
    }

    public function xoa($maCauHoi)
    {
        try {
            cauHoi::updateOrCreate(['isDelete'=>false,'maCauHoi'=>$maCauHoi],['isDelete'=>true]);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
