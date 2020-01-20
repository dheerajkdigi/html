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

    $logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/pluto/void/ppu_callback_process_" . date('Ymd') . ".log";
    $sLog   = "Consume_Start|".$sQueueMessage;
    commonLogging($sLog, $logPath);
    $sProductDetails = array(
        'DWAP_VID0015_PPU_PLU01062001' => array("validity" => "+1 day", "rate" => "15",
                        "subSMS" => " You have been charged for Shilpa Shetty Fitness App for 15 Rs/Day. Click: http://onelink.to/gyvtqb and login with your registered mobile no to access the app",
                        "unsubSMS" => ""),
    );
   
    $aParam = json_decode($sQueueMessage, TRUE);

    $sTransactionId = $aParam['TRXID'];
    $sMsisdn        = substr($aParam["msisdn"],-10);
    $sProductId     = $aParam["ServiceID"];
    $sAmountCharged = $aParam["Amount"];

    $sAction        = "sub";
    $StatusCode     = trim($aParam["StatusCode"]);
    $iRate          = $sProductDetails[$sProductId]["rate"];
    

    if (strtolower($sAction) == "sub" && $StatusCode == "500") {
        if (strtolower($StatusCode) == "500") {
            $billStatus     = "2";
            $sPlanValidity  = $sProductDetails[$sProductId]["validity"];
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
            "Access-Token: mEPV0lzfdiDOmxy1H6naf6xVpoq84uEA"
        );
        $postData = array('user_mobile_no' => $sMsisdn, 'user_mobile_no_code' => '91', 'subscription_start' => $subStart, 'subscription_end' => $subEnd, 'subscription_price' => $sAmountCharged, 'subscription_country_code' => 'IN', 'transaction_id' => $transId, 'subscription_channel' => 'WAP', 'transaction_status' => '1');
        $appNotificationResp = curlSend($appApi,5,$postData,'POST',$header);
        $sLog = __FUNCTION__."|".__LINE__."|APP_NOTIFICATION|".$appApi."|".json_encode($postData)."|".json_encode($header)."|".json_encode($appNotificationResp);
        commonLogging($sLog, $logPath);
        $appResp = json_decode($appNotificationResp['result'],true);
        $msg    = $sProductDetails[$sProductId]["subSMS"];
            $smsApi = "http://amyntas4sms.in/submitsms.jsp?user=SSKAPP&key=2ae2dbb406XX&mobile=+91".$sMsisdn."&message=".urlencode($msg)."&senderid=SSKAPP&accusage=1";
            $smsResp = curlSend($smsApi,5);
            $sLog = __FUNCTION__."|".__LINE__."|SMS_NOTIFICATION|".$smsApi."|".json_encode($smsResp);
            commonLogging($sLog, $logPath);
        /*
        if($appResp['status'] == "200") {
            $msg    = $sProductDetails[$sProductId]["subSMS"];
            $smsApi = "http://amyntas4sms.in/submitsms.jsp?user=SSKAPP&key=2ae2dbb406XX&mobile=+91".$sMsisdn."&message=".urlencode($msg)."&senderid=SSKAPP&accusage=1";
            $smsResp = curlSend($smsApi,5);
            $sLog = __FUNCTION__."|".__LINE__."|SMS_NOTIFICATION|".$smsApi."|".json_encode($smsResp);
            commonLogging($sLog, $logPath);
        }
        */
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
