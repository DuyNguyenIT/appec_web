<?php

namespace App\Http\Controllers\Admin;

use App\Models\CDR1;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\monTienQuyet;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\mucDoKyNangUIT;
use App\Models\hocPhan_ppGiangDay;
use App\Models\tai_lieu_tham_khao;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;

class AdWordController extends Controller
{
    public function in_de_cuong_mon_hoc($maHocPhan)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //t&#7841;o n&#7897;i dung file
        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';   

        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $boldNormalText='blodNormalText';
        $phpWord->addFontStyle($boldNormalText,array('bold' => true, 'size' => 13,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        //format table
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '14c447');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');
        
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        
        $section = $phpWord->addSection();
        // Add first page header
        $header = $section->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $cell = $table->addCell(4500);
        $textrun = $cell->addTextRun();
        $textrun->addText('Tr&#432;&#7901;ng &#272;&#7841;i h&#7885;c Tr� Vinh',array('bold' => true,'italic'=>true, 'size' => 10,'name'=>'Times New Roman'),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spaceAfter' => 100));

        // Add header for all other pages
        $subsequent = $section->addHeader();
        $subsequent->addText('Tr&#432;&#7901;ng &#272;&#7841;i h&#7885;c Tr� Vinh',array('bold' => true,'italic'=>true, 'size' => 10,'name'=>'Times New Roman'));

        // 1/ Thong tin chung
        $section->addText('&#272;&#7873; c&#432;&#417;ng h&#7885;c ph&#7847;n',$headerForntStyle,$headerparagraphStyle);
        
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)->first();  //truy v&#7845;n th�ng tin h&#7885;c ph&#7847;n
       
        $hoc_phan = $section->addTextRun($headerparagraphStyle);
        $hoc_phan->addText('H&#7885;c ph&#7847;n: ',$boldNormalText);
        $hoc_phan->addText($hocPhan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        
        $ma_hoc_phan = $section->addTextRun($headerparagraphStyle);
        $ma_hoc_phan->addText('M� h&#7885;c ph&#7847;n: ',$boldNormalText);
        $ma_hoc_phan->addText($hocPhan->maHocPhan,$headerForntStyle,$headerparagraphStyle);
        ////------------------------------------------1/ th�ng tin chung---------------------------------------------
        $section->addText('1. Th�ng tin chung',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        

        $table = $section->addTable($spanTableStyleName);

        $table->addRow(); //ti�u &#273;&#7873; b&#7843;ng th�ng tin chung

        $cell1 = $table->addCell(4000, $cellRowSpan); 
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Lo&#7841;i h&#7885;c ph&#7847;n',$headding1);

        $cell2 = $table->addCell(4000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('S&#7889; t�n ch&#7881;',$headding1);

        $cell3=$table->addCell(4000, $cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('S&#7889; gi&#7901; h&#7885;c',$headding1);

        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addListItem("&#272;&#7841;i c&#432;&#417;ng",0,$normalText);
        $cell1->addListItem("C&#417; s&#7903;",0,$normalText);
        $cell1->addListItem("Chuy�n ng�nh",0,$normalText);

        

        $cell1 = $table->addCell(4000);
        $cell1->addListItem("L� thuy&#7871;t: ".$hocPhan->tinChiLyThuyet,0,$normalText);
        $cell1->addListItem("B�i t&#7853;p:",0,$normalText);
        $cell1->addListItem("Th&#7921;c h�nh: ".$hocPhan->tinChiThucHanh,0,$normalText);

        $cell1 = $table->addCell(4000);
        $cell1->addListItem("L� thuy&#7871;t: ".($hocPhan->tinChiLyThuyet*15),0,$normalText);
        $cell1->addListItem("B�i t&#7853;p:",0, $normalText);
        $cell1->addListItem("Th&#7921;c h�nh: ".($hocPhan->tinChiThucHanh*30),0,$normalText);

        $doi_tuong_hoc=$section->addTextRun();  //&#273;&#7889;i t&#432;&#7907;ng h&#7885;c
        $doi_tuong_hoc->addText('&#272;&#7889;i t&#432;&#7907;ng h&#7885;c:     ',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $doi_tuong_hoc->addText('  B&#7853;c: &#272;&#7841;i h&#7885;c',$normalText,array('tabs' => array(new \PhpOffice\PhpWord\Style\Tab('right', 9090))));
        $section->addText('Ng�nh:   C�ng ngh&#7879; th�ng tin ',$normalText);
        $section->addText('H&#7879;:         Ch�nh quy',$normalText);
        
        $section->addText('&#272;i&#7873;u ki&#7879;n tham gia m�n h&#7885;c',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        
        
        $monTQ=monTienQuyet::where('maHocPhan',$maHocPhan)->where('isDelete',false)->with('hoc_phan')->get();
        
        $table = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table->addRow();
        $cell1 = $table->addCell(4000);
        $tenmontq ='';
        foreach ($monTQ as $mtq) {
            $tenmontq=$tenmontq.$mtq->hoc_phan->tenHocPhan.';';
        }

        $cell1->addText('H&#7885;c ph&#7847;n ti�n quy&#7871;t',$normalText);
        $cell1 = $table->addCell(8000);
        $cell1->addText($tenmontq,$normalText);

        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addText('C�c y�u c&#7847;u kh�c:',$normalText);
        $cell1 = $table->addCell(8000);
        $html = $hocPhan->yeuCau;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell1, $html, false, false);

        // //--------------------------------------2. T�i li&#7879;u tham kh&#7843;o------------------------------------------------------------
      
        $section->addText('2. T�i li&#7879;u tham kh&#7843;o',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $tailieuthamkhao=tai_lieu_tham_khao::where('maHocPhan',$maHocPhan)->first();

        $table_tailieuthamkhao = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table_tailieuthamkhao->addRow();
        $cell1 = $table_tailieuthamkhao->addCell(4000);
        $cell1->addText('Gi�o tr�nh/ T�i li&#7879;u h&#7885;c t&#7853;p ch�nh',$normalText);
        $cell1 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->giaoTrinh;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell1, $html, false, false);

        $table_tailieuthamkhao->addRow();
        $cell2 = $table_tailieuthamkhao->addCell(4000);
        $cell2->addText('T�i li&#7879;u tham kh&#7843;o th�m',$normalText);
        $cell2 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->thamKhaoThem;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell2, $html, false, false);
        
        $table_tailieuthamkhao->addRow();
        $cell3 = $table_tailieuthamkhao->addCell(4000);
        $cell3->addText('C�c lo&#7841;i h&#7885;c li&#7879;u kh�c',$normalText);
        $cell3 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->taiLieuKhac;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell3, $html, false, false);

        //--------------------------------------3. M� t&#7843; h&#7885;c ph&#7847;n------------------------------------------------------------
        
        $section->addText('3. M� t&#7843; h&#7885;c ph&#7847;n',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $html = $hocPhan->moTaHocPhan;
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        //--------------------------------------4. Chu&#7849;n &#273;&#7847;u ra h&#7885;c ph&#7847;n------------------------------------------------------------
        $CDR1=CDR1::all();//bi&#7871;n n�y &#273;&#7875; in ch&#7911; &#273;&#7873;
        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //bi&#7871;n n�y ch&#7841;y n&#7897;i dung trong b&#7843;ng chu&#7849;n &#273;&#7847;u ra m�n h&#7885;c
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
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
        ->get();

        $section->addText('4. Chu&#7849;n &#273;&#7847;u ra h&#7885;c ph&#7847;n:',$headding1);
        $section->addText('Sau khi ho�n th�nh h&#7885;c ph&#7847;n, sinh vi�n c� th&#7875;:',$normalText);
        
        $table_chuandaura = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table_chuandaura->addRow();
        $table_chuandaura->addCell(1000);
        $table_chuandaura->addCell(7000);
        $cell = $table_chuandaura->addCell(4000,$cellRowSpan);
        $cell->addText('&#272;�p &#7913;ng C&#272;R c&#7911;a CT&#272;R');

       

        foreach ($CDR1 as $cdr) {
            $table_chuandaura->addRow();
            $table_chuandaura->addCell(1000);
            $cell=$table_chuandaura->addCell(7000);
            $cell->addText('Ch&#7911; &#273;&#7873;:'.$cdr->tenCDR1, $boldNormalText);
            $table_chuandaura->addCell(4000);
            foreach ($kqht as $x){
                if($x->maCDR1==$cdr->maCDR1){
                    $table_chuandaura->addRow();
                    $cell1=$table_chuandaura->addCell(1000);
                    $cell1->addText($x->maKQHTVB, $normalText);
                    $cell2=$table_chuandaura->addCell(7000);
                    $cell2->addText($x->tenKQHT, $normalText);
                    $cell3=$table_chuandaura->addCell(4000);
                    $cell3->addText($x->maCDR3VB, $normalText);
                }
            }
            
        }
        //--------------------------------------5. N&#7897;i dung h&#7885;c ph&#7847;n----------------------------------------------------------------
        $section->addText('5. N&#7897;i dung h&#7885;c ph&#7847;n:',$headding1);
        
        #b&#7843;ng
        $table_noidunghp = $section->addTable($spanTableStyleName);
        #tieu de ban
        $table_noidunghp->addRow();
        $cell1 = $table_noidunghp->addCell(7000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('N&#7897;i dung h&#7885;c ph&#7847;n');

        $cell2 = $table_noidunghp->addCell(2000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('CLOs');

        $cell3 = $table_noidunghp->addCell(3000, array('gridSpan' => 3, 'valign' => 'center','vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '14c447'));
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('S&#7889; ti&#7871;t');

        $table_noidunghp->addRow();
        $table_noidunghp->addCell(null, $cellRowContinue);
        $table_noidunghp->addCell(null, $cellRowContinue);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('L� thuy&#7871;t', null, $cellHCentered);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('Th&#7921;c h�nh', null, $cellHCentered);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('Kh�c', null, $cellHCentered);
        #dong noi dung
        $noidung=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)
        ->orderBy('chuong.id','asc')
        ->with('muc')
        ->with('chuong_kqht')
        ->get();
        $chuong_array=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)
        ->orderBy('chuong.id','asc')
        ->pluck('id');
        
        $mudokynangUIT=mucDoKyNangUIT::whereIn('muc_do_ky_nang_itu.id_chuong',$chuong_array)
        ->orderBy('muc_do_ky_nang_itu.maCDR1')
        ->join('cdr_cd1','cdr_cd1.maCDR1','=','muc_do_ky_nang_itu.maCDR1')
        ->join('kqht_hp','kqht_hp.maKQHT','=','muc_do_ky_nang_itu.maKQHT')
        ->get();

        foreach ($noidung as $nd) {
            foreach ($nd->chuong_kqht as $x) {
                $temp=kqHTHP::where('maKQHT',$x->maKQHT)->first();
                $x->maKQHTVB=$temp->maKQHTVB;
                $x->tenKQHT=$temp->tenKQHT;
            }
        }

        foreach ($noidung as $data){
            $table_noidunghp->addRow();
            $cell1=$table_noidunghp->addCell(7000);
            $cell1->addText($data->tenchuong,$boldNormalText);
            $kqht='';
            foreach ($data->chuong_kqht as $item){
               
               $kqht=$kqht.$item->maKQHTVB.';';
            }

            $cell2=$table_noidunghp->addCell(2000);
            $cell2->addText($kqht,$boldNormalText);


            $cell3=$table_noidunghp->addCell(1000);
            $cell3->addText($data->soTietLT,$boldNormalText);


            $cell4=$table_noidunghp->addCell(1000);
            $cell4->addText($data->soTietTH,$boldNormalText);


            $cell5=$table_noidunghp->addCell(1000);
            $cell5->addText($data->soTietKhac,$boldNormalText);
            

            foreach ($data->muc as $m){
                $table_noidunghp->addRow();
                $cell1=$table_noidunghp->addCell(7000);
                $cell1->addText($m->maMucVB.$m->tenMuc,$normalText);
                $table_noidunghp->addCell(2000);
                $table_noidunghp->addCell(1000);
                $table_noidunghp->addCell(1000);
                $table_noidunghp->addCell(1000);
            }
        }

        //--------------------------------------6. Ph&#432;&#417;ng ph�p gi&#7843;ng d&#7841;y:-----------------------------------------------------------
        $section->addText('6. Ph&#432;&#417;ng ph�p gi&#7843;ng d&#7841;y:',$headding1);
        $hp_ppgd=hocPhan_ppGiangDay::where('isDelete',false)->where('maHocPhan',$maHocPhan)->with('ppGiangDay')->get(); //bi&#7875;n hi&#7875;n th&#7883; ph&#432;&#417;ng ph�p gi&#7843;ng d&#7841;y 

        $table_giangday = $section->addTable($spanTableStyleName);

        $table_giangday->addRow(); //ti�u &#273;&#7873; b&#7843;ng th�ng tin chung
        $cell1 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('M� s&#7889;',$headding1);
        
        $cell2 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Ph&#432;&#417;ng ph�p gi&#7843;ng d&#7841;y',$headding1);

        
        $cell3 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Di&#7877;n gi&#7843;i',$headding1);

        $i=1;
        foreach ($hp_ppgd as $x) {
            $table_giangday->addRow(); //n&#7897;i dung b&#7843;ng gi&#7843;ng d&#7841;y
            $cell1 = $table_giangday->addCell(4000);
            $textrun1 = $cell1->addTextRun($cellHCentered);
            $textrun1->addText($i);
            
            $cell2 = $table_giangday->addCell(4000);
            $textrun2 = $cell2->addTextRun($cellHCentered);
            $textrun2->addText($x->ppGiangDay->tenPP);
    
            
            $cell3 = $table_giangday->addCell(4000);
            $textrun3 = $cell3->addTextRun($cellHCentered);
            $textrun3->addText($x->dienGiai);
            $i++;
        }

        //--------------------------------------7. Ph&#432;&#417;ng th&#7913;c &#273;�nh gi�:-----------------------------------------------------------
        $section->addText('7. Ph&#432;&#417;ng th&#7913;c &#273;�nh gi�:',$headding1);

        $table_phuongthucdanhgia= $section->addTable($spanTableStyleName);

        $table_phuongthucdanhgia->addRow(); //ti�u &#273;&#7873; b&#7843;ng th�ng tin chung
        $cell1 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('H�nh th&#7913;c &#273;�nh gi�',$headding1);
        
        $cell2 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Lo&#7841;i h�nh th&#7913;c &#273;�nh gi�',$headding1);

        
        $cell3 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('T&#7881; l&#7879;',$headding1);

        $hocPhan_loaiHTDG=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$maHocPhan)
        ->with('loai_danh_gia')
        ->with('loaiHTDanhGia')
        ->get();
        foreach ($hocPhan_loaiHTDG as $data){
            $table_phuongthucdanhgia->addRow();
            $cell1 = $table_phuongthucdanhgia->addCell(4000);
            $textrun1 = $cell1->addTextRun($cellHCentered);
            $textrun1->addText($data->loai_danh_gia['tenLoaiDG'],$normalText);

            $cell2 = $table_phuongthucdanhgia->addCell(4000);
            $textrun2 = $cell2->addTextRun($cellHCentered);
            $textrun2->addText($data->loaiHTDanhGia['maLoaiHTDG'].$data->loaiHTDanhGia['tenLoaiHTDG'],$normalText);

            $cell3 = $table_phuongthucdanhgia->addCell(4000);
            $textrun3 = $cell3->addTextRun($cellHCentered);
            $textrun3->addText($data->trongSo.'%',$normalText);
        }
        //--------------------------------------8. C�c quy &#273;&#7883;nh chung:-----------------------------------------------------------
        $section->addPageBreak();
        $section->addText('8. C�c quy &#273;&#7883;nh chung:',$headding1);
        $section->addText('C�c quy &#273;&#7883;nh v&#7873; tham d&#7921; l&#7899;p h&#7885;c',$headding1);
        $section->addListItem('Sinh vi�n c� tr�ch nhi&#7879;m tham d&#7921; &#273;&#7847;y &#273;&#7911; c�c bu&#7893;i h&#7885;c. Trong tr&#432;&#7901;ng h&#7907;p ph&#7843;i ngh&#7881; h&#7885;c v� l� do b&#7845;t kh&#7843; kh�ng th� ph&#7843;i c� gi&#7845;y t&#7901; ch&#7913;ng minh &#273;&#7847;y &#273;&#7911; v� h&#7907;p l�.',0,$normalText);
        $section->addListItem('Sinh vi�n v&#7855;ng qu� 20% s&#7889; ti&#7871;t c&#7911;a h&#7885;c ph&#7847;n, d� c� l� do hay kh�ng c� l� do, &#273;&#7873;u b&#7883; coi nh&#432; kh�ng ho�n th�nh h&#7885;c ph&#7847;n v� ph&#7843;i &#273;&#259;ng k� h&#7885;c l&#7841;i v�o h&#7885;c k&#7923; sau.',0,$normalText);
        $section->addText('Quy &#273;&#7883;nh v&#7873; h�nh vi trong l&#7899;p h&#7885;c',$headding1);
        $section->addListItem('H&#7885;c ph&#7847;n &#273;&#432;&#7907;c th&#7921;c hi&#7879;n tr�n nguy�n t&#7855;c t�n tr&#7885;ng ng&#432;&#7901;i h&#7885;c v� ng&#432;&#7901;i d&#7841;y. M&#7885;i h�nh vi l�m &#7843;nh h&#432;&#7903;ng &#273;&#7871;n qu� tr�nh d&#7841;y v� h&#7885;c &#273;&#7873;u b&#7883; nghi�m c&#7845;m.',0,$normalText);
        $section->addListItem('Sinh vi�n ph&#7843;i &#273;i h&#7885;c &#273;�ng gi&#7901; qui &#273;&#7883;nh. Sinh vi�n &#273;i tr&#7877; qu� 5 ph�t sau khi gi&#7901; h&#7885;c b&#7855;t &#273;&#7847;u s&#7869; kh�ng &#273;&#432;&#7907;c tham d&#7921; bu&#7893;i h&#7885;c.',0,$normalText);
        $section->addListItem('Tuy&#7879;t &#273;&#7889;i kh�ng l�m &#7891;n, g�y &#7843;nh h&#432;&#7903;ng &#273;&#7871;n ng&#432;&#7901;i kh�c trong qu� tr�nh h&#7885;c.',0,$normalText);
        $section->addListItem('Tuy&#7879;t &#273;&#7889;i kh�ng &#273;&#432;&#7907;c &#259;n, nhai k&#7865;o cao su, s&#7917; d&#7909;ng c�c thi&#7871;t b&#7883; nh&#432; &#273;i&#7879;n tho&#7841;i, m�y nghe nh&#7841;c trong gi&#7901; h&#7885;c.',0,$normalText);
        $section->addListItem('M�y t�nh x�ch tay, m�y t�nh b&#7843;ng ch&#7881; &#273;&#432;&#7907;c s&#7917; d&#7909;ng tr�n l&#7899;p v&#7899;i m&#7909;c &#273;�ch ghi ch�p b�i gi&#7843;ng, t�nh to�n ph&#7909;c v&#7909; b�i gi&#7843;ng, b�i t&#7853;p. Tuy&#7879;t &#273;&#7889;i kh�ng d�ng v�o vi&#7879;c kh�c.',0,$normalText);
        $section->addListItem('Sinh vi�n vi ph&#7841;m c�c nguy�n t&#7855;c tr�n s&#7869; b&#7883; m&#7901;i ra kh&#7887;i l&#7899;p v� b&#7883; coi l� v&#7855;ng bu&#7893;i h&#7885;c &#273;�.',0,$normalText);
        $section->addText('Quy &#273;&#7883;nh v&#7873; h&#7885;c v&#7909;',$headding1);
        $section->addListItem('C�c v&#7845;n &#273;&#7873; li�n quan &#273;&#7871;n xin b&#7843;o l&#432;u &#273;i&#7875;m, khi&#7871;u n&#7841;i &#273;i&#7875;m, ch&#7845;m ph�c tra, k&#7927; lu&#7853;t thi c&#7917; &#273;&#432;&#7907;c th&#7921;c hi&#7879;n theo quy ch&#7871; h&#7885;c v&#7909; c&#7911;a tr&#432;&#7901;ng &#272;&#7841;i h&#7885;c Tr� Vinh.',0,$normalText);
        $filename=$hocPhan->maHocPhan.'_'.$hocPhan->tenHocPhan.'.docx';
        //xu&#7845;t fileE
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }
}
