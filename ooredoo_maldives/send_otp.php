<?php
require_once "../billing/common_function/common_functions.php";
require_once "../billing/ooredoo_maldives/Ooredoo_Maldives_Billing.php";
require_once "productConfig.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_maldives/portal_' . date('Ymd') . '.log';
$sLog = __FILE__."|".__LINE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$msisdn 	= (int)$_REQUEST['msisdn'];
$plan 		= strtolower($_REQUEST['plan']);
$plan 		= (isset($productConfig[$plan])) ? $plan : "daily";
$promo_id	= isset($_REQUEST['promo_id']) ? $_REQUEST['promo_id'] : '';
//print_r($_POST);exit;
if(strlen($msisdn) != 7) {
	header("Location:index.php?msisdn=".$msisdn."&plan=".$plan."&promo_id=".$promo_id."&msg=invalid_msisdn");exit;
}


$billingObj = new Ooredoo_Maldives_Billing();
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'verify_otp','other2'=>'4746');

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".__LINE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
if($billingResArr["result"]["code"] == "SS001") {
	header("Location:otppage.php?msisdn=".$msisdn."&plan=".$plan."&promo_id=".$promo_id);exit;
}
else if($billingResArr["result"]["code"] == "SS101") {
	header("Location:thankyou.php?msg=already_sub");exit;
}
else {
	header("Location:thankyou.php?&msg=error");exit;
}
dd($billingRes);
?>