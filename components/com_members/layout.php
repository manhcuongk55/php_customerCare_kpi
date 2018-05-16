<?php 
ini_set('display_errors',1);
$COM='members';
$objmem=new CLS_MEMBERLEVEL;
$viewtype='';
if(isset($_GET['viewtype'])){
	$viewtype=addslashes($_GET['viewtype']);
} 
if(is_file(COM_PATH.'com_'.$COM.'/tem/'.$viewtype.'.php'))
	include_once('tem/'.$viewtype.'.php');	
unset($viewtype); unset($objmem); unset($COM);
?>
<div class='clr'></div>