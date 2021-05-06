<?php

namespace App\Http\Controllers\GiangVien;

use App\Models\CDR1;
use App\Models\deThi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\mucDoKyNangUIT;
use App\Models\dethi_cauhoituluan;
use App\Models\hocPhan_ppGiangDay;
use App\Models\phuongAnTracNghiem;
use App\Models\tai_lieu_tham_khao;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;
use App\Http\Controllers\WordController;

class GVWordController extends Controller
{

    public function in_de_cuong_mon_hoc($maHocPhan)
    {
        return WordController::in_de_cuong_mon_hoc($maHocPhan);
    }


    ####---------------------in de thi tu luan
    public function in_de_thi_tu_luan($maDe,$maHocPhan)
    {
        //t&#7841;o file word
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';
        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        $section = $phpWord->addSection();
        $deThi=deThi::where('maDe',$maDe)->first(); 
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        $table_title = $section->addTable();
        $table_title->addRow();
        $cell1 = $table_title->addCell(6000);
        $cell1->addText('Trường Đại học Trà Vinh',$normalText);
        $cell1->addText('Lớp:.................................',$normalText);
        $cell1->addText('Tên:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA KỸ THUẬT VÀ CÔNG NGHỆ',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('HỌC PHẦN: '.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Thời gian thi: '.$deThi->thoiGian.' phút',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Mã đề: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi chú: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--NỘI DUNG ĐỀ THI--',$headerForntStyle,$headerparagraphStyle);
        
        //chọn nội dung đề thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
        $i=1;
        //tính điểm câu hỏi
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->sum('phuong_an_tu_luan.diemPA');
            $noidung[$i]->diem=$diem;  
        }

        foreach ($noidung as $x) {
            $section->addText('Câu '.$i.': ('.$x->diem.' điểm)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $x->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            $i++;
        }
        $section->addText('--Hết--',$headerForntStyle,$headerparagraphStyle);

        //save file
        $filename='dethi.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }

    ##----------------------in de thi thuc hanh
    public function in_de_thi_thuc_hanh($maDe,$maHocPhan)
    {
        //tao file word
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';
        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        $section = $phpWord->addSection();
        $deThi=deThi::where('maDe',$maDe)->first(); 
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        $table_title = $section->addTable();
        $table_title->addRow();
        $cell1 = $table_title->addCell(6000);
        $cell1->addText('Trường Đại học Trà Vinh',$normalText);
        $cell1->addText('Lớp:.................................',$normalText);
        $cell1->addText('Tên:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA KỸ THUẬT VÀ CÔNG NGHỆ',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('HỌC PHẦN:'.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Thời gian thi: '.$deThi->thoiGian.' ph�t',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Mã đề: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi chú: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--NỘI DUNG ĐỀ THI--',$headerForntStyle,$headerparagraphStyle);
        
        //chon noi dung de thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
        $i=1;
        //tinh diem cau hoi
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->sum('phuong_an_tu_luan.diemPA');
            $noidung[$i]->diem=$diem;  
        }

        $i=1;
        foreach ($noidung as $x) {
            $section->addText('Câu '.$i.': ('.$x->diem.' điểm)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $x->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            $i++;
        }
        $section->addText('--Hết--',$headerForntStyle,$headerparagraphStyle);

        //save file
        $filename='dethi.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }

    ##----------------------in de thi trac nghiem
    public function in_de_thi_trac_nghiem($maDe,$maHocPhan)
    {
        //tao file word
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';
        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        $section = $phpWord->addSection();
        $deThi=deThi::where('maDe',$maDe)->first(); 
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        $table_title = $section->addTable();
        $table_title->addRow();
        $cell1 = $table_title->addCell(6000);
        $cell1->addText('Trường Đại học Trà Vinh',$normalText);
        $cell1->addText('Lớp:.................................',$normalText);
        $cell1->addText('Tên:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA KỸ THUẬT VÀ CÔNG NGHỆ',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('HỌC PHẦN: '.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Thời gian thi: '.$deThi->thoiGian.' phút',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Mã đề: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi chú: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--NỘI DUNG ĐỀ THI--',$headerForntStyle,$headerparagraphStyle);
        
        //noi dung de thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cau_hoi','de_thi_cau_hoi.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
       
        $i=1;
        //tính điểm
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->sum('diemPA');
            $noidung[$i]->diem=$diem;  
            $noidung[$i]->phuong_an=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->get();
        }   


        $letter=['A','B','C','D'];
        for ($i=0; $i <count($noidung) ; $i++) { 
            $section->addText('Câu '.($i+1).': ('.$noidung[$i]->diem.' điểm)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $noidung[$i]->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            for ($j=0; $j < count($noidung[$i]->phuong_an); $j++) { 
                # code...
                if(substr($noidung[$i]->phuong_an[$j]->noiDungPA, 0, 3) === '<p>'){
                    $pa=substr_replace($noidung[$i]->phuong_an[$j]->noiDungPA, $letter[$j].'. ', 3, 0);
                }else{
                    $pa = $letter[$j].'. '.$noidung[$i]->phuong_an[$j]->noiDungPA;
                }            
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $pa, false, false);
            }
        }
     
        $section->addText('--Hết--',$headerForntStyle,$headerparagraphStyle);
        //save file
        $filename='dethi'.$deThi->maDeVB.'_hp_'.$hocphan->maHocPhan.'.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }

}
