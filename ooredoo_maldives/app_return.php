<?php
require_once "../billing/common_function/common_functions.php";

$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_maldives/app_return_' . date('Ymd') . '.log';
$sLog = __FILE__."|".__LINE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);

$msisdn 		= (int)$_REQUEST['msisdn'];
$country_code 	= "960";
$app_return_url = "https://lite.theshilpashetty.com/access?user=".$msisdn."&country_code=".$country_code;
$sLog = __FILE__."|".__LINE__."|".$app_return_url;
commonLogging($sLog,$logFilePath);
header("Location:".$app_return_url);exit;
?>