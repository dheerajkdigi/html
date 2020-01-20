<?php
require_once "../billing/common_function/common_functions.php";

$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/etisalat_dubai/app_return_' . date('Ymd') . '.log';
$sLog = __FILE__."|".__LINE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);

$msisdn 		= (int)$_REQUEST['msisdn'];

$app_return_url = "https://lite.theshilpashetty.com/access?user=".$msisdn;
$sLog = __FILE__."|".__LINE__."|".json_encode($app_return_url);
commonLogging($sLog,$logFilePath);
header("Location:".$app_return_url);exit;
?>