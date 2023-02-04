<?php

namespace App\Http\Controllers\GiangVien;

use App\Models\hocPhan;
use App\Models\giangDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class homeController extends Controller
{
    public function index()
    {
        //dem hoc phan
        $mhp_arr=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
        })->groupBy('maBaiQH')->distinct('maHocPhan')
        ->pluck('giangday.maHocPhan');
        
        $dem_hp=hocPhan::where('isDelete',false)->whereIn('maHocPhan',$mhp_arr)->count();

        //dem bai quy hoach
        $dem_quy_hoach=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
        ->orderBy('giangday.namHoc','desc')
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })->groupBy(['maBaiQH','giangday.maLop'])->distinct()->get();
        $dem_quy_hoach=$dem_quy_hoach->count();

        return view('giangvien.home',compact('dem_hp','dem_quy_hoach'));
    }
}
