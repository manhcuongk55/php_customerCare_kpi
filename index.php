<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
// include config
define('incl_path','includes/');
define('libs_path','libs/');

require_once(incl_path.'simple_html_dom.php');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinnit.php');
require_once(incl_path.'gffunction.php');

// include libs
require_once(libs_path.'cls.mysql.php');
require_once(libs_path.'cls.template.php');
require_once(LIB_PATH."cls.member_level.php");
require_once(LIB_PATH."cls.customer.php");
require_once(libs_path."cls.note.php");
require_once(libs_path."cls.meet.php");
require_once(libs_path."cls.report.php");
require_once(libs_path."cls.field.infomation.php");
require_once(libs_path."cls.option.field.php");
require_once(libs_path."cls.display.php");
require_once(libs_path."cls.relationship.php");
require_once(libs_path."cls.subcat.php");
require_once(libs_path."cls.category.php");
require_once(libs_path."cls.group.php");
require_once(libs_path."cls.customer.detail.php");
require_once(libs_path."cls.export.pdf.php");

$tmp=new CLS_TEMPLATE();
$tmp_name=$tmp->Load_defaul_tem();
$this_tem_path=TEM_PATH.$tmp_name.'/';
define('ISHOME',true);
define('THIS_TEM_PATH',$this_tem_path);
$tmp->WapperTem();
?>

