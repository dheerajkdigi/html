<?php
require_once "../billing/common_function/common_functions.php";
require_once "../billing/etisalat_dubai/Etisalat_Dubai_Billing.php";
$logFilePath = '/var/log/portal/' . date('Y') . '/' . date('m') . '/etisalat_dubai/etisalat_dubai_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$msisdn 	= $_REQUEST['msisdn'];
$pin 		= $_REQUEST['pin'];
if(!($msisdn && $pin)) {
	header("Location:index.php?msisdn=".$msisdn."&msg=invalid_pin");exit;
}
$plan 		= "daily";
$billingObj = new Etisalat_Dubai_Billing();
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'verify_otp','other2'=>$pin);

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
if($billingResArr["result"]['code'] == "H001") {
	header("Location:thankyou.php?msg=success");exit;
}
else {
	header("Location:thankyou.php?msg=fail");exit;
}

dd($billingRes);
?>