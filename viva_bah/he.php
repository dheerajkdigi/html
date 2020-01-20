<?php 
require_once "../billing/common_function/common_functions.php";
//require_once "../billing/virgin_saudi/Virgin_Saudi_Billing.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/viva_bah/portal_log_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$roleId 	= "2382";
$transId 	= date("ymdHis").rand(100000, 999999);
$heReturnUrl = "http://m.theshilpashetty.com/viva_bah/heReturnUrl.php";
//$heUrl = "http://www.digitalauthentication.om/api.php?action=he&correlatorId=".$transId."&roleId=".$roleId."&redirectURL=".$heReturnUrl;
$userName = "timwembhq";
$passowrd = "mbtim@3233";
$heUrl = "http://helm.tekmob.com/pim/vivabhrhe?redirectURL=".$heReturnUrl."&user=".$userName."&pass=".$passowrd;
header("Location:".$heUrl);
?>