<?php
require_once "../billing/common_function/common_functions.php";
require_once "../billing/ooredoo_maldives/Ooredoo_Maldives_Billing.php";
require_once "productConfig.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_maldives/portal_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$msisdn 	= $_REQUEST['msisdn'];
$pin 		= $_REQUEST['pin'];
$plan 		= strtolower($_REQUEST['plan']);
$plan 		= (isset($productConfig[$plan])) ? $plan : "daily";
$promo_id	= isset($_REQUEST['promo_id']) ? $_REQUEST['promo_id'] : '';

if(!($msisdn && $pin)) {
	header("Location:otppage.php?msisdn=".$msisdn."&msg=invalid_pin");exit;
}

$billingObj = new Ooredoo_Maldives_Billing();
//$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'send_otp');
$data = array('msisdn' => $msisdn, 'plan' => $plan, 'action' => 'sub', 'other1' => 'verify_otp','other2'=>$pin);

$billingRes 	= $billingObj->charge($data);
$billingResArr 	= json_decode($billingRes,true);
$sLog = __FILE__."|".json_encode($data)."|".$billingRes;
commonLogging($sLog,$logFilePath);
if( in_array($billingResArr["result"]['code'], array("SS000","SS001")) ) {
	if($promo_id) {
		$rate           = $productConfig[$plan]["rate"];
	    $productId      = $productConfig[$plan]["productId"];
	    $transactionId  = $billingResArr["trans_id"];

	    $aInsertData['msisdn']        	= "'".$msisdn."'";
	    $aInsertData['plan_id']         = "'".$plan."'";
	    $aInsertData['service_id']    	= "'".$productId."'";
	    $aInsertData['rate']          	= "'".$rate."'";
	    $aInsertData['operator_id']   	= "'2'";
	    $aInsertData['operator_name'] 	= "'OOREDOO_MALDIVES'";
	    $aInsertData['trans_id']      	= "'".$transactionId."'";
	    $aInsertData['promo_id']        = "'".$promo_id."'";
	    $aDBReturn  =   insertTable('billing.tbl_promo_transaction', $aInsertData);
	    $sLog       =   "InsertInput|" . json_encode($aInsertData) . '|InsertReturn|' . json_encode($aDBReturn);
	    commonLogging($sLog, $logFilePath);

	    $aSelect = selectDetails('billing.tbl_promo', 'service_id,plan_id,UA,client_ip,query_string,s2s_id,aff_id', array('id' => ' = '.$promo_id));
	    $sLog =   "Select |" . json_encode($aSelect) . '|SelectReturn|' . json_encode($aSelect);
	    commonLogging($sLog, $logFilePath);

	    $aff_id = $aSelect['data']['aff_id'];
	    $s2s_id = $aSelect['data']['s2s_id'];

	    $aInsertData['msisdn']        	= "'".$sMsisdn."'";
	    $aInsertData['plan_id']         = "'".$aSelect['data']['plan_id']."'";
	    $aInsertData['service_id']    	= "'".$aSelect['data']['service_id']."'";
	    $aInsertData['rate']          	= "'".$sAmountCharged."'";
	    $aInsertData['operator_id']   	= "'2'";
	    $aInsertData['operator_name'] 	= "'OOREDOO_MALDIVES'";
	    $aInsertData['trans_id']      	= "'".$sTransactionId."'";
	    $aInsertData['aff_id']        	= "'".$aSelect['data']['aff_id']."'";
	    $aInsertData['s2s_id'] 			= "'".$aSelect['data']['s2s_id']."'";
	    $aInsertData['query_string']  	= "'".$aSelect['data']['query_string']."'";
	    $aInsertData['client_ip']       = "'".$aSelect['data']['client_ip']."'";
	    $aInsertData['UA']              = "'".$aSelect['data']['UA']."'";
	    $aInsertData['status']          = "'".$billStatus."'";
	    $aInsertData['sub_date']        = "'".date("Y-m-d H:i:s")."'";
	    $aInsertData['added_on']        = "'".date("Y-m-d H:i:s")."'";
	    $aDBReturn  =   insertTable('billing.tbl_s2s', $aInsertData);
	    $sLog       =   "InsertInput|" . json_encode($aInsertData) . '|InsertReturn|' . json_encode($aDBReturn);
	    commonLogging($sLog, $logFilePath);

	    $aSelectS2S = selectDetails('billing.tbl_affiliate_master', 'aff_id,postback_url', array('aff_id' => ' = '.$aff_id));
	    $sLog =   "Select |" . json_encode($aSelect) . '|SelectReturn|' . json_encode($aSelectS2S);
	    commonLogging($sLog, $logFilePath);
	    if(isset($aSelectS2S['data']['postback_url'])) {
	    	$postback_url = $aSelectS2S['data']['postback_url'].$s2s_id;
		    $apiResponse = curlSend($smsApi, '30');
		    $sLog = __FILE__."|".__LINE__."| S2S API => " . $postback_url . " | Response => " . json_encode($apiResponse)."|".$apiResponse["result"] ;
		    commonLogging($sLog,$logFilePath);
	    }
	    
	}
	header("Location:thankyou.php?msg=success");exit;
}
else if($billingResArr["result"]['message'] == "invalidpin") {
	header("Location:otppage.php?msisdn=".$msisdn."&plan=".$plan."&promo_id=".$promo_id."&msg=invalid_pin");exit;
}
else {
	header("Location:thankyou.php?msg=fail");exit;
}

dd($billingRes);
?>