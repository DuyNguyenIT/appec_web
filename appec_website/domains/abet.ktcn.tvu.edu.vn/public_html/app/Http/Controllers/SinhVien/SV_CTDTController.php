<?php

namespace App\Http\Controllers\sinhvien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SV_CTDTController extends Controller
{
    public function index(){   
       
        $sv=sinhVien::where('sinh_vien.isDelete',false)->where('maSSV',Session::get('maSSV'))
        ->join('lop', function($a){
            $a->on('lop.maLop','=','sinh_vien.maLop')
            ->where('lop.isDelete',false);
        })       
        ->join('giangday',function($q){
            $q->on('giangday.maLop','=','lop.maLop')
                ->where('giangday.isDelete',false);
        })->groupBy('maLop')
        ->get(['maHK','namHoc','giangday.maLop', 'sinh_vien.maSSV', 'lop.tenLop']);
      
        //học phần
        $hp=hocPhan::where('isDelete',false)
        ->get();     
        //giảng viên
        $giangvien=giangVien::where('isDelete',false)
        ->get();
        //lớp 
        $lop=lop::where('isDelete',false)->get();


         
        /////////pks_cdr3//////////
        $pks_cdr=phieuks_ctdt::where('phieuks_ctdt.isDelete',false)->where('maSSV',Session::get('maSSV')) 
        ->join('lop', function($c){
            $c->on('lop.maLop','=','phieuks_ctdt.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('ndks_ctdt', function($a){
            $a->on('ndks_ctdt.id_pksctdt','=','phieuks_ctdt.id')
            ->where('ndks_ctdt.isDelete', false);
        })
        ->join('cdr_cd3', function($a){
            $a->on('cdr_cd3.maCDR3','=','ndks_ctdt.maCDR3')
            ->where('cdr_cd3.isDelete', false);
        })
        ->distinct(['ndks_ctdt.maHocPhan','phieuks_ctdt.id'])
        ->get(['phieuks_ctdt.maSSV','phieuks_ctdt.maLop', 'cdr_cd3.maCDR3', 'phieuks_ctdt.id']);
        
        ////////////////////pks_cabet///////////////////////////
        $pks_cabet=phieuks_ctdt::where('phieuks_ctdt.isDelete',false)->where('maSSV',Session::get('maSSV')) 
        ->join('lop', function($c){
            $c->on('lop.maLop','=','phieuks_ctdt.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('ndks_ctdt', function($a){
            $a->on('ndks_ctdt.id_pksctdt','=','phieuks_ctdt.id')
            ->where('ndks_ctdt.isDelete', false);
        })
        ->join('chuan_abet', function($a){
            $a->on('chuan_abet.maChuanAbet','=','ndks_ctdt.maChuanAbet')
            ->where('chuan_abet.isDelete', false);
        })->distinct(['phieuks_ctdt.id'])
        ->get(['phieuks_ctdt.maSSV', 'phieuks_ctdt.maLop', 'phieuks_ctdt.id','chuan_abet.maChuanAbet']);
                                 
        return view('sinhvien.chuongtrinhdaotao.ctdt',['giangday'=>$sv,'hocphan'=>$hp,'pks_cdr'=>$pks_cdr, 'pks_cabet'=>$pks_cabet,
        'giangvien'=>$giangvien,'lop'=>$lop]);
    } 
}
