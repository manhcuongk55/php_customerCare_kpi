<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objCustomer = new CLS_CUSTOMER;
$objCat = new CLS_CATEGORY;
$objSubCat = new CLS_SUBCAT;
$objGroup = new CLS_GROUP;

if ($GLOBALS['PER'] == PER_USER) {
	$where = " and mem_id= ".$GLOBALS['MEM_ID']." order by id desc ";	
} else {
	$where = " order by cdate desc ";
}

$objCustomer->getList($where, "");
?>
<section class="" id="widget-grid">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Danh sách khách hàng</h2>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th data-hide="" width="5%">No.</th>
									<th data-hide="" width="25%">
										<i class="fa fa-fw fa-user txt-color-blue"></i>Khách hàng
									</th>
									<th data-hide="" width="35%">
										<i class="fa fa-fw fa-user txt-color-blue"></i>Tên khách hàng
									</th>
									<th width="15%">
										<i class="fa fa-fw fa-phone txt-color-blue"></i>
										Điện thoại
									</th>
									<th data-hide="" width="20%">Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$stt = 1;
								while($r=$objCustomer->Fetch_Assoc()) {
									$id = $r['id'];								
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td>
										<?php 
											if($r['type'] == 0) 
												echo "Cá nhân";
											elseif($r['type'] == 1) 
												echo "Doanh nghiệp";
											else echo "Tổ chức";
										?>
									</td>
									<td><?php echo $r['fullname'];?></td>
									<td><?php echo $r['phone'];?></td>
									<td align="center">
			                     		<a title="Xem thông tin" href="<?php echo ROOTHOST?>detail-cusid-<?php echo $id;?>-type-<?php echo $r['type']?>" class="btn btn-primary approve-schedule"><i class="fa fa-eye"></i> Chi tiết</a>
			                     	</td>
								</tr>
								<?php $stt++;} ?>
								
							</tbody>
							<input type="hidden" name="txtids" id="txtids" value="">
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

<!-- end widget grid -->

<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">	
	pageSetUp();
	$("#cbo_group").select2();
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

	// Load form valisation dependency 
	loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/jquery-form/jquery-form.min.js", function() {
		loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/bootstraptree/bootstrap-tree.min.js");
	});
	
	loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
				});
			});
		});
	});

	$("#cbo_group").change(function(){
		var group = $(this).val();
		$(".group_tree").css("display","none");
		$("#root_tree_group_"+group).css("display","block");
	})
</script>

<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.radio.gender {
		margin-right: 10px !important;
	}
	.tree li.root {
		padding-left: 15px;
	}
	.smart-form fieldset {
		padding:10px 15px 0px;
	}
	.tree.smart-form {
		height: 600px;
		overflow: scroll;
	}
</style>

<?php 
unset($objCustomer);
?>
