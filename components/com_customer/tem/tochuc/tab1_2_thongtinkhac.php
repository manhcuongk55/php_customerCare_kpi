<?php
include_once("includes/groupjs.php");
$objFieldInfo = new CLS_FIELD_INFOMATION;
$objSubCat = new CLS_SUBCAT;

// Lấy các trường dữ liệu trong database 
$objFieldInfo->getList(" AND sub_cat_id='".SUB_TC_THONGTIN_KHAC."' AND isactive='1'", " ORDER BY sort asc");
$icon = "";
$i=0;
$totalRecord = $objFieldInfo->Num_rows();

// Lấy alias cub category 
$aliasSubCat = trim($objSubCat->getAliasSubCat(SUB_TC_THONGTIN_KHAC));

$dataEdit = ""; // Data luu tru json object editor

if (count($arrayData) > 0) {	
	foreach ($arrayData as $k => $strJson) {
		
		$dataEdit = json_decode($strJson['json'], true);
		
		if (isset($dataEdit[$aliasSubCat]) && $dataEdit['sub_cat_id'] == SUB_TC_THONGTIN_KHAC) {
			break;
		}		
	}
}

// Xu ly generate du lieu
while ($rs=$objFieldInfo->Fetch_Assoc()) { 
	if ($rs['alias'] == 'ngay_sinh' || $rs['alias'] == 'ngay_mat') {
		$icon = "icon-append fa fa-calendar";
	} else {
		$icon = " icon-append fa fa-user";
	}

	// Gan gia tri chinh sua
	$valueData = "";
	if ($dataEdit != "" && isset($dataEdit[$aliasSubCat][$rs['alias']])) {
		$valueData = $dataEdit[$aliasSubCat][$rs['alias']];
	}
	// end

	if ($i%ITEM_INROW==0) echo "<div class=\"row\">";
?>
	<!-- Trương dư liệu text	 -->
	<?php if($rs['data_type'] == 'text'): ?>
	<section class="col col-3 <?php if($rs['alias']=='menh') echo "field_hidden";?>">
		<label class="label">
			<?php echo $rs['name']?>
		</label>
		<label class="input">
			<i class="<?php echo $icon;?>"></i>
			<input type="text" name="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>" id="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>" value="<?php echo$valueData;?>">
		</label>	
	</section>
	<?php endif;?>

	<!-- Trường dữ liệu radio -->
	<?php if($rs['data_type'] == 'radio'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<div class="inline-group">

			<?php if ($dataEdit != ""):?>
				<?php
					$fieldId = $rs['id'];
					$objOptionField->getList(" AND field_id=$fieldId", "");
					$m=0;
					while ($r=$objOptionField->Fetch_Assoc()) { ?>
						<label class="radio">
							<input type="radio" name="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>" value="<?php echo $r['value']?>" <?php if($valueData == '0') echo "checked=\"true\""?>>
							<i></i><?php echo $r['name'];?>
						</label>
					<?php }
				?>
			
			<?php else:?>
				<?php
					$fieldId = $rs['id'];
					$objOptionField->getList(" AND field_id=$fieldId", "");
					$m=0;
					while ($r=$objOptionField->Fetch_Assoc()) { ?>
						<label class="radio">
							<input type="radio" name="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>" value="<?php echo $r['value']?>" <?php if($m==0) echo "checked=\"true\""?>>
							<i></i><?php echo $r['name'];?>
						</label>
					<?php }
				?>

			<?php endif; ?>

		</div>
	</section>
	<?php endif;?>	

	<!-- Trường dữ liệu textarea -->
	<?php if($rs['data_type'] == 'textarea'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<label class="textarea">
			<i class="icon-append fa fa-bank"></i>
			<textarea name="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>" id="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>"><?php echo $valueData;?></textarea>											
		</label>
	</section>
	<?php endif; ?>

	<!-- Trường dữ liệu type file -->
	<?php if($rs['data_type'] == 'file'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<label for="file" class="input input-file">
			<div class="button">
				<input type="file" multiple="multiple" name="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>_files[]"  class="link"
				onchange="this.parentNode.nextSibling.value = this.value">Browse
			</div>
			<input type="text" placeholder="Hình ảnh..." readonly="">
		</label>
		<?php
		if ($dataEdit != "") { ?>
			<input type="hidden" name="gr10_<?php echo SUB_TC_THONGTIN_KHAC.'_'.$rs['alias']?>" value="<?php echo $valueData;?>">
		<?php }
		?>
	</section>
	<?php endif; ?>

	<!-- Trường dữ liệu type select -->
	<?php if($rs['data_type'] == 'select'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<label class="select">
			<select name="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>" id="gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>">
				<?php
					$fieldId = $rs['id'];
					$objOptionField->getList(" AND field_id=$fieldId", "");
					while ($r=$objOptionField->Fetch_Assoc()) { ?>
						<option value="<?php echo $r['value']?>">
							<?php echo $r['name']?>
						</option>
					<?php }
				?>
			</select><i></i>
			<script type="text/javascript">
				cbo_Selected('gr10_<?php echo SUB_TC_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>', '<?php echo $valueData;?>');
			</script>
		</label>
	</section>
	<?php endif; ?>

	<?php $i++; if (($i%ITEM_INROW==0 && $i>0) || $i==$totalRecord) echo "</div>";?>
<?php } ?>
