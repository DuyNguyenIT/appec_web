<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ctDaoTao;
use App\Models\hocPhan;
use App\Models\hocPhan_kqHTHP;
use App\Models\hocPhan_ctDaoTao;
use App\Models\ctDaoTao_CDR1;
use App\Models\CDR1;
use App\Models\CDR2;
use App\Models\CDR3;


class thongKeController extends Controller
{
    //
    public function index(Type $var = null)
    {
        $ctdt=ctDaoTao::where('isDelete',false)->orderBy('maCT','desc')->get();
        
        return view('admin.thongke.thongke',['ctdaotao'=>$ctdt]);
    }
    //thống kê CDR cấp độ 3 theo từng chương trình
    public function thong_ke_CT_theo_CDR3($maCT)
    {
        //Session::put('maCT',$maCT);
       
        $ctdt=ctDaoTao::where('isDelete',false)->where('maCT',$maCT)->first();
        
        $ctdt_cdr=ctDaoTao_CDR1::where('ctdt_cdrcd1.isDelete',false) ->where('maCT',$maCT)
        ->join('cdr_cd1',function($x){
            $x->on('cdr_cd1.maCDR1','=','ctdt_cdrcd1.maCDR1')
            ->where('cdr_cd1.isDelete',false);
        })
        ->join('cdr_cd2',function($y){
            $y->on('cdr_cd2.maCDR1','=','cdr_cd1.maCDR1')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd3',function($z){
            $z->on('cdr_cd3.maCDR2','=','cdr_cd2.maCDR2')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get();

        $hp_ctdt=hocPhan_ctDaoTao::where('hocphan_ctdaotao.isDelete',false)->where ('maCT',$maCT)
        ->join('hoc_phan',function($a){
            $a->on('hoc_phan.maHocPhan','=','hocphan_ctdaotao.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        }) 
        ->get();

        $hp_cdr3=[];
        foreach ($hp_ctdt as $chon) {
           $temp=hocPhan_KQHTHP::where('hocphan_kqht_hp.isDelete',false) ->where ('maHocPhan',$chon->maHocPhan)
           ->groupBy('hocphan_kqht_hp.maHocPhan', 'hocphan_kqht_hp.maCDR3')->distinct()
           ->get();
            foreach ($temp as $t) {
                array_push($hp_cdr3,$t);
            }
        }
       // return $hp_cdr3;
        /*->join('cdr_cd3',function($c){
            $c->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
            })
                ->join('hocphan_kqht_hp',function($b){
            $b->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            ->where('hocphan_kqht_hp.isDelete',false);
        }) 
        ->groupBy('hocphan_kqht_hp.maHocPhan')->distinct()
        ->groupBy('hocphan_kqht_hp.maHocPhan', 'hocphan_kqht_hp.maCDR3')->distinct()
        ->get();*/

       /* $gd_rs=giangDay::where('giangday.isDelete',false)
        ->join('hoc_phan',function($x){
            $x->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        })
        ->distinct()
        ->get(['hoc_phan.maHocPhan','maHK','namHoc','hoc_phan.tenHocPhan','giangday.maLop']); */
        /*$ldg=loaiDanhGia::where('isDelete',false)->get();
        $lhtdg=loaiHTDanhGia::where('isDelete',false)->get();
           
        $hp=hocPhan::where('maHocPhan',$maHocPhan)
        ->where('isDelete',false)->first();

        $baiQH=giangDay::where('isDelete',false)
        //->where('giangday.maGV',$maGV)
        ->where('giangday.maHocPhan',$maHocPhan)
        ->where('giangday.maHK',$maHK)
        ->where('giangday.namHoc',$namHoc)
        ->distinct()
        ->get('maBaiQH');    

        */
        return view('admin.thongke.thongkechuongtrinhCDR3',['ctdt_cdr'=>$ctdt_cdr,'ctdt'=>$ctdt,'hp_ctdt'=>$hp_ctdt,'hp_cdr3'=>$hp_cdr3]);
    }
}
