<?php 
session_start();
date_default_timezone_set("Asia/Saigon");
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");
require_once("../libs/cls.export.pdf.php");

$objExport =  new CLS_EXPORT;

if(isset($_POST['txt_cus_id'])){
	$objExport->MemId = $_POST['txt_mem_id'];
	$objExport->CustomerId = $_POST['txt_cus_id'];
	$str = "";
	if (isset($_POST['checkbox-category'])) {
		for ($i=0; $i < count($_POST['checkbox-category']); $i++) { 
			$str.= $_POST['checkbox-category'][$i].',';
		}	
		$objExport->CatList = substr($str, 0, strlen($str)-1);
		$objExport->Add_new();
		echo "sucess";
	} else {
		echo "error";
	}

} else {
	echo "error";
}
?>