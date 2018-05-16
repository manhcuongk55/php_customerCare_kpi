<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.note.php");
$objNote = new CLS_NOTE;
$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);

if (isset($JSON['note_id'])) {
	$objNote->ID=$JSON['note_id'];
	$objNote->Delete();
	echo "success";
} else {
	echo "failed";
}
?>