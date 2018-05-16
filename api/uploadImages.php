<?php
require_once("../includes/gfinnit.php");
require_once("../includes/gfconfig.php");
require_once("../libs/cls.mysql.php");
require_once("../includes/gffunction.php");

$objdata  =  new CLS_MYSQL;
// ----------------UPLOAD FILE -----------------
$valid_formats = array("jpg", "png", "gif");
$max_file_size = 1024*10000; 
$path = "../uploads/schedule/";
$strFile = "";
$data ="";
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

	$name = un_unicode($_FILES['files']['name']);    
	move_uploaded_file($_FILES["files"]["tmp_name"], $path.$name);
	$strFile = $path.$name;
	$strFile = ROOTHOST.str_replace("../", "", $strFile);

	$data.= "{\"link\":\"$strFile\"}";
	echo $data;

} else {
	echo "";
}

?>