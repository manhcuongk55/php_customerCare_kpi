<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
if(isset($_GET['del'])) {
	$objmem->ID=$_GET['del'];
	$objmem->Delete();
	echo "<script>window.location='".ROOTHOST."mgmt_member.html';</script>";
}
?>
<section class="" id="widget-grid">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Danh sách người dùng hệ thống</h2>
					<div class="widget-toolbar">
						<button data-toggle="modal"  class="btn btn-danger" onclick="redirectLinkAddUser();" style="padding:7px 8px!important; font-weight:bold;">
		                  <i class="fa fa-plus"></i>
		                  Thêm mới người dùng
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
									<th width="20">No.</th>
									<th data-hide="phone">Tên đăng nhập</th>
									<th>Họ tên</th>
									<th data-hide="phone">Mã nhân viên</th>
									<th data-hide="phone">Email</th>
									<th data-hide="phone">Điện thoại</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$stt = 1;		
								$objmem->getList("", "LIMIT 1000");					
								while($r=$objmem->Fetch_Assoc()) {
									$id = $r['id'];
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td><?php echo $r['username'];?></td>
									<td><?php echo $r['fullname'];?></td>
									<td><?php echo $r['identify'];?></td>
									<td><?php echo $r['email'];?></td>
									<td><?php echo $r['phone'];?></td>

									<td align="center">
			                     		<a title="Sửa" href="<?php echo ROOTHOST?>mgmt_member/edit/<?php echo $id;?>" class="btn btn-primary approve-schedule"><i class="fa fa-edit"></i></a>
			                     		<a title="Xóa" href="#" class="btn btn-danger cancel-schedule" onclick="DeleteAccount(<?php echo "'".$id."'";?>)"><i class="fa fa-trash-o "></i></a>
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

		/* END BASIC */
		var $frmRegisUser = $("#form-register").validate({
			
			// Rules for form validation
			rules : {
				txt_fullname: {
					required : true				
				},
				txt_username : {
					required : true
				},
				txt_pass : {
					required : true
				},
				txt_apikey : {
					required : true
				},
				txt_secretkey : {
					required : true
				}

			},

			// Messages for form validation
		
			messages : {
				txt_fullname: {
					required : "Vui lòng nhập tên"				
				},
				txt_username : {
					required : "Tên đăng nhập"
				},
				txt_pass : {
					required : "Mật khẩu"
				},
				txt_apikey : {
					required : "Vui lòng nhập API KEY"
				},
				txt_secretkey : {
					required : "Vui lòng nhập Secret KEY"
				}
			},
		
			// submitHandler : function(form) {
			// 	$(form).ajaxSubmit({
			// 		success : function() {												
			// 			smartInfoMsg('Thông báo', 'Thành công!', 3000);	
			// 			setTimeout(function(){window.location="<?php echo ROOTHOST?>mgmt_member/"; }, 3000);
						
			// 		}
			// 	});
			// },

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

</script>


<script type="text/javascript">
	$('#txt_username').focusout(function(){
		checkUserExist();
	})
	
	function checkUserExist() {
		var username = $('#txt_username').val();
		$.post("<?php echo ROOTHOST;?>ajaxs/checkMemberExist.php",{username:username},function($rep){	
			var obj = jQuery.parseJSON($rep);		
			if(obj[0]['rep']=='yes') {	
				// user exist 
				$('#checkMemberExist').html('Tài khoản đã tồn tại!');
				return false;
			} else {
				$('#checkMemberExist').html('');
				return true;
			}
		})
	}

	function DeleteAccount(id) {
		smartConfirm('Thông báo', 'Bạn có muốn xóa tài khoản này không?', function() {
			window.location="<?php echo ROOTHOST?>mgmt_member/del/" + id;
		})
	}

	function redirectLinkAddUser() {
		window.location="<?php echo ROOTHOST?>mgmt_member/add.html";
	}
</script>

<?php 
unset($objmem);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.radio.gender {
		margin-right: 10px !important;
	}
</style>

