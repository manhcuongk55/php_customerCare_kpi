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

$objCustomer = new CLS_CUSTOMER;
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

    // get dsach so thich
    $arySubCatHobby = array();
    $aryHobby = array();
    $aryRelation =  array();

    $objSubCat->getList(" and cat_id='2'", "");
    while ($rs=$objSubCat->Fetch_Assoc()) {
        array_push($arySubCatHobby, $rs);
    }

    // get list relationship
    $objRelation->getList("","");
    while ($rs=$objRelation->Fetch_Assoc()) {
        array_push($aryRelation, $rs);
    }

    // Khai báo biến
    $thong_tin_dinh_danh = "";
    $thong_tin_quan_ly_ca_nhan = "";
    $thong_tin_xa_hoi = "";

    $qhgd_thongtindinhdanh = $qhgd_thongtinkhac = "";
    $ly_lich_cong_tac = "";
    $qua_trinh_hoc_tap = "";
    $quan_he_xa_hoi = "";


    while ($rs = $objCustomerDetail->Fetch_Assoc()) {
        $jsonDecode = json_decode($rs['json'], true);  
        
        if (isset($jsonDecode['thong_tin_gan_dinh_danh_co_the']) && $jsonDecode['sub_cat_id'] == SUB_CN_DINHDANH_COTHE) {$thong_tin_dinh_danh = $jsonDecode;
        }

        if (isset($jsonDecode['thong_tin_quan_ly_ca_nhan_trong_xa_hoi'])) {
            $thong_tin_quan_ly_ca_nhan = $jsonDecode;
        }

        if (isset($jsonDecode['thong_tin_xa_hoi_hien_tai'])) {$thong_tin_xa_hoi = $jsonDecode;}

        // So thich
        foreach ($arySubCatHobby as $key => $value) {
            if (isset($jsonDecode[$value['alias']])) {
                array_push($aryHobby, $jsonDecode);
            }
        }

        if ($jsonDecode['sub_cat_id'] == SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE) {$qhgd_thongtindinhdanh = $jsonDecode;
        }
        if ($jsonDecode['sub_cat_id'] == SUB_CN_QHGD_THONGTIN_KHAC) {$qhgd_thongtinkhac = $jsonDecode;}

        if (isset($jsonDecode['ly_lich_cong_tac'])) {$ly_lich_cong_tac = $jsonDecode;}

        if (isset($jsonDecode['qua_trinh_hoc_tap'])) {$qua_trinh_hoc_tap = $jsonDecode;}

        if (isset($jsonDecode['quan_he_xa_hoi'])) {$quan_he_xa_hoi = $jsonDecode;}

    } 

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
        <div id=\"content\">
            <div class=\"row\">
                <article class=\"col-sm-12 col-md-7 col-lg-7\">
                    <div class=\"row\">
                        <div class=\"avatar col-md-6\">
                            <img src=".ROOTHOST.$thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the']['hinh_anh']." width=\"250px\" height=\"auto\">
                        </div>
                        <div class=\"div_name col-md-6\">
                            <h1 class=\"txt-color-blue\">".$thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the']['ho_ten']."</h1>
                        </div>
                    </div>
                </article>
                <article class=\"col-sm-12 col-md-7 col-lg-5\">
                    <ul class=\"info_top\">
                        <li><i class=\"fa fa-female txt-color-blue\"></i> <strong style=\"margin-left: 10px\">Giới tính:</strong>
                            <span>Nam</span>
                        </li>
                        <li><i class=\"fa fa-calendar txt-color-blue\"></i> <strong style=\"margin-left: 10px\">Ngày sinh:</strong>
                            ".date('d-m-Y',strtotime($thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the']['ngay_sinh']))."
                        </li>
                        <li><i class=\"fa fa-phone txt-color-blue\"></i> <strong style=\"margin-left: 10px\">Điện thoại:</strong>
                            ".$thong_tin_xa_hoi['thong_tin_xa_hoi_hien_tai']['dien_thoai']."
                        </li>
                        <li><i class=\"fa fa-envelope-o txt-color-blue\"></i> <strong style=\"margin-left: 10px\">Email:</strong>
                            ".$thong_tin_xa_hoi['thong_tin_xa_hoi_hien_tai']['email']."
                        </li>
                        <li><i class=\"fa fa-university txt-color-blue\"></i> <strong style=\"margin-left: 10px\">Nơi ở hiện tại:</strong>
                            ".$thong_tin_quan_ly_ca_nhan['thong_tin_quan_ly_ca_nhan_trong_xa_hoi']['noi_o_hien_tai']."
                        </li>
                    </ul>
                </article>

                <div class=\"row block_content\">
                    <article class=\"col-sm-6\">
                        <h1 class=\"title\">
                            <i class=\"fa fa-user\"></i>
                            <span>Thông tin định danh cơ thể</span>
                        </h1>
                        <div class=\"content\">";
                            
                            $objFieldInfo->getList(" and sub_cat_id='1'", "");
                            while ($rs=$objFieldInfo->Fetch_Assoc()) {          
                                if (isset($thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the'][$rs['alias']])) { 
                                $html.="<p><strong>".$rs['name'].": </strong>";
                                
                                    if ($rs['alias'] == "gioi_tinh") {
                                        if ($thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the'][$rs['alias']] == 0) 
                                                $html."Nam"; 
                                            else $html."Nữ"; 
                                    } else if ($rs['alias']=='hinh_anh') {
                                
                                    } else {
                                        $html.=$thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the'][$rs['alias']];
                                    }
                                
                                $html."</p>";
                                }
                            }
                            
                        $html.="</div>  
                    </article>
                    <article class=\"col-sm-6\">
                        <h1 class=\"title\">
                            <i class=\"fa fa-puzzle-piece\"></i>
                            <span>Thông tin xã hội</span>
                        </h1>
                        <div class=\"content\">";
                            
                            $objFieldInfo->getList(" and sub_cat_id='3'", "");
                            while ($rs=$objFieldInfo->Fetch_Assoc()) {          
                                if (isset($thong_tin_xa_hoi['thong_tin_xa_hoi_hien_tai'][$rs['alias']])) { 
                                $html.="<p><strong>".$rs['name']." :</strong>";
                                $html.=$thong_tin_xa_hoi['thong_tin_xa_hoi_hien_tai'][$rs['alias']];
                                $html.="</p>";
                                }
                            }
                            
                        $html.="</div>
                        
                    </article>
                    
                </div>";

                // Thông tin quản lý cá nhân
                $html.="<div class=\"row block_content\">
                    <article class=\"col-sm-12\">
                        <h1 class=\"title\">
                            <i class=\"fa  fa-cubes\"></i>
                            <span>Thông tin quản lý cá nhân</span>
                        </h1>
                        <div class=\"content\">";
                            
                            $objFieldInfo->getList(" and sub_cat_id='2'", "");
                            while ($rs=$objFieldInfo->Fetch_Assoc()) {          
                                if (isset($thong_tin_quan_ly_ca_nhan['thong_tin_quan_ly_ca_nhan_trong_xa_hoi'][$rs['alias']])) {
                                $html.="<p><strong>".$rs['name']." :</strong>";
                                $html.=$thong_tin_quan_ly_ca_nhan['thong_tin_quan_ly_ca_nhan_trong_xa_hoi'][$rs['alias']];
                                $html.="</p>";
                                }
                            }
                        $html.="</div>
                    </article>
                </div>

                <!-- Kết thúc -->

                <div class=\"row block_content\">
                    <article class=\"col-sm-12\">
                        <h1 class=\"title\">
                            <i class=\"fa  fa-codepen\"></i>
                            <span>Sở thích</span>
                        </h1>
                        <div class=\"content\">";
                            
                            $tmp = 0;
                            foreach ($aryHobby as $key => $value) {
                                // var_dump($value);
                                $objFieldInfo->getList(" and sub_cat_id='".$value['sub_cat_id']."'", "");
                                $aryAlias = array();
                                while ($rs=$objFieldInfo->Fetch_Assoc()) {
                                    array_push($aryAlias, $rs);
                                }

                                $nameHobby = "";
                                $alias = "";
                                foreach ($arySubCatHobby as $k => $val) {
                                    if($val['id'] == $value['sub_cat_id']) {
                                        $nameHobby = $val['name'];
                                        $alias = $val['alias'];
                                        break;
                                    }
                                }

                                if ($tmp % 7 == 0) $html.="<article class=\"col-sm-6\">";

                                $html.="<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i>".$nameHobby."</h4>";

                                if (isset($value[$alias])) { 
                                    for ($i=0; $i < count($value[$alias]); $i++) {
                                        for ($j=0; $j < count($aryAlias); $j++) { 
                                            if (isset($value[$alias][$i][$aryAlias[$j]['alias']])) {
                                                $html.="<p><strong>".$aryAlias[$j]['name'].":</strong> ".$value[$alias][$i][$aryAlias[$j]['alias']]."</p>";   
                                            }
                                            
                                        }
                                    }
                                }   

                                $tmp ++;
                                if ($tmp % 7 == 0 || $tmp == count($aryHobby)) $html.="</article>";
                            }
                            
                        $html.="</div>
                    </article>
                </div>";

                 // Quan hệ gia đình
                $html.="<div class=\"row block_content\">
                    <article class=\"col-sm-12\">
                        <h1 class=\"title\">
                            <i class=\"fa fa-cogs\"></i>
                            <span>Quan hệ gia đình</span>
                        </h1>
                        <div class=\"content\">";
                            
                            foreach ($aryRelation as $key => $value) {
                                // Neu ho ten ma trống thì bỏ qua
                                if(isset($qhgd_thongtindinhdanh['thong_tin_gan_dinh_danh_co_the'][$key]['ho_ten'])) {

                                    // gen data
                                    $html.="<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i>".$value['relationship']."</h4>";
                                    $html.="<div class=\"row\">";
                                    $html.="<article class=\"col-sm-6\">";
                                    $html.="<h4>Thông tin định danh</h4>";
                                    
                                    foreach ($qhgd_thongtindinhdanh['thong_tin_gan_dinh_danh_co_the'] as $k => $val) {
                                        if ($key == $k) {
                                            $objFieldInfo->getList(" and sub_cat_id='".SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE."'", " order by sort asc");
                                            while ($rs=$objFieldInfo->Fetch_Assoc()) {
                                                if (isset($val[$rs['alias']]) && $val[$rs['alias']] != "") {
                                                    $html.="<p><strong>".$rs['name']." : </strong>".$val[$rs['alias']]."</p>";    
                                                }
                                                
                                            }       
                                        }
                                    }
                                    $html.="</article>";

                                    $html.="<article class=\"col-sm-6\">";
                                    $html.="<h4>Thông tin khác</h4>";
                                    
                                    foreach ($qhgd_thongtinkhac['thong_tin_khac'] as $k => $val) {
                                        if ($key == $k) {
                                            $objFieldInfo->getList(" and sub_cat_id='".SUB_CN_QHGD_THONGTIN_KHAC."'", " order by sort asc");
                                            while ($rs=$objFieldInfo->Fetch_Assoc()) {
                                                if (isset($val[$rs['alias']]) && $val[$rs['alias']] != "") {
                                                    $html.="<p><strong>".$rs['name']." : </strong>".$val[$rs['alias']]."</p>";    
                                                }
                                                
                                            }       
                                        }
                                    }
                                    $html.="</article>";
                                    $html.="</div>";
                                } // end if
                            }
                            
                        $html.="</div>
                    </article>
                </div>";


                $html.="<div class=\"row block_content\">
                    <article class=\"col-sm-6\">
                        <h1 class=\"title\">
                            <i class=\"fa fa-cogs\"></i>
                            <span>Quá trình học tập</span>
                        </h1>
                        <div class=\"content\">";
                            
                            foreach ($qua_trinh_hoc_tap['qua_trinh_hoc_tap'] as $key => $value) {
                                $stt = $key+1;
                                if ($value['from_year'] != "" && $value['to_year'] != "") {

                                    $html.= "<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i> Giai đoạn ".$stt."</h4>";
                                    $objFieldInfo->getList(" and sub_cat_id='".SUB_CN_QUATRINH_HOCTAP."'", "");
                                    while ($rs=$objFieldInfo->Fetch_Assoc()) {
                                        $html.="<p><strong>".$rs['name']." : </strong>".$value[$rs['alias']]."</p>";
                                    }

                                }
                            }
                            
                        $html.="</div>
                    </article>
                    <article class=\"col-sm-6\">
                        <h1 class=\"title\">
                            <i class=\"fa fa-cogs\"></i>
                            <span>Lý lịch công tác</span>
                        </h1>
                        <div class=\"content\">";
                            
                            foreach ($ly_lich_cong_tac['ly_lich_cong_tac'] as $key => $value) {
                                $stt = $key+1;
                                if ($value['from_year'] != "" && $value['to_year'] != "") {

                                    $html.="<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i> Giai đoạn ".$stt."</h4>";
                                    $objFieldInfo->getList(" and sub_cat_id='".SUB_LYLICH_CONGTAC."'", "");
                                    while ($rs=$objFieldInfo->Fetch_Assoc()) {
                                        $html.="<p><strong>".$rs['name']." : </strong>".$value[$rs['alias']]."</p>";
                                    }
                                    
                                }
                            }
                            
                        $html.="</div>
                    </article>
                </div>
                <div class=\"row block_content\">
                    <article class=\"col-sm-12\">
                        <h1 class=\"title\">
                            <i class=\"fa fa-cogs\"></i>
                            <span>Quan hệ xã hội</span>
                        </h1>
                        <div class=\"content\">";
                            
                            foreach ($quan_he_xa_hoi['quan_he_xa_hoi'] as $key => $value) {
                                $stt = $key+1;
                                    $html.= "<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i> Quan hệ ".$stt."</h4>";
                                    $objFieldInfo->getList(" and sub_cat_id='".SUB_QUANHE_XAHOI."'", "");
                                    while ($rs=$objFieldInfo->Fetch_Assoc()) {
                                        $html.= "<p><strong>".$rs['name']." : </strong>".$value[$rs['alias']]."</p>";
                                    }
                            }
                            
                        $html.="</div>
                    </article>
                </div>
            </div>


        </div>
        
    </div>
    </div>
</body>
</html>";

}
echo $html;

?>

