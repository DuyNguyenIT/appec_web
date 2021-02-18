<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chuong extends Model
{
    use HasFactory;
    protected $table='chuong';
    protected $fillable=['tenchuong','tenkhongdau','mota','maHocPhan','isdelete'];
    public function hocphan()
    {
        return $this->belongsTo('App\Models\hocPhan', 'maHocPhan', 'maHocPhan');
    }
}
