<?php
class CLS_GROUP {
	private $pro=array(
		'ID'=>'0',
		'Name'=>'',
		'Value'=>''
		);
	private $objmysql=null;
	public function CLS_GROUP(){
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

	public function Add_new(){
		$cdate=date('Y/m/d H:i:s');
		$sql="INSERT INTO `tbl_group`(`name`,`value`) 
		VALUES (N'".$this->Name."','".$this->Value."')";
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$sql = "UPDATE tbl_group SET 
					`name`='".$this->Name."',
					`value`='".$this->Value."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_group` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}
	
	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_group` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}

	public function getGroupName($id) {
		$sql="SELECT `name` FROM `tbl_group` WHERE `value`='$id'";		
		$this->objmysql->Query($sql);
		if ($this->objmysql->Num_rows() > 0) {
			$r=$this->objmysql->Fetch_Assoc();
			return $r['name'];
		} else {
			return '';
		}
	}
}
?>