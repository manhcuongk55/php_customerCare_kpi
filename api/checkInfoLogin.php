<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
include_once("../includes/gfinnit.php");
include_once("../libs/cls.mysql.php"); 
$objmysql = new CLS_MYSQL;

$date=date('Y-m-d h:i:s').' Call by '.$_SERVER['REMOTE_ADDR']."\n";
file_put_contents('logs.txt',$date,FILE_APPEND);

$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);

$json = "{\"status\":";
if (isset($JSON['username']) && isset($JSON['password'])) {
	$data = $JSON['username'].'---'.$JSON['password'];
	$data = json_encode($JSON)." \n";
	file_put_contents('logs.txt',$data,FILE_APPEND);

	$username = $JSON['username'];
	$password = md5(sha1($JSON['password']));
	
	// query data
	$sql = "select * from tbl_member_level where username='".$username."'";
	$objmysql->Query($sql);

	$json = "{\"status\":";

	if ($objmysql->Num_rows()>0) {
		$rs=$objmysql->Fetch_Assoc();
		if (trim($password)==trim($rs['password'])) {
			$fullname = $rs['fullname'];
			$id = $rs["id"];
			$phone = $rs["phone"];
			$email = $rs["email"];
			$identify = $rs["identify"];
			$permistion = $rs["permistion"];
			$avatar = $rs["avatar"];
			$firebaseId = $rs['firebase_id'];
			$typePlatform = $rs['type_platform'];


			$json.= "\"true\", \"data\":{\"id\":\"$id\", \"fullname\":\"$fullname\", \"phone\":\"$phone\",\"avatar\":\"$avatar\",\"email\":\"$email\",\"identify\":\"$identify\",\"permistion\":\"$permistion\"}}";

			// save firebase ID and type platform
			if ($firebaseId == "" || $firebaseId != $JSON['firebase_id']) {
				$sql="UPDATE tbl_member_level SET `firebase_id`='".$JSON['firebase_id']."', `type_platform`='".$JSON['type_platform']."' WHERE `id`='$id'";
				// echo $sql;
				$objmysql->Exec($sql);
			}
			// end

			
		} else {
			$json.= "\"false\", \"data\":{}}";
		}
	} else {
		$json.= "\"false\", \"data\":{}}";
	}
} else {
	$json.= "\"false\", \"data\":{}}";
}
echo $json;
?>