
<?php
	$dataEdit = "";
	// Lấy alias cub category 
	$aliasSubCat = trim($objSubCat->getAliasSubCat(SUB_QUANHE_XAHOI));

	if (count($arrayData) > 0) {
		foreach ($arrayData as $v => $strJson) {
			$dataEdit = json_decode($strJson['json'], true);

			if (isset($dataEdit[$aliasSubCat]) && $dataEdit['sub_cat_id'] == SUB_QUANHE_XAHOI) {
				// var_dump($dataEdit);
				break;
			}
		}
	}
	$objDisplay->getList(" and sub_cat_id='".SUB_QUANHE_XAHOI."'", ' order by id asc');
	$rs = $objDisplay->Fetch_Assoc();
	$displayItem = $rs['display_item'];
	for($i = 0; $i < $displayItem; $i++) {
?>
<input type="hidden" name="num_qhxh" id="num_qhxh" value="<?php echo $displayItem;?>">
<h4 class="row-seperator-header"><i class="fa fa-plus"></i> Quan hệ <?php echo $i+1;?></h4>
<div class="row">
	<section class="col col-3">
		<label class="label">Cấp độ quan hệ</label>
		<label class="select">
			<select name="gr6_<?php echo SUB_QUANHE_XAHOI;?>_cap_do_quan_he[]" id="gr6_<?php echo $i+1;?>_cap_do_quan_he" attr_value="<?php if(isset($dataEdit[$aliasSubCat][$i]['cap_do_quan_he'])) echo $dataEdit[$aliasSubCat][$i]['cap_do_quan_he']?>">
				<option value="nha_nuoc">Nhà nước</option>
				<option value="doanh_nghiep">Doanh nghiệp</option>
				<option value="ca_nhan">Cá nhân</option>
			</select><i></i>

		</label>
	</section>

	<section class="col col-3">
		<label class="label">Hình thức quan hệ</label>
		<label class="select">
			<select name="gr6_<?php echo SUB_QUANHE_XAHOI;?>_hinh_thuc_quan_he[]" attr_value="<?php if(isset($dataEdit[$aliasSubCat][$i]['hinh_thuc_quan_he'])) echo $dataEdit[$aliasSubCat][$i]['hinh_thuc_quan_he']?>" 
				id="gr6_<?php echo $i+1;?>_hinh_thuc_quan_he">
				<option value="truc_tiep">Trực tiếp</option>
				<option value="gian_tiep">Gián tiếp</option>
			</select><i></i>
		</label>
	</section>

	<section class="col col-3">
		<label class="label">Loại quan hệ</label>
		<label class="select">
			<select name="gr6_<?php echo SUB_QUANHE_XAHOI;?>_loai_quan_he[]" attr_value="<?php if(isset($dataEdit[$aliasSubCat][$i]['loai_quan_he'])) echo $dataEdit[$aliasSubCat][$i]['loai_quan_he']?>"
				id="gr6_<?php echo $i+1;?>_loai_quan_he">
				<option value="ban_be">Bạn bè</option>
				<option value="dong_nghiep">Đồng nghiệp</option>
				<option value="cap_tren">Cấp trên</option>
				<option value="cap_duoi">Cấp dưới</option>
			</select><i></i>
		</label>
	</section>

	<section class="col col-3">
		<label class="label">Tên đầu mối</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr6_<?php echo SUB_QUANHE_XAHOI;?>_dau_moi[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['dau_moi'])) echo $dataEdit[$aliasSubCat][$i]['dau_moi']?>">
		</label>
	</section>
</div>
<div class="row">
	<section class="col col-3">
		<label class="label">
			Số điện thoại
		</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr6_<?php echo SUB_QUANHE_XAHOI;?>_so_dien_thoai[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['so_dien_thoai'])) echo $dataEdit[$aliasSubCat][$i]['so_dien_thoai']?>">
		</label>	
	</section>

	<section class="col col-3">
		<label class="label">
			Cơ quan/Doanh nghiệp
		</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr6_<?php echo SUB_QUANHE_XAHOI;?>_co_quan[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['co_quan'])) echo $dataEdit[$aliasSubCat][$i]['co_quan']?>">
		</label>	
	</section>

	<section class="col col-3">
		<label class="label">
			Địa chỉ
		</label>
		<label class="input">
			<i class="icon-append fa fa-bank"></i>
			<input type="text" name="gr6_<?php echo SUB_QUANHE_XAHOI;?>_dia_chi[]" value="<?php if(isset($dataEdit[$aliasSubCat][$i]['dia_chi'])) echo $dataEdit[$aliasSubCat][$i]['dia_chi']?>">
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