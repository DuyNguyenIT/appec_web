<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\CDR3;
use App\Models\cdr3_abet;
use App\Models\chuan_abet;
use Session;

class AdCDR3_ABETController extends Controller
{
    public function index()
    {
        $cdr3_abet=cdr3_abet::with('cdr_cd3')->with('chuanAbet')->get();
        $cdr3=CDR3::orderBy('maCDR3VB','asc')->get();
        $chuanAbet=chuan_abet::orderBy('maChuanAbet','asc')->get();
        return view('admin.cdr3_chuanAbet',compact('cdr3_abet','cdr3','chuanAbet'));
    }

     
    public function them(Request $request)
    {
        $check_exist=cdr3_abet::where('maCDR3',$request->maCDR3)->where('maChuanAbet',$request->maChuanAbet)->count();
        if($check_exist>0){
            if (Session::has('language') && Session::get('language')=='vi') {
                alert()->warning('Mối liên hệ đã được tạo', 'Thông báo');
            } else {
                alert()->warning('Duplicate checking', 'Message');
            }
            return redirect('/quan-ly/chuan-dau-ra3-abet');
        }
        cdr3_abet::create($request->all());
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Thêm thành công', 'Thông báo');
        } else {
            alert()->success('Added successfully', 'Message');
        }
        return redirect('/quan-ly/chuan-dau-ra3-abet');
    }

    public function sua(Request $request)
    {
        cdr2_abet::updateOrCreate(['id'=>$request->id],['maCDR3'=>$request->maCDR3,'maChuanAbet'=>$request->maChuanAbet]);
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Sửa thành công', 'Thông báo');
        } else {
            alert()->success('Edited successfully', 'Message');
        }
        return redirect('/quan-ly/chuan-dau-ra3-abet');
    }
    
    public function xoa($id)
    {
        cdr2_abet::find($id)->delete();
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Xóa thành công', 'Thông báo');
        } else {
            alert()->success('Deleted successfully', 'Message');
        }
        return redirect('/quan-ly/chuan-dau-ra3-abet');
    }

}
