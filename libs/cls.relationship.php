<?php
class CLS_RELATIONSHIP{
	private $pro=array(
		'ID'=>'0',
		'Name'=>''
		);
	private $objmysql=null;
	public function CLS_RELATIONSHIP(){
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
		$sql="INSERT INTO `tbl_relationship`(`name`) 
		VALUES ('".$this->SubCatId."',N'".$this->Name."')";
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$sql = "UPDATE tbl_relationship SET 
					`name`='".$this->Name."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_relationship` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}

	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_relationship` WHERE 1=1 ".$where.$limit;
		return $this->objmysql->Query($sql);
	}
	
}
?>