<?php 
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");

$objmysql =  new CLS_MYSQL;

if(isset($_POST['scheduleId'])) {
	$scheduleId = $_POST['scheduleId'];
	$sql = "select fullname, service_price,service_name, event_subject, event_description, event_start, event_end,  tbl_schedule.id as schedule_id
	from tbl_user, tbl_schedule
	where tbl_user.id = tbl_schedule.user_id and tbl_schedule.id = ".$scheduleId;

	$objmysql->Query($sql);	
	$r=$objmysql->Fetch_Assoc();
	$fullname=$r['fullname'];
	$serviceName=$r['service_name'];
	$price=number_format($r['service_price']);
	$evtSub=$r['event_subject'];
	$evtDes=$r['event_description'];
	$evtStart=$r['event_start'];
	$evtEnd=$r['event_end'];
	
	$json = "[";
	if ($objmysql->Num_rows() > 0)  {
		$json.= "{\"rep\":\"yes\", \"fullname\": \"$fullname\", \"servicePrice\": \"$price\", \"serviceName\": \"$serviceName\", 
			\"evtSub\": \"$evtSub\", \"evtDes\": \"$evtDes\", \"evtStart\": \"$evtStart\", \"evtEnd\": \"$evtEnd\"}";
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