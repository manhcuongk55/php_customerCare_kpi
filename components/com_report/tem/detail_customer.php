<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objCustomer = new CLS_CUSTOMER;
$objCustomerDetail = new CLS_CUSTOMER_DETAIL;
$objSubCat = new CLS_SUBCAT;
$objGroup = new CLS_GROUP;
$objCat =  new CLS_CATEGORY;
$objFieldInfo = new CLS_FIELD_INFOMATION;
$objRelation = new CLS_RELATIONSHIP;

$cusId = $type = "";
$memId = $GLOBALS['MEM_ID'];

if (isset($_GET['cusid'])) {$cusId = $_GET['cusid'];}
?>
<section class="" id="widget-grid">
	<div class="row">
		<article class="col-sm-12 col-md-4 col-lg-4">
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Thông tin</h2>
					<div class="widget-toolbar">
						<button data-toggle="modal"  class="btn btn-danger" onclick="exportHtmlToPdf('<?php echo $memId;?>');" style="padding:7px 8px!important; font-weight:bold;">
		                  <i class="fa fa-file-excel-o"></i>
		                  Gửi yêu cầu xuất dữ liệu
		                 </button>
	                 </div>
				</header>
				<div role="content" style="display: block;">
					<!-- widget content -->
					<div class="widget-body no-padding">
						<div class="tree smart-form">
							<form class="smart-form" id="form_choose_condition_export" method="POST" action="">
							<fieldset>
								<ul role="tree" class="group_tree"> 
								<li class="parent_li root" role="treeitem">
									<span title="Root" class="root a_root">
										<i class="fa fa-group "></i>
										<?php echo $objGroup->getGroupName($_GET['type']); ?>	
									</span>
									<ul>
										<?php
										$objCat->getCategoryByGroup($_GET['type']);
										while ($rs=$objCat->Fetch_Assoc()) { ?>
											<li style="display:block">
												<span class="items_user_tree"> 
													<!-- <i class="fa fa-lg fa-plus icon-minus-sign"></i> -->
													<label class="checkbox inline-block" style="display:inline-block">
														<input type="checkbox" name="checkbox-category[]" value="<?php echo $rs['id']?>" class="checkbox-category">
														<i></i><?php echo $rs['name']?>
													</label> 
												</span>
												<!-- <?php
													$objSubCat->getSubCategory($rs['id']);
													if ($objSubCat->Num_rows()>0) :?>
														<ul ole="group">
															<?php
															while ($r=$objSubCat->Fetch_Assoc()) {?>
																<li style="display:block">
																<span class="items_user_tree"> 
																<label class="checkbox inline-block">
																	<input type="checkbox" name="checkbox-inline-sub-category[]" value="">
																	<i></i><?php echo $r['name']?>
																</label> 
																</span>
																</li>
															<?php }
															?>
														</ul>
													<?php endif;
												?> -->
											</li>	
										<?php }
										?>
									</ul>
								</li>
								</ul>
								<input type="hidden" name="txt_cus_id" value="<?php echo $_GET['cusid']?>">
								<input type="hidden" name="txt_mem_id" value="<?php echo $GLOBALS['MEM_ID']?>">
							</fieldset>
							</form>
						</div>

					</div>
					<!-- end widget content -->
					
				</div>
			</div>
			
		</article>
		<article class="col-sm-12 col-md-8 col-lg-8">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Thông tin chi tiết khách hàng</h2>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding" style="overflow: hidden;margin: 0px -13px;">
						<?php
						if($_GET['type']==GROUP_CANHAN) {
							include ('detail_canhan.php');
						} else if ($_GET['type']==GROUP_DOANHNGHIEP) {
							include ('detail_doanhnghiep.php');
						} else {
							include ('detail_tochuc.php');
						}
						?>
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

	$("body").addClass('minified');

	function exportHtmlToPdf(mem_id) {
		$.post("<?php echo ROOTHOST?>ajaxs/exportPdf.php",  $("#form_choose_condition_export").serialize(), function(response) {			
			if(response == 'sucess') {
				smartInfoMsg('Thông báo', 'Gửi yêu cầu xuất dữ liệu thành công!', 3000);	
			} else if (response == 'error') {
				smartErrorMsg('Thông báo', 'Bạn chưa chọn thông tin xuất dữ liệu!', 3000);	
			}
			
		});
		// send notify
		$.post("<?php echo ROOTHOST?>api/push_notification.php", {type_notify: 0, mem_id: mem_id}, function() {
			setTimeout(function(){
				window.location = "<?php echo  ROOTHOST?>report_customer.html";
			}, 3000)
		})
		
	}
</script>
<?php 
unset($objCustomer);
?>
