<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt  LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set("Asia/Saigon");

require_once('../includes/gfinnit.php');
require_once('../libs/cls.mysql.php');
require_once('../libs/cls.schedule.php');
$objMysql =  new CLS_MYSQL();
$objS = new CLS_SCHEDULE;

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

if(isset($_GET["sql"])) {
  
  $cell = 2;
  $stt = 1;
 
  $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'STT')
        ->setCellValue('B1', 'Họ tên')
        ->setCellValue('C1', 'CMND')
        ->setCellValue('D1', 'Giới tính')
        ->setCellValue('E1', 'Địa chỉ')
        ->setCellValue('F1', 'Công việc gặp')
        ->setCellValue('G1', 'Gặp ai')
        ->setCellValue('H1', 'Thời gian')
        ->setCellValue('I1', 'Trạng thái');

    $sql = $_GET['sql'];
    $objMysql->Query($sql);
    
    while ($r = $objMysql->Fetch_Assoc()) {
      $gender="";
      $id=$r['id_boss'];
      $ob = new CLS_MYSQL;
      $sql="SELECT fullname, position FROM tbl_member_level WHERE id = '$id'";      
      $ob->Query($sql);
      $rs = $ob->Fetch_Assoc();
      $boss = $rs['fullname'];
      
      if($r['gender']==0) $gender="Nam";
      else $gender = "Nữ";

       $objPHPExcel->setActiveSheetIndex(0)
          ->SetCellValue('A'.$cell, $stt)
          ->SetCellValue('B'.$cell, $r['name'])
          ->SetCellValue('C'.$cell, $r['identify'])
          ->SetCellValue('D'.$cell, $gender)
          ->SetCellValue('E'.$cell, $r['address'])
          ->SetCellValue('F'.$cell, $r['task'])
          ->SetCellValue('G'.$cell, $boss)
          ->SetCellValue('H'.$cell, $r['time_number'])
          ->SetCellValue('I'.$cell, $r['status']);
          
      $stt++;
      $cell++;
   }
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Báo cáo thống kê');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Thong_ke.xls"');
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
