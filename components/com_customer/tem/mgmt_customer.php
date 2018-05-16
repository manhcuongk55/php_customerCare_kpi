<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objCustomer = new CLS_CUSTOMER;

if ($GLOBALS['PER'] == PER_USER) {
	$where = " and mem_id= ".$GLOBALS['MEM_ID']." order by id desc ";	
} else {
	$where = " order by cdate desc ";
}

$objCustomer->getList($where, "");

if(isset($_GET['del'])) {
	$objCustomer->ID=$_GET['del'];
	$objCustomer->Delete();
	echo "<script>window.location='".ROOTHOST."mgmt_customer.html';</script>";
}
	
?>
<section class="" id="widget-grid">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Danh sách khách hàng</h2>
					<div class="widget-toolbar">
						<button data-toggle="modal"  class="btn btn-danger" onclick="redirectLinkAddCustomer();" style="padding:7px 8px!important; font-weight:bold;">
		                  <i class="fa fa-plus"></i>
		                  Thêm mới khách hàng
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
									<th data-hide="" width="5%">No.</th>
									<th data-hide="" width="15%">
										<i class="fa fa-fw fa-user txt-color-blue"></i>Khách hàng
									</th>
									<th data-hide="" width="25%">
										<i class="fa fa-fw fa-user txt-color-blue"></i>Tên khách hàng
									</th>
									<th data-hide="phone" width="20%">
										<i class="fa fa-fw fa-calendar txt-color-blue"></i> Ngày sinh/thành lập
									</th>
									<th data-hide="phone" width="15%">
										<i class="fa fa-fw fa-phone txt-color-blue "></i> Số điện thoại
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
									<td><?php echo date("d-m-Y",strtotime($r['birthday']));?></td>
									<td><?php echo $r['phone'];?></td>
									
									<td align="center">
			                     		<a title="Sửa" href="<?php echo ROOTHOST?>mgmt_customer/edit/<?php echo $id;?>/type/<?php echo $r['type']?>" class="btn btn-primary approve-schedule"><i class="fa fa-edit"></i></a>

			                     		<a title="Xóa" href="#" onclick="deleteCustomer(<?php echo $id?>)" class="btn btn-danger cancel-schedule"><i class="fa fa-trash-o "></i></a>

			                     		<!-- <a title="Xem thông tin" href="<?php echo ROOTHOST?>schedule/userid/<?php echo $id;?>" class="btn btn-primary approve-schedule"><i class="fa fa-eye"></i></a> -->
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

<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_send_multi_sms" class="modal fade" style="display: none; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    ×
                </button>
                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
                	Gửi tin nhắn qua hệ thống eSMS
                </span></h4>
            </div>
            <div class="modal-body" style="padding-top:0px;">
            	<span><strong style="color: red;">Chú ý: Nội dung tin nhắn này sẽ được gửi tới một hoặc nhiều khách hàng</strong></span>
				<form class="smart-form" id="frm-send-sms" method="POST" novalidate="novalidate">
					<fieldset>
						<section>
							<label class="label">Nội dung gửi SMS</label>
							<label class="textarea">
								<i class="icon-append fa fa-check-square-o"></i>
								<textarea name="sms_content"  id="sms_content" placeholder="Vi du: Opavn xin thông báo: Chieu nay 2h chi co lich hen qua Trung tam dieu trị vet nam, chi nho den dung gio chi nhe."></textarea>
							</label>
						</section>
						<input type="hidden" name="schedule_id" value="" id="schedule_id" placeholder="">
					</fieldset>
					<footer>
						<a href="#" onclick="cancelSendSms()" class="btn btn-danger"><i class="fa fa-times-circle"></i>Hủy</a>

						<a href="#" class="btn btn-primary" onclick="sendMultipleSms(<?php echo $GLOBALS['MEM_ID'];?>)"><i class="fa fa-check"></i>Send Sms by eSMS</a>

						<!-- <a href="#" class="btn btn-primary" onclick="sendSMSUsb3G(<?php echo $GLOBALS['MEM_ID'];?>)"><i class="fa fa-check"></i>Send USB 3G</a> -->

					</footer>
				</form>		
            </div>
        </div>
    </div>
</div>
<!-- end widget grid -->

<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_import_list" class="modal fade" style="display: none; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    ×
                </button>
                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
                	Import danh sách khách hàng
                </span></h4>
            </div>
            <div class="modal-body" style="padding-top:0px;">
            	<span><strong style="color: red;">Chú ý: Bạn cần phải download file excel mẫu và nhập thông tin khách hàng theo các trường yêu cầu</strong>
            	<a href="<?php echo ROOTHOST;?>uploads/file_import.xlsx" target="_blank">Download file</a>
            	</span>
				<form class="smart-form" id="frm-import-data-user" method="POST" novalidate="novalidate" enctype="multipart/form-data">
					<fieldset>
						<section>
							<label class="label">File đính kèm</label>
							<label for="file" class="input input-file">
								<div class="button"><input type="file" multiple="multiple" name="files[]" onchange="this.parentNode.nextSibling.value = this.value">Browse</div><input type="text" placeholder="Chọn file từ máy tính của bạn..." readonly="">
							</label>
						</section>
						<input type="hidden" name="memId" value="<?php echo $GLOBALS['MEM_ID']?>" id="memId" placeholder="">
					</fieldset>
					<footer>
						<a href="#" onclick="cancelImport()" class="btn btn-danger"><i class="fa fa-times-circle"></i> Hủy</a>

						<a href="#" class="btn btn-primary" id="cmd_submit_import"><i class="fa fa-check"></i> Import </a>

					</footer>
				</form>		
            </div>
        </div>
    </div>
</div>
<!-- end widget grid -->

<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">	
	pageSetUp();
	
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

	function deleteCustomer(idCus) {
		smartConfirm('Thông báo', 'Bạn có chắc chắn xóa khách hàng này không?', function() {
			window.location="<?php echo ROOTHOST?>mgmt_customer/del/" + idCus;
		})
	}

	function redirectLinkAddCustomer() {
		window.location="<?php echo ROOTHOST?>mgmt_customer/add.html";
	}
</script>

<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.radio.gender {
		margin-right: 10px !important;
	}
</style>

<?php 
unset($objCustomer);
?>
