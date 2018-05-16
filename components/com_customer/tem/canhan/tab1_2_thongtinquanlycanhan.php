<?php
include_once("includes/groupjs.php");
$objFieldInfo = new CLS_FIELD_INFOMATION;
$objSubCat = new CLS_SUBCAT;

// Lấy các trường dữ liệu trong database 
$objFieldInfo->getList(" AND sub_cat_id='".SUB_CN_THONGTIN_QL_CANHAN_XAHOI."' AND isactive='1'", " ORDER BY id asc");
$icon = " icon-append fa fa-user";
$i=0;
$totalRecord = $objFieldInfo->Num_rows();

// Lấy alias cub category 
$aliasSubCat = trim($objSubCat->getAliasSubCat(SUB_CN_THONGTIN_QL_CANHAN_XAHOI));

$dataEdit = ""; // Data luu tru json object editor

if (count($arrayData) > 0) {	
	foreach ($arrayData as $k => $strJson) {
		
		$dataEdit = json_decode($strJson['json'], true);
		
		if (isset($dataEdit[$aliasSubCat]) && $dataEdit['sub_cat_id'] == SUB_CN_THONGTIN_QL_CANHAN_XAHOI) {
			break;
		}		
	}
}


// Xu ly generate du lieu
while ($rs=$objFieldInfo->Fetch_Assoc()) { 

	// Gan gia tri chinh sua
	$valueData = "";
	if ($dataEdit != "" && isset($dataEdit[$aliasSubCat][$rs['alias']])) {
		$valueData = $dataEdit[$aliasSubCat][$rs['alias']];
	}
	// end

	if ($i%ITEM_INROW==0) echo "<div class=\"row\">";
?>
	
	<?php if($rs['data_type'] == 'text'): ?>
	<section class="col col-3">
		<label class="label">
			<?php echo $rs['name']?>
		</label>
		<label class="input">
			<i class="<?php echo $icon;?>"></i>
			<input type="text" name="gr1_<?php echo SUB_CN_THONGTIN_QL_CANHAN_XAHOI;?>_<?php echo $rs['alias']?>" id="gr1_<?php echo SUB_CN_THONGTIN_QL_CANHAN_XAHOI;?>_<?php echo $rs['alias']?>" value="<?php echo $valueData;?>">
		</label>	
	</section>
	<?php endif;?>	

	<?php if($rs['data_type'] == 'textarea'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<label class="textarea">
			<i class="icon-append fa fa-bank"></i>
			<textarea name="gr1_<?php echo SUB_CN_THONGTIN_QL_CANHAN_XAHOI;?>_<?php echo $rs['alias']?>"><?php echo $valueData;?></textarea>											
		</label>
	</section>
	<?php endif; ?>

	<?php if($rs['data_type'] == 'file'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<label for="file" class="input input-file">
			<div class="button">
			<input type="file" multiple="multiple" name="gr1_<?php echo SUB_CN_THONGTIN_QL_CANHAN_XAHOI;?>_files[]"  class="link" id="link" 
			onchange="this.parentNode.nextSibling.value = this.value">Browse
			</div>
			<input type="text" placeholder="Hình ảnh..." readonly="">
		</label>
		<?php
		if (count($arrayData) > 0) { ?>
			<input type="hidden" name="<?php echo $rs['alias']?>" value="<?php echo $valueData;?>">
		<?php }
		?>
	</section>
	<?php endif; ?>


	<?php $i++; if (($i%ITEM_INROW==0 && $i>0) || $i==$totalRecord) echo "</div>";?>
<?php } ?>