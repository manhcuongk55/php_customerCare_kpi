<form class="smart-form" id="form_customer_doanhnghiep" method="POST" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo ROOTHOST;?>components/com_customer/tem/execute_data.php">
						
	<fieldset style="padding-top: 0px;">
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#ttc_dn1" data-toggle="tab">[1] Thông tin chung doanh nghiệp</a>
		</li>
		<li>
			<a href="#ttc_dn2" data-toggle="tab">[2] Thông tin người đại diện doanh nghiệp</a>
		</li>
		<li>
			<a href="#ttc_dn3" data-toggle="tab">[3] Các tổ chức đối tác doanh nghiệp</a>
		</li>
	</ul>
	<div class="tabbable tabs-below">

	<div class="tab-content">
		<div class="tab-pane active" id="ttc_dn1">
			<!-- Thông tin chung doanh nghiêp -->
			<?php include('thongtinchung.php');?>
		</div>
		<div class="tab-pane fade" id="ttc_dn2">
			<!-- Thông tin người đại diện doanh nghiệp -->
			<?php include('nguoidaidien.php');?>
		</div>
		<div class="tab-pane fade" id="ttc_dn3">
			<!-- Đối tác doanh nghiệp -->
			<?php include('tochucdoitac.php');?>
		</div>
	</div>
	</div>
	
	</fieldset>
	<footer>
		<input type="hidden" name="txt_type" value="<?php echo GROUP_DOANHNGHIEP?>">
		<input type="hidden" name="mem_id" value="<?php echo $GLOBALS['MEM_ID'];?>">
		<?php
		if (isset($_GET['id']) && $_GET['type'] == GROUP_DOANHNGHIEP) : ?>
			
			<input type="hidden" name="txt_id" value="<?php echo $_GET['id']?>" id="txt_id">
		<?php endif;?>

		<button type="button" class="btn btn-primary" onclick="backPage()"><i class="fa fa-long-arrow-left "></i> Quay lại</button>

		<button type="button" name="cmd_save" id="cmd_save_doanhnghiep" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php if(isset($_GET['id']) && $_GET['type'] == GROUP_DOANHNGHIEP) echo "Cập nhật"; else echo "Thêm mới";?></button>
	</footer>
</form>

