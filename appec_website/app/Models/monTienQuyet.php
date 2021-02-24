<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monTienQuyet extends Model
{
    use HasFactory;
    protected $table='mon_tien_quyet';
    public $fillable=['maHocPhan','maMonTienQuyet','isDelete'];
    /**
     * Get the user associated with the monTienQuyet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hoc_phan()
    {
        return $this->hasOne('App\Models\hocPhan', 'maHocPhan', 'maMonTienQuyet');
    }
}
