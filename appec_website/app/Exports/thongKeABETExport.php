<?php

namespace App\Exports;

use Session;
use App\Models\ctDaoTao;
use App\Models\chuan_abet;
use App\Models\hocPhan_kqHTHP;
use App\Models\hocPhan_ctDaoTao;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class thongKeABETExport implements FromView
{
    public function view(): View
    {
        $maCT=Session::get('maCT');
        $ctdt=ctDaoTao::where('isDelete',false)->where('maCT',$maCT)->first();
        $hp_ctdt=hocPhan_ctDaoTao::where('hocphan_ctdaotao.isDelete',false)->where ('maCT',$maCT)
        ->join('hoc_phan',function($a){
            $a->on('hoc_phan.maHocPhan','=','hocphan_ctdaotao.maHocPhan')
            ->where('hoc_phan.isDelete',false);
        }) 
        ->get();
       
          $hp_kqhthp=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
          ->join('cdr_cd3',function($a){
           $a->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
           ->where('cdr_cd3.isDelete',false);
           })
           ->join('kqht_hp',function($b){
               $b->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
               ->where('kqht_hp.isDelete',false);
               })
          ->get();
           
        $chuan_abet=chuan_abet::where('isDelete',false)->get();

        return view('admin.thongke.viewExportThongKeABET',['ctdt'=>$ctdt,'hp_ctdt'=>$hp_ctdt,'hp_kqhthp'=>$hp_kqhthp,'chuan_abet'=>$chuan_abet]);
    }
}
