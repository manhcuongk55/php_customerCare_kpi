<?php
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");
require_once("../includes/gffunction.php");

$objdata  =  new CLS_MYSQL;
// ----------------UPLOAD FILE -----------------
$valid_formats = array("jpg", "png", "gif");
$max_file_size = 1024*10000; 
$path = "../uploads/";
$strFile = "";

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	// Loop $_FILES to execute all files
	$name = '';
	$idUser = $_POST['id_user_change_avatar'];
	foreach ($_FILES['files']['name'] as $f => $name) { 
		$name = un_unicode($name);    
	    if ($_FILES['files']['error'][$f] == 4) {
	        continue; // Skip file if any error found
	    }	       
	    if ($_FILES['files']['error'][$f] == 0) {	           
	        if ($_FILES['files']['size'][$f] > $max_file_size) {
	            $message[] = "$name is too large!.";
	            continue; // Skip large files
	        }
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
	        else{ // No error found! Move uploaded files
	        	$rand=rand(1000,99999);
	        	$name=$rand.'_'.$name;
	            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name)) {
	            	$strFile.=$path.$name."#";
	            }
	        }
	    }
	}
	$link = "uploads/".$name;
	$sql = "UPDATE tbl_member_level SET `avatar`='$link' WHERE `id`='$idUser'";
	$objdata->Exec($sql);

	echo "success";
} else {
	echo "failed";
}

?>