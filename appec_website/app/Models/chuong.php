<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chuong extends Model
{
    use HasFactory;
    protected $table='chuong';
    protected $fillable=['tenchuong','tenkhongdau','soTietLT','soTietTH','soTietKhac','mota','maHocPhan','isdelete'];
    
    public function hocphan()
    {
        return $this->belongsTo('App\Models\hocPhan', 'maHocPhan', 'maHocPhan');
    }

    public function muc()
    {
        return $this->hasMany('App\Models\muc', 'id_chuong', 'id');
    }
    
    public function chuong_kqht()
    {
        return $this->hasMany('App\Models\chuong_kqht', 'machuong', 'id');
    }


    #----------------function---------------
    public static function get_one_chuong_by_id($id)
    {
        return self::where('isDelete',false)->where('id',$id)->first();
    }

    public static function get_chuong_by_maHocPhan($maHocPhan)
    {
        return self::where('maHocPhan',$maHocPhan)->get();
    }

    

}