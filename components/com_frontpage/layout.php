<?php 
require_once(LIB_PATH."cls.member_level.php");
$objmem = new CLS_MEMBERLEVEL;

if($objmem->isLogin()==false) { ?>
<?php } 
else { ?>
	<script>window.location.href='<?php echo ROOTHOST;?>mgmt_customer.html';</script>
<?php } 
die;
unset($objmem);
unset($objConstant);
?>