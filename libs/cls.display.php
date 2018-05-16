<?php
class CLS_DISPLAY {
	private $pro=array(
		'ID'=>'0',
		'SubCatId'=>'',
		'DisplayItem'=>'',
		'IsActive'=>'1'
		);
	private $objmysql=null;
	public function CLS_DISPLAY(){
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
		$sql="INSERT INTO `tbl_display`(`sub_cat_id`,`display_item`) 
		VALUES ('".$this->SubCatId."','".$this->DisplayItem."')";

		// echo $sql;die;
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$sql = "UPDATE tbl_display SET 
					`display_item`='".$this->DisplayItem."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_display` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}

	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_display` WHERE 1=1 ".$where.$limit;
		return $this->objmysql->Query($sql);
	}
	
}
?>