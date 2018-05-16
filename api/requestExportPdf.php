<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.export.pdf.php");
$objExport = new CLS_EXPORT;
$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);
$data = "";
if (isset($JSON['cus_id'])) {
	$objExport->MemId = $JSON['mem_id'];
	$objExport->CustomerId = $JSON['cus_id'];
	$str = "";
	if (isset($JSON['chk_category'])) {
		$aryCat = explode(",",$JSON['chk_category']);
		for ($i=0; $i < count($aryCat); $i++) { 
			$str.= $aryCat[$i].',';
		}	
		$objExport->CatList = substr($str, 0, strlen($str)-1);
		$objExport->Add_new();
		echo "sucess";
	} else {
		echo "error";
	}
}



?>