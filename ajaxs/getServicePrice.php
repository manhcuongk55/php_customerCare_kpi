<?php 
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");

$objmysql =  new CLS_MYSQL();

if(isset($_POST['ServiceId'])) {
	$sql = "SELECT `price` FROM tbl_service WHERE id=".$_POST['ServiceId'];
	$objmysql->Query($sql);
	$rs = $objmysql->Fetch_Assoc();
	echo  number_format($rs['price']);

} else {
	echo "0";
}
