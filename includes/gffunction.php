<?php
function paging($total_rows,$max_rows,$cur_page){
	$max_pages=ceil($total_rows/$max_rows);
	$start=$cur_page-5; if($start<1)$start=1;
	$end=$cur_page+5;	if($end>$max_pages)$end=$max_pages;
	$paging='<div class="paging">
	<form action="" method="post" name="frmpaging" id="frmpaging">
	<input type="hidden" name="txtCurnpage" id="txtCurnpage" value="1" />';
	$paging.="<strong>Total:</strong> $total_rows <strong>on</strong> $max_pages <strong>page</strong><br>";
	if($cur_page >1)
	$paging.='<a href="javascript:gotopage('.($cur_page-1).')"> << </a>';
	if($max_pages>1){
		for($i=$start;$i<=$end;$i++)
		{
			if($i!=$cur_page)
			$paging.="<a href=\"javascript:gotopage($i)\"> $i </a>";
			else
			$paging.="<a href=\"#\" class=\"cur_page\"> $i </a>";
		}
	}
	if($cur_page <$max_pages)
	$paging.='<a href="javascript:gotopage('.($cur_page+1).')"> >> </a>';
	$paging.='</div></form>';
	echo $paging;
}
function paging_index($total_rows,$max_rows,$cur_page){
	$max_pages=ceil($total_rows/$max_rows);
	$start=$cur_page-5; if($start<1)$start=1;
	$end=$cur_page+5;	if($end>$max_pages)$end=$max_pages;
	$paging='<div class="paging">
	<form action="" method="post" name="frmpaging" id="frmpaging">
	<input type="hidden" name="txtCurnpage" id="txtCurnpage" value="'.$cur_page.'" />';
	if($cur_page >1)
		$paging.='<a href="javascript:gotopage('.($cur_page-1).')" class="cur_page"> < </a>';
	if($max_pages>1){
		for($i=$start;$i<=$end;$i++)
		{
			if($i!=$cur_page)
			$paging.="<a href=\"javascript:gotopage($i)\"> $i </a>";
			else
		      $paging.="<a href=\"#\" class=\"cur_page\" > $i </a>";
		}
	}
	if($cur_page <$max_pages)
		$paging.='<a href="javascript:gotopage('.($cur_page+1).')"> > </a>';
	$paging.='</form></div>';
	echo $paging;
}
function product_paging($total_rows,$max_rows,$cur_page){
	$max_pages=ceil($total_rows/$max_rows);
	if($max_pages<=1) return;
	$start=$cur_page-5; if($start<1)$start=1;
	$end=$cur_page+5;	if($end>$max_pages)$end=$max_pages;
	$paging="<div class='paging'>";
	if($cur_page >1)
		$paging.='<a href="javascript:gotopage('.($cur_page-1).')" class="cur_page"> PRE </a>';
	if($max_pages>1){
		for($i=$start;$i<=$end;$i++){
			if($i==$cur_page)
				$paging.="<a rel=\"noindex, nofollow\" href='#' class='active'>$i</a>";
			else
				$paging.="<a rel=\"noindex, nofollow\" href='#'>$i</a>";
		}
	}
	if($cur_page <$max_pages)
		$paging.='<a href="javascript:gotopage('.($cur_page+1).')"> NEXT </a>';
	$paging.='</div>';
	echo $paging;
}
// Make a textarea with name is $name
function Create_textare($txtname,$obj){
	echo '<textarea name="'.$txtname.'" id="'.$txtname.'" rows=4 cols=30>&nbsp;</textarea>';
	echo '<script>';
	echo 'var '.$obj.' = new InnovaEditor("'.$obj.'");';
	echo ''.$obj.'.width="100%";';
	echo ''.$obj.'.height="300";';
	echo $obj.".cmdAssetManager = \"modalDialogShow('/GFCMS/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)\"; ";
	echo ''.$obj.'.REPLACE("'.$txtname.'");';
	echo '</script>';
}
function encodeHTML($sHTML){
	$sHTML=str_replace('"','\"',$sHTML);
	return $sHTML;
}
function uncodeHTML($sHTML){
	$sHTML=str_replace('\"','"',$sHTML);
	return $sHTML;
}
function Substring($str,$start,$len){
	$str=str_replace("  "," ",$str);
	$arr=explode(" ",$str);
	if($start>count($arr))	$start=count($arr);
	$end=$start+$len;
	if($end>count($arr))	$end=count($arr);
	$newstr="";
	for($i=$start;$i<$end;$i++)
	{
		if($arr[$i]!="")
		$newstr.=$arr[$i]." ";
	}
	if($len<count($arr)) $newstr.="...";
	return $newstr;
}
function showIconFun($fun,$value){
	$filename="noimage.gif";
	$title="no image";
	switch($fun){
		case "menuitem": 
			$title="Menu Item";
			$filename="menuitem.png"; 
			break;
		case "delete": 
			$title=CDELETE;
			$filename="delete.png"; 
			break;
		case "edit": 
			$title=CEDIT;
			$filename="icon_edit.png"; 
			break;
		case "lock_open": 
			$title='Lock';
			$filename="lock_open.png"; 
			break;
		case "lock_closed": 
			$title='unLock';
			$filename="lock_closed.png"; 
			break;
		case "publish": 
			if($value==1){
				$title=CPUBLIC;
				$filename="publish.png";
			}
			else{
				$title=CUNPUBLIC;
				$filename="unpublish.png";
			}
			break;
		case "show": 
			if($value==1){
				$title="Show";
				$filename="publish.png";
			}
			else{
				$title="Hidden";
				$filename="icon_nodefault.png";
			}
			break;
		case "isfronpage":
			if($value==1) {
				$title="Front page";
				$filename="icon_isfront.png"; 
			}else{ 
				$title="Admin";
				$filename="icon_nofront.png";
			}
			break;
		case "isdefault":
			if($value==1) {
				$title="Default";
				$filename="icon_default.png"; 
			}
			else {
				$title="Not default";
				$filename="icon_nodefault.png";
			}
			break;
	}
	echo "<img border=0 height=\"15\" src=\"".IMG_PATH."$filename\" title=\"$title\"/>";
}
function MENUS_ASSIGN(){
	$objdata=new CLS_MYSQL();
	if(!isset($objmenuitem))
	$objmenuitem=new CLS_MENUITEM();
	
	$sql="SELECT * FROM `view_menu` WHERE `isactive`=\"1\"";
	$objdata->Query($sql);
	while($row_menu=$objdata->Fetch_Assoc()){
		echo "<option onclick=\"getIDs();\" value=\"\" class=\"menutype\">".$row_menu["name"]."</option>";
		echo $objmenuitem->getListMenuItem($row_menu["mnu_id"],0,1);
	}
}
function LoadPosition(){
  $doc = new DOMDocument();
  $doc->load(THIS_TEM_ADMIN_PATH.'template.xml');
  $options = $doc->getElementsByTagName("position");
  
  foreach( $options as $option )
  { 
  	  $opts = $option->getElementsByTagName("option");
	  foreach($opts as $opt)
	  {
		  echo "<option value=\"".$opt->nodeValue."\">".$opt->nodeValue."</option>";
	  }
  }
}
function LoadModBrow($mod_name){
	$path="../".MOD_PATH.$mod_name."/brow";
	//echo $path;
	if(!is_dir($path))
		return;
	$objdir=dir($path);
	while($file=$objdir->read()){
		if(is_file($path."/".$file) && $file!="." && $file!=".." ){
			$file=substr($file,0,strlen($file)-4);
			echo "<option value=\"".$file."\">".$file."</option>";
		}
	}
	return ;
}
function LoadModType(){
	$path="../modules";
	if(!is_dir($path))
		return;
	$objdir=dir($path);
	while($dir=$objdir->read()){
		if(is_dir($path."/".$dir) && $dir!="." && $dir!=".." )
			echo "<option value=\"".$dir."\">".$dir."</option>";
	}
	return ;
}
function un_unicode($str){
	$marTViet=array(
	'à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă',
	'ằ','ắ','ặ','ẳ','ẵ','è','é','ẹ','ẻ','ẽ','ê','ề'
	,'ế','ệ','ể','ễ',
	'ì','í','ị','ỉ','ĩ',
	'ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ'
	,'ờ','ớ','ợ','ở','ỡ',
	'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ',
	'ỳ','ý','ỵ','ỷ','ỹ',
	'đ',
	'A','B','C','D','E','F','J','G','H','I','K','L','M',
	'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	'À','Á','Ạ','Ả','Ã','Â','Ầ','Ấ','Ậ','Ẩ','Ẫ','Ă'
	,'Ằ','Ắ','Ặ','Ẳ','Ẵ',
	'È','É','Ẹ','Ẻ','Ẽ','Ê','Ề','Ế','Ệ','Ể','Ễ',
	'Ì','Í','Ị','Ỉ','Ĩ',
	'Ò','Ó','Ọ','Ỏ','Õ','Ô','Ồ','Ố','Ộ','Ổ','Ỗ','Ơ'
	,'Ờ','Ớ','Ợ','Ở','Ỡ',
	'Ù','Ú','Ụ','Ủ','Ũ','Ư','Ừ','Ứ','Ự','Ử','Ữ',
	'Ỳ','Ý','Ỵ','Ỷ','Ỹ',
	'Đ',",","?","`","~","!","@","#","$","%","^","&","*","(",")","'",'"','&','/','|','','  ',' ','---','--');

	$marKoDau=array('a','a','a','a','a','a','a','a','a','a','a',
	'a','a','a','a','a','a',
	'e','e','e','e','e','e','e','e','e','e','e',
	'i','i','i','i','i',
	'o','o','o','o','o','o','o','o','o','o','o','o'
	,'o','o','o','o','o',
	'u','u','u','u','u','u','u','u','u','u','u',
	'y','y','y','y','y',
	'd',
	'a','b','c','d','e','f','j','g','h','i','k','l','m',
	'n','o','p','q','r','s','t','u','v','w','x','y','z',
	'a','a','a','a','a','a','a','a','a','a','a','a'
	,'a','a','a','a','a',
	'e','e','e','e','e','e','e','e','e','e','e',
	'i','i','i','i','i',
	'o','o','o','o','o','o','o','o','o','o','o','o'
	,'o','o','o','o','o',
	'u','u','u','u','u','u','u','u','u','u','u',
	'y','y','y','y','y',
	'd',"","","","","","","","","","","","",'','','','','','','',' ',' ','_','-','-');

	$str = str_replace($marTViet, $marKoDau, $str);
	return $str;
}

function un_unicode_sms($str){
	$marTViet=array(
	'à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă',
	'ằ','ắ','ặ','ẳ','ẵ','è','é','ẹ','ẻ','ẽ','ê','ề'
	,'ế','ệ','ể','ễ',
	'ì','í','ị','ỉ','ĩ',
	'ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ'
	,'ờ','ớ','ợ','ở','ỡ',
	'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ',
	'ỳ','ý','ỵ','ỷ','ỹ',
	'đ',	
	'À','Á','Ạ','Ả','Ã','Â','Ầ','Ấ','Ậ','Ẩ','Ẫ','Ă'
	,'Ằ','Ắ','Ặ','Ẳ','Ẵ',
	'È','É','Ẹ','Ẻ','Ẽ','Ê','Ề','Ế','Ệ','Ể','Ễ',
	'Ì','Í','Ị','Ỉ','Ĩ',
	'Ò','Ó','Ọ','Ỏ','Õ','Ô','Ồ','Ố','Ộ','Ổ','Ỗ','Ơ'
	,'Ờ','Ớ','Ợ','Ở','Ỡ',
	'Ù','Ú','Ụ','Ủ','Ũ','Ư','Ừ','Ứ','Ự','Ử','Ữ',
	'Ỳ','Ý','Ỵ','Ỷ','Ỹ',
	'Đ',",","?","`","~","!","@","#","$","%","^","&","*","(",")","'",'"','&','/','|');

	$marKoDau=array('a','a','a','a','a','a','a','a','a','a','a',
	'a','a','a','a','a','a',
	'e','e','e','e','e','e','e','e','e','e','e',
	'i','i','i','i','i',
	'o','o','o','o','o','o','o','o','o','o','o','o'
	,'o','o','o','o','o',
	'u','u','u','u','u','u','u','u','u','u','u',
	'y','y','y','y','y',
	'd',	
	'a','a','a','a','a','a','a','a','a','a','a','a'
	,'a','a','a','a','a',
	'e','e','e','e','e','e','e','e','e','e','e',
	'i','i','i','i','i',
	'o','o','o','o','o','o','o','o','o','o','o','o'
	,'o','o','o','o','o',
	'u','u','u','u','u','u','u','u','u','u','u',
	'y','y','y','y','y',
	'd',"","","","","","","","","","","","",'','','','','','','');

	$str = str_replace($marTViet, $marKoDau, $str);
	return $str;
}
function show_catalog($par,$type){
	$objdata=ConnectServer($type);
	$sql="SELECT cat_id,`alias`,`name` FROM `tbl_catalog`  WHERE isactive=1 AND par_id='$par' ";
	$objdata->Query($sql);
	if($objdata->Num_rows()>0){
		echo '<ul>';
		while($row=$objdata->Fetch_Assoc()){
			$class='';
			if($_SESSION['CUR_CAT']==$row['alias'])
				$class='class="active"';
			echo "<li $class id='item-".$row['alias']."'><a href='".ROOTHOST.trans_type($type).'/'.$row['alias']."' title='".$row['name']."'><span>".$row['name']."</span></a>";
			show_catalog($row['cat_id'],$type);
			echo "</li>";
		}
		echo '</ul>';
	}
}
function anti_injection($sql){
$s = array("`","~","!","@","#","$","%","^","&","*","(",")","+","=","[","]",";","<",">","http","//","www");
$sql = str_replace($s, "", $sql);
$sql = preg_replace(sql_regcase("/(from|truncate|expalin|select|insert|delete|where|update|empty|drop table|limit|show tables|#|\*|--|\\\\)/"),"",$sql);
$sql = trim($sql); // strip whitespace
$sql = strip_tags($sql); // strip HTML and PHP tags
$sql = addslashes($sql); // quote string with slashes
return $sql;
}

function MenhNguHanh($namsinh) {
  $can = array(
    '0' => 'Canh',
    '1' => 'Tân',
    '2' => 'Nhâm',
    '3' => 'Quý',
    '4' => 'Giáp',
    '5' => 'Ất',
    '6' => 'Bính',
    '7' => 'Đinh',
    '8' => 'Mậu',
    '9' => 'Kỷ'
);

$chi = array(
    '0' => 'Tý',
    '1' => 'Sử',
    '2' => 'Dần',
    '3' => 'Mão',
    '4' => 'Thìn',
    '5' => 'Tỵ',
    '6' => 'Ngọ',
    '7' => 'Mùi',
    '8' => 'Thân',
    '9' => 'Dậu',
    '10' => 'Tuất',
    '11' => 'Hợi'
);

$menh_ngu_hanh = array(
  'Giáp Tý' => 'Hải trung kim',
  'Ất Sửu' => 'Hải trung kim',
  'Bính Dần' => 'Lô trung hỏa',
  'Đinh Mão' => 'Lô trung hỏa',
  'Mậu Thìn' => 'Đại lâm mộc',
  'Kỷ Tỵ' => 'Đại lâm mộc',
  'Canh Ngọ' => 'Lộ bàng thổ',
  'Tân Mùi' => 'Lộ bàng thổ',
  'Nhâm Thân' => 'Kiếm phong kim',
  'Quý Dậu' => 'Kiếm phong kim',
  'Giáp Tuất' => 'Sơn đầu hỏa',
  'Ất Hợi' => 'Sơn đầu hỏa',
  'Bính Tý' => 'Giản hạ thủy',
  'Đinh Sửu' => 'Giản hạ thủy',
  'Mậu Dần' => 'Thành đầu thổ',
  'Kỷ Mão' => 'Thành đầu thổ',
  'Canh Thìn' => 'Bạch lạp kim',
  'Tân Tỵ' => 'Bạch lạp kim',
  'Nhâm Ngọ' => 'Dương liễu mộc',
  'Quý Mùi' => 'Dương liễu mộc',
  'Giáp Thân' => 'Tuyền trung thủy',
  'Ất Dậu' => 'Tuyền trung thủy',
  'Bính Tuất' => 'Ốc thượng thổ',
  'Đinh Hợi' => 'Ốc thượng thổ',
  'Mậu Tý' => 'Bích lôi hỏa',
  'Kỷ Sửu' => 'Bích lôi hỏa',
  'Canh Dần' => 'Tùng bách mộc',
  'Tân Mão' => 'Tùng bách mộc',
  'Nhâm Thìn' => 'Trường lưu thủy',
  'Quý Tỵ' => 'Trường lưu thủy',
  'Giáp Ngọ' => 'Sa trung kim',
  'Ất Mùi' => 'Sa trung kim',
  'Bính Thân' => 'Sơn hạ hỏa',
  'Đinh Dậu' => 'Sơn hạ hỏa',
  'Mậu Tuất' => 'Bình địa mộc',
  'Kỷ Hợi' => 'Bình địa mộc',
  'Canh Tý' => 'Bích thượng thổ',
  'Tân Sửu' => 'Bích thượng thổ',
  'Nhâm Dần' => 'Kim bạc kim',
  'Quý Mão' => 'Kim bạc kim',
  'Giáp Thìn' => 'Phú đăng hỏa',
  'Ất Tỵ' => 'Phú đăng hỏa',
  'Bính Ngọ' => 'Thiên hà thủy',
  'Đinh Mùi' => 'Thiên hà thủy',
  'Mậu Thân' => 'Đại dịch thổ',
  'Kỷ Dậu' => 'Đại dịch thổ',
  'Canh Tuất' => 'Thoa xuyến kim',
  'Tân Hợi' => 'Thoa xuyến kim',
  'Nhâm Tý' => 'Tang thạch mộc',
  'Quý Sửu' => 'Tang thạch mộc',
  'Giáp Dần' => 'Đại khê thủy',
  'Ất Mão' => 'Đại khê thủy',
  'Bính Thìn' => 'Sa trung thổ',
  'Đinh Tỵ' => 'Sa trung thổ',
  'Mậu Ngọ' => 'Thiên thượng hỏa',
  'Kỷ Mùi' => 'Thiên thượng hỏa',
  'Canh Thân' => 'Thạch Lựu mộc',
  'Tân Dậu' => 'Thạch Lựu mộc',
  'Nhâm Tuất' => 'Đại hải thủy',
  'Quý Hợi' => 'Đại hải thủy'
);
//hiển thị mệnh ngũ hành. Ví dụ: $menh_ngu_hanh['Mậu Thình]; echo ra kết quả Đại lâm mộc

//chuyển thành mảng 
$arr_namsinh = str_split($namsinh);
//lấy ra can 
$can_namsinh = $can[end($arr_namsinh)];

//lấy 2 số cuối của năm sinh
$y2k = substr($namsinh, -2, strlen($namsinh));
$chi_namsinh = $chi[$y2k % 12];
return $menh_ngu_hanh[$can_namsinh.' '.$chi_namsinh]; 
}

function contains_array($array){
    foreach($array as $value){
        if(is_array($value)) {
          return true;
        }
    }
    return false;
}

?>