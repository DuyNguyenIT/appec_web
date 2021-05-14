<?php

namespace App\Http\Controllers\admin;

use App\Models\CDR2;
use App\Models\cdr2_abet;
use App\Models\chuan_abet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class AdCDR2_ABETController extends Controller
{
    public function index()
    {
        $cdr2_abet=cdr2_abet::with('cdr_cd2')->with('chuanAbet')->get();
        $cdr2=CDR2::orderBy('maCDR2VB','asc')->get();
        $chuanAbet=chuan_abet::orderBy('maChuanAbet','asc')->get();
        return view('admin.cdr2_chuanAbet',compact('cdr2_abet','cdr2','chuanAbet'));
    }
    
    public function them(Request $request)
    {
        $check_exist=cdr2_abet::where('maCDR2',$request->maCDR2)->where('maChuanAbet',$request->maChuanAbet)->count();
        if($check_exist>0){
            if (Session::has('language') && Session::get('language')=='vi') {
                alert()->warning('Mối liên hệ đã được tạo', 'Thông báo');
            } else {
                alert()->warning('Duplicate checking', 'Message');
            }
            return redirect('/quan-ly/chuan-dau-ra2-abet');
        }
        cdr2_abet::create($request->all());
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Thêm thành công', 'Thông báo');
        } else {
            alert()->success('Added successfully', 'Message');
        }
        return redirect('/quan-ly/chuan-dau-ra2-abet');
    }

    public function sua(Request $request)
    {
        cdr2_abet::updateOrCreate(['id'=>$request->id],['maCDR2'=>$request->maCDR2,'maChuanAbet'=>$request->maChuanAbet]);
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Sửa thành công', 'Thông báo');
        } else {
            alert()->success('Edited successfully', 'Message');
        }
        return redirect('/quan-ly/chuan-dau-ra2-abet');
    }
    
    public function xoa($id)
    {
        cdr2_abet::find($id)->delete();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Xóa thành công', 'Thông báo');
        } else {
            alert()->success('Deleted successfully', 'Message');
        }
        return redirect('/quan-ly/chuan-dau-ra2-abet');
    }
}