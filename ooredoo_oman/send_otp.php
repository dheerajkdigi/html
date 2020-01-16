<?php
require_once "../billing/common_function/common_functions.php";
require_once "../billing/ooredoo_oman/Ooredoo_Oman_Billing.php";
require_once "productConfig.php";
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$msisdn 	= (int)$_REQUEST['msisdn'];
$plan 		= strtolower($_REQUEST['plan']);
$plan 		= (isset($productConfig[$plan])) ? $plan : "daily";
//print_r($_POST);exit;
if(strlen($msisdn) != 8) {
	header("Location:msisdn.php?msisdn=".$msisdn."&msg=invalid_msisdn");exit;
}


$billingObj = new Ooredoo_Oman_Billing();
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'verify_otp','other2'=>'4746');

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
if($billingResArr["result"]["code"] == "SS001") {
	header("Location:otppage.php?msisdn=".$msisdn);exit;
}
else if($billingResArr["result"]["code"] == "SS101") {
	header("Location:thankyou.php?msg=already_sub");exit;
}
else {
	header("Location:thankyou.php?msg=fail");exit;
}
dd($billingRes);
?>