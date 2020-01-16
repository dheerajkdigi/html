<?php

// script to process Virgin Soudi sdp callbacks
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';

/*
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$sQueueName = 'ETISALAT_DUBAI_SDP_CALLBACK';

$rConnection = new AMQPConnection(RQUEUE_138_HOST, RQUEUE_138_PORT, RQUEUE_138_USER_RENEW, RQUEUE_138_PASSWORD_RENEW, RQUEUE_138_VHOST_RENEW);
$rChannel = $rConnection->channel();
$rChannel->queue_declare($sQueueName, false, true, false, false);

date_default_timezone_set('Asia/Calcutta');

$callback = function($msg) {

    global $sQueueName;
    $sLogingPath = '/usr/local/apache/logs/billing/' . date('Y') . '/' . date('m') . '/virgin_saudi/virgin_saudi_sdp_callback_process_' . date("Ymd") . ".log";
    checkLogPath($sLogingPath);

    try {
        $sQueueMessage = $msg->body;
        $aParameter['path'] = $sLogingPath;
        $aParameter['message'] = "Info :|Consumer start|" . date("Y-m-d H:i:s") . "|QueueMessage = " . $sQueueMessage . "|" . $sQueueName . "\n";
        commonLogging($aParameter);

        processCallback($sQueueMessage, $sLogingPath, $sOperator, $sLogFile);
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    } catch (Exception $e) {

        $aParameter['path'] = $sLogingPath;
        $aParameter['message'] = "Error :|Consumer|" . date("Y-m-d H:i:s") . "|" . $sQueueName . "|" . $e->getMessage() . "\n";
        commonLogging($aParameter);
    }
};

$rChannel->basic_qos(null, 1, null);
$rChannel->basic_consume($sQueueName, '', false, false, false, false, $callback);

while (count($rChannel->callbacks)) {
    $rChannel->wait();
}
*/
function processCallback($sQueueMessage) {

    $logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/virgin_saudi/sdp_callback_process_" . date('Ymd') . ".log";
    $sLog   = "Consume_Start|".$sQueueMessage;
    commonLogging($sLog, $logPath);
    $sProductDetails = array(
        '1150' => array("validity" => "+1 day", "rate" => "1",
                        "subSMS" => "You have successfully subscribed in Shilpa Shetty Fitness for 1 SAR/Day. Please click on the link: http://onelink.to/gyvtqb and to unsubscribe at any time, please send U1 to 300304. For Help please send H to 300304",
                        "unsubSMS" => "Your subscription has been canceled in the service Shilpa Shetty Fitness. For Help please send H to 300304"),
        '1151' => array("validity" => "+7 day", "rate" => "5",
                        "subSMS" => "You have successfully subscribed in Shilpa Shetty Fitness for 5 SAR/Week. Please click on the link: http://onelink.to/gyvtqb and to unsubscribe at any time, please send U2 to 300304. For Help please send H to 300304",
                        "unsubSMS" => "Your subscription has been canceled in the service Shilpa Shetty Fitness. For Help please send H to 300304"),
        '1152' => array("validity" => "+30 day", "rate" => "20",
                        "subSMS" => "You have successfully subscribed in Shilpa Shetty Fitness for 20 SAR/Month. Please click on the link: http://onelink.to/gyvtqb and to unsubscribe at any time, please send U3 to 300304. For Help please send H to 300304",
                        "unsubSMS" => "Your subscription has been canceled in the service Shilpa Shetty Fitness. For Help please send H to 300304"),
    );
   
    $xml    = simplexml_load_string($sQueueMessage);
    $json   = json_encode($xml);
    $aParam = json_decode($json, TRUE);

    $sTransactionId = $aParam['transaction_id'];
    $sMsisdn        = $aParam["msisdn"];
    $sProductId     = $aParam["package_id"];
    $sAmountCharged = $aParam["Amount"];
    $sKeyword       = $aParam["keyword"];
    $sMode          = $aParam["Channel"];
    $sAction        = $aParam["TransactionType"];
    $iRate          = $sProductDetails[$sProductId]["rate"];
    

    if (strtolower($sAction) == "sub" || strtolower($sAction) == "sub_fail") {
        if (strtolower($sAction) == "sub") {
            $billStatus     = "2";
            $sPlanValidity  = ($sAmountCharged == 0) ? "+3 day" : $sProductDetails[$sProductId]["validity"];
            $updateArray['expiry_date'] = $sExpiryDate = date("Y-m-d H:i:s", strtotime($sPlanValidity));
            $updateArray['last_successfull_billed_date'] = date("Y-m-d H:i:s");
            $sSngApiStatus = "Success";

        } else {
            $billStatus     = "5";
            $sSngApiStatus  = "GRACE";
            $iRate          = 0;
        }

        $updateArray['type_id']     = "21";
        $updateArray['type_name']   = "SUB";

        $sAction = "sub";
    } elseif (strtolower($sAction) == "ren") {
        $sPlanValidity  = ($sAmountCharged == 0) ? "+3 day" : $sProductDetails[$sProductId]["validity"];
        $updateArray['expiry_date'] = date("Y-m-d H:i:s", strtotime($sPlanValidity));
        $updateArray['last_successfull_billed_date'] = date("Y-m-d H:i:s");

        $sSngApiStatus  = "Success";
        $sAction        = "renew";
        $billStatus     = "2";

        $updateArray['type_id']     = "36";
        $updateArray['type_name']   = "RENEW";
    } elseif (strtolower($sAction) == "unsub") {
        $billStatus                 = "6";
        $sAction                    = "unsub";
        $updateArray['type_id']     = "99";
        $updateArray['type_name']   = "UNSUB";
    }
    /*
    $updateArray['msisdn']          = $sMsisdn;
    $updateArray['event_id']        = $sProductId;
    $updateArray['rate']            = $sAmountCharged;
    $updateArray['pricepoint_id']   = '';
    $updateArray['status']          = $billStatus;
    $updateArray['operator_id']     = '144';
    $updateArray['circle_id']       = '30';
    $updateArray['circle_name']     = 'others';
    $updateArray['service_name']    = '';
    $updateArray['merchant_id']     = '';
    $updateArray['action']          = strtolower($sAction);
    $updateArray['table_name']      = 'etisalat_dubai_subscription';

    if ($updateArray['status'] != '') {
        $userBaseResult = updateUserBase($updateArray);

        $sLog   = __FUNCTION__."|".__LINE__."|" . $sMsisdn . "|" . $sProductId . "|" . $sAmountCharged . "| Update Userbase Response | " . json_encode($updateArray) . "|" . json_encode($userBaseResult);
        commonLogging($sLog, $logPath);
    }
    */

    if (isset($billStatus) && $billStatus == "2") {
        $transId    = date("YmdHis") . rand(1000, 9999);
        $subStart   = date("Y-m-d H:i:s");
        $subEnd     = date("Y-m-d H:i:s", strtotime($sPlanValidity));
        $amountInSA = $sAmountCharged/100;
        $appApi = "https://app.theshilpashetty.com/api/v1/operators/create-subscription";
        $header = array(
            "Accept: application/json",
            "Access-Token: PTWhkmh6vCtTEq5JyHpVomsWWtd4xLHl"
        );
        $postData = array('user_mobile_no' => substr($sMsisdn,3), 'user_mobile_no_code' => '966', 'subscription_start' => $subStart, 'subscription_end' => $subEnd, 'subscription_price' => $amountInSA, 'subscription_country_code' => 'SA', 'transaction_id' => $transId, 'subscription_channel' => 'WAP', 'transaction_status' => '1');
        $appNotificationResp = curlSend($appApi,5,$postData,'POST',$header);
        $sLog = __FUNCTION__."|".__LINE__."|APP_NOTIFICATION|".$appApi."|".json_encode($postData)."|".json_encode($header)."|".json_encode($appNotificationResp);
        commonLogging($sLog, $logPath);
        $appResp = json_decode($appNotificationResp['result'],true);
        if($appResp['status'] == "200") {
            $msg    = $sProductDetails[$sProductId]["subSMS"];
            $smsApi = "http://sdp.altruistindia.com/eticms/ContentPush_Test?login=DigiOsmosis&pwd=DigiOsmo897&ptype=text&senderid=300304&msisdn=".$sMsisdn."&msg=".urlencode($msg);
            $smsResp = curlSend($smsApi,5);
            $sLog = __FUNCTION__."|".__LINE__."|SMS_NOTIFICATION|".$smsApi."|".json_encode($smsResp);
            commonLogging($sLog, $logPath);
        }
    }
    else if (isset($billStatus) && $billStatus == "6"){
        $msg    = $sProductDetails[$sProductId]["unsubSMS"];
        $smsApi = "http://sdp.altruistindia.com/eticms/ContentPush_Test?login=DigiOsmosis&pwd=DigiOsmo897&ptype=text&senderid=300304&msisdn=".$sMsisdn."&msg=".urlencode($msg);
        $smsResp = curlSend($smsApi,5);
        $sLog = __FUNCTION__."|".__LINE__."|SMS_NOTIFICATION|".$smsApi."|".json_encode($smsResp);
        commonLogging($sLog, $logPath);
    }
    return true;
}

?>
