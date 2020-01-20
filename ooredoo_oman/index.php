<?php 
require_once "../billing/common_function/common_functions.php";
require_once "productConfig.php";
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);

$roleId 	= "2382";
$transId 	= date("ymdHis").rand(100000, 999999);
$heReturnUrl = "http://m.theshilpashetty.com/ooredoo_oman/heReturnUrl.php";
$heUrl = "http://www.digitalauthentication.om/api.php?action=he&correlatorId=".$transId."&roleId=".$roleId."&redirectURL=".$heReturnUrl;
$sLog = __FILE__."|".$heUrl;
commonLogging($sLog,$logFilePath);
header("Location:".$heUrl);
?>