<?php
class CLS_CUSTOMER{
	private $pro=array(
		'ID'=>'0',
		'MemId'=>'',
		'FullName'=>'',
		'Birthday'=>'',
		'Phone'=>'',
		'Gender'=>'',
		'DieDate'=>'',
		'BirthdayFamily'=>'',
		'DiedateFamily'=>'',
		'Type'=>'',		
		'Cdate'=>''
		);
	private $objmysql=null;
	public function CLS_CUSTOMER(){
		$this->objmysql=new CLS_MYSQL;
		$this->Cdate=date('Y-m-d H:i:s');
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

	public function Add_new(){
		$cdate=date('Y/m/d H:i:s');
		$sql="INSERT INTO `tbl_customer`(`mem_id`,`type`,`fullname`,`birthday`,`diedate`,`birthday_family`,`diedate_family`,`cdate`,`phone`,`gender`) 
		VALUES ('".$this->MemId."','".$this->Type."',N'".$this->FullName."','".$this->Birthday."',
				'".$this->DieDate."','".$this->BirthdayFamily."','".$this->DiedateFamily."',
				'".$cdate."','".$this->Phone."','".$this->Gender."')";

		// echo $sql;
		$this->objmysql->Exec($sql);
		$lastID = $this->objmysql->LastInsertID();
		return $lastID;
	}

	public function Update() {
		$sql = "UPDATE tbl_customer SET 
					`fullname`='".$this->FullName."', 
					`birthday`='".$this->Birthday."',
					`diedate`='".$this->DieDate."',
					`birthday_family`='".$this->BirthdayFamily."',
					`diedate_family`='".$this->DiedateFamily."',
					`type`='".$this->Type."',
					`phone`='".$this->Phone."',
					`gender`='".$this->Gender."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql="DELETE FROM `tbl_customer` WHERE  `id`= '".$this->ID."' ";
		$sql1="DELETE FROM `tbl_customer_detail` WHERE  `customer_id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        $this->objmysql->Exec($sql);
        return $this->objmysql->Exec($sql1);
	}

	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_customer` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}

	public function getIdByPhone($phone) {
		$sql="SELECT `id` FROM `tbl_customer` WHERE `phone`='".$phone."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['id'];
		} 
		return '0';
	}

	public function getListPhoneNumberByIds($listId) {
		$sql="SELECT `phone` FROM `tbl_customer` WHERE `id` in '".$listId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$lstPhone = "";
			while($rs = $this->objmysql->Fetch_Assoc()) {
				$lstPhone.=$rs['phone'].',';
			}
			$lstPhone = substr($lstPhone, 0, strlen($lstPhone)-1);
			return $lstPhone;
		} 
		return '';
	}
	
	public function getCustomerName($cusId) {
		$sql="SELECT `fullname` FROM `tbl_customer` WHERE `id`='".$cusId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['fullname'];
		} 
		return '';	
	}

	public function getMemName($memId) {
		$sql="SELECT `fullname` FROM `tbl_member_level` WHERE `id`='".$memId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['fullname'];
		} 
		return '';	
	}

	public function getPermistionMem($memId) {
		$sql="SELECT `permistion` FROM `tbl_member_level` WHERE `id`='".$memId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['permistion'];
		} 
		return '';	
	}

	public function getCusTypeById($memId) {
		$sql="SELECT `type` FROM `tbl_customer` WHERE `id`='".$memId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['type'];
		} 
		return '';	
	}

	
}
?>