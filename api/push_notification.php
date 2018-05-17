<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
$date=date('Y-m-d h:i:s').' Call by '.$_SERVER['REMOTE_ADDR']."\n";
file_put_contents('logs.txt',$date,FILE_APPEND);

include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.customer.php");
include_once("../libs/cls.customer.detail.php");
include_once("../libs/cls.member_level.php");
include_once("../libs/cls.meet.php");
include_once("../libs/cls.export.pdf.php");

$objMem =  new CLS_MEMBERLEVEL;
$objCustomer = new CLS_CUSTOMER;
$objCustomerDetail = new CLS_CUSTOMER_DETAIL;
$objMeet = new CLS_MEET;
$objExport = new CLS_EXPORT;

if (isset($_POST['type_notify'])) {
    $typeNotify = $_POST['type_notify'];

    $aryFirebaseID = array();
    $aryTypePlatform = array();

    // Yeu cầu xuất dữ liệu
    if ($typeNotify == 0) {
        $memId = $_POST['mem_id'];
        $fullname = $objMem->getNameUserById($memId);
        $objMem->getFireBaseIdSuper();

        while($rs = $objMem->Fetch_Assoc()) {
            array_push($aryFirebaseID, $rs['firebase_id']);
            array_push($aryTypePlatform, $rs['type_platform']);
        }

        for ($i=0; $i < count($aryFirebaseID); $i++) { 
            $msg = array (
                'body'  => 'Nhân viên '.$fullname." yêu cầu xuất dữ liệu khách hàng",
                'title' => 'Thông báo',
                    'icon'  => 'myicon',/*Default Icon*/
                    'sound' => 'mySound'/*Default sound*/
            );
            
            if ($aryTypePlatform[$i] == PLATFORM_ANDROID) {
                $fields = array (
                    'to' => $aryFirebaseID[$i],
                    'data'  => $msg
                );
            } else {
                // IOS
                $fields = array (
                    'to' => $firebaseId,
                    'notification'  => $msg,
                    'priority'=>'high'
                );
            }
            
            sendMessToGoogleCloud($fields, API_ACCESS_KEY);
        }

    } else if ($typeNotify == 1) {
        // Phê duyệt yêu cầu
        $memId = $_POST['mem_id'];
        $cusId = $_POST['cus_id'];
        
        $rs = $objMem->getInfoNotifyById($memId);
        $firebaseId = $rs['firebase_id'];
        $typePlatform = $rs['type_platform'];

        $customerName = $objCustomer->getCustomerName($cusId);

        $msg = array (
            'body'  => 'Yêu cầu xuất file PDF khách hàng được phê duyệt',
            'title' => 'Thông báo',
                'icon'  => 'myicon',/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
        );


        if ($typePlatform == PLATFORM_ANDROID) {
            // Android
            $fields = array (
                'to' => $firebaseId,
                'data'  => $msg
            );
        } else {
            // IOS
            $fields = array (
                'to' => $firebaseId,
                'notification'  => $msg,
                'priority'=>'high'
            );
        }
        sendMessToGoogleCloud($fields, API_ACCESS_KEY);


    } else {
        // Từ chối yêu cầu 
        $memId = $_POST['mem_id'];
        $cusId = $_POST['cus_id'];
        $rs = $objMem->getInfoNotifyById($memId);
        $firebaseId = $rs['firebase_id'];
        $typePlatform = $rs['type_platform'];

        $customerName = $objCustomer->getCustomerName($cusId);

        $msg = array (
            'body'  => 'Yêu cầu xuất file PDF khách hàng bị từ chối',
            'title' => 'Thông báo',
                'icon'  => 'myicon',/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
        );
        if ($typePlatform == PLATFORM_ANDROID) {
            // Android
            $fields = array (
                'to' => $firebaseId,
                'data'  => $msg
            );
        } else {
            // IOS
             $fields = array (
                'to' => $firebaseId,
                'notification'  => $msg,
                'priority'=>'high'
            );
        }
        sendMessToGoogleCloud($fields, API_ACCESS_KEY);

    }
    
} else {

    // =====================Lập lịch gưi notification tới device=========================
    // get dach sach nguoi dung
    $aryMember = array();
    $objMem->getList("","");
    $firebaseIdSuper = "";
    $typePlatformSuper = "";
    while ($rs=$objMem->Fetch_Assoc()) {
        array_push($aryMember, $rs);
        if ($rs['permistion'] == 2) {
            $firebaseIdSuper = $rs['firebase_id'];
            $typePlatformSuper = $rs['type_platform'];
        }
        // var_dump($rs);
    }
    // var_dump($firebaseIdSuper);

    // get list customer by mem id  
    foreach ($aryMember as $obj) {
        $curDay = date("d");
        $curMonth = date("m");
        $aryFirebaseID = array();
        $aryTypePlatform = array();
        $aryMessage = array();

        array_push($aryFirebaseID, $firebaseIdSuper);
        array_push($aryTypePlatform, $typePlatformSuper);

        if ($obj['firebase_id'] != "") {
            $firebaseId = $obj['firebase_id'];
            $typePlatform = $obj['type_platform'];

            if ($firebaseId != $firebaseIdSuper) {
                array_push($aryFirebaseID, $firebaseId);
                array_push($aryTypePlatform, $typePlatform);
            }
        }
        
        // var_dump($aryFirebaseID);die;

        // Send notify birthday customer
        $objCustomer->getList(" AND `mem_id`='".$obj['id']."'", "");
        while ($rs=$objCustomer->Fetch_Assoc()) {
            $cusType = $rs['type'];
            $cusName = $rs['fullname'];

            $cusDay = date("d", strtotime($rs['birthday']));
            $cusMonth = date("m", strtotime($rs['birthday']));        

            $offsetDay = $cusDay-$curDay;
            $offsetMonth = $cusMonth-$curMonth;
            $body = "";

            if (($cusMonth == $curMonth && ($offsetDay > 0 && $offsetDay < 2)) ||
                ($cusMonth > $curMonth && ($offsetMonth == 1))) {
                
                if ($cusType == GROUP_CANHAN) {
                    $body = "Ngày ".$cusDay."-".$cusMonth." sinh nhật khách hàng ".$cusName;
                } else if ($cusType == GROUP_DOANHNGHIEP) {
                    $body = "Ngày ".$cusDay."-".$cusMonth." thành lập doanh nghiệp ".$cusName;
                } else {
                    $body = "Ngày ".$cusDay."-".$cusMonth." thành lập tổ chức ".$cusName;
                }
                // push message to array
                $objBody = new BodyMessage();
                $objBody->Type = NOTIFY_BIRTHDAY;
                $objBody->Content = $body;
                array_push($aryMessage, $objBody);
               
            } else {
                // NOT TODO
            }

        } // end while

        // Send notify schedule 
        // Lịch có trạng thái sắp diễn ra
        $objMeet->getList(" AND `status`='".STATUS_WAITING."' AND mem_id='".$obj['id']."'", "");
        // die;
        while ($rs=$objMeet->Fetch_Assoc()) {
            $cusName = $objCustomer->getCustomerName($rs['customer_id']);
            $status = $rs['type'];
            $cusDay = date("d", strtotime($rs['datetime']));
            $cusMonth = date("m", strtotime($rs['datetime']));        

            $offsetDay = $cusDay-$curDay;
            $offsetMonth = $cusMonth-$curMonth;
            $body = "";
            $scheduleType = "";
            if ($status == "tang_qua") $scheduleType = "Tặng quà";
            if ($status == "hop_hanh") $scheduleType = "Họp";
            if ($status == "dam_hieu") $scheduleType = "Đám hiếu";
            if ($status == "dam_hi") $scheduleType = "Đám hỉ";
            if ($status == "di_choi") $scheduleType = "Đi chơi";
            if ($status == "lien_hoan") $scheduleType = "Liên hoan";
            if ($status == "gap_mat") $scheduleType = "Gặp mặt";

            if (($cusMonth == $curMonth && ($offsetDay > 0 && $offsetDay < 2)) ||
                ($cusMonth > $curMonth && ($offsetMonth == 1))) {
                
                $body = "Ngày ".date('d-m-Y', strtotime($rs['datetime']))." ".$scheduleType." khách hàng ".$cusName;
                // push message to array
                $objBody = new BodyMessage();
                $objBody->Type = NOTIFY_SCHEDULE;
                $objBody->Content = $body;
                array_push($aryMessage, $objBody);
               
            } else {
                // NOT TODO
            }

        } // end while

        // Sinh nhật người thân khách hàng

        // Sinh nhật người đại diện doanh nghiêp

        // Ngày thành lập đối tác doanh nghiệp

        // Sinh nhật người đại diện tổ chức

        // Ngày thành lập đối tác của tổ chức

        // send multiple device (Giám đốc và nhân viên)
        $jj=0;
        foreach ($aryFirebaseID as $firebaseId) {
            foreach ($aryMessage as $object) {
                // create message
                $title = "Thông báo";
                if ($object->Type == NOTIFY_SCHEDULE) {
                    $title = "Lịch hẹn";
                } else if ($object->Type == NOTIFY_BIRTHDAY) {
                    $title = "Sinh nhật";
                }

                $msg = array (
                    'title' => $title,
                    'type' => $object->Type,
                    'body'  => $object->Content,
                        'icon'  => 'myicon',/*Default Icon*/
                        'sound' => 'mySound'/*Default sound*/
                );
                // var_dump($msg);
                // echo $firebaseId;
                if (isset($aryTypePlatform[$jj]) && $aryTypePlatform[$jj] == PLATFORM_ANDROID) {
                    $fields = array (
                        'to'        => $firebaseId,
                        'data'  => $msg
                    );
                } else {
                    $fields = array (
                        'to' => $firebaseId,
                        'notification'  => $msg,
                        'priority'=>'high'
                    );
                }
                
                sendMessToGoogleCloud($fields, API_ACCESS_KEY);
            }
            
            
        }

    } // end foreach
}

// function send notification
function sendMessToGoogleCloud($fields, $API_ACCESS_KEY) {
    // header
    $headers = array (
        'Authorization: key=' . $API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    #Send Reponse To FireBase Server    
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch );
    curl_close( $ch );
    #Echo Result Of FireBase Server
    echo $result; 

}

class BodyMessage{
    private $pro=array(
        'type'=>'',
        'Content'=>''
    );
}

?>