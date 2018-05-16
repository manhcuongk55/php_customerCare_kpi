<?php 
ini_set('display_errors',1);
$COM='report';
$objReport=new CLS_REPORT;
$viewtype='';
if(isset($_GET['viewtype'])){
	$viewtype=addslashes($_GET['viewtype']);
} 
if(is_file(COM_PATH.'com_'.$COM.'/tem/'.$viewtype.'.php'))
	include_once('tem/'.$viewtype.'.php');	
unset($viewtype); unset($obj); unset($COM);
?>
<div class='clr'></div>