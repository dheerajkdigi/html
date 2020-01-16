<?php
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';
$logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/du_dubai/cg_return_" . date('Ymd') . ".log";
$phpInput   = file_get_contents('php://input');
$sLog = "Start|".json_encode($_REQUEST)."|".$phpInput;
commonLogging($sLog, $logPath);
echo "ACCEPTED";
?>