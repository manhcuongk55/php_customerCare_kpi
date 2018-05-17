
<?php
	$dataEdit = "";
	
	// Lấy alias cub category 
	$aliasSubCat = trim($objSubCat->getAliasSubCat(SUB_CN_QUATRINH_HOCTAP));

	if (count($arrayData) > 0) {
		foreach ($arrayData as $v => $strJson) {
			$dataEdit = json_decode($strJson['json'], true);

			if (isset($dataEdit[$aliasSubCat]) && $dataEdit['sub_cat_id'] == SUB_CN_QUATRINH_HOCTAP) {
				// var_dump($dataEdit);
				break;
			}
		}
	}

	$objDisplay->getList(" and sub_cat_id='".SUB_CN_QUATRINH_HOCTAP."'", ' order by id asc');
	$rs = $objDisplay->Fetch_Assoc();
	$displayItem = $rs['display_item'];
	echo "<input type=\"hidden\" name=\"num_qtht\" id=\"num_qtht\" value=".$displayItem.">";
	for($i = 0; $i < $displayItem; $i++) {	


?>

<h4 class="row-seperator-header"><i class="fa fa-plus"></i> Giai đoạn <?php echo $i+1;?></h4>
<div class="row">
	<section class="col col-2">
		<label class="label">Từ năm</label>
		<label class="select">
			<select name="gr4_<?php echo SUB_CN_QUATRINH_HOCTAP;?>_from_year[]" id="gr4_<?php echo $i+1;?>_from_year" attr_value="<?php if(isset($dataEdit[$aliasSubCat][$i]['from_year']))echo $dataEdit[$aliasSubCat][$i]['from_year']?>">
				<option value="">Chọn năm</option>
				<?php 
				for ($j=1950; $j < 2030; $j++) { 
					echo "<option value=\"$j\"> Năm ".$j."</option>";	
				}
				?>
			</select><i></i>
			
		</label>
	</section>

	<section class="col col-2">
		<label class="label">Đến năm</label>
		<label class="select">
			<select name="gr4_<?php echo SUB_CN_QUATRINH_HOCTAP;?>_to_year[]" id="gr4_<?php echo $i+1;?>_to_year" attr_value="<?php if(isset($dataEdit[$aliasSubCat][$i]['to_year']))echo $dataEdit[$aliasSubCat][$i]['to_year']?>">
				<option value="">Chọn năm</option>
				<?php 
				for ($j=1950; $j < 2030; $j++) { 
					echo "<option value=\"$j\"> Năm ".$j."</option>";	
				}
				?>
			</select><i></i>
		</label>
	</section>

	<section class="col col-3">
		<label class="label">Cấp học</label>
		<label class="select">
			<select name="gr4_<?php echo SUB_CN_QUATRINH_HOCTAP;?>_cap_hoc[]" id="gr4_<?php echo $i+1;?>_cap_hoc" attr_value="<?php if(isset($dataEdit[$aliasSubCat][$i]['cap_hoc']))echo $dataEdit[$aliasSubCat][$i]['cap_hoc']?>">
				<option value="">Chọn cấp học</option>
				<option value="cap1">Cấp 1</option>
				<option value="cap2">Cấp 2</option>
				<option value="cap3">Cấp 3</option>
				<option value="trung_cap">Trung cấp</option>
				<option value="cao_dang">Cao đẳng</option>
				<option value="dai_hoc">Đại học</option>
				<option value="thac_sy">Thạc sỹ</option>
				<option value="tien_sy">Tiễn sỹ</option>
			</select><i></i>
			
		</label>
	</section>

	<section class="col col-5">
		<label class="label">
			Tên trường
		</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr4_<?php echo SUB_CN_QUATRINH_HOCTAP;?>_truong_hoc[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['truong_hoc'])) echo $dataEdit[$aliasSubCat][$i]['truong_hoc']?>">
		</label>	
	</section>

	
</div>

<div class="row">
	<section class="col col-4">
		<label class="label">
			Quốc gia
		</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr4_<?php echo SUB_CN_QUATRINH_HOCTAP;?>_quoc_gia[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['quoc_gia'])) echo $dataEdit[$aliasSubCat][$i]['quoc_gia']?>">
		</label>	
	</section>

	<section class="col col-4">
		<label class="label">
			Chuyên nghành
		</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr4_<?php echo SUB_CN_QUATRINH_HOCTAP;?>_chuyen_nganh[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['chuyen_nganh'])) echo $dataEdit[$aliasSubCat][$i]['chuyen_nganh']?>">
		</label>	
	</section>
</div>


<?php } ?>
<style type="text/css">
	.row-seperator-header {
	    margin: 10px 14px 10px;
	    border-bottom: none;
	    display: block;
	    color: #a90329;
	    font-size: 15px;
	    font-weight: 400;
	}
</style>