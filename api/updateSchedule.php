<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.meet.php");
$objMeet = new CLS_MEET;
$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);

if (isset($JSON['mem_id'])) {
	$objMeet->ID = $JSON['id'];
	$objMeet->MemId = $JSON['mem_id'];
	$objMeet->CustomerId = $JSON['cus_id'];
	
	$objMeet->Content = $JSON['content'];
	$objMeet->Status = $JSON['status'];
	$objMeet->Type = $JSON['type'];
	$objMeet->Address = $JSON['address'];
	$objMeet->Image = $JSON['image'];
	$objMeet->Result = $JSON['result'];
	$objMeet->DateTime = date('Y-m-d', strtotime($JSON['datetime']));
	$objMeet->NextContent = $JSON['next_content'];
	$objMeet->Note = $JSON['note'];
	$objMeet->Update();
	echo "success";
} else {
	echo "error";
}



?>