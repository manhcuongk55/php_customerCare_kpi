<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objDisplay = new CLS_DISPLAY;
$objSubCat = new CLS_SUBCAT;
$subcat = "";

if(isset($_POST['cmd_save']) && $_POST['txt_display'] != "") {
	$objDisplay->DisplayItem = $_POST['txt_display'];
	if (isset($_POST['txt_id'])) {
		$objDisplay->ID = $_POST['txt_id'];
		$objDisplay->Update();
	} else {
		$objDisplay->SubCatId = $_POST['cbo_sub_cat'];
		$objDisplay->Add_new();	
	}
}

if (isset($_GET['id'])) {
	$id=$_GET['id'];	
	$objDisplay->getList(" and id='$id'", "");
	$rs=$objDisplay->Fetch_Assoc();
	$numdisplay = $rs['display_item'];
	$subcat = $rs['sub_cat_id'];
}

// Xoa dữ liêu
if (isset($_GET['del'])) {
	$objDisplay->ID = $_GET['del'];
	$objDisplay->Delete();
	echo "<script>window.location='".ROOTHOST."config_display.html';</script>";
}

if (isset($_SESSION['GROUP_TYPE']) && isset($_POST['cbo_group_type'])) {
	$_SESSION['GROUP_TYPE'] = $_POST['cbo_group_type'];
} else {
	$_SESSION['GROUP_TYPE'] = "-1";
}

if (isset($_SESSION['CAT_ID']) && isset($_POST['cbo_category'])) {
	$_SESSION['CAT_ID'] = $_POST['cbo_category'];
} else {
	$_SESSION['CAT_ID'] = "-1";
}

?>
<section class="" id="widget-grid">
	<div class="row">

		<article class="col-sm-12 col-md-4 col-lg-4">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<?php if(isset($_GET['id'])) : ?>
						<h2>Sửa thông tin cấu hình</h2>
					<?php else : ?>
						<h2>Thêm mới cấu hình</h2>
					<?php endif; ?>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<form class="smart-form" id="form_display" method="POST" novalidate="novalidate" enctype="multipart/form-data" action="">
							
							<fieldset>
									<?php if(!isset($_GET['id'])) :?>
									<section>
										<label class="label">Khách hàng <span class="require_field">(*)</span></label>
										<label class="select">
											<select name="cbo_group_type" id="cbo_group_type" attr_value="<?php echo $_SESSION['GROUP_TYPE']?>">
												<option value="-1">Chọn loại khách hàng</option>
												<option value="<?php echo GROUP_CANHAN;?>">Cá nhân</option>
												<option value="<?php echo GROUP_DOANHNGHIEP;?>">Doanh nghiệp</option>
												<option value="<?php echo GROUP_TOCHUC;?>">Tổ chức</option>
											</select><i></i>
										</label>	
									</section>										
								
									<section>
										<label class="label">Chọn nhóm thông tin<span class="require_field">(*)</span></label>
										<label class="select">
											<select name="cbo_category" id="cbo_category" attr_value="<?php echo $_SESSION['CAT_ID']?>">
												<option value="-1">Chọn nhóm</option>
												<?php 
												
													$objCat = new CLS_CATEGORY;
													$objCat->getList(" and `group`='".$_SESSION['GROUP_TYPE']."'", "");
													while ($rs=$objCat->Fetch_Assoc()) { ?>
														<option value="<?php echo $rs['id']?>"><?php echo $rs['name']?></option>
													<?php }
												
												?>
											</select><i></i>
										</label>	
									</section>
								
									<section>
										<label class="label">Cần thêm trường dữ liệu mới vào?<span class="require_field">(*)</span></label>
										<label class="select">
											<select name="cbo_sub_cat" id="cbo_sub_cat">
												<option value="">Chọn nhóm thông tin</option>
												<?php 
												
													$objSubCat = new CLS_SUBCAT;
													$objSubCat->getList(" and `cat_id`='".$_SESSION['CAT_ID']."'", "");
													while ($rs=$objSubCat->Fetch_Assoc()) { ?>
														<option value="<?php echo $rs['id']?>"><?php echo $rs['name']?></option>
													<?php }
												
												?>
											</select><i></i>
										</label>	
									</section>

									<section>
										<label class="label">Số lần hiển thị<span class="require_field">(*)</span></label>
										<label class="input">
											<i class="icon-append fa fa-user"></i>
											<input type="text" value="1" name="txt_display" id="txt_display">
										</label>
									</section>

								<?php else: 
									$subName = $objSubCat->getCateName($subcat);
								?>
									<section>
										<label class="label">Nhóm thông tin<span class="require_field">(*)</span></label>
										<label class="input">
											<i class="icon-append fa fa-user"></i>
											<input type="text" value="<?php echo $subName?>" name="" id="" readonly>
										</label>
									</section>

									<section>
										<label class="label">Số lần hiển thị<span class="require_field">(*)</span></label>
										<label class="input">
											<i class="icon-append fa fa-user"></i>
											<input type="text" value="<?php echo $numdisplay?>" name="txt_display" id="txt_display">
										</label>
									</section>
								<?php endif;?>
								
								
								<span><i>Trường (*) là bắt buộc</i></span>
							</fieldset>
							
							<footer>								
								<?php if(isset($_GET['id'])) :?>
									<input type="hidden" name="txt_id" value="<?php echo $_GET['id'];?>" />
								<?php endif;?>
								
								<button type="button" class="btn btn-primary" onclick="backPage()"><i class="fa fa-long-arrow-left "></i> Quay lại</button>

								<button type="submit" name="cmd_save" id="cmd_save" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php if(isset($_GET['id'])) echo "Cập nhật"; else echo "Thêm";?></button>
								
							</footer>
							
						</form>						
						
					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->								


		</article>
		<article class="col-sm-12 col-md-8 col-lg-8">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Cấu hình hiển thị</h2>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th data-hide="phone,tablet" width="20">No.</th>
									<th width="50%">
										<i class="fa fa-fw fa-user txt-color-blue"></i>
										Nhóm thông tin
									</th>
									<th width="20%">
										<i class="fa fa-fw fa-user txt-color-blue"></i>
										Số lần hiển thị
									</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$stt=1;
								$objDisplay->getList(" and isactive='1'", "");
								$objSubCat = new CLS_SUBCAT;
								while($r=$objDisplay->Fetch_Assoc()) {
									$id = $r['id'];
									$namCat = $objSubCat->getSubCatName($r['sub_cat_id']);
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td><?php echo $namCat;?></td>
									<td><?php echo $r['display_item'];?></td>
									<td align="center">
			                     		<a title="Sửa" href="<?php echo ROOTHOST?>config_display/id/<?php echo $id;?>" class="btn btn-primary approve-schedule"><i class="fa fa-edit"></i></a>

			                     		<a title="Xóa" href="#" class="btn btn-danger cancel-schedule" onclick="deleteDisplay(<?php echo "'".$id."'";?>)"><i class="fa fa-trash-o "></i></a>

			                     	</td>
								</tr>
								<?php $stt++;} ?>
								
							</tbody>
						</table>
					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->								


		</article>

	</div>

</section>


<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">	
	var val = $("#cbo_group_type").attr("attr_value");
	$("#cbo_group_type").select2().select2("val", val);

	var val = $("#cbo_category").attr("attr_value");
	$("#cbo_category").select2().select2("val", val);

	var val = $("#cbo_sub_cat").attr("attr_value");
	$("#cbo_sub_cat").select2().select2("val", val);

	pageSetUp();
	
	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {
		var responsiveHelper_dt_basic = undefined;
			var responsiveHelper_datatable_fixed_column = undefined;
			var responsiveHelper_datatable_col_reorder = undefined;
			var responsiveHelper_datatable_tabletools = undefined;
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

			$('#dt_basic').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});

		/* END BASIC */
		var $updateDocumentForm = $("#form_display").validate({
			
			// Rules for form validation
			// rules : {
			// 	txt_field_name: {
			// 		required : true				
			// 	}
			// },

			// // Messages for form validation
		
			// messages : {
			// 	txt_field_name: {
			// 		required : "Trường bắt buộc"	
			// 	}
			// },

			// submitHandler : function(form) {
			// 	$("#form_display").ajaxSubmit({
			// 		success : function() {			
			// 			smartInfoMsg('Thông báo', 'Thành công!', 2000);	
			// 			setTimeout(function(){window.location="<?php echo ROOTHOST?>mgmt_config.html"; }, 1000);
			// 		}
			// 	});
			// },
			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});

	};
	
	// end pagefunction
	// Load form valisation dependency 
	loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/jquery-form/jquery-form.min.js", pagefunction);
	loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
				});
			});
		});
	});

	function deleteDisplay(id) {
		smartConfirm('Thông báo', 'Bạn có muốn xóa bản ghi này không?', function() {
			window.location="<?php echo ROOTHOST?>config_display/del/" + id;
		})
	}
	// Function backPage
	function backPage() {
		window.location="<?php echo ROOTHOST?>config_display.html";
	}

	// commit form
	$("#cbo_group_type").change(function(){
		$("#form_display").submit();
	})

	// commit form
	$("#cbo_category").change(function(){
		$("#form_display").submit();
	})
</script>

<?php 
unset($objDisplay);
unset($objSubCat);
// unset($_SESSION['GROUP_TYPE']);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.require_field {color: red;}
</style>

