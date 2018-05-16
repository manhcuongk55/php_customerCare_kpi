<?php
defined('ISHOME') or die("Can't acess this page, please come back!");
$str=$user=$pas='';
require_once(LIB_PATH."cls.member_level.php");
$objmem = new CLS_MEMBERLEVEL;

// echo THIS_TEM_PATH;die;

if(isset($_POST['txt_user'])){
	$user=addslashes($_POST['txt_user']);
	$pas=addslashes($_POST['txt_pas']);
	$login = $objmem->LOGIN($user,$pas);

	if($login==false) {	
		$str = 'Login information incorrect';
	} else {
		 //setcookie("CK_USERNAME", $user, time()+60*60*24*30);
		 //setcookie("CK_PASSWORD", $pas, time()+60*60*24*30);
	}
}
if($objmem->isLogin()==false) {
?>

<html lang="en-us" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title>Đăng nhập</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/smartadmin-rtl.min.css"> 

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>css/demo.min.css">

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/favicon/favicon.ico" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700"> -->

		<link rel="apple-touch-icon" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/splash/touch-icon-ipad-retina.png">
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="<?php echo ROOTHOST.THIS_TEM_PATH; ?>img/splash/iphone.png" media="screen and (max-device-width: 320px)">

	</head>
	
	<body class="animated fadeInDown">

		<header id="header">
			<div class="row">
				<article col-sm-12 col-md-12 col-lg-6>
					<div id="logo-group">
						<span id="logo"> <img class="login" src="<?php echo ROOTHOST?>images/logo.png" alt="Logo" > </span>
					</div>
				</article>
			</div>
			

		</header>

		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-4 hidden-xs hidden-sm">
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
						<div class="well no-padding">
							<form action="" id="login-form" class="smart-form client-form" method='POST' id="frmlogin" name="frmlogin" action='' autocomplete='off'>
								<header>
									<i class="fa fa-sign-in "></i> Đăng nhập vào hệ thống
								</header>

								<fieldset>
									
									<section>
										<label class="label">Tên đăng nhập</label>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input type="text" name="txt_user" value="administrator">
											<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Làm ơn nhập tên đăng nhập !</b></label>
									</section>

									<section>
										<label class="label">Mật khẩu</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="txt_pas" value="123456a@">
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i>Nhập mật khẩu</b> </label>
									</section>

									<section>
										<label class="checkbox">
											<input type="checkbox" name="remember" checked="">
											<i></i>Giữ đăng nhập</label>
									</section>
								</fieldset>
								<footer>
								
									<button type="submit" class="btn btn-primary">
										Đăng nhập
								    </button>
								</footer>
							</form>

						</div>
						
					</div>
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-4 hidden-xs hidden-sm">
					</div>
				</div>
			</div>

		</div>

		<!--================================================== -->	

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script src="<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/pace/pace.min.js"></script>

	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	    <!-- // <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
		<script> if (!window.jQuery) { document.write('<script src="<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/libs/jquery-2.1.1.min.js"><\/script>');} </script>

	    <!-- // <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> -->
		<script> if (!window.jQuery.ui) { document.write('<script src="<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

		<!-- BOOTSTRAP JS -->		
		<script src="<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/bootstrap/bootstrap.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/jquery-validate/jquery.validate.min.js"></script>
		
		<!-- JQUERY MASKED INPUT -->
		<script src="<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		
		<!--[if IE 8]>
			
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
			
		<![endif]-->

		<!-- MAIN APP JS FILE -->
		<script src="<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/app.min.js"></script>

		<script type="text/javascript">
			runAllForms();

			$(function() {
				// Validation
				$("#login-form").validate({
					// Rules for form validation
					rules : {
						txt_user : {
							required : true
						},
						txt_pas : {
							required : true,
							minlength : 6,
							maxlength : 20
						}
					},

					// Messages for form validation
					messages : {
						txt_user : {
							required : 'Nhập tên đăng nhập'
						},
						txt_pas : {
							required : ' Nhập mật khẩu'
						}
					},

					// Do not change code below
					errorPlacement : function(error, element) {
						error.insertAfter(element.parent());
					}
				});
			});
		</script>

		

	</body>
</html>

<?php } else { ?>	
<script>window.location.href='<?php echo ROOTHOST;?>';</script>
<?php } ?>

