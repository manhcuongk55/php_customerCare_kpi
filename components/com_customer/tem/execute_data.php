<?php
require_once("../../../includes/gfinnit.php");
require_once("../../../includes/gfconfig.php");
require_once("../../../includes/gffunction.php");
require_once("../../../libs/cls.mysql.php");
require_once("../../../libs/cls.customer.php");
require_once("../../../libs/cls.customer.detail.php");
require_once("../../../libs/cls.category.php");
require_once("../../../libs/cls.subcat.php");
require_once("../../../libs/cls.field.infomation.php");

$objCustomer = new CLS_CUSTOMER;
$objSubCat = new CLS_SUBCAT;
$objCat = new CLS_CATEGORY;
$objFieldInfo = new CLS_FIELD_INFOMATION;

// Lấy danh sách sub category theo từng group thông tin

if ($_POST['txt_type'] == GROUP_CANHAN) {
	$objCat->getList(" AND `group`='".GROUP_CANHAN."'", "");

} else if ($_POST['txt_type'] == GROUP_DOANHNGHIEP) {
	$objCat->getList(" AND `group`='".GROUP_DOANHNGHIEP."'", "");

} else {
	$objCat->getList(" AND `group`='".GROUP_TOCHUC."'", "");
}

$strsCatId = "";
while ($rs=$objCat->Fetch_Assoc()) {
	$strsCatId.=$rs['id'].',';
}
// echo $strsCatId;die;
$strsCatId = substr($strsCatId, 0, strlen($strsCatId)-1);
$strsCatId = str_replace(",", "','", $strsCatId);

// get list iD sub category
$objSubCat->getList(" AND `cat_id` IN ('$strsCatId')" ,"");
// get list iD sub category
$lstObjSubCat = array();

while ($rs=$objSubCat->Fetch_Assoc()) {
	$oo = new CLS_SUBCAT;
	$oo->ID = $rs['id'];
	$oo->CatId = $rs['cat_id'];
	$oo->Name = $rs['name'];
	$oo->Alias = $rs['alias'];
	array_push($lstObjSubCat, $oo);
}

$prefix = "";
// // get list object option field
// $objFieldInfo->getList("" ,"");
// $lstObjFieldInfo = array();
// while ($rs=$objFieldInfo->Fetch_Assoc()) {
// 	$obj = new CLS_FIELD_INFOMATION;
// 	$obj->ID = $rs['id'];
// 	$obj->SubCatId = $rs['sub_cat_id'];
// 	$obj->Alias = $rs['alias'];
// 	$obj->Name = $rs['name'];
// 	$obj->DataType = $rs['data_type'];
// 	array_push($lstObjFieldInfo, $obj);
// }


if (isset($_POST['txt_type'])) {	
	// khởi tạo mảng json lưu trữ thông tin khách hàng
	$arrayJsonData = array(); // Lưu trữ thông tin khách hàng
	

	foreach ($lstObjSubCat as $k => $itemObjSubCat) {

		$prefix = 'gr'.$itemObjSubCat->CatId.'_'.$itemObjSubCat->ID.'_';
		
		$strJson = '{"sub_cat_id":"'.$itemObjSubCat->ID.'","'.$itemObjSubCat->Alias.'" : {';

		$aryData = array(); // Mang lưu trữ dữ liệu đối với trường Post lên kiểu mảng []
		$arrayImage = array(); // Lưu hinh ảnh đại diện quan hệ gia đình
		
		$strImage = "";


		// get list object option field
		$objFieldInfo->getList(" AND `sub_cat_id`='".$itemObjSubCat->ID."'" ," ORDER BY `sort` asc");
		$lstObjFieldInfo = array();
		while ($rs=$objFieldInfo->Fetch_Assoc()) {
			$obj = new CLS_FIELD_INFOMATION;
			$obj->ID = $rs['id'];
			$obj->SubCatId = $rs['sub_cat_id'];
			$obj->Alias = $rs['alias'];
			$obj->Name = $rs['name'];
			$obj->DataType = $rs['data_type'];
			array_push($lstObjFieldInfo, $obj);
		}


		foreach ($lstObjFieldInfo as $key => $itemFieldInfo) {		
			
			if ($itemFieldInfo->SubCatId == $itemObjSubCat->ID) {

				if (isset($_POST[$prefix.$itemFieldInfo->Alias])) {

					$data = $_POST[$prefix.$itemFieldInfo->Alias];

					// check data is array object hay khong
					if (is_array($data)) {
						// xu ly data
						//echo  $prefix;
						if (count($aryData) > 0) {
							// cong them cac gia tri vao chuoi  string ban dau
							for ($i=0; $i < count($aryData); $i++) { 
								if (count($aryData) == count($data)) {
									$aryData[$i] .= trim('"'.$itemFieldInfo->Alias.'":'.'"'.$data[$i].'"'.',');	
								}
							}

						} 
						else {
							// khoi tao chuoi string ban dau sau do add vao mang
							for ($m=0; $m < count($data); $m++) {
								$strTmp = '"'.$itemFieldInfo->Alias.'":'.'"'.$data[$m].'"'.',';
								array_push($aryData, $strTmp);
							}
							
						}

					} else {
						// Data du lieu dang POST thuan khong phai mang

						$strJson.= '"'.$itemFieldInfo->Alias.'":'.'"'.$data.'"'.',';	
					}
					
				} else {
					// Save gioi tinh/tinh trang hon nhan quan he gia dinh
					if (($prefix == "gr3_19_" && $itemFieldInfo->Alias == "gioi_tinh") || 
						($prefix == "gr3_20_" && $itemFieldInfo->Alias == "tinh_trang_ket_hon")) {
						if (count($aryData) > 0) {
							for ($i=0; $i < count($aryData); $i++) { 
								$dem = $i+1;
								if (isset($_POST[$prefix.$itemFieldInfo->Alias.$dem])) {
									$data = $_POST[$prefix.$itemFieldInfo->Alias.$dem];
									$aryData[$i] .= trim('"'.$itemFieldInfo->Alias.'":'.'"'.$data[0].'"'.',');		
								}
								
							}
						}
					}
					// ket thuc

					// Xử lý về hình ảnh
					if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST" and $itemFieldInfo->DataType == "file") {
						// ----------------UPLOAD FILE -----------------
						
					    $valid_formats = array("jpg", "png","doc","docx","xls","xlsx","gif");
						$max_file_size = 1024*10000;
						$path = "../../../uploads/avatar/";
						$strFile = "";
						
						// Loop $_FILES to execute all files
						$nameFile = '';
						$namePost = $prefix.$itemFieldInfo->Alias.'_files';

						foreach ($_FILES[$namePost]['name'] as $f => $nameFile) { 

							$nameFile = un_unicode($nameFile);    
						    if ($_FILES[$namePost]['error'][$f] == 4) {
						        continue; // Skip file if any error found
						    }	       
						    if ($_FILES[$namePost]['error'][$f] == 0) {	           
						        if ($_FILES[$namePost]['size'][$f] > $max_file_size) {
						            $message[] = "$nameFile is too large!.";
						            continue; // Skip large files
						        }
								elseif( ! in_array(pathinfo($nameFile, PATHINFO_EXTENSION), $valid_formats) ){
									$message[] = "$nameFile is not a valid format";
									continue; // Skip invalid file formats
								}
						        else{ // No error found! Move uploaded files
						            if(move_uploaded_file($_FILES[$namePost]["tmp_name"][$f], $path.$nameFile)) {
						            	$strFile = $path.$nameFile;
						            }
						        }
						    }
						} // end foreach
						// die($strFile);
						// TH chỉnh sửa thông tin cá nhân, không thực hiện upload ảnh mới, sẽ lấy đường dẫn ảnh cũ
						if (isset($_POST['txt_id']) && $strFile != "") {
							$strFile.= $_POST[$prefix][$itemFieldInfo->Alias];
						}
						// end
						$strFile = str_replace("../", "", $strFile);
						$strJson.= '"'.$itemFieldInfo->Alias.'":'.'"'.$strFile.'"'.',';	

						// Push array image
						$arrayImage = $_FILES[$namePost]['name'];
						
					} // end if
					
				}// end else


			}

		} 
		// end foreach-> ket thuc mot nhom thong tin
		
		// Du lieu dang mang
		if (count($aryData) > 0) {
			$strJson = '{"sub_cat_id":"'.$itemObjSubCat->ID.'","'.$itemObjSubCat->Alias.'" : [';
			
			for ($i=0; $i < count($aryData); $i++) { 
				$strs = '{'.substr($aryData[$i], 0, strlen($aryData[$i])-1);

				// Tính toán mệnh
				$objJson = json_decode($strs, TRUE);
				if (isset($objJson['ngay_sinh'])) {
					$menh = MenhNguHanh(date("Y", strtotime($objJson['ngay_sinh'])));	
					$menh = '"menh":"'.$menh.'"';				
					$strs = str_replace('"menh":""', $menh, $strs);				
				}

				// hinh anh
				if (count($arrayImage) > 0) {
					$hinhanh = '"hinh_anh":"'.$arrayImage[$i].'"';
					$strs.=",".$hinhanh;	
				}
				
				
				$stringJson = $strs.'}';
				$stringJson = $strs.'}';
				$objStr = json_decode($stringJson, true);
				
				if ($itemObjSubCat->Alias == 'qua_trinh_hoc_tap') {
					
					if (isset($objStr['from_year']) && $objStr['from_year'] != "") {
						$strJson .= $strs.'},'; 		
					}

				} else if ($itemObjSubCat->Alias == 'ly_lich_cong_tac') {
					
					if (isset($objStr['from_year']) && $objStr['from_year'] != "") {
						$strJson .= $strs.'},'; 		
					}

				} else if ($itemObjSubCat->Alias == 'quan_he_xa_hoi') {
					if (isset($objStr['cap_do_quan_he']) && $objStr['cap_do_quan_he'] != "") {
						$strJson .= $strs.'},'; 		
					}

				} else if ($itemObjSubCat->ID == SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE) {
					if (isset($objStr['ho_ten']) && $objStr['ho_ten'] != "") {
						$strJson .= $strs.'},'; 		
					}

				} else if ($itemObjSubCat->ID == SUB_CN_QHGD_THONGTIN_KHAC) {
					if (isset($objStr['dien_thoai']) && $objStr['dien_thoai'] != "") {
						$strJson .= $strs.'},'; 		
					}
				} else {
					$strJson .= $strs.'},'; 
				}

				
			}
			if ($strJson != '{"sub_cat_id":"'.$itemObjSubCat->ID.'","'.$itemObjSubCat->Alias.'" : [') {
				$strJson = substr($strJson, 0, strlen($strJson)-1). "]}";	
			} else {
				$strJson .= "]}";
			}
			
			// echo $strJson."<br/>";
		} 
		else {

			if ($strJson != '{"sub_cat_id":"'.$itemObjSubCat->ID.'","'.$itemObjSubCat->Alias.'" : {') 
			{				
				$strJson = substr($strJson, 0, strlen($strJson)-1). "}}";
				
				// Tính mệnh khách hàng từ năm sinh qua thông tin chung cá nhân
				if ($prefix == "gr1_1_") {
					$objJson = json_decode($strJson, TRUE);
					$menh = MenhNguHanh(date("Y", strtotime($objJson['thong_tin_gan_dinh_danh_co_the']['ngay_sinh'])));
					$menh = '"menh":"'.$menh.'"';
					$strJson = str_replace('"menh":""', $menh, $strJson);
				} 
				// kết thúc

			} else {
				// TH so thich chua co thong tin truong du lieu nao
				if ($itemObjSubCat->CatId == CAT_SOTHICH) {
					$strJson = '{"sub_cat_id":"'.$itemObjSubCat->ID.'","'.$itemObjSubCat->Alias.'" : []}';
				} else {
					$strJson = substr($strJson, 0, strlen($strJson)-1). " \"\"}";
				}
				
			}
			
		}	
		// Push data to Array json
		array_push($arrayJsonData, $strJson);
		echo $strJson."<br/> -----------------------------------------<br/>";
	}

	// die;

	// Lưu thông tin khách hàng vào bảng customer trước để nhận thông tin ID khách hàng
	// fixed một số trường thông tin chung khách hàng
	$idCustomer = '-1';
	$objCustomer->MemId=$_POST['mem_id'];
	$objCustomer->Type=$_POST['txt_type'];

	if ($_POST['txt_type'] == GROUP_CANHAN) {
		$objCustomer->FullName=$_POST['gr1_1_ho_ten'];	
		$objCustomer->Phone=$_POST['gr1_3_dien_thoai'];
		$objCustomer->Gender=$_POST['gr1_1_gioi_tinh'];
		$objCustomer->Birthday=date('Y-m-d', strtotime($_POST['gr1_1_ngay_sinh']));
		$objCustomer->DieDate=date('Y-m-d', strtotime($_POST['gr1_1_ngay_mat']));
		
 	} else if ($_POST['txt_type'] == GROUP_DOANHNGHIEP) {
 		$objCustomer->FullName=$_POST['gr7_24_ten_doanh_nghiep'];	
		$objCustomer->Phone=$_POST['gr7_24_so_dien_thoai'];
		$objCustomer->Birthday=date('Y-m-d', strtotime($_POST['gr7_24_ngay_thanh_lap']));
 	} else {
 		$objCustomer->FullName=$_POST['gr10_33_ten_to_chuc'];	
		$objCustomer->Phone=$_POST['gr10_33_so_dien_thoai'];
		$objCustomer->Birthday=date('Y-m-d', strtotime($_POST['gr10_33_ngay_thanh_lap']));
 	}

 	if (isset($_POST['txt_id'])) {
		$objCustomer->ID = $_POST['txt_id'];
		$idCustomer = $objCustomer->Update();
	} else {
		$idCustomer = $objCustomer->Add_new();	
	}

	// insert dư liệu khách hàng
	// TH sua thong tin, thi xoa cac ban ghi cu va them ban ghi moi
	$objDetail = new CLS_CUSTOMER_DETAIL;
	if (isset($_POST['txt_id'])) {
		$objDetail->CustomerId=$_POST['txt_id'];
		$objDetail->Delete();
	} else {
		$objDetail->CustomerId=$idCustomer;
	}

	foreach ($arrayJsonData as $key => $value) {
		$value = json_decode($value, TRUE);
		$json = json_encode($value, JSON_UNESCAPED_UNICODE);

		// var_dump($value)."<br/>_____________";
		
		if (isset($value['sub_cat_id'])) {
			$objDetail->SubCatId = $value['sub_cat_id'];
			// echo "<br/>".$objDetail->SubCatId."<br/>______________";
			// var_dump($json)."<br/>___________________________________________";
		}
		
		$objDetail->Json = $json;
		$objDetail->Add_new();		
	}
	// die;
	echo "<script>window.location='".ROOTHOST."mgmt_customer.html';</script>";
	

} else {
	echo "Server is not response";
} 

unset($objDetail);
unset($objCustomer);
unset($objCat);
unset($objSubCat);
unset($objFieldInfo);
?>