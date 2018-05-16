<?php
#API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AIzaSyB6el3ViwEws3JtSNdG4W0XHufGpRH3OtI' );
    $registrationIds = "eia0r04XXro:APA91bG3o8sm-7kROMgmqSqJe-GP2fnq-dbt-bNvS53MKLmO8PlpYl711VmACYBlXLz2HvlFlpZa_IL6jllk8anBsCNVVVzmBTXvlwNDgpiD9CQlQBaYJGbNWBZzMboyArp9UmVZ6Ynt";
#prep the bundle
     $msg = array
          (
        'body'  => 'Ngày 13-05-2018 sinh nhật khách hàng Trần Bảo Anh',
        'title' => 'Thông báo',
                'icon'  => 'myicon',/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
          );
    $fields = array
            (
                'to'        => $registrationIds,
                'notification'  => $msg
            );
    
    
    $headers = array
            (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );
#Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
#Echo Result Of FireBase Server
echo $result;

?>