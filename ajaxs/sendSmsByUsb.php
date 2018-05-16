<?php
require "php_serial.class.php";

$serial = new phpSerial;
$serial->deviceSet("COM6");
$serial->confBaudRate(115200);

// Then we need to open it
$serial->deviceOpen();

// To write into
$serial->sendMessage("AT+CMGF=1\n\r"); 
$serial->sendMessage("AT+CMGS=\"01656241161\"\n\r");
$serial->sendMessage("bach banh bao\n\r");
$serial->sendMessage(chr(26));

//wait for modem to send message
sleep(7);
$read=$serial->readPort();
$serial->deviceClose();
echo "success";

?>