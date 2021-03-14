<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\he;
use Illuminate\Http\Request;
use SweetAlert;

class heController extends Controller
{
    public function index(Type $var = null)
    {
        $he=he::where('isDelete',false)->orderBy('maHe','desc')->get();
        return view('admin.he',['he'=>$he]);
    }

    public function them(Request $request)
    {
        try {
            $he=he::updateOrCreate(['maHe'=>$request->maHe],['tenHe'=>$request->tenHe,'isdelete'=>false]);
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/he');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/he');
        }
    }

    public function sua(Request $request)
    {
        try {
            $he=he::updateOrCreate(['maHe'=>$request->maHe],['tenHe'=>$request->tenHe,'isdelete'=>false]);
            alert()->success('Sửa thành công', 'Thông báo');
            return redirect('/quan-ly/he');
        } catch (\Throwable $th) {
            alert()->error('Lỗi:'.$th, 'Cảnh báo');
            return redirect('/quan-ly/he');
        }
    }
    
    
    public function xoa_he($maHe)
    {
        try {
            $he=he::updateOrCreate(['maHe'=>$maHe],['isDelete'=>true]);
            alert()->success('Xóa thành công', 'Thông báo');
            return redirect('/quan-ly/he');
        } catch (\Throwable $th) {
            alert()->error('Lỗi:'.$th, 'Cảnh báo');
            return redirect('/quan-ly/he');
        }
    }
}
