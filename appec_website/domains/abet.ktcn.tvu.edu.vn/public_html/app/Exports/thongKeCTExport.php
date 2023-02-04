<?php

namespace App\Exports;

use Session;
use App\Models\ctDaoTao;
use App\Models\ctDaoTao_CDR1;
use App\Models\hocPhan_ctDaoTao;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\hocPhan_kqHTHP;

class thongKeCTExport implements FromView
{
    public function view(): View
    {
        $maCT=Session::get('maCT');
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
           $temp=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) ->where ('maHocPhan',$chon->maHocPhan)
           ->groupBy('hocphan_kqht_hp.maHocPhan', 'hocphan_kqht_hp.maCDR3')->distinct()
           ->get();
            foreach ($temp as $t) {
                array_push($hp_cdr3,$t);
            }
        }
        return view('admin.thongke.viewExportThongKeCTCDR3', [
            'ctdt_cdr'=>$ctdt_cdr,'ctdt'=>$ctdt,'hp_ctdt'=>$hp_ctdt,'hp_cdr3'=>$hp_cdr3
        ]);
    }
}
