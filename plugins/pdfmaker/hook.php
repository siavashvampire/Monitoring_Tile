<?php


namespace plugin\pdfmaker;


use plugin\pdfmaker\lib\TCPDF;
use pluginController;
use TCPDF_FONTS;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    public function _makePDF($htmlpersian, $nameOfFile, $landscape = false, $type = 'A4')
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//        // set document information
//        $pdf->SetCreator(PDF_CREATOR);
//        $pdf->SetAuthor(' کاشی سازی حافظ');
//        $pdf->SetTitle('نمونه فایل');
//        $pdf->SetSubject('موضوع فایل');
//        $pdf->SetKeywords(' 1 و 2 و 3');
//
//        // set default header data
//        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'کاشی سازی حافظ', 'موضوع فایل');

        $pdf->setPrintHeader(false);
        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language dependent data:
        $lg = array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

        // set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);

//    $fontname = TCPDF_FONTS::addTTFfont('C:\Users\vampire\Desktop\test\BNazanin.ttf', 'TrueTypeUnicode', '', 32);
//        $pdf->SetFont($fontname, '', 12);
        // set font
        $pdf->SetFont('bnazanin', '', 12);

        // add a page
        $pdf->AddPage(($landscape) ? 'L' : 'P', $type);

        // Persian and English content
        $pdf->WriteHTML($htmlpersian, true, 0, true, 0);

        //Close and output PDF document
        $pdf->Output($nameOfFile . '.pdf', 'I');
    }
}