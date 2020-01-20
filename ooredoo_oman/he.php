<?php 
require_once "../billing/common_function/common_functions.php";
//require_once "../billing/virgin_saudi/Virgin_Saudi_Billing.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_oman/portal_log_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$roleId 	= "2382";
$transId 	= date("ymdHis").rand(100000, 999999);
$heReturnUrl = "http://m.theshilpashetty.com/ooredoo_oman/heReturnUrl.php";
$heUrl = "http://www.digitalauthentication.om/api.php?action=he&correlatorId=".$transId."&roleId=".$roleId."&redirectURL=".$heReturnUrl;

header("Location:".$heUrl);
?>