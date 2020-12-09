<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bacDaoTao;
use Illuminate\Http\Request;

class bacDaoTaoController extends Controller
{
    public function index(Type $var = null)
    {
        $bdt=bacDaoTao::where('isDelete',false)->get();
    
        return view('admin.bacdaotao',['bdt'=>$bdt]);
    }
    //thêm bậc đào tạo mới
    public function themBacDaoTao(Request $request)
    {

        try {
            $bdt=new bacDaoTao();
            $bdt->maBac=$request->maBac;
            $bdt->tenBac=$request->tenBac;
            $bdt->save();
            return redirect('/quan-ly/bac-dao-tao')->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return $th;
        }
      
    }

    //chỉnh sửa bậc đào tạo
    public function suaBacDaoTao(Request $request)
    {
        try {
            $bdt=bacDaoTao::where('maBac',$request->maBac)->first();
            $bdt->tenBac=$request->tenBac;
            $bdt->update();
            return redirect('/quan-ly/bac-dao-tao')->with('success','Sửa thành công!');
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }

    //xóa bậc đào tọa
    public function xoaBacDaoTao($maBac)
    {
        try {
            $bdt=bacDaoTao::where('maBac',$maBac)->first();
            $bdt->isDelete=true;
            $bdt->update();
            return redirect('/quan-ly/bac-dao-tao')->with('success','Xóa thành công!');
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
        
    }


}
