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

    //PTTMai có sửa hàm thêm. Hàm thêm trước chạy không đúng, thay bằng đoạn này
    public function them(Request $request)
    {
        try {
            $bdt=bacDaoTao::create($request->only('maBac','tenBac'));
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/bac-dao-tao');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/bac-dao-tao');
        }
    }

    //chỉnh sửa bậc đào tạo
    //PTTMai có sửa hàm sua. Hàm sửa trước chạy không đúng, thay bằng đoạn này
    public function sua(Request $request)
    {
        try {
            $bdt=bacDaoTao::updateOrCreate(['maBac'=>$request->maBac],['tenBac'=>$request->tenBac]);
            alert()->success('Updated successfully', 'Message');
            return redirect('/quan-ly/bac-dao-tao');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Update failed');
            return redirect('/quan-ly/bac-dao-tao');
        }
    }

    //xóa bậc đào tọa
    //PTTMai có sửa hàm xoa. Hàm xóa trước chạy không đúng, thay bằng đoạn này
    public function xoa($maBac)
    {
        try {
            echo $maBac;
            $bdt=bacDaoTao::updateOrCreate(['maBac'=>$maBac],['isDelete'=>true]);
            alert()->success('Deleted successful', 'Message');
            return redirect('/quan-ly/bac-dao-tao');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed');
            return redirect('/quan-ly/bac-dao-tao');
        }
        
    }


}
