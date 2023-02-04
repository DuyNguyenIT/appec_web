<?php

namespace App\Models;


use App\Models\CDR3;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cdr3_abet extends Model
{
    use HasFactory;
    protected $table = 'cdr_cd3_chuan_abet';
    protected $fillable = ['maCDR3','maChuanAbet','created_at','updated_at'];

    //cdr3
    public function cdr_cd3()
    {
        return $this->belongsTo(CDR3::class, 'maCDR3', 'maCDR3');
    }
    //chuan abets
    public function chuanAbet()
    {
        return $this->belongsTo(chuan_abet::class, 'maChuanAbet', 'maChuanAbet');
    }

}
