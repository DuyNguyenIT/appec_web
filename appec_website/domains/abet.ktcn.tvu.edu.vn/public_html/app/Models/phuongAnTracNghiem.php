<?php

namespace App\Models;

use App\Models\CDR3;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class phuongAnTracNghiem extends Model
{
    use HasFactory;
    protected $table = 'phuong_an_trac_nghiem';
    protected $fillable = ['noiDungPA','diemPA','maCauHoi','isCorrect','maCDR3', 'maChuanAbet'];
    
    public function cdr3(): BelongsTo
    {
        return $this->belongsTo(CDR3::class, 'maCDR3', 'maCDR3');
    }  
    
}
