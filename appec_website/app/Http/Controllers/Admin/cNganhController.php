<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cNganh;
use App\Models\nganh;

class cNganhController extends Controller
{
    public function index(Type $var = null)
    {
        $cnganh=cNganh::where('isDelete',false)->orderBy('maNganh','desc')->with('nganh')->get();
         $nganh=nganh::where('isDelete',false)->orderBy('maNganh','desc')->get();
        
        return view('admin.chuyennganh',['cnganh'=>$cnganh, 'nganh'=>$nganh]);
    }
    public function them(Request $request)
    {
        try {
            $cnganh=cNganh::updateOrCreate(['tenCNganh'=>$request->tenCNganh,'maNganh'=>$request->maNganh,'isDelete'=>false]);
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/chuyen-nganh');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/chuyen-nganh');
        }
    }
    public function sua(Request $request)
    {
        try {
            $cnganh=cNganh::updateOrCreate(['maCNganh'=>$request->maCNganh],['tenCNganh'=>$request->tenCNganh,'maNganh'=>$request->maNganh,'isDelete'=>false]);
            //return $request->all();
            
            alert()->success('Updated successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/chuyen-nganh');
        } catch (\Throwable $th) {
            
            alert()->error('Error:'.$th, 'Update failed')->persistent('Close');
            return redirect('/quan-ly/chuyen-nganh');
        }
    }
    public function xoa($macnganh)
    {
        try {
            $cnganh=cNganh::updateOrCreate(['maCNganh'=>$macnganh],['isDelete'=>true]);
            alert()->success('Deleted successful', 'Message') ->persistent('Close');
            return redirect('/quan-ly/chuyen-nganh');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed') ->persistent('Close');
            return redirect('/quan-ly/chuyen-nganh');
        }
    }
}
