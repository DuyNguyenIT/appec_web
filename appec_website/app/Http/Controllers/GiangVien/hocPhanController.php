<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use App\Models\bacDaoTao;
use App\Models\ctDaoTao;
use App\Models\giangDay;
use App\Models\hocPhan_ctDaoTao;
use App\Models\hocPhan_kqHTHP;
use App\Models\sinhVien;
use Illuminate\Http\Request;
use Session;

class hocPhanController extends Controller
{
    public function index(Type $var = null)
    {
        $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
        
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
        })
        ->get();
        return view('giangvien.hocphan.hocphan',['gd'=>$gd]);
    }

    public function xem_ket_qua_hoc_tap($maHocPhan)
    {
        try {
        
            $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
            ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
            ->join('hoc_phan',function($x){
                $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
                ->where('hoc_phan.isDelete',false);
            })
            ->join('kqht_hp',function($y){
                $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
                ->where('kqht_hp.isDelete',false);
            })
            ->join('kqht_hp_cdrcd3',function($z){
                $z->on('kqht_hp_cdrcd3.maKQHT','=','hocphan_kqht_hp.maKQHT')
                ->where('kqht_hp_cdrcd3.isDelete',false);
            })
            ->join('cdr_cd3',function($t){
                $t->on('cdr_cd3.maCDR3','=','kqht_hp_cdrcd3.maCDR3')
                ->where('cdr_cd3.isDelete',false);
            })
            ->get();

            return view('giangvien.hocphan.xemkqht',['kqht'=>$kqht]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function xem_ds_sv_giang_day($maLop)
    {
        $dssv=sinhVien::where('isDelete',false)->where('maLop',$maLop)->get();
        return view('giangvien.hocphan.xemdssinhvien',['dssv'=>$dssv]);
    }

    public function hocPhanViaCTDT($maCT)
    {
        try {
            $hp_ct=hocPhan_ctDaoTao::where('hocphan_ctdaotao.isDelete',false)->where('maCT',$maCT)
            ->join('hoc_phan',function($q){
                $q->on('hocphan_ctdaotao.maHocPhan','=','hoc_phan.maHocPhan')
                    ->where('hoc_phan.isDelete',false);
            })
            ->get();
            return response()->json($hp_ct);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function giang_vien_day_hoc_phan(Type $var = null)
    {
        # code...
    }
}
