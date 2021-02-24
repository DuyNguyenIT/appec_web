<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hocPhan_ppGiangDay extends Model
{
    use HasFactory;
    protected $table='hocphan_ppgiangday';
    public $fillable=['maHocPhan','maPP','dienGiai','isDelete'];

    /**
     * Get the user that owns the hocPhan_ppGiangDay
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ppGiangDay()
    {
        return $this->belongsTo('App\Models\ppGiangDay', 'maPP', 'maPP');
    }
}
