<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hocPhan_kqHTHP extends Model
{
    use HasFactory;
    protected $table='hocphan_kqht_hp';
    public $fillable=['maHocPhan','maKQHT','maCDR3','maChuanAbet','isDelete'];

    ##-------------------function---------
    public static function get_kqht_cdr3_abet($maHocPhan)
    {
        return self::where('hocphan_kqht_hp.isDelete',false) 
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->Leftjoin('chuan_abet',function($y){
            $y->on('chuan_abet.maChuanAbet','=','hocphan_kqht_hp.maChuanAbet')
            ->where('chuan_abet.isDelete',false);
        })
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->orderBy('kqht_hp.maKQHT')
        ->join('cdr_cd3',function($t){
            $t->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->join('cdr_cd2',function($t){
            $t->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd1',function($t){
            $t->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd1.isDelete',false);
        })
        ->get();
    }
}