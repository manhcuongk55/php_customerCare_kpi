<?php
include_once("includes/groupjs.php");
$objFieldInfo = new CLS_FIELD_INFOMATION;
$objOptionField = new CLS_OPTION_FIELD;
$objSubCat = new CLS_SUBCAT;

// Lấy các trường dữ liệu trong database 
$objFieldInfo->getList(" AND sub_cat_id='".SUB_CN_THONGTIN_XAHOI_HIENTAI."' AND isactive='1'", " ORDER BY sort asc");
$icon = "icon-append fa fa-user";
$i=0;
$totalRecord = $objFieldInfo->Num_rows();

// Lấy alias cub category 
$aliasSubCat = trim($objSubCat->getAliasSubCat(SUB_CN_THONGTIN_XAHOI_HIENTAI));

$dataEdit = ""; // Data luu tru json object editor

if (count($arrayData) > 0) {	
	foreach ($arrayData as $k => $strJson) {
		
		$dataEdit = json_decode($strJson['json'], true);
		
		if (isset($dataEdit[$aliasSubCat]) && $dataEdit['sub_cat_id'] == SUB_CN_THONGTIN_XAHOI_HIENTAI) {
			break;
		}		
	}
}

while ($rs=$objFieldInfo->Fetch_Assoc()) { 
	if ($rs['alias'] == 'ngay_ket_hon') {
		$icon = "icon-append fa fa-calendar";
	}
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
			<input type="text" name="gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>" id="gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>" value="<?php echo $valueData;?>">
		</label>	
	</section>
	<?php endif;?>

	<?php if($rs['data_type'] == 'radio'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<div class="inline-group">
			<?php
			$fieldId = $rs['id'];
			$objOptionField->getList(" AND field_id=$fieldId", "");
			$j=0;
			while ($r=$objOptionField->Fetch_Assoc()) { ?>
				<label class="radio">
					<?php if($dataEdit != "") :?>

						<input type="radio" name="gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>" value="<?php echo $r["value"]?>" 
						<?php if ($valueData == $r["value"]) echo "checked=\"true\""?>>
						<i></i><?php echo $r["name"]?></label>

					<?php else: ?>

						<input type="radio" name="gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>" value="<?php echo $r["value"]?>" <?php if ($j==0) echo "checked=\"true\""?>>
						<i></i><?php echo $r["name"]?></label>

					<?php endif; ?>

			<?php $j++;}
			?>
		</div>
	</section>
	<?php endif;?>	

	<?php if($rs['data_type'] == 'textarea'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<label class="textarea">
			<i class="icon-append fa fa-bank"></i>
			<textarea name="gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>" id="gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>"><?php echo $valueData;?></textarea>											
		</label>
	</section>
	<?php endif; ?>

	<?php if($rs['data_type'] == 'select'): ?>
	<section class="col col-3">
		<label class="label"><?php echo $rs['name']?></label>
		<label class="select">
			<select name="gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>" id="gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>">
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
				cbo_Selected('gr1_<?php echo SUB_CN_THONGTIN_XAHOI_HIENTAI;?>_<?php echo $rs['alias']?>', '<?php echo $valueData;?>');
			</script>
		</label>
	</section>
	<?php endif; ?>


	<?php $i++; if (($i%ITEM_INROW==0 && $i>0) || $i==$totalRecord) echo "</div>";?>
<?php } ?>