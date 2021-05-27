<?php

namespace App\Http\Controllers\sinhvien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SV_PKS_ABETController extends Controller
{
    public function index($maHocPhan, $maLop){
      
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)
        ->where('isDelete',false)->first();
        
        $lop=lop::where('maLop', $maLop)->where('isDelete',false)->first();
        $chuanabet=chuan_abet::all();
        $giangday=giangDay::where('maHocPhan',$maHocPhan)->where('giangday.isDelete',false)
        ->join('lop', function($a){
            $a->on('lop.maLop','=','giangday.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('sinh_vien',function($b){   
            $b->on('sinh_vien.maLop','=','lop.maLop')->where('maSSV',Session::get('maSSV'))
            ->where('sinh_vien.isDelete',false);   
         })
         ->get(['maHocPhan', 'lop.maLop','maHK','namHoc', 'sinh_vien.maSSV', 'sinh_vien.HoSV', 'sinh_vien.TenSV']);

        $cdr1=CDR1::all();

        $cdr=CDR1::join('cdr_cd2',function($x){ 
            $x->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd3',function($x){
            $x->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get();
        
        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false)
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->join('chuan_abet',function($t){
            $t->on('chuan_abet.maChuanAbet','=','hocphan_kqht_hp.maChuanAbet')
            ->where('chuan_abet.isDelete',false);
        })->groupBy('hocphan_kqht_hp.maChuanAbet')
        ->join('cdr_cd3',function($y){
            $y->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })    
        ->join('cdr_cd2',function($t){
            $t->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd1',function($t){
            $t->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd1.isDelete',false);
        })
        ->distinct(['hocphan_kqht_hp.maHocPhan','cdr_cd1.maCDR1' ,'hocphan_kqht_hp.maChuanAbet'])/**/
        ->get(['hocphan_kqht_hp.maHocPhan','cdr_cd1.maCDR1','hocphan_kqht_hp.maChuanAbet','chuan_abet.maChuanAbetVB','chuan_abet.tenChuanAbet']);
       
        return view('sinhvien.hocphan.pks_chuanabet',
        ['maHocPhan'=>$maHocPhan,'hocPhan'=>$hocPhan,'CDR1'=>$cdr1,'cdr'=>$cdr,'kqht'=>$kqht, 'giangday'=>$giangday,'lop'=>$lop ]);
    }

    public function guiks_chuanabet(Request  $request, $maHocPhan)
    { 
        
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)
        ->where('isDelete',false)->first();
        $chuanabet=chuan_abet::where('isDelete',false)->get();
        
        $giangday=giangDay::where('maHocPhan',$maHocPhan)->where('giangday.isDelete',false)
        
        ->join('lop', function($c){
            $c->on('lop.maLop','=','giangday.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('sinh_vien',function($b){   
            $b->on('sinh_vien.maLop','=','lop.maLop')->where('maSSV',Session::get('maSSV'))
            ->where('sinh_vien.isDelete',false);   
         })->first();
         
      /*    ->join('giang_vien', function($a){
            $a->on('giang_vien.maGV','=','giangday.maGV')
            ->where('giang_vien.isDelete',false);
        })
        ->join('lop', function($c){
            $c->on('lop.maLop','=','giangday.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('sinh_vien',function($b){   
            $b->on('sinh_vien.maLop','=','lop.maLop')->where('maSSV',Session::get('maSSV'))
            ->where('sinh_vien.isDelete',false);   
         })
         ->get(['maHocPhan','giangday.maGV', 'giang_vien.hoGV', 'giang_vien.tenGV','lop.maLop','maHK','namHoc', 'sinh_vien.maSSV', 'sinh_vien.HoSV', 'sinh_vien.TenSV']);
        */
        
        $pks =new phieu_khao_sat();  
        
       // $pks->ngaykhaosat=Carbon::now();

        $pks->maHocPhan=$giangday->maHocPhan;
        $pks->maLop=$giangday->maLop;
        $pks->maGV=$giangday->maGV;
        $pks->maHK=$giangday->maHK;
        $pks->namHoc=$giangday->namHoc;
        $pks->maSSV=$giangday->maSSV;
        
        $pks->save();
     
    $kqht=hocPhan_kqHTHP::where('maHocPhan',$maHocPhan)->where('hocphan_kqht_hp.isDelete',false)
       ->distinct(['hocphan_kqht_hp.maHocPhan','cdr_cd1.maCDR1'])
         ->get(['hocphan_kqht_hp.maHocPhan','hocphan_kqht_hp.maChuanAbet',]);
        
        $array=[]; // khai bao mang A
       
        $array1=[];
        //for($i=0;$i<count($kqht);$i++){
            foreach ($kqht as  $value) { 
            
                array_push($array,$request['muc_'.$value->maChuanAbet ]); //['muc_'.$value->id ]) lay name="cau_{{ $ndks->khaosat['id'] }}" de lay vi tri radio da chon.
                array_push($array1,$value->maChuanAbet );
                
            }// $request goi lai vi tri da chon gan cho mang $array
                $result = array_merge($array, $array1);// xuat gia tri $array da duoc gan
               
       $pks = phieu_khao_sat::where('maHocPhan',$maHocPhan)->orderBy('id', 'DESC')->first();
     
        for($i=0;$i<count($kqht);$i++){

            $ndpks=new noi_dung_pks();
            $ndpks->maHocPhan=$pks->maHocPhan;
            $ndpks->id_pks=$pks->id;
            $ndpks->maKQHT=null;
            $ndpks->maCDR3=null;
            $ndpks->maChuanAbet=$kqht[$i]->maChuanAbet ;

            $ndpks->maMucDoDG=$array[$i];
            $ndpks->save();
          
        }
        return redirect('sinh-vien/hoc-phan/pks-chuanabet/'.$maHocPhan.'/'.$giangday->maLop)->with('success','Gửi thành công!!!');
    }
}
