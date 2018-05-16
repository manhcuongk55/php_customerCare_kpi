<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.subcat.php");
$objSubCate = new CLS_SUBCAT;
$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);

if (isset($JSON['mem_id'])) {	
	$data = "";
	$objSubCate->getList("","");

	while($rs=$objSubCate->Fetch_Assoc()) {
		$id = $rs['id'];
		$cat_id = $rs['cat_id'];
		$name = $rs['name'];
		$alias = $rs['alias'];

		$data.= "{\"id\":\"$id\", \"cat_id\":\"$cat_id\", \"name\":\"$name\",\"alias\":\"$alias\"},";
	}

	$data = "[".substr($data, 0, strlen($data)-1)."]";	
	echo $data;
	
}
?>