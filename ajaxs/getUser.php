<?php 
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");

$objmysql =  new CLS_MYSQL;

if(isset($_POST['identify'])) {
	$identify = $_POST['identify'];
	$sql = "SELECT * FROM tbl_user  WHERE identify='$identify'";
	$objmysql->Query($sql);	
	$r=$objmysql->Fetch_Assoc();
	$id=$r['id'];
	$json = "[";
	if ($objmysql->Num_rows() > 0)  {
		$json.= "{\"rep\":\"yes\", \"id\": \"$id\"}";
	} 
	else {
		$json.= "{\"rep\":\"no\", \"id\": \"\"}";
	}
	echo $json."]";
	
} else {
	$json = "[";
	$json.= "{\"rep\":\"no\", \"id\": \"\"}]";
	echo $json."]";
}

?>