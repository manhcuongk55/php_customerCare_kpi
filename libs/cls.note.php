<?php
class CLS_NOTE {
	private $pro=array(
		'ID'=>'0',
		'MemId'=>'',
		'CustomerId'=>'',
		'Title'=>'',
		'Content'=>'',
		'Cdate'=>''
		);
	private $objmysql=null;
	public function CLS_NOTE(){
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
		$sql="INSERT INTO `tbl_note`(`mem_id`,`customer_id`,`title`,`content`,`cdate`) 
		VALUES ('".$this->MemId."','".$this->CustomerId."',N'".$this->Title."',N'".$this->Content."','".$cdate."')";
		// echo $sql;die;
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$sql = "UPDATE tbl_note SET 
					`mem_id`='".$this->MemId."',
					`customer_id`='".$this->CustomerId."',
					`title`=N'".$this->Title."',
					`content`=N'".$this->Content."'
					 WHERE `id`='".$this->ID."'";
					 // die($sql);
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_note` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}
	
	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_note` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}
	
}
?>