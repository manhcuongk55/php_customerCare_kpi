<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objNote = new CLS_NOTE;
$memId = $cusId = $content = $title = "";

if(isset($_POST['txt_content'])) {
	$memId = $objNote->MemId = $GLOBALS['MEM_ID'];
	// $cusId = $objNote->CustomerId = $_POST['txt_customer_id'];
	$title = $objNote->Title = $_POST['txt_title'];
	$content = $objNote->Content = $_POST['txt_content'];

	if(isset($_POST['txt_id'])) {
		$objNote->ID=$_POST['txt_id'];
		$objNote->Update();
	} else {
		$objNote->Add_new();
	}
	// die;
}

if (isset($_GET['id'])) {
	$objNote->getList(" AND id='".$_GET['id']."'", "");
	if($objNote->Num_rows()>0) {
		$rs = $objNote->Fetch_Assoc();
		$memId = $rs['mem_id'];
		$cusId = $rs['customer_id'];
		$title = $rs['title'];
		$content = $rs['content'];
	}
}

if(isset($_GET['del'])) {
	$objNote->ID = $_GET['del'];
	$objNote->Delete();
	echo "<script>window.location='".ROOTHOST."note.html';</script>";
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
						<h2>Sửa ghi chú</h2>
					<?php else : ?>
						<h2>Thêm mới ghi chú</h2>
					<?php endif; ?>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<form class="smart-form" id="form_note" method="POST" novalidate="novalidate" enctype="multipart/form-data" action="">
							
							<fieldset>
								<!-- <section>
									<label class="label">Chọn khách hàng</label>
									<label class="select">
										<select name="txt_customer_id" id="txt_customer_id" attr_value="<?php echo $cusId;?>">
											<option value="">Chọn khách hàng</option>
											<?php
											$objCustomer = new CLS_CUSTOMER;
											$objCustomer->getList(" AND mem_id='".$GLOBALS['MEM_ID']."'", "");
											while ($rs=$objCustomer->Fetch_Assoc()) {
												echo "<option value='".$rs['id']."'>".$rs['fullname']."</option>";
											}
											?>
										</select><i></i>
									</label>	
								</section> -->
								<section>
										<label class="label">Tiêu đề</label>
										<label class="input">
											<i class="icon-append fa fa-edit"></i>
											<input type="text" name="txt_title" value="<?php echo $title?>">
										</label>
								</section>
								<section>
										<label class="label">Nội dung ghi chú</label>
										<label class="textarea">
											<i class="icon-append fa fa-edit"></i>
											<textarea name="txt_content"><?php echo $content;?></textarea>
										</label>
								</section>
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

		<article class="col-sm-12 col-md-8 col-lg-8">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Danh sách ghi chú</h2>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th data-hide="phone,tablet" width="20">No.</th>
									<th>
										<i class="fa fa-fw fa-edit txt-color-blue"></i>
										Tiêu đề
									</th>
									<th>
										<i class="fa fa-fw fa-suitcase txt-color-blue"></i>
										Nội dung ghi chú
									</th>
									<th><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> Thời gian</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$objNote->getList(" and mem_id='".$GLOBALS['MEM_ID']."'", "ORDER BY id desc");
								$stt = 1;

								while($r=$objNote->Fetch_Assoc()) {
									$id = $r['id'];
									// $customerName = $objCustomer->getCustomerName($r['customer_id']);
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td><?php echo $r['title'];?></td>
									<td><?php echo $r['content'];?></td>
									<td><?php echo date("d-m-Y H:i:s", strtotime($r['cdate']))?></td>
									<td align="center">
			                     		<a title="Sửa" href="<?php echo ROOTHOST?>note/id/<?php echo $id;?>" class="btn btn-primary approve-schedule"><i class="fa fa-edit"></i></a>

			                     		<a title="Xóa" href="#" class="btn btn-danger cancel-schedule" onclick="deleteNote(<?php echo "'".$id."'";?>)"><i class="fa fa-trash-o "></i></a>

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
	var val = $("#txt_customer_id").attr("attr_value");
	$("#txt_customer_id").select2().select2("val", val);

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
		var $updateDocumentForm = $("#form_note").validate({
			
			// Rules for form validation
			rules : {
				txt_customer_id: {
					required : true				
				},
				txt_content : {
					required : true
				},
				txt_title : {
					required : true
				}

			},

			// Messages for form validation
		
			messages : {
				txt_customer_id: {
					required : "Chọn khách hàng"	
				},
				
				txt_content : {
					required : "Nội dung ghi chú không được trống"
				},
				txt_title : {
					required : "Tiêu đề không được trống"
				}
			},

			submitHandler : function(form) {
				$("#form_note").ajaxSubmit({
					success : function() {			
						smartInfoMsg('Thông báo', 'Thành công!', 2000);	
						setTimeout(function(){window.location="<?php echo ROOTHOST?>note.html"; }, 1000);
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

</script>

<?php 
unset($objNote);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.error {color: red;}
</style>

