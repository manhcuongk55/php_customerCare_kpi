<?php
include_once("includes/groupjs.php");
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
?>
<article class="col-sm-12 col-md-7 col-lg-7">	
	<div class="row">
	<div class="avatar col-md-6">
		<img src="<?php echo $thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the']['hinh_anh']?>" width="100%" height="auto">
	</div>
	<div class="div_name col-md-6">
		<h1 class="txt-color-blue"><?php echo $thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the']['ho_ten']?></h1>
	</div>
	</div>
</article>
<article class="col-sm-12 col-md-5 col-lg-5">
	<ul class="info_top">
		<li><i class="fa fa-female txt-color-blue"></i> <strong style="margin-left: 10px">Giới tính:</strong>
			<span><?php if ($thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the']['gioi_tinh'] == 0) echo "Nam"; else echo "Nữ"?></span>
		</li>
		<li><i class="fa fa-calendar txt-color-blue"></i> <strong style="margin-left: 10px">Ngày sinh:</strong>
			<?php echo date('d-m-Y',strtotime($thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the']['ngay_sinh']));?>
		</li>
		<li><i class="fa fa-phone txt-color-blue"></i> <strong style="margin-left: 10px">Điện thoại:</strong>
			<?php echo $thong_tin_xa_hoi['thong_tin_xa_hoi_hien_tai']['dien_thoai'];?>
		</li>
		<li><i class="fa fa-envelope-o txt-color-blue"></i> <strong style="margin-left: 10px">Email:</strong>
			<?php echo $thong_tin_xa_hoi['thong_tin_xa_hoi_hien_tai']['email'];?>
		</li>
		<li><i class="fa fa-university txt-color-blue"></i> <strong style="margin-left: 10px">Nơi ở hiện tại:</strong>
			<?php echo $thong_tin_quan_ly_ca_nhan['thong_tin_quan_ly_ca_nhan_trong_xa_hoi']['noi_o_hien_tai'];?>
		</li>
	</ul>
</article>
<div class="row block_content">
	<article class="col-sm-6">
		<h1 class="title">
			<i class="fa fa-user"></i>
			<span>Thông tin định danh cơ thể</span>
		</h1>
		<div class="content">
			<?php
			$objFieldInfo->getList(" and sub_cat_id='1'", "");
			while ($rs=$objFieldInfo->Fetch_Assoc()) {			
				if (isset($thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the'][$rs['alias']])) { ?>
				<p><strong><?php echo $rs['name']?> :</strong>
				<?php 
					if ($rs['alias'] == "gioi_tinh") {
						if ($thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the'][$rs['alias']] == 0) echo "Nam"; else echo "Nữ";
					} else if ($rs['alias']=='hinh_anh') {
						// Not show
					} else {
						echo $thong_tin_dinh_danh['thong_tin_gan_dinh_danh_co_the'][$rs['alias']];
					}
				?>
				</p>
			<?php	}
			}
			?>
		</div>	
	</article>
	<article class="col-sm-6">
		<h1 class="title">
			<i class="fa fa-puzzle-piece"></i>
			<span>Thông tin xã hội</span>
		</h1>
		<div class="content">
			<?php
			$objFieldInfo->getList(" and sub_cat_id='3'", "");
			while ($rs=$objFieldInfo->Fetch_Assoc()) {			
				if (isset($thong_tin_xa_hoi['thong_tin_xa_hoi_hien_tai'][$rs['alias']])) { ?>
				<p><strong><?php echo $rs['name']?> :</strong>
				<?php echo $thong_tin_xa_hoi['thong_tin_xa_hoi_hien_tai'][$rs['alias']];?>
				</p>
			<?php	}
			}
			?>
		</div>
		
	</article>
	
</div>

<div class="row block_content">
	<article class="col-sm-12">
		<h1 class="title">
			<i class="fa  fa-cubes"></i>
			<span>Thông tin quản lý cá nhân</span>
		</h1>
		<div class="content">
			<?php
			$objFieldInfo->getList(" and sub_cat_id='2'", "");
			while ($rs=$objFieldInfo->Fetch_Assoc()) {			
				if (isset($thong_tin_quan_ly_ca_nhan['thong_tin_quan_ly_ca_nhan_trong_xa_hoi'][$rs['alias']])) { ?>
				<p><strong><?php echo $rs['name']?> :</strong>
				<?php echo $thong_tin_quan_ly_ca_nhan['thong_tin_quan_ly_ca_nhan_trong_xa_hoi'][$rs['alias']];?>
				</p>
			<?php	}
			}
			?>
		</div>
	</article>
</div>

<div class="row block_content">
	<article class="col-sm-12">
		<h1 class="title">
			<i class="fa  fa-codepen"></i>
			<span>Sở thích</span>
		</h1>
		<div class="content">
			<?php
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

				if ($tmp % 7 == 0) echo "<article class=\"col-sm-6\">";

				echo "<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i>".$nameHobby."</h4>";
				if (isset($value[$alias])) { 
					for ($i=0; $i < count($value[$alias]); $i++) {
						for ($j=0; $j < count($aryAlias); $j++) { 
							if (isset($value[$alias][$i][$aryAlias[$j]['alias']])) {
								echo "<p><strong>".$aryAlias[$j]['name'].":</strong> ".$value[$alias][$i][$aryAlias[$j]['alias']]."</p>";	
							}
							
						}
					}
				}	

				$tmp ++;
				if ($tmp % 7 == 0 || $tmp == count($aryHobby)) echo "</article>";
			}
			?>
		</div>
	</article>
</div>

<div class="row block_content">
	<article class="col-sm-12">
		<h1 class="title">
			<i class="fa fa-cogs"></i>
			<span>Quan hệ gia đình</span>
		</h1>
		<div class="content">
			<?php
			foreach ($aryRelation as $key => $value) {
				// Neu ho ten ma trống thì bỏ qua
				if(isset($qhgd_thongtindinhdanh['thong_tin_gan_dinh_danh_co_the'][$key]['ho_ten']) &&  $qhgd_thongtindinhdanh['thong_tin_gan_dinh_danh_co_the'][$key]['ho_ten']== "") continue;

				// gen data
				echo "<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i>".$value['relationship']."</h4>";
				echo "<div class=\"row\">";
				echo "<article class=\"col-sm-6\">";
				echo "<h4>Thông tin định danh</h4>";
				
				foreach ($qhgd_thongtindinhdanh['thong_tin_gan_dinh_danh_co_the'] as $k => $val) {
					if ($key == $k) {
						$objFieldInfo->getList(" and sub_cat_id='".SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE."'", " order by sort asc");
						while ($rs=$objFieldInfo->Fetch_Assoc()) {
							if (isset($val[$rs['alias']]) && $val[$rs['alias']] != "") {
								echo "<p><strong>".$rs['name']." : </strong>".$val[$rs['alias']]."</p>";	
							}
							
						}		
					}
				}
				echo "</article>";

				echo "<article class=\"col-sm-6\">";
				echo "<h4>Thông tin khác</h4>";
				
				foreach ($qhgd_thongtinkhac['thong_tin_khac'] as $k => $val) {
					if ($key == $k) {
						$objFieldInfo->getList(" and sub_cat_id='".SUB_CN_QHGD_THONGTIN_KHAC."'", " order by sort asc");
						while ($rs=$objFieldInfo->Fetch_Assoc()) {
							if (isset($val[$rs['alias']]) && $val[$rs['alias']] != "") {
								echo "<p><strong>".$rs['name']." : </strong>".$val[$rs['alias']]."</p>";	
							}
							
						}		
					}
				}
				echo "</article>";
				echo "</div>";
			}
			?>
		</div>
	</article>
</div>

<div class="row block_content">
	<article class="col-sm-6">
		<h1 class="title">
			<i class="fa fa-cogs"></i>
			<span>Quá trình học tập</span>
		</h1>
		<div class="content">
			<?php
			foreach ($qua_trinh_hoc_tap['qua_trinh_hoc_tap'] as $key => $value) {
				$stt = $key+1;
				if ($value['from_year'] != "" && $value['to_year'] != "") {

					echo "<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i> Giai đoạn ".$stt."</h4>";
					$objFieldInfo->getList(" and sub_cat_id='".SUB_CN_QUATRINH_HOCTAP."'", "");
					while ($rs=$objFieldInfo->Fetch_Assoc()) {
						echo "<p><strong>".$rs['name']." : </strong>".$value[$rs['alias']]."</p>";
					}

				}
			}
			?>
		</div>
	</article>
	<article class="col-sm-6">
		<h1 class="title">
			<i class="fa fa-cogs"></i>
			<span>Lý lịch công tác</span>
		</h1>
		<div class="content">
			<?php
			foreach ($ly_lich_cong_tac['ly_lich_cong_tac'] as $key => $value) {
				$stt = $key+1;
				if ($value['from_year'] != "" && $value['to_year'] != "") {

					echo "<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i> Giai đoạn ".$stt."</h4>";
					$objFieldInfo->getList(" and sub_cat_id='".SUB_LYLICH_CONGTAC."'", "");
					while ($rs=$objFieldInfo->Fetch_Assoc()) {
						echo "<p><strong>".$rs['name']." : </strong>".$value[$rs['alias']]."</p>";
					}
					
				}
			}
			?>
		</div>
	</article>
</div>
<div class="row block_content">
	<article class="col-sm-12">
		<h1 class="title">
			<i class="fa fa-cogs"></i>
			<span>Quan hệ xã hội</span>
		</h1>
		<div class="content">
			<?php
			foreach ($quan_he_xa_hoi['quan_he_xa_hoi'] as $key => $value) {
				$stt = $key+1;
					echo "<h4 class=\"row-seperator-header\"><i class=\"fa fa-plus\"></i> Quan hệ ".$stt."</h4>";
					$objFieldInfo->getList(" and sub_cat_id='".SUB_QUANHE_XAHOI."'", "");
					while ($rs=$objFieldInfo->Fetch_Assoc()) {
						echo "<p><strong>".$rs['name']." : </strong>".$value[$rs['alias']]."</p>";
					}
			}
			?>
		</div>
	</article>
</div>
<style type="text/css">
	.row-seperator-header {
    	margin: 15px 0px 10px;
    	font-size: 15px;
	}
</style>