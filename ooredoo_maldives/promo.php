<?php
//ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Calcutta');

ini_set('display_errors', 0);
#session_start();

require_once '../billing/common_function/update_userbase.php';
require_once "../billing/common_function/common_functions.php";
require_once "productConfig.php";

$logPath = '/var/log/billing/'.date("Y").'/'.date("m").'/ooredoo_maldives/promo_'.date("Ymd").'.log';
//$logPath = '/tmp/promo_'.date("Ymd").'.log';
checkLogPath($logPath);
$msisdn = (isset($_SERVER['ooredoomvmsisdn']) && $_SERVER['ooredoomvmsisdn']) ? $_SERVER['ooredoomvmsisdn'] : "";
/*if($isSubscribed==true) {
    header("Location: index.php");exit;
}*/

$planId   = $_GET['p3'];
//$planId   = 'daily';

$sLog = "PromoRequest|".$msisdn."|".$productId."|".$planId."|".json_encode($_GET)."|".json_encode($_SERVER);
commonLogging($sLog, $logPath);

if( !isset($productConfig[$planId]) ) {
    echo "Invalid  Request.";
    $sLog = "InvalidRequest|".$msisdn."|".$productId."|".$planId."|".json_encode($_GET);
    commonLogging($sLog, $logPath);
    exit;
}
/*if($_GET['p1']=='19294b82-e883-4f23-9389-16c46f48276b'){
    $_GET['p1']='1104';
}*/
$rate           = $productConfig[$planId]["rate"];
$validity       = $productConfig[$planId]["validity"];
$productId       = $productConfig[$planId]["productId"];
$transactionId  = date("Ymd").substr(number_format(time() * mt_rand(),0,'',''),0,7);
$cgUrl = 'index.php?plan='.$planId;
//error_log('\n'.date('Y-m-d H:i:s').' => '.$msisdn.' CG URL=> '.$cgUrl,3,$logPath);

$aInsertData['msisdn']        	= "'".$msisdn."'";
$aInsertData['plan_id']    		= "'".$planId."'";
$aInsertData['service_id']    	= "'".$productId."'";
$aInsertData['rate']          	= "'".$rate."'";
$aInsertData['operator_id']   	= "'2'";
$aInsertData['operator_name'] 	= "'OOREDOO_MALDIVES'";
$aInsertData['trans_id']      	= "'".$transactionId."'";
$aInsertData['aff_id']        	= "'".$_GET['p1']."'";
//$aInsertData['aff_id']        	= '1104';
$aInsertData['s2s_id'] 			= "'".$_GET['p2']."'";
$aInsertData['query_string']  	= "'".$_SERVER['QUERY_STRING']."'";
$aInsertData['client_ip']       = "'".getClientIp()."'";
$aInsertData['UA']        	= "'".$_SERVER['HTTP_USER_AGENT']."'";
$aDBReturn  =   insertTable('billing.tbl_promo', $aInsertData);
$promo_id=$aDBReturn['last_insert_id'];
#$promo_id = $_SESSION[$promo_id];
$cgUrl = 'index.php?plan='.$planId.'&promo_id='.$promo_id;

$sLog       =   "InsertInput|" . json_encode($aInsertData) . '|InsertReturn|' . json_encode($aDBReturn);
commonLogging($sLog, $logPath);
$sLog = "CGRedirect|".$cgUrl;
commonLogging($sLog, $logPath);
header("Location:".$cgUrl);
?>
