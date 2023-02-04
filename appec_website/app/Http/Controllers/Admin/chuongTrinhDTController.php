<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ctdtExport;
use App\Http\Controllers\Controller;
use App\Models\bacDaoTao;
use App\Models\cNganh;
use App\Models\ctDaoTao;
use App\Models\he;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class chuongTrinhDTController extends Controller
{
    public function index()
    {
        $ctdt=ctDaoTao::where('isDelete',false)->orderBy('maCT','desc')->with('bac')->with('cnganh')->with('he')->get();
        $bac=bacDaoTao::where('isDelete',false)->orderBy('maBac','desc')->get();
        $cn=cNganh::where('isDelete',false)->orderBy('maCNganh','desc')->get();
        $he=he::where('isDelete',false)->orderBy('maHe','desc')->get();
        return view('admin.chuongtrinhDT',['ctdaotao'=>$ctdt,'bac'=>$bac,'chuyennganh'=>$cn,'he'=>$he]);
    }

    public function excel(Excel $excel)
    {
        $customer_data=ctDaoTao::all();
        $customer_array[]= array('Mã chương trình','Tên chương trình');
        foreach($customer_data as $customer)
        {
            $customer_array[] = array(
                'Mã chương trình'  => $customer->maCT,
                'Tên chương trình'   => $customer->tenCT
            );
        }
        return $excel->download(new ctdtExport,'ctdt.xlsx');
    }

    public function them(Request $request)
    {
        try {
            $ctdt=new ctDaoTao();
            $ctdt->tenCT=$request->tenCT;
            $ctdt->tenCT_EN=$request->tenCT_EN;
            $ctdt->maBac=$request->maBac;
            $ctdt->maCNganh=$request->maCNganh;
            $ctdt->maHe=$request->maHe;
            $ctdt->soQuyetDinh=$request->soQuyetDinh;
            $ctdt->ngayBanHanh	=$request->ngayBanHanh;
            $ctdt->save();
            return redirect('quan-ly/chuong-trinh-dao-tao')->with('success','Thêm thành công!!');
        } catch (\Throwable $th) {      
        return redirect('quan-ly/chuong-trinh-dao-tao')->with('warning','Lỗi :'.$th);
        }
        
    }
    public function sua(Request $request)
    {
        try {
            $ctdt=ctDaoTao::where('maCT',$request->maCT)->first();
            if($ctdt){
                $ctdt->tenCT=$request->tenCT;
                $ctdt->tenCT_EN=$request->tenCT_EN;
                $ctdt->maBac=$request->maBac;
                $ctdt->maCNganh=$request->maCNganh;
                $ctdt->maHe=$request->maHe;
                $ctdt->soQuyetDinh=$request->soQuyetDinh;
                $ctdt->ngayBanHanh	=$request->ngayBanHanh;
                $ctdt->update();
                return redirect('quan-ly/chuong-trinh-dao-tao')->with('success','Sửa thành công!!');
            }else{
                return redirect('quan-ly/chuong-trinh-dao-tao')->with('warning','Không tìm thấy chương tình đào tạo!!');

            }
          
        } catch (\Throwable $th) { 
            return redirect('quan-ly/chuong-trinh-dao-tao')->with('warning','Lỗi :'.$th);
        }
    }
    public function xoa($maCT)
    {
        try {
            $ctdt=ctDaoTao::where('maCT',$maCT)->first();
            if($ctdt){
                $ctdt->isdelete=true;
                $ctdt->update();
                return redirect('quan-ly/chuong-trinh-dao-tao')->with('success','Xóa thành công!!');
            }else{
                return redirect('quan-ly/chuong-trinh-dao-tao')->with('warning','Không tìm thấy chương trình đào tạo!!');
            }
        } catch (\Throwable $th) { 
            return redirect('quan-ly/chuong-trinh-dao-tao')->with('warning','Lỗi :'.$th);
        }
    }

    public function xem_thong_tin_hoc_phan($maHocPhan)
    {
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->orderBy('maHocPhan','desc')->with('hocphan_ctdt')->get();
        
    }
}
