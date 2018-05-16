<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objMysql = new CLS_MYSQL;
$objSubCat= new CLS_SUBCAT;
$objDisplay = new CLS_DISPLAY;
$id = $hobby = "";

if(isset($_POST['cmd_save'])) {
	if (isset($_POST['txt_id'])) {
		$sql="UPDATE tbl_sub_category SET `name`=N'".$_POST['txt_hobby']."' WHERE id='".$_POST['txt_id']."'";
		$objMysql->Exec($sql);	
	} else {
		
		$objSubCat->CatId = CAT_SOTHICH;
		$objSubCat->Name = $_POST['txt_hobby'];
		$objSubCat->Alias = un_unicode($_POST['txt_hobby']);
		$lastID = $objSubCat->addNewHoby();
		// Thêm vào bảng tbl_display -> mặc định hiển thị là 1
		$objDisplay->SubCatId=$lastID;
		$objDisplay->DisplayItem=1;// Mặc định là 1
		$objDisplay->Add_new();
	}
		
}
if (isset($_GET['id'])) {
	$sql="SELECT * FROM tbl_sub_category WHERE id='".$_GET['id']."'";
	$objMysql->Query($sql);
	if($objMysql->Num_rows()>0) {
		$rs = $objMysql->Fetch_Assoc();
		$hobby = $rs['name'];
		$id = $rs['id'];
	}
}

if(isset($_GET['del'])) {
	$sql =  "DELETE FROM tbl_sub_category WHERE id='".$_GET['del']."'";	
	$objMysql->Exec($sql);
	echo "<script>window.location='".ROOTHOST."config_hobby.html';</script>";
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
						<h2>Chỉnh sửa</h2>
					<?php else : ?>
						<h2>Thêm mới sở thích</h2>
					<?php endif; ?>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<form class="smart-form" id="form_hobby" method="POST" novalidate="novalidate" enctype="multipart/form-data" action="">
							
							<fieldset>
								<section>
									<label class="label">Sở thích khách hàng</label>
									<label class="input">
										<i class="icon-append fa fa-edit"></i>
										<input type="text" name="txt_hobby" value="<?php echo $hobby?>">
									</label>	
								</section>
							</fieldset>
							
							<footer>								
								<?php if(isset($_GET['id'])) :?>
									<input type="hidden" name="txt_id" value="<?php echo $_GET['id'];?>" />
								<?php endif;?>
								
								<button type="button" name="reset" id="reset" class="btn btn-primary"><i class="fa fa-refresh" onclick="backPage()"></i> Reset</button>

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
					<h2>Sở thích khách hàng</h2>
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
										Sở thích
									</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql="SELECT * FROM tbl_sub_category where cat_id='".CAT_SOTHICH."'";
								$objMysql->Query($sql);								
								$stt = 1;

								while($r=$objMysql->Fetch_Assoc()) {
									$id = $r['id'];
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td><?php echo $r['name'];?></td>
									<td align="center">
			                     		<a title="Sửa" href="<?php echo ROOTHOST?>config_hobby/id/<?php echo $id;?>" class="btn btn-primary approve-schedule"><i class="fa fa-edit"></i></a>

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
		var $updateDocumentForm = $("#form_hobby").validate({
			
			// Rules for form validation
			rules : {
				txt_hobby: {
					required : true				
				}			

			},

			// Messages for form validation
		
			messages : {
				txt_hobby: {
					required : "Trường bắt buộc"	
				}
			},

			submitHandler : function(form) {
				$("#form_hobby").ajaxSubmit({
					success : function() {			
						smartInfoMsg('Thông báo', 'Thành công!', 2000);	
						setTimeout(function(){window.location="<?php echo ROOTHOST?>config_hobby.html"; }, 1000);
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
			window.location="<?php echo ROOTHOST?>config_hobby/del/" + id;
		})
	}

	function backPage() {
		window.location="<?php echo ROOTHOST?>config_hobby.html";
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
