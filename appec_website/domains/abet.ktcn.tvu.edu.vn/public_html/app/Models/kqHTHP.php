<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kqHTHP extends Model
{
    use HasFactory;
    protected $table='kqht_hp';
    protected $primaryKey='maKQHT';
    public $fillable=['maKQHTVB','tenKQHT', 'isDelete'];

    #----------------------function-----------
    public static function get_kqht_by_mahocphan($maHocPhan)
    {
        $kqht_arr=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->distinct('hocphan_kqht_hp.maKQHT')
        ->join('kqht_hp',function($x){
            $x->on('hocphan_kqht_hp.maKQHT','=','kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->pluck('hocphan_kqht_hp.maKQHT');
        $kqht=kqHTHP::whereIn('maKQHT',$kqht_arr)->get();
        return $kqht;
    }
}
