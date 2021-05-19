<?php

namespace App\Http\Controllers\GiaoVu;

use Illuminate\Http\Request;
use App\Imports\dsSV_HPImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class dsSinhVienHocPhanImport extends Controller
{
    public function import(Request $request)
    {
        if($request->has('file')){
            $extension = $request->file->getClientOriginalExtension();
            if($extension=='csv'||$extension=='xls'){
                $file=$request->file('file')->store('import');
                $import=new dsSV_HPImport;
                Excel::import(new dsSV_HPImport,$file);
            }else{
                if (session::has('language') && session::get('language')=='vi') {
                    alert()->warning('Chỉ chấp nhận .csv and .xls!','Thông báo');
                } else {
                    alert()->warning('Only accept .csv and .xls!','Message');
                }
                return redirect('/giao-vu/hoc-phan-giang-day/xem-danh-sach-sinh-vien/'.Session::get('maHocPhan').'/'.Session::get('maLop').'/'.Session::get('maHK').'/'.Session::get('namHoc'));
            }
        }
        return redirect('/giao-vu/hoc-phan-giang-day/xem-danh-sach-sinh-vien/'.Session::get('maHocPhan').'/'.Session::get('maLop').'/'.Session::get('maHK').'/'.Session::get('namHoc'));
    }

    public function download_template()
    {
        return response()->download(storage_path('template_list_students _course.csv'));
    }
}
