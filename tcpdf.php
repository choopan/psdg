<?php
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set font
$pdf->SetFont('freeserif', '', 14, '', true);

$pdf->AddPage();

$html = iconv('TIS-620','UTF-8', "ทดสอบ");

$pdf->writeHtml($html);

$pdf->Output('test1.pdf', 'I');
?>