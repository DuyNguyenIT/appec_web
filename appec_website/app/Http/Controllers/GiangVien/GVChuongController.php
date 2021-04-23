<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use App\Models\chuong;
use App\Models\hocPhan;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Session;

class GVChuongController extends Controller
{
    public function index($maHocPhan)
    {
        Session::put('maHocPhan_chuong',$maHocPhan);
        $chuong=chuong::where('isdelete',false)->where('maHocPhan',$maHocPhan)->orderBy('id','asc')->with('muc')->get();
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        return view('giangvien.hocphan.chuong.index',['chuong'=>$chuong,'hocPhan'=>$hocphan]);
    }

    public function ngan_hang_cau_hoi()
    {
        $chuong=chuong::where('isdelete',false)->where('maHocPhan',Session::get('maHocPhan'))->orderBy('id','asc')->with('muc')->get();
        $hocphan=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();
        //return $chuong[0];
        return view('giangvien.quyhoach.noidungdanhgia.nganHangCauHoi',['chuong'=>$chuong,'hocPhan'=>$hocphan]);
    }
    public function them(Request $request)
    {
        try {
            chuong::create(['tenchuong'=>$request->tenchuong,
            'tenkhongdau'=>CommonController::con_str($request->tenchuong),
            'mota'=>$request->mota,
            'maHocPhan'=>Session::get('maHocPhan_chuong')]);
            return redirect('giang-vien/hoc-phan/chuong/'.Session::get('maHocPhan_chuong'))->with('success','Thêm thành công');
        } catch (\Throwable $th) {
            return redirect('giang-vien/hoc-phan/chuong/'.Session::get('maHocPhan_chuong'))->with('warning','Có lỗi '.$th);
        }
    }

    public function sua(Request $request)
    {
        try {
            $chuong=chuong::updateOrCreate(['id'=>$request->id],['tenchuong'=>$request->tenchuong,
            'tenkhongdau'=>CommonController::con_str($request->tenchuong),
            'mota'=>$request->mota,
            'maHocPhan'=>Session::get('maHocPhan_chuong')]);
          
            return redirect('giang-vien/hoc-phan/chuong/'.Session::get('maHocPhan_chuong'))->with('success','Sửa thành công');
        } catch (\Throwable $th) {
            return redirect('giang-vien/hoc-phan/chuong/'.Session::get('maHocPhan_chuong'))->with('warning','Có lỗi '.$th);
        }
    }

    public function xoa($id)
    {
        try {
            $chuong=chuong::updateOrCreate(['id'=>$id],['isDelete'=>$request->tenchuong]);
            return redirect('giang-vien/hoc-phan/chuong/'.Session::get('maHocPhan_chuong'))->with('success','Sửa thành công');
        } catch (\Throwable $th) {
            return redirect('giang-vien/hoc-phan/chuong/'.Session::get('maHocPhan_chuong'))->with('warnini','Có lỗi '.$th);
        }
    }

    
}
