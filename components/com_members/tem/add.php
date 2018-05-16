<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objmysql=new CLS_MYSQL;

$username=$pass=$fullname=$phone=$email=$identify=$cbo_permistion=$gender=$birthday="";

if(isset($_POST['cmd_save'])) {
	$username=$objmem->Username=$_POST['txt_username'];
	$cbo_permistion=$objmem->Permistion=$_POST['cbo_permistion'];
	$fullname=$objmem->Fullname=$_POST['txt_fullname'];
	$phone=$objmem->Phone=$_POST['txt_phone'];
	$gender=$objmem->Gender=$_POST['opt_gender'];
	$email=$objmem->Email=$_POST['txt_email'];
	$identify=$objmem->Identify=$_POST['txt_identidy'];
	$birthday=$objmem->Birthday=date('Y-m-d', strtotime($_POST['txt_birthday']));

	if(isset($_POST['txt_id'])) {
		$objmem->ID=$_POST['txt_id'];
		$objmem->Update();
	} else {
		$objmem->Password=md5(sha1($_POST['txt_pass']));
		$objmem->Add_new();	
	}
	echo "<script>window.location='".ROOTHOST."mgmt_member.html';</script>";
}

if (isset($_GET['id'])) {
	$id=$_GET['id'];
	$sql="SELECT * FROM tbl_member_level WHERE id='$id'";
	$objmysql->Query($sql);
	if($objmysql->Num_rows()>0) {
		$rs=$objmysql->Fetch_Assoc();		
		$username=$rs['username'];
		$cbo_permistion=$rs['permistion'];
		$fullname=$rs['fullname'];
		$phone=$rs['phone'];
		$gender=$rs['gender'];
		$email=$rs['email'];
		$identify=$rs['identify'];
		$birthday=strtotime($rs['birthday']);
	}
}

?>
<section class="" id="widget-grid">
	<div class="row">
		
		<article class="col-sm-12 col-md-10 col-lg-10">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<?php if(isset($_GET['id'])) : ?>
						<h2>Chỉnh sửa thông tin người dùng</h2>
					<?php else : ?>
						<h2>Thêm mới người dùng</h2>
					<?php endif; ?>
				</header>

				<!-- widget div-->
				<div role="content">
					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<form class="smart-form" id="form-register" method="POST" novalidate="novalidate" enctype="multipart/form-data" action="">
							
							<fieldset>
								<div class="row">
									<section class="col col-4">
										<label class="label">Tên đăng nhập (<span class="req">*</span>)</label>
										<label class="input">
											<i class="icon-append fa fa-user"></i>
											<input type="text" name="txt_username" id="txt_username" value="<?php echo $username;?>">
										</label>	
										<span style="color:red" id="checkMemberExist" ></span>
									</section>
									<?php if (!isset($_GET['id'])) :?>	
									<section class="col col-4">
										<label class="label">Mật khẩu (<span class="req">*</span>)</label>
										<label class="input">
											<i class="icon-append fa fa-key"></i>
											<input type="password" name="txt_pass" id="txt_pass" value="<?php echo $pass;?>">
										</label>	
									</section>	
									<?php endif; ?>	
									<section class="col col-4">
										<label class="label">Phân quyền</label>
										<label class="select">
											<select name="cbo_permistion" id="cbo_permistion">
												<option value="1">Cấp quản lý</option>
												<option value="2" selected="true">Cấp người dùng</option>
											</select><i></i>
											<script type="text/javascript">
												cbo_Selected('cbo_permistion', <?php echo $cbo_permistion; ?>);
											</script>
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
										<label class="label">Họ tên (<span class="req">*</span>)</label>
										<label class="input">
											<i class="icon-append fa fa-user"></i>
											<input type="text" name="txt_fullname" id="txt_fullname" value="<?php echo $fullname;?>">
										</label>
									</section>
									<section class="col col-4">
										<label class="label">Số điện thoại (<span class="req">*</span>)</label>
										<label class="input">
											<i class="icon-append fa fa-phone"></i>
											<input type="text" name="txt_phone" id="txt_phone" value="<?php echo $phone;?>" placeholder="098x xxx xxx">
										</label>
									</section>
									<section class="col col-4">
										<label class="label">Giới tính</label>
										<div class="inline-group">
											<label class="radio gender">
												<input type="radio" name="opt_gender" value="0" <?php if($gender==0) echo "checked=\"true\"";?>>
												<i></i>Nam</label>
											<label class="radio">
												<input type="radio" name="opt_gender" value="1" <?php if($gender==1) echo "checked=\"true\"";?>>
												<i></i>Nữ</label>
										</div>
									</section>	
								</div>
								<div class="row">
									<section class="col col-4">
										<label class="label">Email (<span class="req">*</span>)</label>
										<label class="input"> 
											<i class="icon-append fa fa-envelope-o"></i>
												<input type="text" name="txt_email" value="<?php echo $email;?>" id="txt_email">
											</label>
									</section>
									<section class="col col-4">
										<label class="label">Mã nhân viên (<span class="req">*</span>)</label>
										<label class="input">
											<i class="icon-append fa fa-credit-card"></i>
											<input type="text" name="txt_identidy" id="txt_identidy" value="<?php echo $identify;?>" placeholder="">
										</label>								
									</section>							
									<section class="col col-4">
										<label class="label">Ngày/tháng/năm sinh</label>
										<label class="input"> 
											<i class="icon-append fa fa-calendar"></i>
												<input type="text" name="txt_birthday" value="<?php if (isset($_GET['id'])) { echo date('d-m-Y',$birthday);} ?>" id="txt_birthday" placeholder="Theo định dạng: DD-MM-YYYY">
											</label>
									</section>
								</div>

							</fieldset>
							
							<footer>
								<input type="hidden" name="cmd_save"/>
								<?php if(isset($_GET['id'])) :?>
									<input type="hidden" name="txt_id" value="<?php echo $_GET['id'];?>" />
								<?php endif;?>

								<button type="button" class="btn btn-primary" onclick="backPage()"><i class="fa fa-long-arrow-left "></i> Quay lại</button>

								<button type="submit" name="i_submit" id="i_submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php if(isset($_GET['id'])) echo "Cập nhật"; else echo "Thêm mới";?></button>
								
							</footer>
						</form>						
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
				txt_identidy : {
					required : true
				},
				txt_email : {
					required : true
				},
				cbo_permistion : {
					required : true
				},
				txt_phone: {
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
				txt_email : {
					required : "Vui lòng nhập email"
				},
				txt_identidy : {
					required : "Vui lòng nhập mã nhân viên"
				},
				cbo_permistion : {
					required : "Vui lòng chọn quyền"
				},
				txt_phone : {
					required : "Vui lòng nhập sđt"
				}
			},
		
			submitHandler : function(form) {
				$("#form-register").ajaxSubmit({
					success : function() {												
						smartInfoMsg('Thông báo', 'Thành công!', 3000);	
						setTimeout(function(){window.location="<?php echo ROOTHOST?>mgmt_member.html"; }, 1000);
						
					}
				});
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});

		// / START AND FINISH DATE
		$('#txt_birthday').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
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
		smartConfirm('Thông báo', 'Bạn có muốn xóa người dùng này không?', function() {
			window.location="<?php echo ROOTHOST?>mgmt_member/del/" + id;
		})
	}
	function backPage() {
		window.location="<?php echo ROOTHOST?>mgmt_member.html";
	}
</script>

<?php 
unset($objmem);
unset($objmysql);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.radio.gender {
		margin-right: 10px !important;
	}
	.req {
		color: red;
	}
</style>

