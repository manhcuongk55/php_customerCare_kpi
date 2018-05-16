<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.note.php");
$objNote = new CLS_NOTE;
$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);

if (isset($JSON['mem_id'])) {
	$objNote->MemId = $JSON['mem_id'];	
	$content = $JSON['content'];
	$objNote->Title = $content['title'];
	$objNote->Content = $content['body'];
	$objNote->Add_new();
	echo "success";
} else {
	echo "failed";
}
?>