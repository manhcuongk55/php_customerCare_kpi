<?php
class CLS_REPORT{
	private $pro=array(
		'ID'=>'0'
		);
	private $objmysql=null;
	public function CLS_REPORT(){
		$this->objmysql=new CLS_MYSQL;		
	}
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		return $this->pro[$proname];
	}

	
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}

	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}

	public function getList($where, $limit) {
		
		$sql="select tbl_schedule.id as schedule_id, tbl_schedule.service_price, tbl_schedule.service_name,
			tbl_user.fullname as name_user, tbl_user.phone as phone_user, type, address,
			 event_subject, event_description, event_start, event_end, 
			tbl_schedule.status as status_schedule 
			from tbl_user, tbl_schedule, tbl_member_level 
			where tbl_user.id = tbl_schedule.user_id 
			and tbl_schedule.mem_id = tbl_member_level.id 
			and ".$where." 
			order by tbl_schedule.cdate desc";	
		//echo $sql;
		// die;
		return $this->objmysql->Query($sql);
	}

	public function getNameStatus($status) {
		switch ($status) {
			case '0':
				return "<strong style=\"color:red\">Đang chờ</strong>";
				break;
			case '1':
				return "<strong style=\"color:red\">Đang thực hiện</strong>";
				break;
			case '2':
				echo "<strong style=\"color:red\">Hoàn thành</strong>";
				return;
			case '3':
				return "<strong style=\"color:red\">Quá hạn xử lý</strong>";
				break;
			case '-1':
				return "<strong style=\"color:red\">Được hủy bỏ</strong>";
				break;
			
			default:
				# code...
				break;
		}
	}
	
}
?>