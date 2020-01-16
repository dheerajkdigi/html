<?php
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';
require_once 'sdp_callback_process.php';
$logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/virgin_saudi/sdp_callback_" . date('Ymd') . ".log";
$phpInput   = file_get_contents('php://input');
$sLog = "Start|".json_encode($_REQUEST)."|".$phpInput;
commonLogging($sLog, $logPath);
processCallback($phpInput);
echo "ACCEPTED";
//http://sdp.altruistindia.com/eticms/ContentPush_Test?login=DigiOsmosis&pwd=DigiOsmo897&ptype=text&senderid=300304&msisdn=966570982573&msg=Test+From+SSK+APP
?>