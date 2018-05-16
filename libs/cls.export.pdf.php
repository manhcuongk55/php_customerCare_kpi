<?php
class CLS_EXPORT {
	private $pro=array(
		'ID'=>'0',
		'MemId'=>'',
		'CustomerId'=>'',
		'CatList'=>'',
		'Status'=>'',
		'Note'=>'',
		'Cdate'=>''
		);
	private $objmysql=null;
	public function CLS_EXPORT(){
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
		$sql="INSERT INTO `tbl_export_pdf`(
			`mem_id`,`customer_id`,`cat_list`,`status`,`note`,`cdate`) 
		VALUES (
			'".$this->MemId."','".$this->CustomerId."','".$this->CatList."','".$this->Status."',N'".$this->Note."', '".$cdate."')";
		// die($sql);
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$sql = "UPDATE tbl_export_pdf SET 
					`status`='".$this->Status."',
					`note`='".$this->Note."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_export_pdf` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}
	
	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_export_pdf` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}
	
}
?>