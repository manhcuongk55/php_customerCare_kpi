<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.customer.php");
include_once("../libs/cls.customer.detail.php");
$objCus = new CLS_CUSTOMER;
$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);

if (isset($JSON['mem_id'])) {
	$memId = $JSON['mem_id'];
	if (isset($JSON['permistion']) && $JSON['permistion'] == PER_SUPPERVISOR) {
		$objCus->getList("","");
	} else {
		$objCus->getList(" and mem_id='".$memId."'","");
	}
	

	$data = "";
	while($rs=$objCus->Fetch_Assoc()) {
		$id = $rs['id'];
		$type = $rs['type'];
		$fullname = $rs['fullname'];
		$birthday = $rs['birthday'];
		$phone = $rs['phone'];
		$avatar = $rs['avatar'];

		$data.= "{\"id\":\"$id\", \"type\":\"$type\", \"fullname\":\"$fullname\",\"birthday\":\"$birthday\",\"phone\":\"$phone\",\"avatar\":\"$avatar\"},";
	}

	$data = "[".substr($data, 0, strlen($data)-1)."]";	
	echo $data;
}



?>