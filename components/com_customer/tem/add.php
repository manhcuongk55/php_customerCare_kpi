<?php
include_once("includes/groupjs.php");
require_once("libs/cls.customer.detail.php");

$objFieldInfo = new CLS_FIELD_INFOMATION;
$objCustomerDetail = new CLS_CUSTOMER_DETAIL;
$arrayData = array();
if (isset($_GET['id'])) {
	$objCustomerDetail->getList(" and customer_id='".$_GET['id']."'", "");
	while ($rs=$objCustomerDetail->Fetch_Assoc()) {
		array_push($arrayData, $rs);
	}
}
$type="-1";

?>
<section id="widget-grid" class="">
	<div class="row">

		<!-- <h2 class="row-seperator-header"><i class="fa fa-plus"></i> Thêm mới khách hàng </h2> -->

		<!-- NEW WIDGET START -->
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget"  id="wid-id-7" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				
				<header>
					<ul class="nav nav-tabs pull-left in">
						
						<?php if(isset($_GET['id'])) :?>
							<input type="hidden" name="trigger-tab" id="trigger-tab" value="<?php echo $_GET['type']?>"
							>
						<?php $type=$_GET['type']; endif;?>

						<li class="active" style="<?php if($type!='0' && $type!='-1') echo'display:none;';?>">
							<a data-toggle="tab" href="#hr1" attr_value="0"> <i class="fa fa-lg fa-user"></i> <span class="hidden-mobile hidden-tablet"> Khách hàng cá nhân </span> </a>
						</li>
						<li style="<?php if($type!='1' && $type!='-1') echo'display:none;';?>">
							<a data-toggle="tab" href="#hr2" id="tab_doanhnghiep" attr_value="1"> <i class="fa fa-lg fa-bank"></i> <span class="hidden-mobile hidden-tablet"> Khách hàng doanh nghiệp</span> </a>
						</li>
						<li style="<?php if($type!='2' && $type!='-1') echo'display:none;';?>">
							<a data-toggle="tab" href="#hr3" id="tab_tochuc" attr_value="2"> <i class="fa fa-lg fa-bank"></i> <span class="hidden-mobile hidden-tablet"> Khách hàng tổ chức</span> </a>
						</li>
					

					</ul>
				</header>

				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
					</div>
					<!-- end widget edit box -->
					<!-- widget content -->
					<div class="widget-body">
						<div class="tab-content">

							<!-- Khách hàng cá nhân -->
							<div class="tab-pane active" id="hr1">
								<?php include('canhan/khachhangcanhan.php');?>
							</div>

							<!-- kết thúc Khách hàng cá nhân -->

							<!-- Khách hàng doanh nghiệp -->
							<div class="tab-pane" id="hr2">
								<?php include('doanhnghiep/khachhangdoanhnghiep.php');?>
							</div>
							<!-- Kết thúc khách hàng doanh nghiệp -->

							<!-- Khách hàng tổ chức -->
							<div class="tab-pane" id="hr3">
								<?php include('tochuc/khachhangtochuc.php');?>
							</div>
							<!-- kết thúc khách hàng tổ chức -->

						</div>
							
					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

	</div>
</section>
<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">	
	var num_qtht = $("#num_qtht").val();
	var num_llct = $("#num_llct").val();
	var num_qhxh = $("#num_qhxh").val();

	for (var i = 0; i < num_qtht; i++) {
		var j=i+1;
		$val = $('#gr4_'+j+'_from_year').attr('attr_value');
		$val1 = $('#gr4_'+j+'_to_year').attr('attr_value');
		$val2 = $('#gr4_'+j+'_cap_hoc').attr('attr_value');

		$('#gr4_'+j+'_from_year').select2().select2("val", $val);
		$('#gr4_'+j+'_to_year').select2().select2("val", $val1);
		$('#gr4_'+j+'_cap_hoc').select2().select2("val", $val2);
	}

	for (var i = 0; i < num_llct; i++) {
		var j=i+1;
		$val = $('#gr5_'+j+'_from_year').attr('attr_value');
		$val1 = $('#gr5_'+j+'_to_year').attr('attr_value');
		$('#gr5_'+j+'_from_year').select2().select2("val", $val);
		$('#gr5_'+j+'_to_year').select2().select2("val", $val1);
	}

	for (var i = 0; i < num_qhxh; i++) {
		var j=i+1;
		$val = $('#gr6_'+j+'_cap_do_quan_he').attr('attr_value');
		$val1 = $('#gr6_'+j+'_hinh_thuc_quan_he').attr('attr_value');
		$val2 = $('#gr6_'+j+'_loai_quan_he').attr('attr_value');

		$('#gr6_'+j+'_cap_do_quan_he').select2().select2("val", $val);
		$('#gr6_'+j+'_hinh_thuc_quan_he').select2().select2("val", $val1);
		$('#gr6_'+j+'_loai_quan_he').select2().select2("val", $val2);
	}	
	
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
		var $frmRegisUser = $("#form_customer_canhan").validate({
			
			// Rules for form validation
			rules : {
				gr1_1_ho_ten: {
					required : true				
				},
				gr1_3_dien_thoai: {
					required : true
				},
				gr1_2_quoc_tich: {
					required : true
				},
				gr1_2_noi_o_hien_tai: {
					required : true
				}

			},

			// Messages for form validation
		
			messages : {
				gr1_1_ho_ten: {
					required : "Vui lòng nhập tên"				
				},
				gr1_3_dien_thoai: {
					required : "Vui lòng nhập điện thoại"
				},
				gr1_2_quoc_tich: {
					required : "Vui lòng nhập quốc tịch"
				},
				gr1_2_noi_o_hien_tai: {
					required : "Vui lòng nơi ỏ"
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});

		// / START AND FINISH DATE
		$('#gr1_1_ngay_sinh').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr1_1_ngay_mat').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr1_3_ngay_ket_hon').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr7_24_ngay_thanh_lap').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr8_26_ngay_sinh').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr9_31_ngay_thanh_lap').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr9_32_ngay_sinh').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr10_33_ngay_thanh_lap').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});	
		$('#gr11_35_ngay_sinh').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr12_37_ngay_thanh_lap').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#gr12_38_ngay_sinh').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});
		
		
		
		// Quan he gia dinh
		var number = $("#quantity_relationship").val();
		for (var i = 0; i < number; i++) {
			$('#gr3_19_ngay_sinh_'+i).datepicker({
				dateFormat : 'dd-mm-yy',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#finishdate').datepicker('option', 'minDate', selectedDate);
				}
			});			
			$('#gr3_19_ngay_mat_'+i).datepicker({
				dateFormat : 'dd-mm-yy',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#finishdate').datepicker('option', 'minDate', selectedDate);
				}
			});	
		}
		
		// Trigger tab
		if($("#trigger-tab").length) {
			if ($("#trigger-tab").val()==1) {
				$("#tab_doanhnghiep").trigger("click");
			} else if ($("#trigger-tab").val()==2) {
				$("#tab_tochuc").trigger("click");
			}
		}
		
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

	// --------------javascript--------------

	// Function backPage
	function backPage() {
		window.location="<?php echo ROOTHOST?>mgmt_customer.html";
	}

	// Get value when click TAB
	// $(".pull-left.in li a").click(function(){
	// 	$value = $(this).attr('attr_value');
	// 	$("#txt_type").val($value);
	// });

	/*Event click button add customer canhan*/
	$("#cmd_save").click(function() {
		if ($("#gr1_1_ho_ten").val() == "") {
			smartErrorMsg('Thông báo', 'Bạn chưa nhập thông tin họ tên khách hàng', 5000);
			return;
		}
		if ($("#gr1_2_quoc_tich").val() == "") {
			smartErrorMsg('Thông báo', 'Bạn chưa nhập thông tin quốc tịch khách hàng', 5000);
			return;
		}
		if ($("#gr1_3_dien_thoai").val() == "") {
			smartErrorMsg('Thông báo', 'Bạn chưa nhập thông tin điện thoại khách hàng', 5000);
			return;
		}
		//  Submit form data
		
		smartInfoMsg('Thông báo', 'Thành công!', 2000);
		setTimeout(function(){
			$("#form_customer_canhan").submit();	
		}, 1000);
		
	});

	/*Event click button add customer doanh nghiep*/
	$("#cmd_save_doanhnghiep").click(function() {
		if ($("#gr7_24_ten_doanh_nghiep").val() == "") {
			smartErrorMsg('Thông báo', 'Bạn chưa nhập tên doanh nghiệp', 5000);
			return;
		}
		//  Submit form data
		
		smartInfoMsg('Thông báo', 'Thành công!', 2000);
		setTimeout(function(){
			$("#form_customer_doanhnghiep").submit();
		}, 1000);
		
	});

	/*Event click button add customer doanh nghiep*/
	$("#cmd_save_tochuc").click(function() {
		if ($("#gr10_33_ten_to_chuc").val() == "") {
			smartErrorMsg('Thông báo', 'Bạn chưa nhập tên tổ chức', 5000);
			return;
		}
		//  Submit form data
		$("#form_customer_tochuc").submit();	
		
	});

</script>
<style type="text/css">
	.row-seperator-header {
		margin-left: 0px;
	}
	.field_hidden {
		display: none;
	}
</style>