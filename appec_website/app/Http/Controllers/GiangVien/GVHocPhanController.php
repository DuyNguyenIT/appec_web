<?php

namespace App\Http\Controllers\GiangVien;

use Session;
use App\Models\CDR3;
use App\Models\giangDay;
use App\Models\sinhVien;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\hocPhan_ctDaoTao;
use App\Http\Controllers\Controller;

class GVHocPhanController extends Controller
{
    public function index(Type $var = null)
    {
        $gd=giangDay::where('giangday.isDelete',false)->where('maGV',Session::get('maGV'))
        ->join('hoc_phan',function($q){
            $q->on('hoc_phan.maHocPhan','=','giangday.maHocPhan')
                ->where('hoc_phan.isDelete',false);
        })->groupBy('maBaiQH')->distinct()
        ->get();
        return view('giangvien.hocphan.hocphan',['gd'=>$gd]);
    }
    ////////////////---------------Xem kết quả học tập của học phần
    public function xem_ket_qua_hoc_tap($maHocPhan)
    {
        try {
        
            $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
            ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
            
            // ->join('hoc_phan',function($x){
            //     $x->on('hocphan_kqht_hp.maHocPhan','=','hoc_phan.maHocPhan')
            //     ->where('hoc_phan.isDelete',false);
            // })
            ->join('kqht_hp',function($y){
                $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
                ->where('kqht_hp.isDelete',false);
            })
            ->join('cdr_cd3',function($t){
                $t->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
                ->where('cdr_cd3.isDelete',false);
            })
            ->get();
           
            return view('giangvien.hocphan.xemkqht',['kqht'=>$kqht]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    ////////////////---------------Sửa kết quả học tập của học phần

    public function sửa_ket_qua_hoc_tap(Request $request)
    {
        # code...
    }

    ////////////////---------------Xem danh sách sinh viên giảng dạy
    public function xem_ds_sv_giang_day($maLop)
    {
        $dssv=sinhVien::where('isDelete',false)->where('maLop',$maLop)->get();
        return view('giangvien.hocphan.xemdssinhvien',['dssv'=>$dssv]);
    }


    ////////////////---------------Xem học phần thông qua chương trình đào tạo
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

    ////////////////---------------Giảng viên dạy học phần
    public function giang_vien_day_hoc_phan(Type $var = null)
    {
        # code...
    }

    ////////////////---------------Chuẩn đầu ra đáp ứng giảng dạy
    public function chuan_dau_ra_dap_ung_giang_day($maHocPhan,$maLop,$maHK,$namHoc,$maBaiQH)
    {   
        //maGV
        $maGV=Session::get('maGV');
        Session::put('maHocPhan',$maHocPhan);
        Session::put('maHK',$maHK);
        Session::put('namHoc',$namHoc);
        Session::put('maBaiQH',$maBaiQH);
        Session::put('maLop',$maLop);

        //maHocPhan, maHK, namHoc
        $gd=giangDay::where('giangday.isDelete',false)
        ->where('giangday.maGV',$maGV)
        ->where('giangday.maHocPhan',$maHocPhan)
        ->where('giangday.maHK',$maHK)
        ->where('giangday.namHoc',$namHoc)
        ->where('giangday.maLop',$maLop)
        ->join('cdr_cd3',function($x){
            $x->on('giangday.maCDR3','=','cdr_cd3.maCDR3')
            ->where('giangday.isDelete',false);
        })
        ->get();

        $cdr3=CDR3::where('isDelete',false)
        ->get();
        return view('giangvien.hocphan.cdr_dap_ung_gd',['chuandaura'=>$gd,'cdr3'=>$cdr3]);

    }

    ////////////////---------------Thêm chuẩn đầu ra
    public function them_chuan_dau_ra(Request $request)
    {
        $gd=new giangDay();
        $gd->maHocPhan=Session::get('maHocPhan');
        $gd->maHK=Session::get('maHK');
        $gd->namHoc=Session::get('namHoc');
        $gd->maGV=Session::get('maGV');
        $gd->maBaiQH=Session::get('maBaiQH');
        $gd->maCDR3=$request->maCDR3;
        $gd->maLop=Session::get('maLop');
        $gd->save();
        return redirect('/giang-vien/hoc-phan/chuan-dau-ra-dap-ung-giang-day/'.Session::get('maHocPhan').'/'.Session::get('maLop').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maBaiQH'));
    }

    ////////////////---------------Sửa chuẩn đầu ra
    public function sua_chuan_dau_ra(Request $request)
    {
        $gd=giangDay::where('isDelete',false)
        ->where('maCDR3',$request->maCDR3_old)
        ->where('maBaiQH',Session::get('maBaiQH'))
        ->first();
        $gd->delete();  
        // $gd->maCDR3=$request->maCDR3;
        // $gd->save();

        return redirect('/giang-vien/hoc-phan/chuan-dau-ra-dap-ung-giang-day/'.Session::get('maHocPhan').'/'.Session::get('maLop').'/'.Session::get('maHK').'/'.Session::get('namHoc').'/'.Session::get('maBaiQH'));

    }
}
