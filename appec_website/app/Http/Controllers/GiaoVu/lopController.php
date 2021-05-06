<?php

namespace App\Http\Controllers\GiaoVu;

use App\Http\Controllers\Controller;
use App\Models\lop;
use App\Models\sinhVien;
use Illuminate\Http\Request;
use Session;

class lopController extends Controller
{
    public function index()
    {
        $lop=lop::where('isDelete',false)->orderBy('maLop','desc')->get();
        foreach ($lop as $x) {
            $x->countsv=sinhVien::where('maLop',$x->maLop)->count('maSSV');
        }
        return view('giaovu.lop.lop',['lop'=>$lop]);
    }

   public function addClass(Request $request)
    {
        $lop=lop::where('maLop',$request->maLop)->first();
        if($lop){
            alert()->waring('Class is exist','Warning');
            return redirect('/giao-vu/quan-ly-lop');
        }
        lop::create($request->all());
        alert()->success('Added successfully','Message');
        return redirect('/giao-vu/quan-ly-lop');
    }


    public function editClass(Request $request)
    {
        lop::updateOrCreate(['maLop'=>$request->maLop],['tenLop'=>$request->tenLop,'namTS'=>$request->namTS]);
        return redirect('/giao-vu/quan-ly-lop');
    }

    public function delClass($maLop)
    {
        if(sinhVien::where('maLop',$maLop)->count('maSSV')>0){
            alert()->warning('Class has students','Message');
            return redirect('/giao-vu/quan-ly-lop');
        }
         lop::find($maLop)->delete();
         alert()->success('Deleted successfully','Message');
         return redirect('/giao-vu/quan-ly-lop');
         
    }
    public function xem_danh_sach_sinh_vien($maLop)
    {
        Session::put('maLop',$maLop);
        $dssv=sinhVien::where('isDelete',false)->where('maLop',$maLop)->get();
        return view('giaovu.lop.danhsachsv',['dssv'=>$dssv,'maLop'=>$maLop]);
    }
}
