<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cNganh;
use App\Models\nganh;
use Illuminate\Http\Request;

class nganhController extends Controller
{
    public function index()
    {
        $nganh=nganh::where('isDelete',false)->get();
        return view('admin.nganh',['nganh'=>$nganh]);
    }

    public function them(Request $request)
    {
        try {
            $nganh=new nganh();
            $nganh->maNganh=$request->maNganh;
            $nganh->tenNganh=$request->tenNganh;
            $nganh->save();
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/nganh-hoc');
    
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/nganh-hoc');
        }
    }

    public function sua(Request $request)
    {
        try {
            $nganh=nganh::where('maNganh',$request->maNganh)->first();
            $nganh->maNganh=$request->maNganh;
            $nganh->tenNganh=$request->tenNganh;
            $nganh->update();
            alert()->success('Updated successfully', 'Message');
            return redirect('/quan-ly/nganh-hoc');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Update failed');
            return redirect('/quan-ly/nganh-hoc');
        }
    }

    public function xoa($maNganh)
    {
        try {
            $nganh=nganh::where('maNganh',$maNganh)->first();
            $nganh->isDelete=true;
            $nganh->update();
            alert()->success('Deleted successful', 'Message');
            return redirect('/quan-ly/nganh-hoc');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed');
            return redirect('/quan-ly/nganh-hoc');
        }
        
    }
}
