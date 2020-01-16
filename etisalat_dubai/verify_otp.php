<?php
require_once '../billing/common_function/update_userbase.php';
require_once "../billing/common_function/common_functions.php";
require_once "../billing/etisalat_dubai/Etisalat_Dubai_Billing.php";
require_once "productConfig.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/etisalat_dubai/portal_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$msisdn 	= $_REQUEST['msisdn'];
$pin 		= $_REQUEST['pin'];
$plan 		= strtolower($_REQUEST['plan']);
$plan 		= (isset($productConfig[$plan])) ? $plan : "daily";
$promo_id 	= $_REQUEST['promo_id'];

if(!($msisdn && $pin)) {
	header("Location:otppage.php?msisdn=".$msisdn."&msg=invalid_pin"."&promo_id=".$promo_id);exit;
}

$billingObj = new Etisalat_Dubai_Billing();
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'verify_otp','other2'=>$pin);

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
if($billingResArr["result"]['code'] == "SS001") {

    $rate           = $productConfig[$plan]["rate"];
    $productId      = $productConfig[$plan]["productId"];
    $transactionId  = $billingResArr["trans_id"];

    $aInsertData['msisdn']        	= "'".$msisdn."'";
    $aInsertData['plan_id']             = "'".$plan."'";
    $aInsertData['service_id']    	= "'".$productId."'";
    $aInsertData['rate']          	= "'".$rate."'";
    $aInsertData['operator_id']   	= "'1'";
    $aInsertData['operator_name'] 	= "'ETISALAT_DUBAI'";
    $aInsertData['trans_id']      	= "'".$transactionId."'";
    $aInsertData['promo_id']        	= "'".$promo_id."'";
    $aDBReturn  =   insertTable('billing.tbl_promo_transaction', $aInsertData);
    $sLog       =   "InsertInput|" . json_encode($aInsertData) . '|InsertReturn|' . json_encode($aDBReturn);
    commonLogging($sLog, $logFilePath);
    header("Location:thankyou.php?msg=success");exit;
}
else if($billingResArr["result"]['message'] == "invalidpin") {
	header("Location:otppage.php?msisdn=".$msisdn."&plan=".$plan."&msg=invalid_pin");exit;
}
else {
	header("Location:thankyou.php?msg=fail");exit;
}

dd($billingRes);
?>