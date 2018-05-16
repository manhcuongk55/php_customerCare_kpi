<?php
$objmem=new CLS_MEMBERLEVEL;
?>
<!DOCTYPE html>
<html lang="en-us">	
	<head>
		<meta name="google" content="notranslate" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">		
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Viettel group</title>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/your_style.css">
		<?php include_once("includes/groupcss.php");?>		
		<script src="<?php echo ROOTHOST; ?>js/gfscript.js"></script> 

	</head>
	<body class="smart-style-6">
		<?php
		if(!$objmem->isLogin()) {	
			if(isset($_GET['viewtype']) && $_GET['viewtype']=='forgot')
				include_once("components/com_members/tem/forgot.php");
			else {
				include_once("components/com_members/tem/login.php");
			}
		}
			
		else {	
			$username=$objmem->getInfo('username');
			$fullname=$objmem->getInfo('fullname');
			$idUser=$objmem->getInfo('id');
			$linkAvatar=$objmem->getInfo('avatar');
			$GLOBALS['PER']=$objmem->getInfo('permistion');
			$GLOBALS['MEM_ID']=$objmem->getInfo('id');	
			$GLOBALS['FULLNAME']=$objmem->getInfo('fullname');
		?>

		<header id="header">
			<div id="logo-group">
				<span id="logo"> 
				<a href="<?php echo ROOTHOST;?>"><img data-hide="phone" src="<?php echo ROOTHOST ?>images/logo.png" alt="Logo"></a>
				</span>
			</div>
			<!-- #TOGGLE LAYOUT BUTTONS -->
			<!-- pulled right: nav area -->
			<div class="pull-right">
				
				<!-- collapse menu button -->
				<div id="hide-menus" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->
				
				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="<?php echo ROOTHOST;?>logout" title="Thoát" data-action="userLogout" data-logout-msg=""><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->

				<!-- search mobile button (this is hidden till mobile view port) -->
				<div id="search-mobile" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
				</div>
				<!-- end search mobile button -->
				
				<!-- #SEARCH -->
				<!-- input: search field -->
				<form action="#ajax/search.html" class="header-search pull-right">
					<input id="search-fld" type="text" name="param" placeholder="Tìm kiếm">
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
					<a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>
				</form>
				<!-- end input: search field -->

				<!-- fullscreen button -->
				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
				</div>
				<!-- end fullscreen button -->

			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->
		
		<!-- #NAVIGATION -->
		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS/SASS variables -->
		<aside id="left-panel">
			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as is --> 
					
					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
						<?php if($linkAvatar == "N/A" || $linkAvatar == '') :?>
							<img src="<?php echo ROOTHOST.THIS_TEM_PATH?>img/avatars/male.png" alt="me" class="online" /> 
						<?php else:?>
							<img src="<?php echo ROOTHOST.$linkAvatar?>" alt="me" class="online" /> 
						<?php endif;?>
						<span>
							<?php echo $fullname?> 
						</span>
						<i class="fa fa-angle-down" id="click_changepass"></i>						
					</a> 
					
				</span>
			</div>
			<div class="bl_changepass" style="display:none">
				<ul>
					<li>
						<a href="#" onclick="ShowDialogChangePass(<?php echo $idUser;?>)" class="cls_changepass">Đổi mật khẩu?</a>
					</li>
					<li>
						<a href="#" onclick="ShowDialogChangeAvatar(<?php echo $idUser;?>)" class="cls_change_avatar">Thay ảnh đại diện</a>
					</li>
					<li>
						<a href="<?php echo ROOTHOST;?>logout" title="Thoát" data-action="userLogout" data-logout-msg="" class="cls_changepass">Thoát</a> </span>
					</li>
				</ul>
				
			</div>
			<!-- end user info -->

			<!-- NAVIGATION : This navigation is also responsive

			To make this navigation dynamic please make sure to link the node
			(the reference to the nav > ul) after page load. Or the navigation
			will not initialize.
			-->
				
				<nav>
					<ul>
							<li class="<?php if($_GET['com']=='customer' ||$_GET['viewtype'] == 'mgmt_customer') echo 'active'?>">
								<a href="<?php echo ROOTHOST;?>mgmt_customer.html" aria-expanded="false" >
									<i class="fa fa-lg fa-fw fa-group"></i> 
									<span class="menu-item-parent">Quản lý khách hàng</span>
								</a>
							</li>
							<li class="<?php if($_GET['com'] == 'meet') echo 'active'?>">
								<a href="<?php echo ROOTHOST;?>meet.html" aria-expanded="false" >
									<i class="fa fa-lg fa-fw fa-calendar"></i> 
									<span class="menu-item-parent">Quản lý gặp gỡ khách hàng</span>
								</a>
							</li>
							 <li class="<?php if($_GET['com'] == 'note') echo 'active'?>">
								<a href="<?php echo ROOTHOST;?>note.html" aria-expanded="false" >
									<i class="fa fa-lg fa-fw fa-edit"></i> 
									<span class="menu-item-parent">Quản lý ghi chú nhanh</span>
								</a>
							</li>
							<li class="<?php if ($_GET['viewtype']=='mgmt_export') echo 'active'?>">
								<a href="<?php echo ROOTHOST;?>mgmt_export.html" aria-expanded="false">
									<i class="fa fa-lg fa-fw fa-code"></i> 
									<span class="menu-item-parent">Yêu cầu xuất dữ liệu</span>
								</a>
							</li>
							<li class="<?php if($_GET['com'] == 'members' && $_GET['viewtype']!='dashboard	') echo 'active'?>">
								<a href="<?php echo ROOTHOST;?>mgmt_member.html" aria-expanded="false">
									<i class="fa fa-lg fa-fw fa-group"></i> 
									<span class="menu-item-parent">Quản lý người dùng</span>
								</a>
							</li>
							
							<li class="open">
								<a href="#" aria-expanded="false">
									<i class="fa fa-lg fa-fw fa-cogs"></i> 
									<span class="menu-item-parent">Cấu hình dữ liệu</span>
								</a>
								<ul style="display: block;">
									<li class="<?php if($_GET['viewtype'] == "mgmt_config" || $_GET['viewtype'] == "add_config") echo 'active'?>">
										<a href="<?php echo ROOTHOST;?>mgmt_config.html"> <i class="fa fa-fw fa-cog"></i> Thêm mới trường dữ liệu</a>
									</li>

									<li class="<?php if($_GET['viewtype'] =='config_relation') echo 'active'?>">
										<a href="<?php echo ROOTHOST;?>config_relation.html"> <i class="fa fa-fw fa-child"></i> Thêm quan hệ gia đình</a>
									</li>

									<li class="<?php if($_GET['viewtype'] =='config_hobby') echo 'active'?>">
										<a href="<?php echo ROOTHOST;?>config_hobby.html"> <i class="fa fa-fw fa-life-bouy"></i> Thêm sở thích</a>
									</li>

									<li class="<?php if($_GET['viewtype']=='config_display') echo 'active'?>">
										<a href="<?php echo ROOTHOST;?>config_display.html"> <i class="fa fa-fw fa-cube"></i> Cấu hình hiển thị</a>
									</li>
								</ul>
							</li>

							<li class="open">
								<a href="#"><i class="fa fa-lg fa-fw fa-file-excel-o"></i> <span class="menu-item-parent">Báo cáo</span></a>
								<ul style="display: block;">
									<li class=" <?php if($_GET['viewtype'] == 'report_customer') echo 'active'?>">
										<a href="<?php echo ROOTHOST;?>report_customer.html"> <i class="fa fa-fw fa-user"></i> Thông tin khách hàng</a>
									</li>
								</ul>
							</li>
					</ul>
				</nav>
				
			
			<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

		</aside>
		<!-- END NAVIGATION -->
		
		<!-- #MAIN PANEL -->
		<div id="main" role="main">
			<!-- RIBBON -->
			<div id="ribbon" style="display:none;">


				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>Trang chủ</li>
					<li>Quản lý bán hàng</li>
				</ol>
				<!-- end breadcrumb -->
			</div>
			<!-- END RIBBON -->

			<!-- #MAIN CONTENT -->
			<div id="content">
				<?php 
					$this->loadComponent();
				?>
			</div>
			
			<!-- END #MAIN CONTENT -->

		</div>
		<!-- END #MAIN PANEL -->

		<!-- #PAGE FOOTER -->
		<div class="page-footer" style="padding: 9px 13px 0; padding-left:233px; height: 30px;">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white">Copyright © 2018 by Trung tâm Kinh doanh sản phẩm công nghệ cao Viettel</span>
				</div>
			
				<!-- end col -->
			</div>
			<!-- end row -->
		</div>
		<!-- END FOOTER -->

		<?php } ?>

		<!-- form return task -->
		<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_change_pass" class="modal fade" style="display: none; ">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
		                    ×
		                </button>
		                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
		                	Thay đổi mật khẩu
		                </span></h4>
		            </div>
		            <div class="modal-body" style="padding-top:0px;">
						<form class="smart-form" id="form_change_pass" method="POST" novalidate="novalidate" enctype="multipart/form-data">
							<fieldset>
								<section>
									<label class="label">Nhập mật khẩu cũ</label>
									<label class="input">
										<i class="icon-append fa fa-lock"></i>
										<input placeholder="Mật khẩu cũ" type="password" name="old_pass"  id="old_pass" value="">
									</label>
								</section>
								<section>
									<label class="label">Nhập mật khẩu mới</label>
									<label class="input">
										<i class="icon-append fa fa-lock"></i>
										<input placeholder="Mật khẩu mới" type="password" name="new_pass"  id="new_pass" value="">
									</label>
								</section>
								<section>
									<label class="label">Nhập lại mật khẩu</label>
									<label class="input">
										<i class="icon-append fa fa-lock"></i>
										<input placeholder="Mật khẩu mới" type="password" name="re_new_pass"  id="re_new_pass" value="">
									</label>
								</section>

								<input type="hidden" name="id_user_change" value="" id="id_user_change" placeholder="">
							</fieldset>
							
							<footer>
								
								<a href="#" onclick="CancelChangePass()" class="btn btn-danger"><i class="fa fa-mail-reply"></i>Hủy</a>
								<a href="#" onclick="DoChangePass()" class="btn btn-primary"><i class="fa fa-check"></i>Lưu </a>
				            				
							</footer>
							
						</form>		
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Popup change avatar -->
		<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_change_avatar" class="modal fade" style="display: none; ">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
		                    ×
		                </button>
		                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
		                	Thay đổi ảnh đại diện
		                </span></h4>
		            </div>
		            <div class="modal-body" style="padding-top:0px;">
						<form class="smart-form" id="form_change_avatar" method="POST" novalidate="novalidate" enctype="multipart/form-data">
							<fieldset>
								<section>
									<label class="label">File đính kèm</label>
									<label for="file" class="input input-file">
										<div class="button"><input type="file" multiple="multiple" name="files[]" onchange="this.parentNode.nextSibling.value = this.value">Browse</div><input type="text" placeholder="Chọn file từ máy tính của bạn..." readonly="">
									</label>
								</section>
								<input type="hidden" name="id_user_change_avatar" value="" id="id_user_change_avatar" placeholder="">
							</fieldset>
							<footer>
								<a href="#" onclick="CancelChangeAvatar()" class="btn btn-danger"><i class="fa fa-mail-reply"></i>Hủy</a>
								<a href="#" class="btn btn-primary" id="cmd_submit_upload_avatar"><i class="fa fa-check"></i>Lưu </a>
							</footer>
						</form>		
		            </div>
		        </div>
		    </div>
		</div>
		<!-- end change avatảr -->

		<!--=========================Modal Alert========================= -->
		<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="modal_alert" class="modal fade" style="display: none;">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
		                    ×
		                </button>
		                <h4 id="myModalLabel" class="modal-title">
		                  <span id="modal_alert_icon"><i class="fa fa-warning"></i> </span>
		                  <span id="modal_alert_title"> </span>
		                </h4>
		            </div>
		            <div class="modal-body">
		              <p id="modal_alert_msg">

		            	</p>
		            </div>
		            <div class="modal-footer">

		                  <button type="button" class="btn btn-primary" id="alert_ok_btn"><i class="fa fa-check lhtml" langcode="cfr_yes">Đồng ý </i></button>
		                  <button type="button" class="btn btn-default" id="alert_cancel_btn"><i class="fa fa-times lhtml" langcode="cfr_no">Hủy bỏ</i></button>
		            </div>
		          </div>


		        </div>
		    </div>
		</div>
		<div class="div_loading">
			<img src="<?php echo ROOTHOST;?>images/loading.gif" class="img_loading" style="display:none;">
		</div>
	</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		$( "#click_changepass" ).click(function() {
		  $( ".bl_changepass" ).toggle( "slow", function() {});
		});
	})

	function ShowDialogChangePass(id) {
		$("#dialog_change_pass").modal("show");
		$("#id_user_change").val(id);
	}

	function ShowDialogChangeAvatar(id) {
		$("#dialog_change_avatar").modal("show");
		$("#id_user_change_avatar").val(id);
	}

	function CancelChangePass() {
		$("#dialog_change_pass").modal("hide");
		$( ".bl_changepass" ).toggle( "slow", function() {});
	}

	function CancelImport() {
		$("#dialog_import_staff").modal("hide");		
	}

	function CancelChangeAvatar() {
		$("#dialog_change_avatar").modal("hide");
		$( ".bl_changepass" ).toggle( "slow", function() {});
	}

	function ShowDialogViewAvatar(link) {
		$("#dialog_view_avatar").modal("show");
		$("#view_avatar").attr('src', link);
	}

	function DoChangePass() {
		if($('#new_pass').val() == '' && $("#re_new_pass").val() == '' && $("#old_pass").val() == '') {
			smartErrorMsg('Thông báo', 'Bạn chưa nhập thông tin đổi mật khẩu', 3000);
			return;
		}

		if($('#new_pass').val() != $("#re_new_pass").val()) {
			smartErrorMsg('Thông báo', 'Mật khẩu mới chưa khớp nhau', 3000);
			return;
		}

		$.post("ajaxs/changepass.php", $("#form_change_pass").serialize(), function(data) {
			if(data == 'success') {
				smartInfoMsg('Thông báo', 'Thay đổi mật khẩu thành công!', 5000);
				$("#dialog_change_pass").modal("hide");
				 $( ".bl_changepass" ).toggle( "slow", function() {});
				 window.location.href="<?php echo ROOTHOST;?>logout";

			} else if (data == 'error_old_pass') {
				smartErrorMsg('Thông báo', 'Nhập sai mật khẩu cũ', 3000);
			}
			
		})
	}

	function CancelBuy() {
		$("#dialog_view_info").modal("hide");
	}

	function SaveBuyProduct() {				
		$.post("ajaxs/save_buy_product.php",$("#form-buy_product").serialize(), function(data) {
			if(data == 'success') {
				smartInfoMsg('Thông báo', 'Lưu thông tin thành công!', 5000);
				$("#dialog_view_info").modal("hide");
				location.reload();

			} else if (data == 'error') {
				smartErrorMsg('Thông báo', 'Không thành công', 3000);
			}
			
		})
	}

	function DoChangeAvatar() {
		smartInfoMsg('Thông báo', 'Thay ảnh đại diện thành công!', 5000);
		setTimeout(function(){
			$("#form_change_avatar").submit();
		}, 1500);
		$("#dialog_change_avatar").modal("hide");
	}

	$(document).ready(function (e) {
		$("#form_change_avatar").on('submit',function(e) {
			e.preventDefault();
			$.ajax({
				url: "<?php echo ROOTHOST;?>ajaxs/upload_avatar.php", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data){
					// alert(data);
					if(data=='success'){
						$("#dialog_change_avatar").modal("hide");
						smartInfoMsg('Thông báo', 'Thay ảnh đại diện thành công!', 5000);
						setTimeout(function() {
							window.location.href="<?php echo ROOTHOST;?>logout";
						}, 1000);
						
					}else{						
						smartErrorMsg('Thông báo', 'Thay ảnh không thành công!', 5000);
					}
				}
			});
		});
		$('#cmd_submit_upload_avatar').click(function(){
			$("#form_change_avatar").submit();
			$(this).hide();
		})
	});
</script>
<?php
unset($objmem);
?>
<style type="text/css">#demo-setting {
	display: none !important;
}
</style>

