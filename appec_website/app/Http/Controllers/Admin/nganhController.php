<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cNganh;
use App\Models\nganh;
use Illuminate\Http\Request;

class nganhController extends Controller
{
    public function index(Type $var = null)
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
           // return redirect('/quan-ly/nganh-hoc')->with('success','Added successfully!');
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/nganh-hoc');
    
        } catch (\Throwable $th) {
            //return redirect('/quan-ly/nganh-hoc')->with('warning','error:'.$th);
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
            //return redirect('/quan-ly/nganh-hoc')->with('success','Updated successfully!');
            alert()->success('Updated successfully', 'Message');
            return redirect('/quan-ly/nganh-hoc');
        } catch (\Throwable $th) {
            //return redirect('/quan-ly/nganh-hoc')->with('warning','error:'.$th);
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
            //return redirect('/quan-ly/nganh-hoc')->with('success','Xóa thành công!');
            alert()->success('Deleted successful', 'Message');
            return redirect('/quan-ly/nganh-hoc');
        } catch (\Throwable $th) {
            //return redirect('/quan-ly/nganh-hoc')->with('warning','Lỗi:'.$th);
            alert()->error('Error:'.$th, 'Delete failed');
            return redirect('/quan-ly/nganh-hoc');

        }
        
    }
}
