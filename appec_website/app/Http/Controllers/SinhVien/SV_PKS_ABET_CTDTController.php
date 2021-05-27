<?php

namespace App\Http\Controllers\sinhvien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SV_PKS_ABET_CTDTController extends Controller
{
    public function index($maLop,$maSSV){
     
        $lop=lop::where('maLop', $maLop)->where('isDelete',false)->first();
        


        $sv=sinhVien::where('sinh_vien.isDelete',false)->where('maSSV',$maSSV)  
        ->join('lop',function($b){   
            $b->on('lop.maLop','=','sinh_vien.maLop')
            ->where('lop.isDelete',false);   
         })
        ->join('giangday',function($q){
            $q->on('giangday.maLop','=','lop.maLop')
                ->where('giangday.isDelete',false);
        })
        ->get(['giangday.maHK','giangday.namHoc','sinh_vien.maLop', 'sinh_vien.maSSV']);
        $ctdt=chuan_abet::where('chuan_abet.isDelete',false)
        ->get(['chuan_abet.maChuanAbetVB', 'chuan_abet.maChuanAbet','chuan_abet.tenChuanAbet']);
                                            
    
        return view('sinhvien.chuongtrinhdaotao.pks_cabet_ctdt',['ctdt'=>$ctdt,'sv'=>$sv, 'lop'=>$lop]);
    }

    public function guiks_ctdt(Request  $request, $maLop)
    {  
        $lop=lop::where('maLop',$maLop)
        ->where('isDelete',false)->first();
        $cabet=chuan_abet::where('isDelete',false)->get();
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

         $ctdt=chuan_abet::where('chuan_abet.isDelete',false)
         ->get(['chuan_abet.maChuanAbetVB', 'chuan_abet.maChuanAbet','chuan_abet.tenChuanAbet']);
                   
        
         $array=[]; // khai bao mang A
        
         $array1=[];
         //for($i=0;$i<count($kqht);$i++){
             foreach ($ctdt as  $value) { 
            
                 array_push($array,$request['muc_'.$value->maChuanAbet ]); //['muc_'.$value->id ]) lay name="cau_{{ $ndks->khaosat['id'] }}" de lay vi tri radio da chon.
                 array_push($array1,$value->maChuanAbet);
                
           }// $request goi lai vi tri da chon gan cho mang $array
                 $result = array_merge($array, $array1);// xuat gia tri $array da duoc gan
       
      $pks = phieuks_ctdt::where('maLop',$maLop)->orderBy('id', 'DESC')->first();
     
        for($i=0;$i<count($ctdt);$i++){

             $ndpks=new ndks_ctdt();

             $ndpks->id_pksctdt=$pks->id;
             $ndpks->maCDR3=null;
             $ndpks->maChuanAbet=$ctdt[$i]->maChuanAbet;
             $ndpks->maMucDoDG=$array[$i];
             $ndpks->save();
          
         }
       
        return redirect('sinh-vien/khao-sat-ctdt/khao-sat-chuanabet/'.$maLop.'/'.$giangday->maSSV)->with('success','Gửi thành công!!!');
    }
}
