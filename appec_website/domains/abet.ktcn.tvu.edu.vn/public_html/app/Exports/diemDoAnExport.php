<?php

namespace App\Exports;

use Session;
use App\Models\deThi;
use App\Models\hocPhan;
use App\Models\giangVien;
use App\Models\ct_bai_quy_hoach;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class diemDoAnExport implements FromView
{
    
    public function view(): View
    {

        $maCTBaiQH=Session::get('maCTBaiQH');

        // loai hinh thuc danh gia
        $loaiHTDG=ct_bai_quy_hoach::where('maCTBaiQH',$maCTBaiQH)->first('maLoaiHTDG');

        //chi tiet bai quy hoach
        $ctbqh=ct_bai_quy_hoach::where('maCTBaiQH',$maCTBaiQH)->first();
        
        //lay ma can bo cham 2
        Session::put('maGV_2',$ctbqh->maGV_2);
        $gv2=giangVien::where('maGV',Session::get('maGV_2'))->first();

        //neu khong co can bo 2 thi tao ra mot can bo co ten = nhiu giang vien
        if($gv2==null){
            $gv2= new giangVien();
            $gv2->hoGV="";
            $gv2->tenGV="Nhiều giảng viên";
        }

        // lay thong tin hoc phan
        $hp=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->where('isDelete',false)->first();
        //lay thong tin giang vien dang online
        $gv=giangVien::where('isDelete',false)->where('maGV',Session::get('maGV'))->first();

        //maCTBaiQH->lay tat ca phieu cham
        $maDe=deThi::getPhieuChamByCTBQH($maCTBaiQH,Session::get('maGV'));  
        if($ctbqh->maLoaiDG<3){
            return view('giangvien.ketqua.exportViewDoan.exportDiemDoAnGiuaKi',['hp'=>$hp,'gv'=>$gv,'gv2'=>$gv2,'deThi'=>$maDe]);
        }else{
            foreach ($maDe as $md) {
                $temp=deThi::where('de_thi.isDelete',false)
                ->where('de_thi.maCTBaiQH',$maCTBaiQH)
                ->where('de_thi.maDe',$md->maDe)
                ->Join('phieu_cham',function($x) use ($md){
                        $x->on('phieu_cham.maDe','=','de_thi.maDe')
                        ->where('phieu_cham.loaiCB',2)
                        ->where('phieu_cham.maSSV',$md->maSSV)
                        ->where('phieu_cham.isDelete',false);
                })->first();
                if($temp){
                    $md->diemCB2=$temp->diemSo;
                    $md->diemTB=($md->diemSo+$temp->diemSo)/2;
                }
                
            }
        }
        return view('giangvien.ketqua.exportViewDoan.exportDiemDoAn',['hp'=>$hp,'gv'=>$gv,'gv2'=>$gv2,'deThi'=>$maDe]);
    }
}
