<?php
require_once "../billing/common_function/common_functions.php";
require_once "../billing/ooredoo_maldives/Ooredoo_Maldives_Billing.php";
require_once "productConfig.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_maldives/portal_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$msisdn 	= $_REQUEST['msisdn'];

$aSelect 	= selectDetails('billing.ooredoo_maldives_subscription', 'id,msisdn,event_id,pricepoint_id', array('msisdn' => " = '960" . $msisdn . "'",'status' => " != '6'"));

$sLog 		= __FILE__."|".__FUNCTION__."|".__LINE__."|Select  = " . json_encode($aSelect);
commonLogging($sLog,$logFilePath);
        
$plan 		= strtolower($aSelect['data']['pricepoint_id']);

$billingObj = new Ooredoo_Maldives_Billing();
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'unsub');

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
echo $billingRes;
/*
$response['msisdn'] = $msisdn;
if($billingResArr["result"]['code'] == "H000") {
	$response['error_code'] 		= "SS000";
	$response['error_message']		= "Success";
	$response['error_description']	= "User Unsubscribed Successfullly";
} else if($billingResArr["result"]['code'] == "H102") {
	$response['error_code'] 		= "SS102";
	$response['error_message']		= "Success";
	$response['error_description']	= "User Unsubscribed Successfullly";
}
else {
	$response['error_code'] 		= "SS999";
	$response['error_message']		= "Errror";
	$response['error_description']	= "Something went Wrong.";
}

echo json_encode($response);
*/
?>