<?php 
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");
require_once("../libs/cls.schedule.php");

$objSchedule =  new CLS_SCHEDULE();


if (isset($_POST['action']) && $_POST['action'] == 'add') {
	$objSchedule->MemId=$_POST['mem_id'];
	$objSchedule->UserId=$_POST['user_id'];
	$objSchedule->EvtSubject=$_POST['evt_sub'];
	$objSchedule->EvtDescription=$_POST['evt_des'];
	$objSchedule->EvtStart=$_POST['evt_start'];
	
	$endDefault = strtotime($_POST['evt_start']) + 30*60;
	$objSchedule->EvtEnd=date('Y-m-d H:i:s', $endDefault);	

	$objSchedule->ServiceName=$_POST['service_name'];
	$objSchedule->ServicePrice=$_POST['service_price'];

	$objSchedule->Add_new();
	echo  "success";

} else if (isset($_POST['action']) && $_POST['action'] == 'edit') {	
	$objSchedule->EvtSubject=$_POST['evt_sub'];
	$objSchedule->EvtDescription=$_POST['evt_des'];
	$objSchedule->EvtStart=$_POST['evt_start'];
	
	$endDefault = strtotime($_POST['evt_start']) + 30*60;
	$objSchedule->EvtEnd=date('Y-m-d H:i:s', $endDefault);	

	$objSchedule->ServiceName=$_POST['service_name'];
	$price = str_replace(",", "", $_POST['service_price']);
	$objSchedule->ServicePrice=$price;

	// if(strtotime($objSchedule->EvtStart) >= strtotime($objSchedule->EvtEnd)) {
	// 	echo "error_date";
	// } else {
	// 	$objSchedule->ID=$_POST['schedule_id'];
	// 	$objSchedule->Update();	
	// 	echo  "success";
	// }

	$objSchedule->ID=$_POST['schedule_id'];
	$objSchedule->Update();	
	echo  "success";
	
} else if (isset($_POST['action']) && $_POST['action'] == 'delete') {	
	$objSchedule->ID=$_POST['schedule_id'];
	$objSchedule->Delete();
	echo  "success";

} else if (isset($_POST['action']) && $_POST['action'] == 'change_status') {	
	$objSchedule->ID=$_POST['schedule_id'];
	$objSchedule->Status=$_POST['status_change'];
	$objSchedule->updateStatus();
	echo  "success";

}  else {
	echo "error";
}
