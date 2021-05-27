<?php

namespace App\Models;

use App\Models\phuongAnTuLuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class dethi_cauhoituluan extends Model
{
    use HasFactory;
    protected $table = 'de_thi_cauhoi_tuluan';
    protected $fillable = ['maDe','maCauHoi','maPATL'];
    /**
     * Get the user associated with the dethi_cauhoituluan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function phuong_an_tu_luan(): HasOne
    {
        return $this->hasOne(phuongAnTuLuan::class, 'maPATL', 'maPATL');
    }
}
