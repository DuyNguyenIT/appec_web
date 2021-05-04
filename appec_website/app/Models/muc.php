<?php

namespace App\Models;

use App\Models\chuong;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class muc extends Model
{
    use HasFactory;
    protected $table = 'muc';
    protected $fillable = ['maMucVB','tenMuc','id_chuong'];

    public function chuong()
    {
        return $this->belongsTo(chuong::class, 'id_chuong', 'id');
    }

    ##-----------function-----------
    public static function get_all()
    {
        return self::all();
    }

    public static function get_by_id($id)
    {
        return self::find($id);
    }

    public static function get_by_machuong($maChuong)
    {
        return self::where('id_chuong',$maChuong)->get();
    }

    

}
