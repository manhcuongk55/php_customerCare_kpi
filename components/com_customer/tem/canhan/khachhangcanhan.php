<form class="smart-form" id="form_customer_canhan" method="POST" novalidate="novalidate" enctype="multipart/form-data" action="<?php echo ROOTHOST;?>components/com_customer/tem/execute_data.php">
						
	<fieldset style="padding-top: 0px;">
	<ul class="nav nav-tabs">
		<li class="active">
			<a data-toggle="tab" href="#AA">[1] Thông tin chung</a>
		</li>
		<li>
			<a data-toggle="tab" href="#BB">[2] Sở thích</a>
		</li>
		<li>
			<a data-toggle="tab" href="#CC">[3] Quan hệ gia đình</a>
		</li>
		<li>
			<a data-toggle="tab" href="#DD">[4] Quá trình học tập</a>
		</li>
		<li>
			<a data-toggle="tab" href="#EE">[5] Lý lịch công tác</a>
		</li>
		<li>
			<a data-toggle="tab" href="#FF">[6] Quan hệ xã hội</a>
		</li>
	</ul>
	<div class="tabbable tabs-below">
		<div class="tab-content">
			<!-- Thông tin chung cá nhân -->
			<div class="tab-pane active" id="AA">
				<?php include('thongtinchung.php');?>
			</div>

			<!-- Sở thích -->
			<div class="tab-pane" id="BB">
				<?php include('sothich.php');?>
			</div>

			<!-- Quan hệ gia đình -->
			<div class="tab-pane" id="CC">
				<?php include('quanhegiadinh.php');?>
			</div>

			<!-- Quá trinh học tập -->
			<div class="tab-pane" id="DD">
				<?php include('quatrinhhoctap.php');?>
			</div>

			<!-- Lý lịch công tác -->
			<div class="tab-pane" id="EE">
				<?php include('lylichcongtac.php');?>
			</div>

			<!-- Quan hệ xã hội -->
			<div class="tab-pane" id="FF">
				<?php include('quanhexahoi.php');?>
			</div>
			
		</div>
		
	</div>
	</fieldset>
	<footer>
		<input type="hidden" name="txt_type" value="<?php echo GROUP_CANHAN;?>" id="txt_type_canhan">
		<input type="hidden" name="mem_id" value="<?php echo $GLOBALS['MEM_ID'];?>">
		<?php
		
		if (isset($_GET['id']) && $_GET['type'] == GROUP_CANHAN) : ?>
			<input type="hidden" name="txt_id" value="<?php echo $_GET['id']?>" id="txt_id">
		<?php endif;?>

		<button type="button" class="btn btn-primary" onclick="backPage()"><i class="fa fa-long-arrow-left "></i> Quay lại</button>

		<button type="button" name="cmd_save" id="cmd_save" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php if(isset($_GET['id']) && $_GET['type'] == GROUP_CANHAN) echo "Cập nhật"; else echo "Thêm mới";?></button>
	</footer>
</form>