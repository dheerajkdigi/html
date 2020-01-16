<?php
require_once '/var/www/html/billing/common_function/common_functions.php';
$headers = getallheaders();
echo "<pre>";
print_r($headers);;
$sMicroLogFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_maldives/ooredoo_maldives_he_' . date('Ymd') . '.log';
$sLog       = "Headers : " . json_encode($headers);
checkLogPath($sMicroLogFilePath);
commonLogging($sLog,$sMicroLogFilePath);
?>