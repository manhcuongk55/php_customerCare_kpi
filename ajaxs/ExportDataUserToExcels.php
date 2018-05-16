<?php 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set("Asia/Saigon");
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");

if (PHP_SAPI == 'cli')
  die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
               ->setLastModifiedBy("Maarten Balliauw")
               ->setTitle("Office 2007 XLSX Test Document")
               ->setSubject("Office 2007 XLSX Test Document")
               ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
               ->setKeywords("office 2007 openxml php")
               ->setCategory("Test result file");

$objMysql = new CLS_MYSQL;

if(isset($_GET['lstIds'])) {
	$cell = 2;
	$stt = 1;
 
  $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'STT')
        ->setCellValue('B1', 'Ho ten')
        ->setCellValue('C1', 'So dien thoai');

  $memId = $_GET['memId'];
	$lstIds = $_GET['lstIds'];
	$lstIds = substr($lstIds, 0, strlen($lstIds)-1);
	$lstIds = str_replace(",", "','", $lstIds);

	$sql = "select fullname,phone from tbl_user where id in ('".$lstIds."') and mem_id = '".$memId."'";

	$objMysql->Query($sql);
	while ($rs = $objMysql->Fetch_Assoc()) {
    $phone = "+84".substr($rs['phone'], 1, strlen($rs['phone']));

		$objPHPExcel->setActiveSheetIndex(0)
          ->SetCellValue('A'.$cell, $stt)
          ->SetCellValue('B'.$cell, $rs['fullname'])
          ->SetCellValue('C'.$cell, $phone, PHPExcel_Cell_DataType::TYPE_STRING);
          
		$stt++;
		$cell++;
	}
}



// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Danh sach send sms');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Danh_sach_send_sms.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


?>