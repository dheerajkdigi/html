<?php
require_once "../billing/common_function/common_functions.php";
require_once "../billing/ooredoo_maldives/Ooredoo_Maldives_Billing.php";
require_once "productConfig.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_maldives/api_' . date('Ymd') . '.log';
$sLog = __FILE__."|".__LINE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$aff_id 		= (int)strtolower($_REQUEST['aff_id']);
$ext_trans_id 	= strtolower($_REQUEST['ext_trans_id']);
$msisdn 		= (int)$_REQUEST['msisdn'];
$plan 			= strtolower($_REQUEST['plan']);
$plan 			= (isset($productConfig[$plan])) ? $plan : "";
$action 		= strtolower($_REQUEST['action']);
$other1			= strtolower($_REQUEST['other1']);
$other2			= strtolower($_REQUEST['other2']);
//print_r($_POST);exit;
if(!($ext_trans_id && $msisdn && $plan) || !in_array($action,array('sub','status')) || ($action == "sub" && !($aff_id && in_array($other1,array("send_otp", "verify_otp")) && !($other1 == "verify_otp" && $other2 == "") )) ) {
	$aData = array('msisdn' => $msisdn, 'amount' => '', 'trans_id' => $ext_trans_id, 'result' => array('status' => "FAIL", 'code' => "SS400", 'message' => "Bad Request"), 'operator' => array('name' => 'ooredoo_maldives', 'circle' => $paramArray['circle']));
	$sLog = __FILE__."|".__LINE__."|".json_encode($_REQUEST)."|".json_encode($aData);
	commonLogging($sLog,$logFilePath);
	echo json_encode($aData);exit;
}
else {
	//echo "OK";exit;
}

$billingObj = new Ooredoo_Maldives_Billing();
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => $action, 'other1' => $other1, 'other2' => $other2, 'aff_id' => $aff_id, 'ext_trans_id' => $ext_trans_id);
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'verify_otp','other2'=>'4746');

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".__LINE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
echo $billingRes;
/*
if($billingResArr["result"]["code"] == "H001") {
	header("Location:otppage.php?msisdn=".$msisdn."&plan=".$plan);exit;
}
else if($billingResArr["result"]["code"] == "H101") {
	header("Location:thankyou.php?msg=already_sub");exit;
}
else {
	header("Location:index.php?msisdn=".$msisdn."&plan=".$plan."&msg=invalid_msisdn");exit;
}
dd($billingRes);
*/
?>