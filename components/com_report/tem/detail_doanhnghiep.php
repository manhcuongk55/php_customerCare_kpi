<?php
include_once("includes/groupjs.php");
// get data
$objCustomerDetail->getList(" and customer_id='$cusId'", "");
$totalRecord = $objCustomerDetail->Num_rows();
$tmp=0;

echo "<article class=\"col-sm-12 col-md-12 col-lg-12\">";
while ($rs = $objCustomerDetail->Fetch_Assoc()) {
	$jsonDecode = json_decode($rs['json'], true);
	// var_dump($jsonDecode);
	$subCatname = $objSubCat->getCateName($jsonDecode['sub_cat_id']);
	$categoryName = $objSubCat->getCategoryName($jsonDecode['sub_cat_id']);

	if ($tmp%2==0) echo "<div class=\"row block_content\"> <h1 class=\"title\">
			<i class=\"fa fa-cubes\"></i>
			<span>".$categoryName."</span>
		</h1>";
	echo "<article class=\"col-lg-6\">";
	echo "<h5><p><i class=\"fa fa-plus\"></i><strong> ".$subCatname."</strong></p></h5>";

	// get alias sub cat
	$alias = $objSubCat->getAlias($jsonDecode['sub_cat_id']);
	// echo $alias;
	
	// lay danh sach cac field cua tung sub cat
	$objFieldInfo->getList(" and sub_cat_id='".$jsonDecode['sub_cat_id']."'", " ORDER BY sort asc");
	
	while ($rs=$objFieldInfo->Fetch_Assoc()) {
		// echo $rs['alias']."<br/>";
		if (contains_array($jsonDecode[$alias])) {
			for ($i=0; $i < count($jsonDecode[$alias]); $i++) { 
				if (isset($jsonDecode[$alias][$i][$rs['alias']])) {
					echo "<p><strong>".$rs['name']." : </strong>".$jsonDecode[$alias][$i][$rs['alias']]."</p>";
				}
			}
		}
		else {			
			if (isset($jsonDecode[$alias][$rs['alias']])) {
				if ($rs['alias'] == "mo_hinh_to_chuc") {
					echo "<p><strong>".$rs['name']." : </strong><a href=\"".ROOTHOST.$jsonDecode[$alias][$rs['alias']]."\">Xem chi tiết</a></p>";	
				} else {
					echo "<p><strong>".$rs['name']." : </strong>".$jsonDecode[$alias][$rs['alias']]."</p>";
				}
				
			}
		}
	}

	echo "</article>";

	$tmp++;
	if ($tmp%2 == 0 || $tmp == $totalRecord) echo "</div>";


}
echo "</article>";
?>
