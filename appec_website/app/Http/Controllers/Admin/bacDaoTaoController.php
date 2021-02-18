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
    public function them(Request $request)
    {
        try {
            $bdt=bacDaoTao::created($request->only('maBac','tenBac'));
            alert()->success('Thêm thành công', 'Thông báo')->persistent('Đóng');
            return redirect('/quan-ly/bac-dao-tao');
        } catch (\Throwable $th) {
            alert()->error('Lỗi:'.$th, 'Cảnh báo');
            return redirect('/quan-ly/bac-dao-tao');
        }
    }

    //chỉnh sửa bậc đào tạo
    public function sua(Request $request)
    {
        try {
            $bdt=bacDaoTao::updateOrCreated(['maBac'=>$request->maBac],['tenBac'=>$request->tenBac]);
            alert()->success('Sửa thành công', 'Thông báo');
            return redirect('/quan-ly/bac-dao-tao');
        } catch (\Throwable $th) {
            alert()->error('Lỗi:'.$th, 'Cảnh báo');
            return redirect('/quan-ly/bac-dao-tao');
        }
    }

    //xóa bậc đào tọa
    public function xoa($maBac)
    {
        try {
            $bdt=bacDaoTao::updateOrCreated(['maBac'=>$request->maBac],['isDelete'=>false]);

            return redirect('/quan-ly/bac-dao-tao')->with('success','Xóa thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/bac-dao-tao')->with('warning','Lỗi:'.$th);
        }
        
    }


}
