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
	$memId = $JSON['mem_id'];
	$objNote->getList(" and mem_id='".$memId."'"," ORDER BY id desc");

	$data = "";
	while($rs=$objNote->Fetch_Assoc()) {
		$id = $rs['id'];
		$mem_id = $rs['mem_id'];
		$note_id = $rs['id'];
		$title = $rs['title'];
		$content = $rs['content'];

		$data.= "{
				\"mem_id\":\"$mem_id\",
				\"content\": {
					\"note_id\":\"$note_id\",
					\"title\":\"$title\",
					\"content\":\"$content\"
				}},";
	}

	$data = "[".substr($data, 0, strlen($data)-1)."]";	
	echo $data;
}



?>