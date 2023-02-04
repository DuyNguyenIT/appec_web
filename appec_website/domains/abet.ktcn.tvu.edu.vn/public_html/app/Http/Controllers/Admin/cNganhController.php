<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cNganh;
use App\Models\nganh;
use Session;

class cNganhController extends Controller
{
    public function index()
    {
        $cnganh=cNganh::where('isDelete',false)->orderBy('maNganh','desc')->with('nganh')->get();
        $nganh=nganh::where('isDelete',false)->orderBy('maNganh','desc')->get();
        return view('admin.chuyennganh',['cnganh'=>$cnganh, 'nganh'=>$nganh]);
    }
    public function them(Request $request)
    {
        $cnganh=cNganh::updateOrCreate(['tenCNganh'=>$request->tenCNganh,'maNganh'=>$request->maNganh,'isDelete'=>false]);
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Thêm thành công', 'Thông báo')->persistent('Close');
        } else {
            alert()->success('Added successfully', 'Message')->persistent('Close');
        }
        return redirect('/quan-ly/chuyen-nganh');     
    }
    public function sua(Request $request)
    {
        
        $cnganh=cNganh::updateOrCreate(['maCNganh'=>$request->maCNganh],['tenCNganh'=>$request->tenCNganh,'maNganh'=>$request->maNganh,'isDelete'=>false]);
        //return $request->all();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Sửa thành công!!','Thông báo');
        } else {
            alert()->success('Edited successfully!!','Message');
        }
        return redirect('/quan-ly/chuyen-nganh');
       
    }
    public function xoa($macnganh)
    {
        try {
            $cnganh=cNganh::updateOrCreate(['maCNganh'=>$macnganh],['isDelete'=>true]);
            alert()->success('Deleted successful', 'Message');
            return redirect('/quan-ly/chuyen-nganh');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed');
            return redirect('/quan-ly/chuyen-nganh');
        }
    }
}
