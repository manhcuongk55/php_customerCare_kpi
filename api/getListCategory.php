<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.category.php");
$objCat = new CLS_CATEGORY;
$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);

if (isset($JSON['category'])) {	
	$data = "";
	$objCat->getList("","");
	$canhan = "\"canhan\": [";
	$doanhnghiep = "\"doanhnghiep\": [";
	$tochuc = "\"tochuc\": [";

	while($rs=$objCat->Fetch_Assoc()) {
		$id = $rs['id'];
		$name = $rs['name'];
		$group = $rs['group'];
		
		if ($group == 0) {
			$canhan.="{\"cat_id\":\"$id\", \"name\":\"$name\"},";
		} else if ($group==1)  {
			$doanhnghiep.="{\"cat_id\":\"$id\", \"name\":\"$name\"},";
		} else {
			$tochuc.="{\"cat_id\":\"$id\", \"name\":\"$name\"},";
		}
	}


	$canhan = substr($canhan, 0, strlen($canhan)-1)."]";
	$doanhnghiep = substr($doanhnghiep, 0, strlen($doanhnghiep)-1)."]";
	$tochuc = substr($tochuc, 0, strlen($tochuc)-1)."]";

	$data = "{".$canhan.",".$doanhnghiep.",".$tochuc."}";
	echo $data;
	
}
?>