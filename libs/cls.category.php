<?php
class CLS_CATEGORY {
	private $pro=array(
		'ID'=>'0',
		'Name'=>'',
		'Alias'=>''
		);
	private $objmysql=null;
	public function CLS_CATEGORY(){
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
		$sql="INSERT INTO `tbl_category`(`name`,`alias`) 
		VALUES (N'".$this->Name."','".$this->Alias."')";
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$sql = "UPDATE tbl_category SET 
					`name`='".$this->Name."',
					`alias`='".$this->Alias."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_category` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}
	
	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_category` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}
	
	public function getAlias($catId) {
		$sql="SELECT `alias` FROM `tbl_category` WHERE `id`='".$catId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['alias'];
		} 
		return '';	
	}

	public function getCategoryByGroup($groupId) {
		$sql="SELECT * FROM `tbl_category` WHERE `group`='".$groupId."'";		
		// echo $sql;
		return $this->objmysql->Query($sql);	

	}
}
?>