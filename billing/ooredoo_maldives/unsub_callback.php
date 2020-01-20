<?php
require_once '/var/www/html/billing/common_function/common_functions.php';
require_once "Ooredoo_Maldives_Billing.php";

$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_maldives/unsub_callback_' . date('Ymd') . '.log';
$sLog = __LINE__."|START|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
/*
$productConfig['480355'] 	= array('plan'=>'daily');
$productConfig['480365']    = array('plan'=>'weekly');
$productConfig['480375']   	= array('plan'=>'monthly');
*/
$msisdn 	= substr($_REQUEST["Origin"], 3);
$productId 	= $_REQUEST["ProductId"];
//$planId 	= $_REQUEST["PricePointId"];
//$plan 	= $productConfig[$planId]["plan"];

$aSelect 	= selectDetails('billing.ooredoo_maldives_subscription', 'id,msisdn,event_id,pricepoint_id', array('msisdn' => " = '960" . $msisdn . "'", 'status' => " != '6'"));

$sLog 		= __LINE__."|Select  = " . json_encode($aSelect);
commonLogging($sLog,$logFilePath);
        
$plan 		= strtolower($aSelect['data']['pricepoint_id']);

$billingObj = new Ooredoo_Maldives_Billing();
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'unsub', 'other1' => 'callback');

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = "END|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);


echo date("YmdHis").rand(1111,9999);
?>