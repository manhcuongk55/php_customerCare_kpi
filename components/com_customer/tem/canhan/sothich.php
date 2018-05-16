<?php
include_once("includes/groupjs.php");
$objFieldInfo = new CLS_FIELD_INFOMATION;
$objOptionField = new CLS_OPTION_FIELD;
$objDisplay = new CLS_DISPLAY;
$objSubCat = new CLS_SUBCAT;


// Lấy các trường dữ liệu trong database 
$objSubCat->getList(" AND cat_id='".CAT_SOTHICH."'", " ORDER BY id asc");
$lstHobby = array();

// save to array
while ($rs=$objSubCat->Fetch_Assoc()) {
	$oo = new CLS_SUBCAT;
	$oo->ID=$rs['id'];
	$oo->CatId=$rs['cat_id'];
	$oo->Name=$rs['name'];
	$oo->Alias=$rs['alias'];
	array_push($lstHobby, $oo);
}

$totalList = count($lstHobby);
$icon = "icon-append fa fa-user";
$dataEdit = "";
?>
<ul class="nav nav-tabs">
	<?php
	$i=0;
	foreach ($lstHobby as $key => $value) { if ($i==0) $cls="active"; else $cls="";?>
		<li class="<?php echo $cls;?>">
			<a data-toggle="tab" href="#TAB_SOTHICH<?php echo $i;?>"><?php echo $value->Name;?></a>
		</li>	
	<?php $i++;}
	?>
</ul>
<div class="tabbable tabs-below">
	<div class="tab-content padding-10">
		<?php
		$i=0;
		foreach ($lstHobby as $key => $value) { if ($i==0) $cls=" active"; else $cls="";?>
			<div class="tab-pane<?php echo $cls;?>" id="TAB_SOTHICH<?php echo $i;?>">
				<?php
					// get list filed of item: example filed of sport
					$lstField = array();
					$objFieldInfo->getList(" and sub_cat_id='".$value->ID."' AND isactive='1'", " order by id asc");
					while ($rs=$objFieldInfo->Fetch_Assoc()) {
						$oo = new CLS_FIELD_INFOMATION;
						$oo->ID=$rs['id'];
						$oo->SubCatId=$rs['sub_cat_id'];
						$oo->Alias=$rs['alias'];
						$oo->Name=$rs['name'];
						$oo->DataType=$rs['data_type'];
						array_push($lstField, $oo);

					}
					// var_dump($lstField);
					
					$objDisplay->getList(" and sub_cat_id='".$value->ID."'", ' order by id asc');
					$rs = $objDisplay->Fetch_Assoc();
					$displayItem = $rs['display_item'];
					
					// generate field data

					for ($jj=0; $jj < $displayItem; $jj++) {?>
						<!-- <h4 class="row-seperator-header"><i class="fa fa-plus"></i>
							<?php echo "";?>
						</h4> -->
						<?php
						$j=0;

						foreach ($lstField as $k1 => $v1) { 
							if ($j%ITEM_INROW==0) echo "<div class=\"row\">";
						?>
							<?php if($v1->DataType == 'text'): ?>
								<section class="col col-3">
									<label class="label">
										<?php 
										echo $v1->Name;
										if (count($arrayData) > 0) {
											foreach ($arrayData as $v => $strJson) {

												$dataEdit = json_decode($strJson['json'], true);

												if (isset($dataEdit[$value->Alias]) && $dataEdit['sub_cat_id'] == $value->ID) {
													break;
												}
											}
											// gan gia tri chinh sua
											$valueData = "";
											if ($dataEdit != "" && isset($dataEdit[$value->Alias][$jj][$v1->Alias])) {
												$valueData = $dataEdit[$value->Alias][$jj][$v1->Alias];
											}
										}
										?>
									</label>
									<label class="input">
										<i class="<?php echo $icon;?>"></i>
										<input type="text" name="gr2_<?php echo $value->ID;?>_<?php echo $v1->Alias;?>[]" value="<?php  echo $valueData;?>">
									</label>	
								</section>
							<?php endif;?>	
						<?php 
							$j++;
							if ($j%ITEM_INROW==0 || $j==count($lstField)) echo "</div>";
						}
						?>
						
					<?php }

				?>
			</div>
		<?php $i++;}
		?>
		
	</div>
</div>
