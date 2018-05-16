<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.customer.php");
include_once("../libs/cls.customer.detail.php");
include_once("../libs/cls.group.php");
include_once("../libs/cls.relationship.php");
include_once("../libs/cls.subcat.php");
include_once("../libs/cls.category.php");
include_once("../libs/cls.field.infomation.php");

$objCustomerDetail = new CLS_CUSTOMER_DETAIL;
$objSubCat = new CLS_SUBCAT;
$objGroup = new CLS_GROUP;
$objCat =  new CLS_CATEGORY;
$objFieldInfo = new CLS_FIELD_INFOMATION;
$objRelation = new CLS_RELATIONSHIP;



$html="";
if (isset($_GET['export_id'])) {
    $cusId = $_GET['export_id'];
    // get data
	$objCustomerDetail->getList(" and customer_id='$cusId'", "");
	$totalRecord = $objCustomerDetail->Num_rows();
	$tmp=0;
    $html.="<!DOCTYPE html>
		<html>
		<head>
		    <link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"".ROOTHOST."templates/default/css/bootstrap.min.css\">";
		    $html.="<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"".ROOTHOST."templates/default/css/font-awesome.min.css\">";
		    $html.="<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"".ROOTHOST."templates/default/css/smartadmin-production-plugins.min.css\">";
		    $html.="<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"".ROOTHOST."templates/default/css/smartadmin-production.min.css\">";
		    $html.="<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"".ROOTHOST."templates/default/css/smartadmin-skins.min.css\">";
		    $html.="<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"".ROOTHOST."templates/default/css/smartadmin-rtl.min.css\">"; 
		    $html.="<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"".ROOTHOST."templates/default/css/demo.min.css\">";
		    $html.="<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"".ROOTHOST."templates/default/css/style_form_pdf.css\">";
		$html.="</head>
		<body>
		   <div id=\"main\">
		        <div id=\"content\">";

		        $html.="<article class=\"col-sm-12 col-md-12 col-lg-12\">";
				while ($rs = $objCustomerDetail->Fetch_Assoc()) {
					$jsonDecode = json_decode($rs['json'], true);
					// var_dump($jsonDecode);
					$subCatname = $objSubCat->getCateName($jsonDecode['sub_cat_id']);
					$categoryName = $objSubCat->getCategoryName($jsonDecode['sub_cat_id']);

					if ($tmp%2==0) $html.= "<div class=\"row block_content\"> <h1 class=\"title\">
							<i class=\"fa fa-cubes\"></i>
							<span>".$categoryName."</span>
						</h1>";
					$html.= "<article class=\"col-lg-6\">";
					$html.= "<h5><p><i class=\"fa fa-plus\"></i><strong> ".$subCatname."</strong></p></h5>";

					// get alias sub cat
					$alias = $objSubCat->getAlias($jsonDecode['sub_cat_id']);
					// echo $alias;
					
					// lay danh sach cac field cua tung sub cat
					$objFieldInfo->getList(" and sub_cat_id='".$jsonDecode['sub_cat_id']."'", "");
					
					while ($rs=$objFieldInfo->Fetch_Assoc()) {
						// echo $rs['alias']."<br/>";
						if (contains_array($jsonDecode[$alias])) {
							for ($i=0; $i < count($jsonDecode[$alias]); $i++) { 
								if (isset($jsonDecode[$alias][$i][$rs['alias']])) {
									$html.= "<p><strong>".$rs['name']." : </strong>".$jsonDecode[$alias][$i][$rs['alias']]."</p>";
								}
							}
						}
						else {
							if (isset($jsonDecode[$alias][$rs['alias']])) {
								$html.= "<p><strong>".$rs['name']." : </strong>".$jsonDecode[$alias][$rs['alias']]."</p>";
							}
						}
					}

					$html.= "</article>";

					$tmp++;
					if ($tmp%2 == 0 || $tmp == $totalRecord) $html.="</div>";


				}
				$html.= "</article>";
			$html.="</div>";
		$html.="</div>";
	$html.="</body>";
$html.="</html>";

echo $html;
}

?>
