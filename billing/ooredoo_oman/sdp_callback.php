<?php
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';
$logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/ooredoo_oman/sdp_callback_" . date('Ymd') . ".log";
$phpInput   = file_get_contents('php://input');
$transId = rand(100000000, 999999999);
$sLog = "Start|".json_encode($_REQUEST)."|".$phpInput."|".$transId;
commonLogging($sLog, $logPath);
//echo "ACCEPTED";
echo $transId;
?>