<?php
require_once "../billing/common_function/common_functions.php";
require_once "../billing/virgin_saudi/Virgin_Saudi_Billing.php";
require_once "productConfig.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/virgin_saudi/portal_log_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$msisdn 	= (int)$_POST['msisdn'];
$plan 		= strtolower($_REQUEST['plan']);
$plan 		= (isset($productConfig[$plan])) ? $plan : "daily";
//print_r($_POST);exit;
if(strlen($msisdn) != 9 || !in_array(substr($msisdn,0,3),['570','571','572'])) {
	header("Location:index.php?msisdn=".$msisdn."&msg=invalid_msisdn");exit;
}


$billingObj = new Virgin_Saudi_Billing();
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'verify_otp','other2'=>'4746');

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
if($billingResArr["result"]["code"] == "H001") {
	header("Location:otppage.php?msisdn=".$msisdn);exit;
}
else if($billingResArr["result"]["code"] == "H101") {
	header("Location:thankyou.php?msg=already_sub");exit;
}
else {
	header("Location:index.php?msisdn=".$msisdn."&msg=invalid_msisdn");exit;
}
dd($billingRes);
?>