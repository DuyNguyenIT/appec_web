<?php

namespace App\Http\Controllers\GiaoVu;

use Illuminate\Http\Request;
use App\Imports\dsSinhVienImport;
use App\Http\Controllers\Controller;
use Session;

class dsSinhVienImportController extends Controller
{
    public function import(Request $request)
    {
        if($request->has('file')){
            $extension = $request->file->getClientOriginalExtension();
            if($extension=='csv'||$extension=='xls'){
                 $file=$request->file('file')->store('import');
                (new dsSinhVienImport)->import($file);
            }else{
                if (session::has('language') && session::get('language')=='vi') {
                    alert()->warning('Chỉ chấp nhận .csv và .xls!','Thông báo');
                } else {
                    alert()->warning('Only accept .csv and .xls!','Message');
                }
                return redirect('/giao-vu/quan-ly-lop');
            }
        }
        return redirect('/giao-vu/quan-ly-lop/xem-danh-sach-sinh-vien/'.Session::get('maLop'));
    }

    public function download_template()
    {
        return response()->download(storage_path('template_list_students.csv'));
    }
}
