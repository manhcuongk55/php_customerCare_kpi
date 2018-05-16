<?php 
session_start();
date_default_timezone_set("Asia/Saigon");
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");
require_once("../libs/cls.export.pdf.php");

$objExport =  new CLS_EXPORT;

if(isset($_POST['id_export_pdf'])){
	$objExport->ID = $_POST['id_export_pdf'];
	$objExport->Status = '-1';
	$objExport->Note = $_POST['content_reject'];
	$objExport->Update();
	echo "success";
} else {
	echo "error";
}
?>