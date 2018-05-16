<?php
class CLS_CUSTOMER_DETAIL{
	private $pro=array(
		'ID'=>'0',
		'CustomerId'=>'',
		'SubCatId'=>'',
		'Json'=>'',
		'Cdate'=>''
		);
	private $objmysql=null;
	public function CLS_CUSTOMER_DETAIL(){
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
		$sql="INSERT INTO `tbl_customer_detail`(`customer_id`,`sub_cat_id`,`json`,`cdate`) 
		VALUES ('".$this->CustomerId."','".$this->SubCatId."',N'".$this->Json."','".$cdate."')";

		// echo $sql; 
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_customer_detail` WHERE  `customer_id`= '".$this->CustomerId."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}

	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_customer_detail` WHERE 1=1 ".$where.$limit;		
		// echo $sql;
		return $this->objmysql->Query($sql);
	}

	public function getIdByPhone($phone) {
		$sql="SELECT `id` FROM `tbl_customer_detail` WHERE `phone`='".$phone."'";
		$this->objmysql->Query($sql);	
		if ($this->objmysql->Num_rows() > 0) {
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['id'];
		} 
		return '0';
	}

	public function getListPhoneNumberByIds($listId) {
		$sql="SELECT `phone` FROM `tbl_customer_detail` WHERE `id` in '".$listId."'";
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
	
}
?>