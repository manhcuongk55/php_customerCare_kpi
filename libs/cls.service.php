<?php
class CLS_SERVICE{
	private $pro=array(
		'ID'=>'0',
		'Name'=>'',
		'Price'=>'',
		'Sale'=>'',
		'Note'=>''
		);
	private $objmysql=null;
	public function CLS_SERVICE(){
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

	public function Add_new() {		
		$sql="INSERT INTO `tbl_service`(`name`,`price`,`sale`,`note`) 
		VALUES ('".$this->Name."','".$this->Price."','".$this->Sale."','".$this->Note."')";

		//echo $sql; die;
		return $this->objmysql->Exec($sql);

		//$lastID = $this->objmysql->LastInsertID();
		//return $lastID;
	}

	public function Update() {
		$sql = "UPDATE tbl_service SET 
					`name`='".$this->Name."', 
					`price`='".$this->Price."',
					`sale`='".$this->Sale."',
					`note`='".$this->Note."'
					 WHERE `id`='".$this->ID."'";
					 //echo $sql;die;
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_service` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}

	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_service` WHERE 1=1 ".$where.$limit;
		return $this->objmysql->Query($sql);
	}

	
	
}
?>