<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.customer.php");
include_once("../libs/cls.subcat.php");
include_once("../libs/cls.category.php");
include_once("../libs/cls.customer.detail.php");
$objCusDetail = new CLS_CUSTOMER_DETAIL;
$objSubCat = new CLS_SUBCAT;
$objCat = new CLS_CATEGORY;
// Receiver data post from APP
$postData = file_get_contents("php://input");
// Paser data post to json
$JSON = json_decode($postData, true);
// Check params JSON
if (isset($JSON['cus_id'])) {
	$cusId = $JSON['cus_id'];
	// get data json from database
	$objCusDetail->getList(" and customer_id='".$cusId."'","");	
	$data = "";
	// Processing data
	$aryCatId = array();
	$aryJsonData = array();

	while($rs=$objCusDetail->Fetch_Assoc()) {
		$catId = $objSubCat->getCatId($rs['sub_cat_id']);
		if (!in_array($catId, $aryCatId)) {
			array_push($aryCatId, $catId);
		}
		array_push($aryJsonData, $rs['json']);
	}	

	$dataReturn = "";
	for ($i=0; $i < count($aryCatId); $i++) { 
		// get alias of category via cat id
		$alias = $objCat->getAlias($aryCatId[$i]);
		if ($alias == "qua_trinh_hoc_tap" || $alias == "ly_lich_cong_tac" || $alias == "quan_he_xa_hoi") {
			$alias.=$alias."_customer";
		}
		// create json 
		$strJson = "\"$alias\": {";
		
		foreach ($aryJsonData as $key => $value) {
			$decodeJson = json_decode($value, true);
			// get cat id via sub cat id from table tbl_sub_cat
			$catId = $objSubCat->getCatId($decodeJson['sub_cat_id']);
			// check
			if (isset($decodeJson['sub_cat_id']) && $catId == $aryCatId[$i]) {
				$aliasSubCat = $objSubCat->getAlias($decodeJson['sub_cat_id']);
				$json = json_encode($decodeJson[$aliasSubCat], JSON_UNESCAPED_UNICODE);
				$strJson.= "\"$aliasSubCat\" : ".$json. ",";
			}
		}

		$strJson = substr($strJson, 0, strlen($strJson)-1)."}";		
		$dataReturn.= $strJson. ",";		
	}
	$dataReturn = "{".substr($dataReturn, 0, strlen($dataReturn)-1)."}";		
	echo $dataReturn;
}
?>