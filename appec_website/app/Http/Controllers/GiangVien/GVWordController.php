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
        $cell1->addText('Tr&#432;&#7901;ng: &#272;&#7841;i h&#7885;c Tr� Vinh',$normalText);
        $cell1->addText('L&#7899;p:.................................',$normalText);
        $cell1->addText('T�n:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA K&#7928; THU&#7852;T V� C�NG NGH&#7878;',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('H&#7884;C PH&#7846;N: '.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Th&#7901;i gian thi: '.$deThi->thoiGian.' ph�t',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('M� &#273;&#7873;: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi ch�: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--N&#7896;I DUNG &#272;&#7872; THI--',$headerForntStyle,$headerparagraphStyle);
        
        //ch�n n&#7897;i dung &#273;&#7873; thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
        $i=1;
        //t�nh &#273;i&#7875;m c�u h&#7887;i
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->sum('phuong_an_tu_luan.diemPA');
            $noidung[$i]->diem=$diem;  
        }

        foreach ($noidung as $x) {
            $section->addText('C�u '.$i.': ('.$x->diem.' &#273;i&#7875;m)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $x->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            $i++;
        }
        $section->addText('--H&#7870;T--',$headerForntStyle,$headerparagraphStyle);

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
        $cell1->addText('Tr&#432;&#7901;ng: &#272;&#7841;i h&#7885;c Tr� Vinh',$normalText);
        $cell1->addText('L&#7899;p:.................................',$normalText);
        $cell1->addText('T�n:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA K&#7928; THU&#7852;T V� C�NG NGH&#7878;',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('H&#7884;C PH&#7846;N: '.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Th&#7901;i gian thi: '.$deThi->thoiGian.' ph�t',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('M� &#273;&#7873;: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi ch�: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--N&#7896;I DUNG &#272;&#7872; THI--',$headerForntStyle,$headerparagraphStyle);
        
        //ch�n n&#7897;i dung &#273;&#7873; thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
        $i=1;
        //t�nh &#273;i&#7875;m c�u h&#7887;i
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->sum('phuong_an_tu_luan.diemPA');
            $noidung[$i]->diem=$diem;  
        }

        $i=1;
        foreach ($noidung as $x) {
            $section->addText('C�u '.$i.': ('.$x->diem.' &#273;i&#7875;m)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $x->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            $i++;
        }
        $section->addText('--H&#7870;T--',$headerForntStyle,$headerparagraphStyle);

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
        $cell1->addText('Tr&#432;&#7901;ng: &#272;&#7841;i h&#7885;c Tr� Vinh',$normalText);
        $cell1->addText('L&#7899;p:.................................',$normalText);
        $cell1->addText('T�n:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA K&#7928; THU&#7852;T V� C�NG NGH&#7878;',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('H&#7884;C PH&#7846;N: '.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Th&#7901;i gian thi: '.$deThi->thoiGian.' ph�t',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('M� &#273;&#7873;: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi ch�: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--N&#7896;I DUNG &#272;&#7872; THI--',$headerForntStyle,$headerparagraphStyle);
        
        //ch�n n&#7897;i dung &#273;&#7873; thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cau_hoi','de_thi_cau_hoi.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
       
        $i=1;
        //t�nh &#273;i&#7875;m c�u h&#7887;i
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->sum('diemPA');
            $noidung[$i]->diem=$diem;  
            $noidung[$i]->phuong_an=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->get();
        }   


        $letter=['A','B','C','D'];
        for ($i=0; $i <count($noidung) ; $i++) { 
            $section->addText('C�u '.($i+1).': ('.$noidung[$i]->diem.' &#273;i&#7875;m)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $noidung[$i]->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            for ($j=0; $j < count($noidung[$i]->phuong_an); $j++) { 
                # code...            
                $pa = $noidung[$i]->phuong_an[$j]->noiDungPA;
                $pa=substr_replace($pa, $letter[$j].'. ', 3, 0);
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $pa, false, false);
            }
        }
     
        
        $section->addText('--H&#7870;T--',$headerForntStyle,$headerparagraphStyle);

        //save file
        $filename='dethi.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }

}
