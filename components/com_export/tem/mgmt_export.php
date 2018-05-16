<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objExport = new CLS_EXPORT;
$objCustomer = new CLS_CUSTOMER;
$objCat = new CLS_CATEGORY;
$strCondition = "";

if(isset($_GET['id_approved'])) {
	$objExport->ID = $_GET['id_approved'];
	$objExport->Status = 1;
	$objExport->Update();
	echo "<script>window.location='".ROOTHOST."mgmt_export.html';</script>";
}

if ($GLOBALS['PER'] == PER_USER) {
	$strCondition = "AND `mem_id`='".$GLOBALS['MEM_ID']."'";
}

?>
<section class="" id="widget-grid">
	<div class="row">

		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Quản lý yêu cầu xuất dữ liệu khách hàng</h2>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th width="3%">No.</th>
									<th width="15%">Nhân viên</th>
									<th width="15%">Khách hàng</th>
									<th width="22%">Thông tin xuất</th>
									<th width="15%">Thời gian</th>
									<th width="11%">Trạng thái</th>
									<th width="19%">Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$objExport->getList($strCondition, "order by id desc");
								$stt = 1;

								while($r=$objExport->Fetch_Assoc()) {
									$id = $r['id'];
									$status = $r['status'];  // status =1 phe dyet

									$objTmpCus = new CLS_CUSTOMER;
									$cusType = $objTmpCus->getCusTypeById($r['customer_id']);
									$per = $objCustomer->getPermistionMem($r['mem_id']);
									$customerName = $objCustomer->getCustomerName($r['customer_id']);
									$memberName = $objCustomer->getMemName($r['mem_id']);
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td><?php echo $memberName;?></td>
									<td><?php echo $customerName;?></td>
									<td>
										<ul style="padding: 0px;margin: 0px 0px 0px 10px">
											<?php
											$strID = str_replace(",", "','", $r['cat_list']);
											$objCat->getList(" and id in ('$strID')", "");
											while ($rs=$objCat->Fetch_Assoc()) {
												echo "<li>".$rs['name']."</li>";
											}
											?>
										</ul>
									</td>
									<td><?php echo date("d-m-Y H:i:s", strtotime($r['cdate']))?></td>
									<td><?php 
									if ($r['status'] == '0') {
										echo "Chờ phê duyệt";
									} else if ($r['status'] == '1') {
										echo "Đã phê duyệt";
									} else if ($r['status'] == '-1') {
										echo "<span style=\"color:red\">Từ chối"."<br/> Lý do: ".$r['note']."</span>";
									} else {
										// TODO
									}
									?></td>
									<td align="center">
										<?php
										if ($GLOBALS['PER'] == PER_SUPPERVISOR && $status == '0') { ?>
										
			                     		<a title="Phê duyệt" href="#" onclick="popupApproved(<?php echo "'".$id."'";?>, '<?php echo $r['mem_id'];?>', '<?php echo $r['customer_id'];?>')" class="btn btn-primary approve-schedule">Phê duyệt</a>

			                     		<a title="Từ chối" href="#" class="btn btn-danger cancel-schedule" onclick="popupReject(<?php echo "'".$id."'";?>,'<?php echo $r['mem_id'];?>', '<?php echo $r['customer_id'];?>')">Từ chối</a>
			                     		<?php }

			                     		elseif ($status != '-1' && $status != '0') { ?>
			                     			
			                     			<a title="Xuất PDF" href="#" class="btn btn-danger cancel-schedule" onclick="exportPdf(<?php echo "'".$r['customer_id']."'";?>,'<?php echo $cusType?>')">Xuất PDF
			                     			</a>

			                     		<?php } ?>

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
<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_reject_required" class="modal fade" style="display: none; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    ×
                </button>
                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
                	Từ chối yêu cầu
                </span></h4>
            </div>
            <div class="modal-body" style="padding-top:0px;">
				<form class="smart-form" id="form_reject_required" method="POST" novalidate="novalidate" enctype="multipart/form-data">
					<fieldset>
						<section>
							<label class="label">Lý do <span style="color: red;">(*)</span></label>
							<label class="input">
								<i class="icon-append fa fa-pencil"></i>
								<input placeholder="" type="text" name="content_reject"  id="content_reject" value="">
							</label>
						</section>
						<input type="hidden" name="id_export_pdf" value="" id="id_export_pdf" placeholder="">
						<input type="hidden" name="mem_id_reject" value="" id="mem_id_reject" placeholder="">
						<input type="hidden" name="cus_id_reject" value="" id="cus_id_reject" placeholder="">
					</fieldset>
					<footer>						
						<a href="#" class="btn btn-primary" onclick="approvedReject()" id="cmd_submit_reject"><i class="fa fa-check"></i>OK</a>
					</footer>
				</form>		
            </div>
        </div>
    </div>
</div>

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

	function popupApproved(id, mem_id, cus_id) {
		smartConfirm('Thông báo', 'Bạn có chắc chắn phê duyệt yêu cầu này không?', function() {
			// send notify
			$.post("<?php echo ROOTHOST?>api/push_notification.php", {type_notify: 1, mem_id: mem_id, cus_id: cus_id}, function() {
			})
			window.location="<?php echo ROOTHOST?>mgmt_export_approved.html"+id;
		})
	}
	function popupReject(id, mem_id, cus_id) {
		$("#dialog_reject_required").modal("show");
		$("#id_export_pdf").val(id);
		$("#mem_id_reject").val(mem_id);
		$("#cus_id_reject").val(cus_id);
	}
	
	function approvedReject() {
		var mem_id = $("#mem_id_reject").val();
		var cus_id = $("#cus_id_reject").val();

		$("#cus_id_reject").val(cus_id);

		if($('#content_reject').val() == '') {
			smartErrorMsg('Thông báo', 'Bạn chưa nêu lý do từ chối!', 3000);
			return;
		}
		$.post("ajaxs/rejectExport.php", $("#form_reject_required").serialize(), function(data) {
			if(data == 'success') {
				smartInfoMsg('Thông báo', 'Từ chối yêu cầu thành công!', 5000);
				$("#dialog_reject_required").modal("hide");
				
			} else if (data == 'error') {
				smartErrorMsg('Thông báo', 'Từ chối chưa thành công', 3000);
			}
			
		})

		$.post("<?php echo ROOTHOST?>api/push_notification.php", {type_notify: 2, mem_id: mem_id, cus_id: cus_id}, function() {
			setTimeout(function(){
				window.location = "<?php echo  ROOTHOST?>mgmt_export.html";
			}, 3000)
		})


	}
	function exportPdf(id, cus_type) {
		var URL = "<?php echo ROOTHOST?>api/exportPdf.php?export_id="+id+"&type="+cus_type;	
		window.location=URL;
	}

</script>

<?php 
unset($objCustomer);
unset($objExport);
unset($objCat);
?>

