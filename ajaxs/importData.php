<?php
require_once("../includes/gfinnit.php");
require_once("../libs/cls.mysql.php");
require_once("../libs/cls.user.php");
require_once("../includes/gffunction.php");
include '../Classes/PHPExcel/IOFactory.php';
$objuser = new CLS_USER;

$valid_formats = array("xlsx", "xls");
$max_file_size = 1024*100000000; 
$path = "../uploads/";
$strFile = "";

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    // Loop $_FILES to execute all files
    $memId = $_POST['memId'];
    foreach ($_FILES['files']['name'] as $f => $name) { 
        $name = un_unicode($name);    
        if ($_FILES['files']['error'][$f] == 4) {
            continue; // Skip file if any error found
        }          
        if ($_FILES['files']['error'][$f] == 0) {              
            if ($_FILES['files']['size'][$f] > $max_file_size) {
                $message[] = "$name is too large!.";
                continue; // Skip large files
            }
            elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                $message[] = "$name is not a valid format";
                continue; // Skip invalid file formats
            }
            else{ // No error found! Move uploaded files
                $rand=rand(1000,99999);
                $name=$rand.'_'.$name;
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name)) {
                    $strFile.=$path.$name;
                }
            }
        }
    }
    $link = "uploads/".$name;
    $inputFileName = '../'.$link;
    //  Read your Excel workbook
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch(Exception $e) {
        die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
    }
    //  Get worksheet dimensions    
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();

    //  Loop through each row of the worksheet in turn
    for ($row = 2; $row <= $highestRow; $row++){ 
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                        NULL,
                                        TRUE,
                                        FALSE);
        
        
        $objuser->FullName=$rowData[0][1];
        $objuser->Birthday=strtotime($rowData[0][2]);
        $objuser->Phone=$rowData[0][3];
        $objuser->Gender=$rowData[0][4];
        $objuser->Type=$rowData[0][5] == "Thường" ? 0 : 1;
        $objuser->Address=$rowData[0][6];
        
        // globals avaible mem id                                       
        $objuser->MemID=$memId;
        $objuser->Add_new();
    }

    echo "success";
} else {
    echo "failed";
}

?>