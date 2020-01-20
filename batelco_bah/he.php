<?php 
require_once "../billing/common_function/common_functions.php";
//require_once "../billing/virgin_saudi/Virgin_Saudi_Billing.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/batelco_bah/portal_log_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$roleId 	= "2382";
$transId 	= date("ymdHis").rand(100000, 999999);
$heReturnUrl = "http://m.theshilpashetty.com/batelco_bah/heReturnUrl.php";
//$heUrl = "http://www.digitalauthentication.om/api.php?action=he&correlatorId=".$transId."&roleId=".$roleId."&redirectURL=".$heReturnUrl;

$userName = "timwemb";
$passowrd = "o1s6m70";
$heUrl = "http://helm.tekmob.com/pim/batelcobhrhe?redirectURL=".$heReturnUrl."&user=".$userName."&pass=".$passowrd;

header("Location:".$heUrl);
?>