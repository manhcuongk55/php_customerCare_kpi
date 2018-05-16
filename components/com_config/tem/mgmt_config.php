<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");

if(isset($_GET['del'])) {
	$objFieldInfo->ID = $_GET['del'];
	$objFieldInfo->changeStatus();
	echo "<script>window.location='".ROOTHOST."mgmt_config.html';</script>";
}

?>
<section class="" id="widget-grid">
	<div class="row">

		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Quản lý cấu hình</h2>
					<div class="widget-toolbar">
						<button data-toggle="modal"  class="btn btn-danger" onclick="redirectAddNew();" style="padding:7px 8px!important; font-weight:bold;">
		                  <i class="fa fa-plus"></i>
		                  Thêm mới cấu hình
		                 </button>
	                 </div>
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
										<i class="fa fa-fw fa-user"></i>
										Tên
									</th>
									<th>
										<i class="fa fa-fw fa-edit"></i>
										Alias
									</th>
									<th>
										<i class="fa fa-fw fa-calendar"></i>
										Data type
									</th>
									<th>
										<i class="fa fa-fw fa-location"></i>
										Category
									</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$objFieldInfo->getList(" and isactive='1'", "");
								$stt = 1;
								$objSubCat = new CLS_SUBCAT;
								while($r=$objFieldInfo->Fetch_Assoc()) {
									$id = $r['id'];
									$catName = $objSubCat->getCateName($r['sub_cat_id']);
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td><?php echo $r['name'];?></td>
									<td><?php echo $r['alias'];?></td>
									<td><?php echo $r['data_type'];?></td>
									<td><?php echo $catName;?></td>
									
									<td align="center">
			                     		<!-- <a title="Sửa" href="<?php echo ROOTHOST?>meet/id/<?php echo $id;?>" class="btn btn-primary approve-schedule"><i class="fa fa-edit"></i></a> -->

			                     		<a title="Xóa" href="#" class="btn btn-danger cancel-schedule" onclick="deleteConfig(<?php echo "'".$id."'";?>)"><i class="fa fa-trash-o "></i></a>

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

	function deleteConfig(id) {
		smartConfirm('Thông báo', 'Bạn có muốn xóa cấu hình này không?', function() {
			window.location="<?php echo ROOTHOST?>mgmt_config/del/" + id;
		})
	}

	function redirectAddNew() {
		window.location="<?php echo ROOTHOST?>mgmt_config/add.html";
	}

</script>

<?php 
unset($objMeet);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.error {color: red;}
</style>

