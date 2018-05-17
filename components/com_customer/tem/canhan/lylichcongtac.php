
<?php
	$dataEdit = "";
	// Lấy alias cub category 
	$aliasSubCat = trim($objSubCat->getAliasSubCat(SUB_LYLICH_CONGTAC));

	if (count($arrayData) > 0) {
		foreach ($arrayData as $v => $strJson) {
			$dataEdit = json_decode($strJson['json'], true);

			if (isset($dataEdit[$aliasSubCat]) && $dataEdit['sub_cat_id'] == SUB_LYLICH_CONGTAC) {
				// var_dump($dataEdit);
				break;
			}
		}
	}
	$objDisplay->getList(" and sub_cat_id='".SUB_LYLICH_CONGTAC."'", ' order by id asc');
	$rs = $objDisplay->Fetch_Assoc();
	$displayItem = $rs['display_item'];
	echo "<input type=\"hidden\" name=\"num_llct\" id=\"num_llct\" value=".$displayItem.">";
	for($i = 0; $i < $displayItem; $i++) {
?>

<h4 class="row-seperator-header"><i class="fa fa-plus"></i> Giai đoạn <?php echo $i+1;?></h4>
<div class="row">
	<section class="col col-2">
		<label class="label">Từ năm</label>
		<label class="select">
			<select name="gr5_<?php echo SUB_LYLICH_CONGTAC;?>_from_year[]" id="gr5_<?php echo $i+1;?>_from_year" attr_value="<?php if(isset($dataEdit[$aliasSubCat][$i]['from_year'])) echo $dataEdit[$aliasSubCat][$i]['from_year']?>">
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
			<select name="gr5_<?php echo SUB_LYLICH_CONGTAC;?>_to_year[]" id="gr5_<?php echo $i+1;?>_to_year" attr_value="<?php if(isset($dataEdit[$aliasSubCat][$i]['to_year']))echo $dataEdit[$aliasSubCat][$i]['to_year']?>">
				<option value="">Chọn năm</option>
				<?php 
				for ($j=1950; $j < 2030; $j++) { 
					echo "<option value=\"$j\"> Năm ".$j."</option>";	
				}
				?>
			</select><i></i>
		</label>
	</section>

	<section class="col col-4">
		<label class="label">
			  Chức danh
		</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr5_<?php echo SUB_LYLICH_CONGTAC;?>_chuc_danh[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['chuc_danh'])) echo $dataEdit[$aliasSubCat][$i]['chuc_danh']?>">
		</label>	
	</section>

	<section class="col col-4">
		<label class="label">
			Đơn vị công tác
		</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr5_<?php echo SUB_LYLICH_CONGTAC;?>_don_vi_cong_tac[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['don_vi_cong_tac'])) echo $dataEdit[$aliasSubCat][$i]['don_vi_cong_tac'];?>">
		</label>	
	</section>

	
</div>

<div class="row">
	<section class="col col-4">
		<label class="label">Địa chỉ</label>
		<label class="textarea">
			<i class="icon-append fa fa-bank"></i>
			<textarea name="gr5_<?php echo SUB_LYLICH_CONGTAC;?>_dia_chi[]"><?php if(isset($dataEdit[$aliasSubCat][$i]['dia_chi'])) echo trim($dataEdit[$aliasSubCat][$i]['dia_chi'])?></textarea>
		</label>
	</section>

	<section class="col col-4">
		<label class="label">Khen thưởng</label>
		<label class="textarea">
			<i class="icon-append fa fa-bank"></i>
			<textarea name="gr5_<?php echo SUB_LYLICH_CONGTAC;?>_khen_thuong[]"><?php if(isset($dataEdit[$aliasSubCat][$i]['khen_thuong'])) echo trim($dataEdit[$aliasSubCat][$i]['khen_thuong'])?></textarea>											
		</label>
	</section>

	<section class="col col-4">
		<label class="label">Kỷ luật</label>
		<label class="textarea">
			<i class="icon-append fa fa-bank"></i>
			<textarea name="gr5_<?php echo SUB_LYLICH_CONGTAC;?>_ky_luat[]"><?php if(isset($dataEdit[$aliasSubCat][$i]['ky_luat'])) echo trim($dataEdit[$aliasSubCat][$i]['ky_luat']);?></textarea>										
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