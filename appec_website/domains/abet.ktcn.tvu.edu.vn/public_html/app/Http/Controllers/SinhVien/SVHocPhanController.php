<?php

namespace App\Http\Controllers\sinhvien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SVHocPhanController extends Controller
{
    public function index()
    {
        $sv=sinhVien::where('sinh_vien.isDelete',false)->where('maSSV',Session::get('maSSV'))
        ->join('lop', function($a){
            $a->on('lop.maLop','=','sinh_vien.maLop')
            ->where('lop.isDelete',false);
        })       
        ->join('giangday',function($q){
            $q->on('giangday.maLop','=','lop.maLop')
                ->where('giangday.isDelete',false);
        })
        ->join('hoc_phan',function($x){
            $x->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })
        ->get(['hoc_phan.maHocPhan','maHK','namHoc','hoc_phan.tenHocPhan','giangday.maLop', 'sinh_vien.maSSV']);
        
        
        //học phần
        $hp=hocPhan::where('isDelete',false)
        ->get();     
        //giảng viên
        $giangvien=giangVien::where('isDelete',false)
        ->get();
        //lớp 
        $lop=lop::where('isDelete',false)->get();
       
        
        //giang day 
       $gd_data=giangDay::where('giangday.isDelete',false)
        ->get();
        foreach ($sv as $x) {
            $gv=[];
            foreach ($gd_data as $y) {
                if($y->maHocPhan==$x->maHocPhan && $y->maHK==$x->maHK && $y->namHoc==$x->namHoc && $y->maLop==$x->maLop){
                    if(!array_search($y->maGV,$gv))
                        array_push($gv,$y->maGV);
                        
                }
                $temp=[];
                foreach (array_unique($gv) as $t) { 
                    $temp_gv=giangVien::where('isDelete',false)
                    ->where('maGV',$t)
                    ->first();
                    array_push($temp,$temp_gv);
                }
                $x->GV=$temp;
            }
        }
        
        return view('sinhvien.hocphan.hocphan',['giangday'=>$sv,'hocphan'=>$hp,
        'giangvien'=>$giangvien,'lop'=>$lop]);
    }
    public function monhoc($maHocPhan)
    {
        $giangday=giangDay::where('giangday.maHocPhan',$maHocPhan)->where('giangday.isDelete',false)
        
        ->join('hoc_phan', function($c){
            $c->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })
        ->join('giang_vien', function($c){
            $c->on('giang_vien.maGV','=','giangday.maGV')
            ->where('giang_vien.isDelete',false);
        })
        ->join('lop', function($c){
            $c->on('lop.maLop','=','giangday.maLop')
            ->where('lop.isDelete',false);
        })
       
        ->join('sinh_vien',function($b){   
            $b->on('sinh_vien.maLop','=','lop.maLop')->where('maSSV',Session::get('maSSV'))
            ->where('sinh_vien.isDelete',false);   
         })->get();
         
      
        //học phần
        $hp=hocPhan::where('isDelete',false)
        ->get();     
        //giảng viên
        $giangvien=giangVien::where('isDelete',false)
        ->get();
        //lớp 
        $lop=lop::where('isDelete',false)->get();
        
        ///// dieu kien trung lap trong pks_kqht ///////
        
        $pks_kqht=phieu_khao_sat::where('phieu_khao_sat.maHocPhan',$maHocPhan)->where('phieu_khao_sat.isDelete',false)->where('maSSV',Session::get('maSSV')) 
        ->join('lop', function($c){
            $c->on('lop.maLop','=','phieu_khao_sat.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('noi_dung_pks', function($a){
            $a->on('noi_dung_pks.id_pks','=','phieu_khao_sat.id')
            ->where('noi_dung_pks.isDelete', false);
        })
        ->join('kqht_hp', function($a){
            $a->on('kqht_hp.maKQHT','=','noi_dung_pks.maKQHT')
            ->where('kqht_hp.isDelete', false);
        })
        ->distinct(['noi_dung_pks.maHocPhan','phieu_khao_sat.id'])    
        ->get(['phieu_khao_sat.maSSV', 'phieu_khao_sat.maHocPhan','phieu_khao_sat.maLop', 'kqht_hp.maKQHT','phieu_khao_sat.id']);
        

        /////////pks_cdr3//////////
        $pks_cdr=phieu_khao_sat::where('phieu_khao_sat.maHocPhan',$maHocPhan)->where('phieu_khao_sat.isDelete',false)->where('maSSV',Session::get('maSSV')) 
        ->join('lop', function($c){
            $c->on('lop.maLop','=','phieu_khao_sat.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('noi_dung_pks', function($a){
            $a->on('noi_dung_pks.id_pks','=','phieu_khao_sat.id')
            ->where('noi_dung_pks.isDelete', false);
        })
        ->join('cdr_cd3', function($a){
            $a->on('cdr_cd3.maCDR3','=','noi_dung_pks.maCDR3')
            ->where('cdr_cd3.isDelete', false);
        })
        ->distinct(['noi_dung_pks.maHocPhan','phieu_khao_sat.id'])
        ->get(['phieu_khao_sat.maSSV', 'phieu_khao_sat.maHocPhan','phieu_khao_sat.maLop', 'cdr_cd3.maCDR3', 'phieu_khao_sat.id']);
        
        ////////////////////pks_cabet///////////////////////////
        $pks_cabet=phieu_khao_sat::where('phieu_khao_sat.maHocPhan',$maHocPhan)->where('phieu_khao_sat.isDelete',false)->where('maSSV',Session::get('maSSV')) 
        ->join('lop', function($c){
            $c->on('lop.maLop','=','phieu_khao_sat.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('noi_dung_pks', function($a){
            $a->on('noi_dung_pks.id_pks','=','phieu_khao_sat.id')
            ->where('noi_dung_pks.isDelete', false);
        })
        ->join('chuan_abet', function($a){
            $a->on('chuan_abet.maChuanAbet','=','noi_dung_pks.maChuanAbet')
            ->where('chuan_abet.isDelete', false);
        })->distinct(['noi_dung_pks.maHocPhan','phieu_khao_sat.id'])
        ->get(['phieu_khao_sat.maSSV', 'phieu_khao_sat.maHocPhan','phieu_khao_sat.maLop', 'phieu_khao_sat.id','chuan_abet.maChuanAbet']);
      
        return view('sinhvien.hocphan.khaosathocphan',['giangday'=>$giangday,'hocphan'=>$hp,'pks_kqht'=>$pks_kqht,'pks_cdr'=>$pks_cdr,'pks_cabet'=>$pks_cabet,
        'giangvien'=>$giangvien,'lop'=>$lop]);
    }

}
