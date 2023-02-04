<?php

namespace App\Http\Controllers\sinhvien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SV_PKS_CDR3_CTDTController extends Controller
{
    public function index($maLop,$maSSV){
     
        $lop=lop::where('maLop', $maLop)->where('isDelete',false)->first();
        $cdr1=CDR1::all();

        $sv=sinhVien::where('maSSV', $maSSV)->where('isDelete',false)->first();

        $giangday=giangDay::where('giangday.maLop',$maLop)->where('giangday.isDelete',false)
        ->join('lop', function($a){
            $a->on('lop.maLop','=','giangday.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('sinh_vien',function($b){   
            $b->on('sinh_vien.maLop','=','lop.maLop')->where('maSSV',Session::get('maSSV'))
            ->where('sinh_vien.isDelete',false);   
         })
         ->get([ 'lop.maLop','maHK','namHoc', 'sinh_vien.maSSV', 'sinh_vien.HoSV', 'sinh_vien.TenSV']);       

        
    
        $ctdt=CDR1::join('cdr_cd2',function($x){ 
            $x->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd3',function($x){
            $x->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
            ->where('cdr_cd3.isDelete',false);
        })
         ->get(['cdr_cd3.maCDR3VB', 'cdr_cd3.maCDR3','cdr_cd1.maCDR1','cdr_cd3.tenCDR3']);
                                               
        return view('sinhvien.chuongtrinhdaotao.pks_cdr3_ctdt',['maLop'=>$maLop,'CDR1'=>$cdr1,'ctdt'=>$ctdt,'giangday'=>$giangday, 'lop'=>$lop]);
    }

    public function guiks_ctdt(Request  $request, $maLop)
    { 
       
        $lop=lop::where('maLop',$maLop)
        ->where('isDelete',false)->first();
        $cdr3=CDR3::where('isDelete',false)->get();
        $giangday=giangDay::where('giangday.maLop',$maLop)->where('giangday.isDelete',false)
        ->join('lop', function($a){
            $a->on('lop.maLop','=','giangday.maLop')
            ->where('lop.isDelete',false);
        })
        ->join('sinh_vien',function($b){   
            $b->on('sinh_vien.maLop','=','lop.maLop')->where('maSSV',Session::get('maSSV'))
            ->where('sinh_vien.isDelete',false);   
         })->first();
         
         $pks= new phieuks_ctdt();
         $pks->maLop= $giangday->maLop; 
         $pks->maSSV = $giangday->maSSV;
         
         $pks->maHK=$giangday->maHK;    
         $pks->namHoc=$giangday->namHoc;         
         $pks->save();

        $ctdt=CDR1::join('cdr_cd2',function($x){ 
            $x->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd3',function($x){
            $x->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get(['cdr_cd3.maCDR3VB', 'cdr_cd3.maCDR3','cdr_cd3.tenCDR3']);
                   
        
         $array=[]; // khai bao mang A
        
         $array1=[];
         //for($i=0;$i<count($kqht);$i++){
             foreach ($ctdt as  $value) { 
            
                 array_push($array,$request['muc_'.$value->maCDR3 ]); //['muc_'.$value->id ]) lay name="cau_{{ $ndks->khaosat['id'] }}" de lay vi tri radio da chon.
                 array_push($array1,$value->maCDR3);
                
           }// $request goi lai vi tri da chon gan cho mang $array
                 $result = array_merge($array, $array1);// xuat gia tri $array da duoc gan
       
      $pks = phieuks_ctdt::where('maLop',$maLop)->orderBy('id', 'DESC')->first();
     
        for($i=0;$i<count($ctdt);$i++){

             $ndpks=new ndks_ctdt();

             $ndpks->id_pksctdt=$pks->id;
             $ndpks->maCDR3=$ctdt[$i]->maCDR3;
             $ndpks->maChuanAbet=null;
             $ndpks->maMucDoDG=$array[$i];
             $ndpks->save();
          
         }
       
        return redirect('sinh-vien/khao-sat-ctdt/khao-sat-cdr3/'.$maLop.'/'.$giangday->maSSV)->with('success','Gửi thành công!!!');
    }
}
