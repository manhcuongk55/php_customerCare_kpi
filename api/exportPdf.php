<?php
require 'pdfcrowd.php';
include_once("../includes/gfconfig.php");
try
{   
    $cusId = "";
    $client = new Pdfcrowd("bachbanhbao", "a25ce009da40da22e1e76b20e8fdd624");
    if (isset($_GET['export_id'])) {
        $cusId = $_GET['export_id'];
        if ($_GET['type'] == 0) {
            $pdf = $client->convertURI('http://annam.muathu7.com/customercare/api/generateDataPdf.php?export_id='.$cusId);    
        } else if ($_GET['type'] == 1) {
            $pdf = $client->convertURI('http://annam.muathu7.com/customercare/api/generateDataPdfDoanhNghiep.php?export_id='.$cusId);
        } else {
            $pdf = $client->convertURI('http://annam.muathu7.com/customercare/api/generateDataPdfToChuc.php?export_id='.$cusId);
        }
        
    } else {
        $pdf = $client->convertURI('<h3 style="text-align:center">Hệ thống đang cập nhật</h3>');
    }
    
    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"thong_tin_khach_hang.pdf\"");

    // send the generated PDF 
    echo $pdf;
}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}
?>

