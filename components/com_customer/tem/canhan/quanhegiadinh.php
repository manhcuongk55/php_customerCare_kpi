<?php
include_once("includes/groupjs.php");
$objFieldInfo = new CLS_FIELD_INFOMATION;
$objOptionField = new CLS_OPTION_FIELD;
$objRelationship = new CLS_RELATIONSHIP;
$objSubCat = new CLS_SUBCAT;

// Lay danh sach quan he nguoi than trong bang tbl_relationship
$objRelationship->getList(" ", " ORDER BY id asc");
$lstRelationship = array();

// save to array
while ($rs=$objRelationship->Fetch_Assoc()) {
	$oo = new CLS_RELATIONSHIP;
	$oo->ID=$rs['id'];
	$oo->Name=$rs['relationship'];	
	array_push($lstRelationship, $oo);
}


$icon = "icon-append fa fa-user";
?>
<input type="hidden" name="" id="quantity_relationship" value="<?php echo count($lstRelationship)?>">
<ul class="nav nav-tabs">
	<?php
	$i=0;
	foreach ($lstRelationship as $key => $value) { if ($i==0) $cls="active"; else $cls="";?>
		<li class="<?php echo $cls;?>">
			<a data-toggle="tab" href="#TAB_QHGD<?php echo $i;?>"><?php echo $value->Name;?></a>
		</li>	
	<?php $i++;}
	?>
</ul>
<div class="tabbable tabs-below">
	<div class="tab-content padding-10">
		<?php
		$i=0;
		foreach ($lstRelationship as $key => $value) { if ($i==0) $cls=" active"; else $cls="";?>
			<div class="tab-pane<?php echo $cls;?>" id="TAB_QHGD<?php echo $i;?>">

				<h4 class="row-seperator-header"><i class="fa fa-plus"></i> Thông tin định danh [<?php echo $value->Name;?>]</h4>

				<?php
				// Lấy alias cub category 
				$aliasSubCat = trim($objSubCat->getAliasSubCat(SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE));

				$dataEdit = ""; // Data luu tru json object editor

				if (count($arrayData) > 0) {	
					foreach ($arrayData as $k => $strJson) {
						
						$dataEdit = json_decode($strJson['json'], true);
						
						if (isset($dataEdit[$aliasSubCat]) && $dataEdit['sub_cat_id'] == SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE) {
							// var_dump($dataEdit);
							break;
						}		
					}
				}

				// kêt thúc

				$objFieldInfo->getList(" and sub_cat_id='".SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE."'", " order by sort asc");
				$j=0;
				$totalRecord=$objFieldInfo->Num_rows();

				while ($rs=$objFieldInfo->Fetch_Assoc()) {
					if ($rs['alias'] == 'ngay_sinh' || $rs['alias'] == 'ngay_mat') {
						$icon = "icon-append fa fa-calendar";
					} else {
						$icon = " icon-append fa fa-user";
					}

					// gan gia tri chinh sua
					$valueData = "";
					if(isset($dataEdit[$aliasSubCat][$i][$rs['alias']])) {
						$valueData = $dataEdit[$aliasSubCat][$i][$rs['alias']];
					}
					// end

					if ($j%ITEM_INROW==0) echo "<div class=\"row\">";
					?>

					<?php if($rs['data_type'] == 'hidden'): ?>
						<input type="hidden" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias']?>[]" value="<?php echo $value->Name?>">
					<?php endif;?>

					<!-- Trường dữ liệu kiểu text -->
					<?php if($rs['data_type'] == 'text'): ?>
						<?php if ($rs['alias'] == "quan_he"):?>
							<input type="hidden" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias']?>[]" value="<?php echo $value->Name;?>">
						<?php else:?>
							<section class="col col-3 <?php if($rs['alias']=='menh') echo "field_hidden";?>">
								<label class="label">
									<?php echo $rs['name']?>
								</label>
								<label class="input">
									<i class="<?php echo $icon;?>"></i>
									<input type="text" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias']?>[]" value="<?php echo $valueData;?>" 
									id="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias'].'_'.$value->ID;?>">
								</label>	
							</section>
						<?php endif;?>	
					<?php endif;?>	

					<!-- Trường dữ liệu kiểu textarea -->
					<?php if($rs['data_type'] == 'textarea'): ?>
					<section class="col col-3">
						<label class="label"><?php echo $rs['name']?></label>
						<label class="textarea">
							<i class="icon-append fa fa-bank"></i>
							<textarea name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias']?>[]"><?php echo $valueData;?></textarea>
						</label>
					</section>
					<?php endif; ?>

					<!-- Trường dữ liệu kiểu file -->
					<?php if($rs['data_type'] == 'file'): ?>
					<section class="col col-3">
						<label class="label"><?php echo $rs['name']?></label>
						<label for="file" class="input input-file">
							<div class="button">
							<input type="file" multiple="multiple" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE.'_'.$rs['alias'];?>_files[]"  class="link" 
							onchange="this.parentNode.nextSibling.value = this.value">Browse
							</div>
							<input type="text" placeholder="Hình ảnh..." readonly="">
						</label>
						<?php
						if ($dataEdit != "") { ?>
							<input type="hidden" name="<?php echo $rs['alias']?>" 
							value="<?php echo $valueData;?>">
						<?php }
						?>
					</section>					
					<?php endif; ?>

					<!-- Trường dữ liệu kiểu radio -->
					<?php if($rs['data_type'] == 'radio'): ?>
						<section class="col col-3">
							<label class="label"><?php echo $rs['name']?></label>
							<div class="inline-group">

							<!-- Trường hợp sửa dữ liệu -->
							
							<?php if ($dataEdit != ""):?>
								<label class="radio">
									<input type="radio" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias']?><?php echo $value->ID;?>[]" value="0" <?php if($valueData == '0') echo "checked=\"true\""?>>
									<i></i>Nam
								</label>
								<label class="radio">
									<input type="radio" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias']?><?php echo $value->ID;?>[]" value="1" <?php if($valueData == '1') echo "checked=\"true\""?>>
									<i></i>Nữ
								</label>

							<?php else:?>
								<!-- Trường hợp thêm mới dữ liệu -->

								<label class="radio">
									<input type="radio" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias']?><?php echo $value->ID;?>[]" value="0" checked="true">
									<i></i>Nam
								</label>
								<label class="radio">
									<input type="radio" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE;?>_<?php echo $rs['alias']?><?php echo $value->ID;?>[]" value="1">
									<i></i>Nữ
								</label>

							<?php endif; ?>
							</div>
						</section>
					<?php endif;?>
					
					<?php $j++; if($j%ITEM_INROW==0 || $j==$totalRecord) echo "</div>";
				} // end while
				?>


				<!-- THONG TIN KHAC -->
				<h4 class="row-seperator-header"><i class="fa fa-plus"></i> Thông tin khác</h4>
				<?php

				// Lấy alias cub category 
				$aliasSubCat = trim($objSubCat->getAliasSubCat(SUB_CN_QHGD_THONGTIN_KHAC));

				$dataEdit = ""; // Data luu tru json object editor

				if (count($arrayData) > 0) {	
					foreach ($arrayData as $k => $strJson) {
						
						$dataEdit = json_decode($strJson['json'], true);
						
						if (isset($dataEdit[$aliasSubCat]) && $dataEdit['sub_cat_id'] == SUB_CN_QHGD_THONGTIN_KHAC) {
							break;
						}		
					}
				}

				// kêt thúc

				$objFieldInfo->getList(" and sub_cat_id='".SUB_CN_QHGD_THONGTIN_KHAC."'", " order by id asc");
				$j=0;
				$totalRecord=$objFieldInfo->Num_rows();

				while ($rs=$objFieldInfo->Fetch_Assoc()) {
					if ($rs['alias'] == 'ngay_sinh' || $rs['alias'] == 'ngay_mat') {
						$icon = "icon-append fa fa-calendar";
					} else {
						$icon = " icon-append fa fa-user";
					}

					// gan gia tri chinh sua
					$valueData = "";
					if(isset($dataEdit[$aliasSubCat][$i][$rs['alias']])) {
						$valueData = $dataEdit[$aliasSubCat][$i][$rs['alias']];
					}
					// end

					if ($j%ITEM_INROW==0) echo "<div class=\"row\">";
					?>
					<?php if($rs['data_type'] == 'text'): ?>
					<section class="col col-3">
						<label class="label">
							<?php echo $rs['name']?>
						</label>
						<label class="input">
							<i class="<?php echo $icon;?>"></i>
							<input type="text" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>[]" value="<?php echo $valueData;?>">
						</label>	
					</section>
					<?php endif;?>	

					<?php if($rs['data_type'] == 'textarea'): ?>
					<section class="col col-3">
						<label class="label"><?php echo $rs['name']?></label>
						<label class="textarea">
							<i class="icon-append fa fa-bank"></i>
							<textarea name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_KHAC;?>_<?php echo $rs['alias']?>[]"><?php echo $valueData;?></textarea>											
						</label>
					</section>
					<?php endif; ?>

					<?php if($rs['data_type'] == 'file'): ?>
					<section class="col col-3">
						<label class="label"><?php echo $rs['name']?></label>
						<label for="file" class="input input-file">
							<div class="button">
							<input type="file" multiple="multiple" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_KHAC.'_'.$rs['alias'];?>_files[]"  class="link" id="link" 
							onchange="this.parentNode.nextSibling.value = this.value">Browse
							</div>
							<input type="text" placeholder="Hình ảnh..." readonly="">
						</label>
						<?php
						if ($dataEdit != "") { ?>
							<input type="hidden" name="<?php echo $rs['alias']?>" 
							value="<?php echo $valueData;?>">
						<?php }
						?>
					</section>					
					<?php endif; ?>

					<?php if($rs['data_type'] == 'radio'): ?>
						<section class="col col-3">
							<label class="label"><?php echo $rs['name']?></label>
							<div class="inline-group">

								<?php if ($dataEdit != ""):?>
									<label class="radio">
										<input type="radio" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_KHAC;?>_<?php echo $rs['alias']?><?php echo $value->ID;?>[]" value="0" <?php if($valueData == '0') echo "checked=\"true\""?>>
										<i></i>Đã kết hôn
									</label>
									<label class="radio">
										<input type="radio" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_KHAC;?>_<?php echo $rs['alias']?><?php echo $value->ID;?>[]" value="1" <?php if($valueData == '0') echo "checked=\"true\""?>>
										<i></i>Chưa 
									</label>

								<?php else:?>
									<!-- Trường hợp thêm mới dữ liệu -->

									<label class="radio">
										<input type="radio" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_KHAC;?>_<?php echo $rs['alias']?><?php echo $value->ID;?>[]" value="0" checked="true">
										<i></i>Đã kết hôn
									</label>
									<label class="radio">
										<input type="radio" name="gr3_<?php echo SUB_CN_QHGD_THONGTIN_KHAC;?>_<?php echo $rs['alias']?><?php echo $value->ID;?>[]" value="1">
										<i></i>Chưa
									</label>

								<?php endif; ?>
							</div>
						</section>
					<?php endif;?>
					
					<?php $j++; if($j%ITEM_INROW==0 || $j==$totalRecord) echo "</div>";
				} // end while
				?>

			</div>
		<?php $i++;
		} // end foreach
		?>
		
	</div>
</div>
