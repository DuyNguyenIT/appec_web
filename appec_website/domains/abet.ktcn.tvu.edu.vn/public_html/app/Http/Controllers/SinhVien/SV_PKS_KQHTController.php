<?php

namespace App\Http\Controllers\sinhvien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SV_PKS_KQHTController extends Controller
{
    public function index($maHocPhan, $maLop){
        
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)
        ->where('isDelete',false)->first();
        $pks=phieu_khao_sat::all();
        $lop=lop::where('maLop', $maLop)->where('isDelete',false)->first();

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
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })->groupBy('hocphan_kqht_hp.maKQHT')
        // ->join('chuan_abet',function($t){
        //     $t->on('chuan_abet.maChuanAbet','=','hocphan_kqht_hp.maChuanAbet')
        //     ->where('chuan_abet.isDelete',false);
        // })
        ->join('cdr_cd3',function($t){
            $t->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
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
        ->distinct(['hocphan_kqht_hp.id','hocphan_kqht_hp.maHocPhan','hocphan_kqht_hp.maKQHT','cdr_cd1.maCDR1'])
        ->get(['hocphan_kqht_hp.maHocPhan','hocphan_kqht_hp.maKQHT','kqht_hp.maKQHTVB','cdr_cd1.maCDR1',
        'kqht_hp.tenKQHT']);
        
       
            return view('sinhvien.hocphan.pks_kqht',
        ['maHocPhan'=>$maHocPhan,'hocPhan'=>$hocPhan,'CDR1'=>$cdr1,'cdr'=>$cdr,'kqht'=>$kqht, 'giangday'=>$giangday,'lop'=>$lop ]);

        
        }

    public function guiks_kqht(Request  $request, $maHocPhan)
    { 
        
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)
        ->where('isDelete',false)->first();
        
        $giangday=giangDay::where('maHocPhan',$maHocPhan)->where('giangday.isDelete',false)
        
        ->join('lop', function($c){
            $c->on('lop.maLop','=','giangday.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('sinh_vien',function($b){   
            $b->on('sinh_vien.maLop','=','lop.maLop')->where('maSSV',Session::get('maSSV'))
            ->where('sinh_vien.isDelete',false);   
         })->first();
        

                    $pks =new phieu_khao_sat();  

                    $pks->maHocPhan=$giangday->maHocPhan;
                    $pks->maLop=$giangday->maLop;
                    $pks->maGV=$giangday->maGV;
                    $pks->maHK=$giangday->maHK;
                    $pks->namHoc=$giangday->namHoc;
                    $pks->maSSV=$giangday->maSSV;
                    $pks->maSSV=$giangday->maSSV;
                    $pks->save(); 
  
        $kqht=hocPhan_kqHTHP::where('maHocPhan',$maHocPhan)->where('hocphan_kqht_hp.isDelete',false)
        ->distinct(['hocphan_kqht_hp.id','hocphan_kqht_hp.maHocPhan','hocphan_kqht_hp.maKQHT','cdr_cd1.maCDR1'])
         ->get(['hocphan_kqht_hp.maHocPhan','hocphan_kqht_hp.maKQHT',]);
         
        $array=[]; // khai bao mang A
        
        $array1=[];
        //for($i=0;$i<count($kqht);$i++){
            foreach ($kqht as  $value) { 
            
                array_push($array,$request['muc_'.$value->maKQHT ]); //['muc_'.$value->id ]) lay name="cau_{{ $ndks->khaosat['id'] }}" de lay vi tri radio da chon.
                array_push($array1,$value->maKQHT);
                
            }// $request goi lai vi tri da chon gan cho mang $array
       //  } 
       $result = array_merge($array, $array1);// xuat gia tri $array da duoc gan
          
       $pks = phieu_khao_sat::where('maHocPhan',$maHocPhan)->orderBy('id', 'DESC')->first();
     
        for($i=0;$i<count($kqht);$i++){

            $ndpks=new noi_dung_pks();
            $ndpks->maHocPhan=$pks->maHocPhan;
            $ndpks->id_pks=$pks->id;
            $ndpks->maKQHT=$kqht[$i]->maKQHT;
            $ndpks->maCDR3=null;
            $ndpks->maChuanAbet=null;

            $ndpks->maMucDoDG=$array[$i];
            $ndpks->save();
          
        }
       
        return redirect('sinh-vien/hoc-phan/pks-kqht/'.$maHocPhan.'/'.$giangday->maLop)->with('success','Gửi thành công!!!');
    }
}
