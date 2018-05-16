<?php 
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");
require_once("../libs/cls.member_level.php");

$mem =  new CLS_MEMBERLEVEL();

if(isset($_POST['id_user_change'])) {
	$id = $_POST['id_user_change'];

	$oldPass = $mem->GetPassword($id);
	$old_p = md5(sha1($_POST['old_pass']));

	if($oldPass != $old_p) {
		echo "error_old_pass";
		return;
	} else {
		$newPass = md5(sha1($_POST['new_pass']));
		$mem->UpdatePassword($newPass, $id);
		echo "success";
	}
}
?>