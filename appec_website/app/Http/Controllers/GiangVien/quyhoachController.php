<?php

namespace App\Http\Controllers\GiangVien;

use App\Models\giangDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hocPhan;
use App\Models\hocPhan_loaiHTDanhGia;
use App\Models\loaiDanhGia;
use App\Models\loaiHTDanhGia;
use Session;

class quyhoachController extends Controller
{
    public function index(Type $var = null)
    {
        $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
        
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
        })
        ->get();
        
        return view('giangvien.quyhoach.quyhoach',['gd'=>$gd]);
    }

    public function quy_hoach_ket_qua_hoc_tap($maHocPhan)
    {
       try {
           $ldg=loaiDanhGia::where('isDelete',false)->get();
           $lhtdg=loaiHTDanhGia::where('isDelete',false)->get();
           $hp=hocPhan::where('maHocPhan',$maHocPhan)
           ->where('isDelete',false)->first();
           $qh=hocPhan_loaiHTDanhGia::where('hocphan_loai_hinhthuc_dg.isDelete',false)
           ->where('maHocPhan',$maHocPhan)
           ->join('loai_danh_gia',function($x){
               $x->on('loai_danh_gia.maLoaiDG','=','hocphan_loai_hinhthuc_dg.maLoaiDG')
               ->where('loai_danh_gia.isDelete',false);
           })
           ->join('loai_ht_danhgia',function($x){
            $x->on('loai_ht_danhgia.maLoaiHTDG','=','hocphan_loai_hinhthuc_dg.maLoaiHTDG')
            ->where('loai_ht_danhgia.isDelete',false);
        })
           ->get();
          
           return view('giangvien.quyhoach.quyhoachketqua',['qh'=>$qh,'hp'=>$hp,
           'ldg'=>$ldg,'lhtdg'=>$lhtdg]);
       } catch (\Throwable $th) {
           return $th;
       }
    }
}
