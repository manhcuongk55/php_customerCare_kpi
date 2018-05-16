<?php
class CLS_MEMBERLEVEL{
	private $pro=array(
		'ID'=>'0',
		'Username'=>'',
		'Password'=>'',
		'Fullname'=>'',
		'Gender'=>'',
		'Phone'=>'',
		'Email'=>'',
		'Birthday'=>'',
		'Identify'=>'',
		'Position'=>'',
		'Permistion'=>'',
		'IsActive'=>'1',
		'Avatar'=>'',	
		'Cdate'=>'',
		'Mdate'=>'');
	private $objmysql=null;
	private $total=0;
	private $result=array();
	public function CLS_MEMBERLEVEL(){
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
	public function Query($sql){
		return $this->objmysql->Query($sql);
	}

	public function getInfoMember($id) {
		$sql="SELECT * FROM `tbl_member_level` WHERE 1=1 and id='".$id."'";
		return $this->objmysql->Query($sql);
	}
	
	public function getList($where=' ',$limit=' '){
		$sql="SELECT * FROM `tbl_member_level` WHERE 1=1 ".$where.$limit;
		//echo $sql;
		return $this->objmysql->Query($sql);
	}

	public function getListAccountByOrgId($idOrg) {
		$sql="SELECT * FROM tbl_member_level WHERE `id_org`='$idOrg'";		
		return $this->objmysql->Query($sql);
	}

	public function getInfoUserById($id){
		$sql = "SELECT * FROM `tbl_member_level` WHERE id = '$id'";
		return $this->objmysql->Query($sql);
	}

	public function getPhoneByUser($user){
		$sql="SELECT * FROM `tbl_member_level` WHERE username='$user'";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['phone'];
	}
	public function getBankAccountByUser($user){
		$sql="SELECT * FROM `tbl_member_level` WHERE username='$user'";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['stk'];
	}	
	
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}

	public function Add_new(){
		$cdate = date('Y/m/d H:i:s');

		$sql="INSERT INTO `tbl_member_level`(
		`username`,`password`,`fullname`,`gender`,`phone`,`email`,
		`identify`,`birthday`,`position`,`permistion`,`cdate`,`mdate`,`isactive`, `avatar`) VALUES (
		'".$this->Username."','".$this->Password."',N'".$this->Fullname."',
		'".$this->Gender."','".$this->Phone."','".$this->Email."','".$this->Identify."',
		'".$this->Birthday."','".$this->Position."','".$this->Permistion."','".$cdate."','".$cdate."','".$this->IsActive."', '".$this->Avatar."')";
		
		// echo $sql;
		// die;
		return $this->objmysql->Exec($sql);
	}
	public function Update(){
		$cdate = date('Y/m/d H:i:s');
		$sql = "UPDATE tbl_member_level SET										
				`username`='".$this->Username."',
				`fullname`=N'".$this->Fullname."',
				`permistion`='".$this->Permistion."',
				`phone`='".$this->Phone."', 
				`gender`='".$this->Gender."',
				`email`='".$this->Email."',
				`identify`='".$this->Identify."',
				`birthday`='".$this->Birthday."',
				`mDate`='".$cdate."'
				WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_member_level` WHERE `id`='".$this->ID."'";
        return $this->objmysql->Exec($sql1);
	}

	public function UserExist($user){
		$sql = "SELECT * FROM tbl_member_level WHERE username='$user'";
		$this->objmysql->Query($sql);
		return $this->objmysql->Num_rows();
	}
	
	public function ChangePass($user,$pass){
		$sql="UPDATE tbl_member_level SET password='$pass' WHERE username='$user' ";
		return $this->objmysql->Exec($sql);
	}
	
	public function LOGIN($user,$pass){
		$flag=true;
		$pass=md5(sha1($pass));
		if($user=='' || $pass=='')
			$flag=false;
		$sql="SELECT * FROM `tbl_member_level` WHERE `username`='$user' AND `isactive`=1";
		$this->objmysql->Query($sql);
		$rows='';
		if($this->objmysql->Num_rows()>0){
			$rows=$this->objmysql->Fetch_Assoc();
			if($rows['password']!=$pass)
				$flag=false;
		}
		else{
			$flag=false;
		}
		if($flag==true){
			$_SESSION['MLEVELISLOGIN']=$rows;
		}
		return $flag;
	}
	public function isLogin(){
		if(isset($_SESSION['MLEVELISLOGIN']))
			return true;
		return false;
	}
	public function LOGOUT(){
		unset($_SESSION['MLEVELISLOGIN']);
	}
	public function getInfo($name){
		if(!isset($_SESSION['MLEVELISLOGIN'][$name]))
			return "N/A";
		return $_SESSION['MLEVELISLOGIN'][$name];
	}
    public function getMemberUsername(){
        return isset($_SESSION['MLEVELUSER'])?$_SESSION['MLEVELUSER']['username']:'';
    }
        
    public function getMemberLogin(){
        return $_SESSION['MLEVELUSER'];
    }

   	public function GetPassword($id) {
   		$sql ="SELECT `password` from tbl_member_level WHERE `id`='$id'";
   		$this->objmysql->Query($sql);
   		$r =  $this->objmysql->Fetch_Assoc();
   		return $r['password'];
   	}

   	public function UpdatePassword($newPass, $id) {
   		$sql = "UPDATE tbl_member_level SET `password` = '".$newPass."' WHERE `id` = '$id'";
   		return $this->objmysql->Exec($sql);
   	}
	
	public function getNameUserById($id) {
		$sql="SELECT * FROM `tbl_member_level` WHERE `id`='".$id."' ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['fullname'];
	}

	public function getListPosition() {
		$sql = "SELECT * FROM tbl_position";
		$this->objmysql->Query($sql);
		$html ="";
		while ($r = $this->objmysql->Fetch_Assoc()) {
			$html.= "<option value='".$r['id']."'>".$r['position']."</option>";
		}

		echo  $html;
	}

	public function getFireBaseIdSuper () {
		$sql="SELECT `firebase_id`,`type_platform` FROM tbl_member_level WHERE `permistion`=1";
		return $this->objmysql->Query($sql);
	}

	public function getInfoNotifyById($memId) {
		$sql="SELECT `firebase_id`,`type_platform` FROM tbl_member_level WHERE `id`='$memId'";
		$this->objmysql->Query($sql);	
		return $this->objmysql->Fetch_Assoc();
	}

}
?>