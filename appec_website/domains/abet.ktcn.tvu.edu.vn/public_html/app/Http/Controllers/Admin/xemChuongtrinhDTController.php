<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\he;
use Carbon\Carbon;
use App\Models\cNganh;
use App\Models\hocPhan;
use App\Models\ctDaoTao;
use App\Models\ctKhoiKT;
use App\Models\bacDaoTao;
use App\Models\giangVien;
use App\Models\loaiHocPhan;
use Illuminate\Http\Request;
use App\Models\hocPhan_ctDaoTao;
use App\Models\bien_soan_de_cuong;
use App\Models\phan_bien_de_cuong;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

class xemChuongtrinhDTController extends Controller
{
    public function index()
    {
        $ctdt=ctDaoTao::where('isDelete',false)->orderBy('maCT','desc')->with('bac')->with('cnganh')->with('he')->with('hocphan')->get();
        $bac=bacDaoTao::where('isDelete',false)->orderBy('maBac','desc')->get();
        $cn=cNganh::where('isDelete',false)->orderBy('maCNganh','desc')->get();
        $he=he::where('isDelete',false)->orderBy('maHe','desc')->get();
        $hocphan= hocPhan_ctDaoTao::where('isDelete',false)->orderBy('maCT','desc')->get();
        $hocphan_ten= hocPhan::where('isDelete',false)->get();
        return view('admin.ctdaotao.xemchuongtrinhDT',['XemctDaoTao'=>$ctdt,'bac'=>$bac,'chuyennganh'=>$cn,'he'=>$he,'hocphan'=>$hocphan,'hocphan_ten'=>$hocphan_ten]);
    }

    public function xem_thong_tin_hoc_phan($maHocPhan)
    {
        Session::put('maHocPhan',$maHocPhan);
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->orderBy('maHocPhan','desc')->with('hocphan_ctdt')->get();
        $bienSoan=bien_soan_de_cuong::where('maHocPhan',$maHocPhan)->with('giang_vien')->get();
        $phanBien=phan_bien_de_cuong::where('maHocPhan',$maHocPhan)->with('giang_vien')->get();
        $ctkhoi=ctKhoiKT::where('isDelete',false)->orderBy('maCTKhoiKT','asc')->get();
        $ctdt=ctDaoTao::all();
        $loaihp=loaiHocPhan::all();
        $giangvien=giangVien::all();
        foreach ($hocphan as $hp) {
            foreach ($hp->hocphan_ctdt as $hp_ctdt) {
                $ct=ctDaoTao::where('maCT',$hp_ctdt->maCT)->first();
                $hp_ctdt->tenCT=$ct->tenCT;
            }
        }
        return view('admin.ctdaotao.xemthongtinhocphan',compact('hocphan','ctkhoi','ctdt','loaihp','giangvien','bienSoan','phanBien'));
    }

    public function dieu_chinh_thoi_gian_soan_de_cuong(Request $request)
    {
        $bienSoan=bien_soan_de_cuong::all();
        foreach ($bienSoan as $bs) {
            $bs->thoiGianBatDau=$request->thoiGianBatDau;
            $bs->thoiGianKetThuc=$request->thoiGianKetThuc;
            $bs->update();
        }
        CommonController::success_notify('Điều chỉnh thành công!!','Adjusted successfully');
        return redirect('/quan-ly/bien-soan-va-phan-bien-de-cuong/');
    }

    public function dieu_chinh_thoi_phan_bien_de_cuong(Request $request)
    {
        $phanBien=phan_bien_de_cuong::all();
        foreach ($phanBien as $pb) {
            $pb->thoiGianBatDau=$request->thoiGianBatDau;
            $pb->thoiGianKetThuc=$request->thoiGianKetThuc;
            $pb->update();
        }
        CommonController::success_notify('Điều chỉnh thành công!!','Adjusted successfully');
        return redirect('/quan-ly/bien-soan-va-phan-bien-de-cuong/');
    }

    public function them_bien_soan_de_cuong(Request $request)
    {
        if(bien_soan_de_cuong::where('maHocPhan',Session::get('maHocPhan'))->where('maGV',$request->maGV)->count('maGV')>0){
            CommonController::warning_notify('Giảng viên đã được chọn!!!','Lecture is selected');
        }else{
            bien_soan_de_cuong::create(['maHocPhan'=>Session::get('maHocPhan'),'maGV'=>$request->maGV,'thoiGianBatDau'=>Carbon::now(),
            'thoiGianKetThuc'=>Carbon::now()]);
            CommonController::success_notify('Thêm thành công!!','Added successfully');
        }
        return redirect('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/'.Session::get('maHocPhan'));
    }

    public function xoa_bien_soan_de_cuong($maGV)
    {
        
        bien_soan_de_cuong::where('maGV',$maGV)->where('maHocPhan',Session::get('maHocPhan'))->delete();
        CommonController::success_notify('Xóa thành công!!!','Deleted successfully');
        return redirect('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/'.Session::get('maHocPhan'));
    }

    public function them_phan_bien_de_cuong(Request $request)
    {
        if(phan_bien_de_cuong::where('maHocPhan',Session::get('maHocPhan'))->where('maGV',$request->maGV)->count('maGV')>0){
            CommonController::warning_notify('Giảng viên đã được chọn!!!','Lecture is selected');
        
        }else{
            phan_bien_de_cuong::create(['maHocPhan'=>Session::get('maHocPhan'),'maGV'=>$request->maGV,'thoiGianBatDau'=>Carbon::now(),
            'thoiGianKetThuc'=>Carbon::now()]);
            CommonController::success_notify('Thêm thành công!!!','Added successfully');
        }   
        return redirect('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/'.Session::get('maHocPhan'));
    }

    public function xoa_phan_bien_de_cuong($maGV)
    {
        phan_bien_de_cuong::where('maGV',$maGV)->where('maHocPhan',Session::get('maHocPhan'))->delete();
        CommonController::success_notify('Xóa thành công!!!','Deleted successfully');
        return redirect('/quan-ly/bien-soan-va-phan-bien-de-cuong/xem-thong-tin-hoc-phan/'.Session::get('maHocPhan'));
    }
}
