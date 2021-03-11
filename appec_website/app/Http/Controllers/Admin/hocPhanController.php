<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ctKhoiKT;
use App\Models\hocPhan;
use Illuminate\Http\Request;


class hocPhanController extends Controller
{
    public function index(Type $var = null)
    {
        $hocphan=hocPhan::where('isDelete',false)->orderBy('maHocPhan','desc')->with('ctkhoi')->get();
        
        $ctkhoi=ctKhoiKT::where('isDelete',false)->orderBy('maCTKhoiKT','asc')->get();
        return view('admin.hocphan',['ctkhoi'=>$ctkhoi,'hocphan'=>$hocphan]);
       // return view('admin.chuongtrinhDT',['ctdaotao'=>$ctdt,'bac'=>$bac,'chuyennganh'=>$cn,'he'=>$he]);
    }
    //PTTMai thêm
    //Thêm học phần
    public function them(Request $request)
    {
        
        try {
            $tclt=$request->tinChiLyThuyet;
            $tcth=$request->tinChiThucHanh;
            $tongtc=$tclt + $tcth;
            hocPhan::create($request->only('maHocPhan','tenHocPhan',['tongSoTinChi'=>$tongtc],'tinChiLyThuyet','tinChiThucHanh','moTaHocPhan','maCTKhoiKT'));
           // return $request->all();//xem thử giá trị nhận lên từ form
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/hoc-phan');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/hoc-phan');
        }
        
    }

    //Sửa học phần
    public function sua(Request $request)
    {
        try {
            $tclt=$request->tinChiLyThuyet;
            $tcth=$request->tinChiThucHanh;
            $tongtc=$tclt+$tcth;
            //echo $tongtc;
            $hp=hocPhan::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['tenHocPhan'=>$request->tenHocPhan,'tongSoTinChi'=>$tongtc,'tinChiLyThuyet'=>$request->tinChiLyThuyet,'tinChiThucHanh'=>$request->tinChiThucHanh,'moTaHocPhan'=>$request->moTaHocPhan,'maCTKhoiKT'=>$request->maCTKhoiKT] );
            
            alert()->success('Updated successfully', 'Message');
            return redirect('/quan-ly/hoc-phan');
        } catch (\Throwable $th) {
           // dd ("lỗi ".$th); hiện lỗi thử
            alert()->error('Error:'.$th, 'Update failed');
           return redirect('/quan-ly/hoc-phan');
        }
    }

    //xóa học phần
    public function xoa($maHocPhan)
    {
        try {
            $hp=hocPhan::updateOrCreate(['maHocPhan'=>$maHocPhan],['isDelete'=>true]);
            alert()->success('Deleted successful', 'Message');
            return redirect('/quan-ly/hoc-phan');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed');
            return redirect('/quan-ly/hoc-phan');
        }
    }
    //Hết đoạn PTTMai thêm
}
