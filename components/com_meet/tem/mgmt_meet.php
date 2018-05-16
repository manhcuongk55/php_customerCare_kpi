<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objMeet = new CLS_MEET;
$objCustomer = new CLS_CUSTOMER;

if(isset($_GET['del'])) {
	$objMeet->ID = $_GET['del'];
	$objMeet->Delete();
	echo "<script>window.location='".ROOTHOST."meet.html';</script>";
}

?>
<section class="" id="widget-grid">
	<div class="row">

		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Quản lý gặp gỡ khách hàng</h2>
					<div class="widget-toolbar">
						<button data-toggle="modal"  class="btn btn-danger" onclick="redirectAddNew();" style="padding:7px 8px!important; font-weight:bold;">
		                  <i class="fa fa-plus"></i>
		                  Thêm mới gặp gỡ
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
										Tên khách hàng
									</th>
									<th>
										<i class="fa fa-fw fa-edit"></i>
										Nội dung
									</th>
									<th>
										<i class="fa fa-fw fa-calendar"></i>
										Thời gian
									</th>
									<th>
										<i class="fa fa-fw fa-location"></i>
										Địa điểm
									</th>
									<th>
										<i class="fa fa-fw fa-suitcase"></i>
										Trạng thái
									</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$objMeet->getList(" and mem_id='".$GLOBALS['MEM_ID']."'", "order by id desc");
								$stt = 1;

								while($r=$objMeet->Fetch_Assoc()) {
									$id = $r['id'];
									$customerName = $objCustomer->getCustomerName($r['customer_id']);
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td><?php echo $customerName;?></td>
									<td><?php echo $r['content'];?></td>
									<td><?php echo date("d-m-Y H:i:s", strtotime($r['datetime']))?></td>
									<td><?php echo $r['address'];?></td>
									<td><?php 
									if ($r['status'] == STATUS_COMPLETE) {
										echo "Thành công";
									} else if ($r['status'] == STATUS_FAILED) {
										echo "Thất bại";
									} else if ($r['status'] == STATUS_CANCEL) {
										echo "Hủy bỏ";
									} else if ($r['status'] == STATUS_WAITING) {
										echo "Sắp diễn ra";
									} else {
										// TODO
									}
									?></td>
									<td align="center">
			                     		<a title="Sửa" href="<?php echo ROOTHOST?>meet/id/<?php echo $id;?>" class="btn btn-primary approve-schedule"><i class="fa fa-edit"></i></a>

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

	function deleteNote(id) {
		smartConfirm('Thông báo', 'Bạn có muốn xóa gặp gỡ này không?', function() {
			window.location="<?php echo ROOTHOST?>meet/del/" + id;
		})
	}

	function redirectAddNew() {
		window.location="<?php echo ROOTHOST?>meet/add.html";
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

