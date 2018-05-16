<?php
class CLS_SUBCAT {
	private $pro=array(
		'ID'=>'0',
		'CatId'=>'',
		'Name'=>'',
		'Alias'=>'',
		'Cdate'=>'',
		'IsActive'=>''
		);
	private $objmysql=null;
	public function CLS_SUBCAT(){
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
		
		$sql="INSERT INTO `tbl_sub_category`(`cat_id`,`name`,`alias`,`cdate`,`isactive`) 
		VALUES ('".$this->CatId."',N'".$this->Name."','".$this->Alias."',
				'".$cdate."','".$this->IsActive."')";
		return $this->objmysql->Exec($sql);
	}

	public function addNewHoby() {
		$objmysql=new CLS_MYSQL;
		$cdate=date('Y/m/d H:i:s');
		$objmysql->Exec("BEGIN");

		$sql="INSERT INTO `tbl_sub_category`(`cat_id`,`name`,`alias`,`cdate`,`isactive`) 
		VALUES ('".$this->CatId."',N'".$this->Name."','".$this->Alias."',
				'".$cdate."','".$this->IsActive."')";

		$result = $objmysql->Exec($sql);		
		$subCatId = $objmysql->LastInsertID();
		if($result){
			$objmysql->Exec('COMMIT');
			return $subCatId;
		}
		else	$objmysql->Exec('ROLLBACK');
	}

	public function Update() {
		$sql = "UPDATE tbl_sub_category SET 
					`cat_id`='".$this->CatId."', 
					`name`='".$this->Name."',
					`alias`='".$this->Alias."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_sub_category` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}
	
	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_sub_category` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}

	public function getAliasSubCat($idCat) {
		$sql="SELECT `alias` FROM `tbl_sub_category` WHERE id=$idCat";
		$this->objmysql->Query($sql);
		$rs = $this->objmysql->Fetch_Assoc();
		return $rs['alias'];
	}
	public function getCateName($catId) {
		$sql="SELECT `name` FROM `tbl_sub_category` WHERE `id`='".$catId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['name'];
		} 
		return '';	
	}

	public function getSubCatName($catId) {
		$sql="SELECT * FROM `tbl_sub_category` WHERE `id`='".$catId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			
			$sql="SELECT `name`,`group` FROM `tbl_category` WHERE `id`='".$rs['cat_id']."'";
			$this->objmysql->Query($sql);	
			$r = $this->objmysql->Fetch_Assoc();
			
			$sql="SELECT `name` FROM `tbl_group` WHERE `value`='".$r['group']."'";
			$this->objmysql->Query($sql);	
			$r1 = $this->objmysql->Fetch_Assoc();

			return "<span>".$r1['name']."</span><br/>&nbsp;&nbsp;&nbsp;---<span>".$r['name']."</span><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---<span>".$rs['name']."</span>";
		} 
		return '';	
	}

	public function getAlias($catId) {
		$sql="SELECT `alias` FROM `tbl_sub_category` WHERE `id`='".$catId."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['alias'];
		} 
		return '';	
	}

	public function getCatId($id) {
		$sql="SELECT `cat_id` FROM `tbl_sub_category` WHERE `id`='".$id."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['cat_id'];
		} 
		return '';	
	}
	
	public function getSubCategory($catId) {
		$sql="SELECT * FROM `tbl_sub_category` WHERE `cat_id`='".$catId."'";
		return $this->objmysql->Query($sql);
	}

	public function getCategoryName($subCatId) {
		$catId = $this->getCatId($subCatId);
		$sql="SELECT `name` FROM tbl_category WHERE id='$catId'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['name'];
		} 
		return '';		
	}
}
?>