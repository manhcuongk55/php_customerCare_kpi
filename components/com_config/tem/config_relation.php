<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objMysql = new CLS_MYSQL;
$id = $relation = "";

if(isset($_POST['cmd_save'])) {
	if (isset($_POST['txt_id'])) {
		$sql="UPDATE tbl_relationship SET `relationship`=N'".$_POST['txt_relationship']."' WHERE id='".$_POST['txt_id']."'";
		$objMysql->Exec($sql);	
	} else {
		$sql="INSERT INTO tbl_relationship (`relationship`) VALUES (N'".$_POST['txt_relationship']."')";
		$objMysql->Exec($sql);	
	}
		
}
if (isset($_GET['id'])) {
	$sql="SELECT * FROM tbl_relationship WHERE id='".$_GET['id']."'";
	$objMysql->Query($sql);
	if($objMysql->Num_rows()>0) {
		$rs = $objMysql->Fetch_Assoc();
		$relation = $rs['relationship'];
		$id = $rs['id'];
	}
}

if(isset($_GET['del'])) {
	$sql =  "DELETE FROM tbl_relationship WHERE id='".$_GET['del']."'";	
	$objMysql->Exec($sql);
	echo "<script>window.location='".ROOTHOST."config_relation.html';</script>";
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
						<h2>Sửa quan hệ gia đình</h2>
					<?php else : ?>
						<h2>Thêm quan hệ gia đình</h2>
					<?php endif; ?>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<form class="smart-form" id="form_relationship" method="POST" novalidate="novalidate" enctype="multipart/form-data" action="">
							
							<fieldset>
								<section>
									<label class="label">Quan hệ với khách hàng</label>
									<label class="input">
										<i class="icon-append fa fa-edit"></i>
										<input type="text" name="txt_relationship" value="<?php echo $relation?>">
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
					<h2>Quan hệ gia đình khách hàng</h2>
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
										<i class="fa fa-fw fa-user txt-color-blue"></i>
										Tên quan hệ
									</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql="SELECT * FROM tbl_relationship";
								$objMysql->Query($sql);								
								$stt = 1;

								while($r=$objMysql->Fetch_Assoc()) {
									$id = $r['id'];
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td><?php echo $r['relationship'];?></td>
									<td align="center">
			                     		<a title="Sửa" href="<?php echo ROOTHOST?>config_relation/id/<?php echo $id;?>" class="btn btn-primary approve-schedule"><i class="fa fa-edit"></i></a>

			                     		<a title="Xóa" href="#" class="btn btn-danger cancel-schedule" onclick="deleteRelation(<?php echo "'".$id."'";?>)"><i class="fa fa-trash-o "></i></a>

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
<script type="text/javascript">	

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
		var $updateDocumentForm = $("#form_relationship").validate({
			
			// Rules for form validation
			rules : {
				txt_relationship: {
					required : true				
				}			

			},

			// Messages for form validation
		
			messages : {
				txt_relationship: {
					required : "Trường bắt buộc"	
				}
			},

			submitHandler : function(form) {
				$("#form_relationship").ajaxSubmit({
					success : function() {			
						smartInfoMsg('Thông báo', 'Thành công!', 2000);	
						setTimeout(function(){window.location="<?php echo ROOTHOST?>config_relation.html"; }, 1000);
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

	function deleteRelation(id) {
		smartConfirm('Thông báo', 'Bạn có muốn xóa quan hệ này không?', function() {
			window.location="<?php echo ROOTHOST?>config_relation/del/" + id;
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
