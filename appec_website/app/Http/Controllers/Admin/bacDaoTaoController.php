<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\bacDaoTao;
use Illuminate\Http\Request;
use Session;
class bacDaoTaoController extends Controller
{
    public function index()
    {
        //$bdt=bacDaoTao::where('isDelete',false)->get();
        $bdt=bacDaoTao::all();
        return view('admin.bacdaotao',['bdt'=>$bdt]);
    }
    
    //PTTMai có sửa hàm thêm. Hàm thêm trước chạy không đúng, thay bằng đoạn này
    public function them(Request $request)
    {
        try {
            $bdt=bacDaoTao::create($request->only('maBac','tenBac'));
            if (Session::has('language') && Session::get('language')=='vi') {
                alert()->success('Thêm thành công', 'Thông báo')->persistent('Close');
            } else {
                alert()->success('Added successfully', 'Message')->persistent('Close');
            }
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
        $bdt=bacDaoTao::updateOrCreate(['maBac'=>$request->maBac],['tenBac'=>$request->tenBac]);
        if (Session::has('language') && Session::get('language')=='vi') {
            alert()->success('Sửa thành công!!','Thông báo');
        } else {
            alert()->success('Edited successfully!!','Message');
        }
        return redirect('/quan-ly/bac-dao-tao');
    }
    //xóa bậc đào tọa
    //PTTMai có sửa hàm xoa. Hàm xóa trước chạy không đúng, thay bằng đoạn này
    public function xoa($maBac)
    {
        try {
            //$bdt=bacDaoTao::updateOrCreate(['maBac'=>$maBac],['isDelete'=>true]);
            bacDaoTao::find($maBac)->delete();
            alert()->success('Deleted successful', 'Message');
            return redirect('/quan-ly/bac-dao-tao');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed');
            return redirect('/quan-ly/bac-dao-tao');
        }
        
    }
}