<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objMeet = new CLS_MEET;
$memId = "";
$cbo_type = $cbo_customer_id = $txt_datetime =$txt_content = $txt_address = $cbo_status = $txt_result = $txt_next_time = $txt_next_content = $txt_note = $txt_image = "";


if(isset($_POST['cbo_customer_id'])) {

	$memId = $objMeet->MemId = $GLOBALS['MEM_ID'];
	$cbo_type = $objMeet->Type = $_POST['cbo_type'];
	$cbo_customer_id = $objMeet->CustomerId = $_POST['cbo_customer_id'];
	$txt_datetime = $objMeet->DateTime = date('Y-m-d H:i:s', strtotime($_POST['txt_datetime']));
	$txt_content = $objMeet->Content = $_POST['txt_content'];
	$txt_address = $objMeet->Address = $_POST['txt_address'];
	$cbo_status = $objMeet->Status = $_POST['cbo_status'];
	$txt_result = $objMeet->Result = $_POST['txt_result'];
	$txt_next_time = $objMeet->NextTime = date('Y-m-d H:i:s', strtotime($_POST['txt_next_time']));
	$txt_next_content = $objMeet->NextContent = $_POST['txt_next_content'];
	$txt_note = $objMeet->Note = $_POST['txt_note'];

	// ----------------UPLOAD FILE -----------------
	$valid_formats = array("jpg", "png");
	$max_file_size = 1024*10000; 
	$path = "uploads/images/";
	$strFile = "";	

	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
		// Loop $_FILES to execute all files
		$nameFile = '';
		foreach ($_FILES['files']['name'] as $f => $nameFile) { 
			$nameFile = un_unicode($nameFile);    
		    if ($_FILES['files']['error'][$f] == 4) {
		        continue; // Skip file if any error found
		    }	       
		    if ($_FILES['files']['error'][$f] == 0) {	           
		        if ($_FILES['files']['size'][$f] > $max_file_size) {
		            $message[] = "$nameFile is too large!.";
		            continue; // Skip large files
		        }
				elseif( ! in_array(pathinfo($nameFile, PATHINFO_EXTENSION), $valid_formats) ){
					$message[] = "$nameFile is not a valid format";
					continue; // Skip invalid file formats
				}
		        else{ // No error found! Move uploaded files
		            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$nameFile)) {
		            	$strFile.=$path.$nameFile;
		            }
		        }
		    }
		}	
		
	} else {
		echo "failed";
	}

	if ($strFile != "") {
		$objMeet->Image=$strFile;	
	} else {
		$objMeet->Image=$_POST['txt_image'];
	}
	

	if(isset($_POST['txt_id'])) {
		$objMeet->ID=$_POST['txt_id'];
		$objMeet->Update();
	} else {
		$objMeet->Add_new();
	}
	
}

if (isset($_GET['id'])) {
	$objMeet->getList(" AND id='".$_GET['id']."'", "");
	if($objMeet->Num_rows()>0) {
		$rs = $objMeet->Fetch_Assoc();
		$memId = $rs['mem_id'];
		$cbo_type = $rs['type'];
		$cbo_customer_id = $rs['customer_id'];
		$txt_datetime = date('Y-m-d H:i:s', strtotime($rs['datetime']));
		$txt_content = $rs['content'];
		$txt_address = $rs['address'];
		$cbo_status = $rs['status'];
		$txt_result = $rs['result'];
		$txt_next_time = date('Y-m-d H:i:s', strtotime($rs['next_time']));
		$txt_next_content = $rs['next_content'];
		$txt_note = $rs['note'];
		$txt_image = $rs['image'];
	}
}

?>
<section class="" id="widget-grid">
	<div class="row">

		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<?php if(isset($_GET['id'])) : ?>
						<h2>Sửa thông tin gặp gỡ</h2>
					<?php else : ?>
						<h2>Thêm mới gặp gỡ</h2>
					<?php endif; ?>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<form class="smart-form" id="form_meet" method="POST" novalidate="novalidate" enctype="multipart/form-data" action="">
							
							<fieldset>
								<div class="row">
									<section class="col col-3">
										<label class="label">Nhân sự kinh doanh</label>
										<label class="input">
											<i class="icon-append fa fa-user"></i>
											<input type="text" value="<?php echo $GLOBALS['FULLNAME'] ?>" readonly>
										</label>
									</section>

									<section class="col col-3">
										<label class="label">Kiểu gặp gỡ <span class="require_field">(*)</span></label>
										<label class="select">
											<select name="cbo_type" id="cbo_type" attr_value="<?php echo $cbo_type;?>">
												<option value="">Chọn loại giao dịch</option>
												<option value="tang_qua">Tặng quà</option>
												<option value="hop_hanh">Họp hành</option>
												<option value="dam_hieu">Đám hiếu</option>
												<option value="dam_hi">Đám hỉ</option>
												<option value="di_choi">Đi chơi</option>
												<option value="lien_hoan">Liên hoan</option>
												<option value="gap_mat">Gặp mặt</option>
											</select><i></i>
										</label>	
									</section>

									<section class="col col-3">
										<label class="label">Cá nhân/doanh nghiệp <span class="require_field">(*)</span></label>
										<label class="select">
											<select name="cbo_customer_id" id="cbo_customer_id" attr_value="<?php echo $cbo_customer_id;?>">
												<option value="">Chọn khách hàng</option>
												<?php
												$objCustomer = new CLS_CUSTOMER;
												$objCustomer->getList(" and mem_id='".$GLOBALS['MEM_ID']."'", "");
												while ($rs=$objCustomer->Fetch_Assoc()) {
													echo "<option value='".$rs['id']."'>".$rs['fullname']."</option>";
												}
												?>
											</select><i></i>
										</label>	
									</section>

									<section class="col col-3">
										<label class="label">
											Ngày gặp gỡ <span class="require_field">(*)</span>
										</label>
										<label class="input">
											<i class="icon-append fa fa-calendar"></i>
											<input type="text" name="txt_datetime" id="txt_datetime" 
											value="<?php if(isset($_GET['id'])) echo date("d-m-Y", strtotime($txt_datetime))?>">
										</label>	
									</section>

								</div>
								
								<div class="row">
									<section class="col col-3">
										<label class="label">Nội dung <span class="require_field">(*)</span></label>
										<label class="textarea">
											<i class="icon-append fa fa-edit"></i>
											<textarea name="txt_content"><?php echo $txt_content;?></textarea>
										</label>
									</section>

									<section class="col col-3">
										<label class="label">Địa điểm gặp gỡ <span class="require_field">(*)</span></label>
										<label class="textarea">
											<i class="icon-append fa fa-edit"></i>
											<textarea name="txt_address"><?php echo $txt_address;?></textarea>
										</label>
									</section>

									<section class="col col-3">
										<label class="label">Hình ảnh gặp gỡ</label>
										<label for="file" class="input input-file">
											<div class="button">
												<input type="file" multiple="multiple" name="files[]"  class="link"
												onchange="this.parentNode.nextSibling.value = this.value">Browse
											</div>
											<input type="text" placeholder="Hình ảnh..." readonly="">
											<?php
											if(isset($_GET['id'])) { ?>
											<input type="hidden" name="txt_image" value="<?php echo $txt_image?>">
											<?php } ?>
										</label>
									</section>

									<section class="col col-3">
										<label class="label">Trạng thái</label>
										<label class="select">
											<select name="cbo_status" id="cbo_status" attr_value="<?php echo $cbo_status;?>">
												<option value="st_waiting">Sắp diễn ra</option>
												<option value="st_complete">Thành công</option>
												<option value="st_cancel">Hủy bỏ</option>
												<option value="st_faile">Thất bại</option>
											</select><i></i>
										</label>	
									</section>

								</div>

								<div class="row">
									<section class="col col-3">
										<label class="label">Kết quả</label>
										<label class="textarea">
											<i class="icon-append fa fa-edit"></i>
											<textarea name="txt_result"><?php echo $txt_result;?></textarea>
										</label>
									</section>

									<section class="col col-3" style="display: none;">
										<label class="label">
											Thời gian làm việc tiếp
										</label>
										<label class="input">
											<i class="icon-append fa fa-calendar"></i>
											<input type="text" name="txt_next_time" id="txt_next_time" value="<?php if(isset($_GET['id'])) echo date("d-m-Y", strtotime($txt_next_time))?>">
										</label>	
									</section>

									<section class="col col-3">
										<label class="label">Nội dung cv tiếp theo</label>
										<label class="textarea">
											<i class="icon-append fa fa-edit"></i>
											<textarea name="txt_next_content"><?php echo $txt_next_content;?></textarea>
										</label>
									</section>

									<section class="col col-3">
										<label class="label">Ghi chú</label>
										<label class="textarea">
											<i class="icon-append fa fa-edit"></i>
											<textarea name="txt_note"><?php echo $txt_note;?></textarea>
										</label>
									</section>

								</div>
								<span><i>Trường (*) là bắt buộc</i></span>
							</fieldset>
							
							<footer>								
								<?php if(isset($_GET['id'])) :?>
									<input type="hidden" name="txt_id" value="<?php echo $_GET['id'];?>" />
								<?php endif;?>
								
								<button type="reset" name="reset" id="reset" class="btn btn-primary"><i class="fa fa-refresh "></i> Reset</button>

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

	</div>

</section>


<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">	
	var val = $("#cbo_type").attr("attr_value");
	$("#cbo_type").select2().select2("val", val);

	var val = $("#cbo_customer_id").attr("attr_value");
	$("#cbo_customer_id").select2().select2("val", val);

	var val = $("#cbo_status").attr("attr_value");
	$("#cbo_status").select2().select2("val", val);

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
		var $updateDocumentForm = $("#form_meet").validate({
			
			// Rules for form validation
			rules : {
				cbo_customer_id: {
					required : true				
				},
				txt_content : {
					required : true
				},
				cbo_type : {
					required : true
				},
				txt_address: {
					required : true
				},
				txt_datetime : {
					required : true
				},
				cbo_status : {
					required : true
				}


			},

			// Messages for form validation
		
			messages : {
				cbo_customer_id: {
					required : "Chọn khách hàng"	
				},
				txt_content : {
					required : "Nội dung không được trống"
				},
				cbo_type : {
					required : "Chọn kiểu gặp gỡ"
				},
				txt_address : {
					required : "Địa chỉ gặp gỡ"
				},
				txt_datetime : {
					required : "Thời gian gặp gỡ"
				}, 
				cbo_status : {
					required : "Chọn trạng thái"
				}
			},

			submitHandler : function(form) {
				$("#form_meet").ajaxSubmit({
					success : function() {			
						smartInfoMsg('Thông báo', 'Thành công!', 2000);	
						setTimeout(function(){window.location="<?php echo ROOTHOST?>meet.html"; }, 1000);
					}
				});
			},
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

	function deleteNote(id) {
		smartConfirm('Thông báo', 'Bạn có muốn xóa ghi chú này không?', function() {
			window.location="<?php echo ROOTHOST?>note/del/" + id;
		})
	}

	$('#txt_datetime').datepicker({
		dateFormat : 'dd-mm-yy',
		prevText : '<i class="fa fa-chevron-left"></i>',
		nextText : '<i class="fa fa-chevron-right"></i>',
		onSelect : function(selectedDate) {
			$('#finishdate').datepicker('option', 'minDate', selectedDate);
		}
	});
	$('#txt_next_time').datepicker({
		dateFormat : 'dd-mm-yy',
		prevText : '<i class="fa fa-chevron-left"></i>',
		nextText : '<i class="fa fa-chevron-right"></i>',
		onSelect : function(selectedDate) {
			$('#finishdate').datepicker('option', 'minDate', selectedDate);
		}
	});
	$("#cbo_customer_id").select2();
	$("#cbo_status").select2();
	$("#cbo_type").select2();
</script>

<?php 
unset($objMeet);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.require_field {color: red;}
</style>

