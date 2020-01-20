<?php
require_once "../billing/common_function/common_functions.php";
require_once "../billing/ooredoo_oman/Ooredoo_Oman_Billing.php";
require_once "productConfig.php";
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$msisdn 	= $_REQUEST['msisdn'];
$pin 		= $_REQUEST['pin'];
$plan 		= strtolower($_REQUEST['plan']);
$plan 		= (isset($productConfig[$plan])) ? $plan : "daily";
if(!($msisdn && $pin)) {
	header("Location:otppage.php?msisdn=".$msisdn."&msg=invalid_pin");exit;
}

$billingObj = new Ooredoo_Oman_Billing();
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'verify_otp','other2'=>$pin);

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
if($billingResArr["result"]['code'] == "SS001") {
	header("Location:thankyou.php?msg=success");exit;
}
else if($billingResArr["result"]['message'] == "invalidpin") {
	header("Location:otppage.php?msisdn=".$msisdn."&msg=invalid_pin");exit;
}
else if(strtolower($billingResArr["result"]['message']) == "already_active") {
	header("Location:thankyou.php?msg=already_sub");exit;
}
else if($billingResArr["result"]['message']) {
	header("Location:thankyou.php?msg=".urlencode($billingResArr["result"]['message']));exit;
}
else {
	header("Location:thankyou.php?msg=fail");exit;
}

dd($billingRes);
?>