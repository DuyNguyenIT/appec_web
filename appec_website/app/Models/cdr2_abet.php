<?php

namespace App\Models;

use App\Models\CDR2;
use App\Models\chuan_abet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cdr2_abet extends Model
{
    use HasFactory;
    protected $table = 'cdr_cd2_chuan_abet';
    protected $fillable = ['maCDR2','maChuanAbet'];
    //cdr2
    public function cdr_cd2()
    {
        return $this->belongsTo(CDR2::class, 'maCDR2', 'maCDR2');
    }
    //chuan abets
    public function chuanAbet()
    {
        return $this->belongsTo(chuan_abet::class, 'maChuanAbet', 'maChuanAbet');
    }
}