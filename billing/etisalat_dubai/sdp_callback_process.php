<?php

// script to process Etisalat UAE sdp callbacks
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';

function processCallback($sQueueMessage) {

    $logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/etisalat_dubai/sdp_callback_process_" . date('Ymd') . ".log";
    $sLog   = "Consume_Start|".$sQueueMessage;
    commonLogging($sLog, $logPath);
    $smsApi = "https://pt1.etisalat.ae/eticms/ContentPush_Test?login=TimweD2C&pwd=TimweD2C9865&ptype=text&senderid=ShilpaShety";
    $sProductDetails = array(
        '1543' => array("validity" => "+1 day", "rate" => "3.25"),
        '1544' => array("validity" => "+7 day", "rate" => "11"),
        '1545' => array("validity" => "+30 day", "rate" => "30"),
    );
    $sProductDetails['1543'] =  array("validity" => "+1 day","rate" => "325",
                                        "325" =>array("validity" => "+1 day"),
                                        "225" =>array("validity" => "+1 day"),
                                        "125" =>array("validity" => "+1 day"),
                                        "0" =>array("validity" => "+1 day"),
                                        "subSMS" => "Dear Customer. Thank you for subscribing to Shilpa Shetty Fitness Daily. Subscription charge is AED 3.25 per day (VAT Inclusive) after 1 day promotion period is over. To unsubscribe at any time, send C SSFD to 1111. Free trial applicable only for first time subscriber.",
                                        "unsubSMS" => "Dear customer Your subscription to Shilpa Shetty Fitness  Daily has been cancelled. To Resubscribe, please send SSFD to 1111."
                                    );
    $sProductDetails['1544'] =  array("validity" => "+7 day", "rate" => "1100",
                                        "1100" =>array("validity" => "+7 day"),
                                        "1000" =>array("validity" => "+7 day"),
                                        "900" =>array("validity" => "+7 day"),
                                        "800" =>array("validity" => "+7 day"),
                                        "700" =>array("validity" => "+6 day"),
                                        "600" =>array("validity" => "+5 day"),
                                        "500" =>array("validity" => "+4 day"),
                                        "325" =>array("validity" => "+3 day"),
                                        "225" =>array("validity" => "+2 day"),
                                        "125" =>array("validity" => "+1 day"),
                                        "0" =>array("validity" => "+1 day"),
                                        "subSMS" => "Dear Customer. Thank you for subscribing to Shilpa Shetty Fitness Weekly. Subscription charge is AED 11 per week (VAT Inclusive) after 1 day promotion period is over. To unsubscribe at any time, send C SSFW to 1111. Free trial applicable only for first time subscriber.",
                                        "unsubSMS" => "Dear customer Your subscription to Shilpa Shetty Fitness  Weekly has been cancelled. To Resubscribe, please send SSFW to 1111."
                                    );
    $sProductDetails['1545'] =  array("validity" => "+30 day","rate" => "30",
                                        "3000" =>array("validity" => "+30 day"),
                                        "2900" =>array("validity" => "+29 day"),
                                        "2800" =>array("validity" => "+28 day"),
                                        "2700" =>array("validity" => "+27 day"),
                                        "2600" =>array("validity" => "+26 day"),
                                        "2500" =>array("validity" => "+25 day"),
                                        "2400" =>array("validity" => "+24 day"),
                                        "2300" =>array("validity" => "+23 day"),
                                        "2200" =>array("validity" => "+22 day"),
                                        "2100" =>array("validity" => "+21 day"),
                                        "2000" =>array("validity" => "+20 day"),
                                        "1900" =>array("validity" => "+19 day"),
                                        "1800" =>array("validity" => "+18 day"),
                                        "1700" =>array("validity" => "+17 day"),
                                        "1600" =>array("validity" => "+16 day"),
                                        "1500" =>array("validity" => "+15 day"),
                                        "1400" =>array("validity" => "+14 day"),
                                        "1300" =>array("validity" => "+13 day"),
                                        "1200" =>array("validity" => "+12 day"),
                                        "1100" =>array("validity" => "+11 day"),
                                        "1000" =>array("validity" => "+10 day"),
                                        "900" =>array("validity" => "+9 day"),
                                        "800" =>array("validity" => "+8 day"),
                                        "700" =>array("validity" => "+7 day"),
                                        "600" =>array("validity" => "+6 day"),
                                        "500" =>array("validity" => "+5 day"),
                                        "400" =>array("validity" => "+4 day"),
                                        "325" =>array("validity" => "+3 day"),
                                        "225" =>array("validity" => "+2 day"),
                                        "125" =>array("validity" => "+1 day"),
                                        "0" =>array("validity" => "+1 day"),
                                        "subSMS" => "Dear Customer. Thank you for subscribing to Shilpa Shetty Fitness Monthly. Subscription charge is AED 30 per month (VAT Inclusive) after 1 day promotion period is over. To unsubscribe at any time, send C SSFM to 1111. Free trial applicable only for first time subscriber.",
                                        "unsubSMS" => "Dear customer Your subscription to Shilpa Shetty Fitness  Monthly has been cancelled. To Resubscribe, please send SSFM to 1111."
                                    );
    if(isJSON($sQueueMessage)) {
        $json   = $sQueueMessage;
    }
    else {
        $xml    = simplexml_load_string($sQueueMessage);
        $json   = json_encode($xml);
    }
    
    $aParam = json_decode($json, TRUE);

    $sTransactionId = $aParam['transaction_id2'];
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
            $sPlanValidity  = isset($sProductDetails[$sProductId][$sAmountCharged]["validity"]) ? $sProductDetails[$sProductId][$sAmountCharged]["validity"] : $sProductDetails[$sProductId]["validity"];
            $updateArray['expiry_date'] = $sExpiryDate = date("Y-m-d H:i:s", strtotime($sPlanValidity));
            $updateArray['last_successfull_billed_date'] = date("Y-m-d H:i:s");
            $sSngApiStatus = "Success";

            $aSelect1 = selectDetails('billing.tbl_promo_transaction', 'promo_id', array('trans_id' => ' = "'.$sTransactionId.'"'));
            $sLog =   "Select |" . json_encode($aSelect1) . '|SelectReturn|' . json_encode($aSelect1);
            commonLogging($sLog, $logPath);
            if($aSelect1['data']['promo_id']) {
                $aSelect = selectDetails('billing.tbl_promo', 'service_id,plan_id,UA,client_ip,query_string,s2s_id,aff_id', array('id' => ' = '.$aSelect1['data']['promo_id']));
                $sLog =   "Select |" . json_encode($aSelect) . '|SelectReturn|' . json_encode($aSelect);
                commonLogging($sLog, $logPath);

                $aff_id = $aSelect['data']['aff_id'];
                $s2s_id = $aSelect['data']['s2s_id'];

                $aInsertData['msisdn']        	= "'".$sMsisdn."'";
                $aInsertData['plan_id']         = "'".$aSelect['data']['plan_id']."'";
                $aInsertData['service_id']    	= "'".$aSelect['data']['service_id']."'";
                $aInsertData['rate']          	= "'".$sAmountCharged."'";
                $aInsertData['operator_id']   	= "'1'";
                $aInsertData['operator_name'] 	= "'ETISALAT_DUBAI'";
                $aInsertData['trans_id']      	= "'".$sTransactionId."'";
                $aInsertData['aff_id']        	= "'".$aSelect['data']['aff_id']."'";
                $aInsertData['s2s_id'] 		    = "'".$aSelect['data']['s2s_id']."'";
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
        } else {
            $billStatus     = "5";
            $sSngApiStatus  = "GRACE";
            $iRate          = 0;
        }

        $updateArray['type_id']     = "21";
        $updateArray['type_name']   = "SUB";

        $sAction = "sub";
    } 
    elseif (strtolower($sAction) == "ren") {
        $sPlanValidity = isset($sProductDetails[$sProductId][$sAmountCharged]["validity"]) ? $sProductDetails[$sProductId][$sAmountCharged]["validity"] : $sProductDetails[$sProductId]["validity"];
        $updateArray['expiry_date'] = date("Y-m-d H:i:s", strtotime($sPlanValidity));
        $updateArray['last_successfull_billed_date'] = date("Y-m-d H:i:s");

        $sSngApiStatus  = "Success";
        $sAction        = "renew";
        $billStatus     = "2";

        $updateArray['type_id']     = "36";
        $updateArray['type_name']   = "RENEW";
    } 
    elseif (strtolower($sAction) == "unsub") {
        $billStatus                 = "6";
        $sAction                    = "unsub";
        $updateArray['type_id']     = "99";
        $updateArray['type_name']   = "UNSUB";
    }
    
    $updateArray['msisdn']          = $sMsisdn;
    $updateArray['event_id']        = $sProductId;
    $updateArray['rate']            = $sAmountCharged;
    $updateArray['pricepoint_id']   = '';
    $updateArray['status']          = $billStatus;
    $updateArray['operator_id']     = '';
    $updateArray['circle_id']       = '30';
    $updateArray['circle_name']     = 'others';
    $updateArray['service_name']    = '';
    $updateArray['merchant_id']     = '';
    $updateArray['action']          = strtolower($sAction);
    $updateArray['table_name']      = 'billing.etisalat_dubai_subscription';

    if ($updateArray['status'] != '') {
        $userBaseResult = updateUserBase($updateArray);

        $sLog   = __FUNCTION__."|".__LINE__."|" . $sMsisdn . "|" . $sProductId . "|" . $sAmountCharged . "| Update Userbase Response | " . json_encode($updateArray) . "|" . json_encode($userBaseResult);
        commonLogging($sLog, $logPath);

        //insert into txn table
        $txnInsertData['msisdn']        = "'" . $updateArray['msisdn'] . "'";
        $txnInsertData['event_id']      = "'" . $updateArray['event_id'] . "'";        
        $txnInsertData['plan_id']       = "'" . $updateArray['plan_id'] . "'";
        $txnInsertData['trans_id']      = "'" . $sTransactionId . "'";
        $txnInsertData['status']        = "'" . $updateArray['status'] . "'";
        $txnInsertData['type_id']       = "'" . $updateArray['type_id'] . "'";
        $txnInsertData['type_name']     = "'" . $updateArray['type_name'] . "'";
        $txnInsertData['rate']          = "'" . $updateArray['rate'] . "'";
        $txnInsertData['error_code']    = "'" . $aParam["TransactionType"] . "'";
        //$txnInsertData['error_desc']    = "'".addslashes($aParam['result'])."'";

        $txnDBReturn  =   insertTable('billing.etisalat_dubai_txn', $txnInsertData);
        $sLog       =   "Insert Input  = " . json_encode($txnInsertData) . '; Insert Table Return = ' . json_encode($txnDBReturn);

        $sLogStr    =   'Insert Txn Query|'.$sLog;
        commonLogging($sLogStr, $logPath);
            }
    

    if (isset($billStatus) && $billStatus == "2") {
        $transId    = date("YmdHis") . rand(1000, 9999);
        $subStart   = date("Y-m-d H:i:s");
        $subEnd     = date("Y-m-d H:i:s", strtotime($sPlanValidity));
        $amountInAED= $sAmountCharged/100;
        $appApi = "https://app.theshilpashetty.com/api/v1/operators/create-subscription";
        $header = array(
            "Accept: application/json",
            "Access-Token: coDFN6qMEjcuWjNJote52dflgEqFc4UJ"
        );
        $postData = array('user_mobile_no' => substr($sMsisdn,3), 'user_mobile_no_code' => '971', 'subscription_start' => $subStart, 'subscription_end' => $subEnd, 'subscription_price' => $amountInAED, 'subscription_country_code' => 'AE', 'transaction_id' => $transId, 'subscription_channel' => 'WAP', 'transaction_status' => '1');
        $appNotificationResp = curlSend($appApi,5,$postData,'POST',$header);
        $sLog = __FUNCTION__."|".__LINE__."|APP_NOTIFICATION|".$appApi."|".json_encode($postData)."|".json_encode($header)."|".json_encode($appNotificationResp);
        commonLogging($sLog, $logPath);
        $appResp = json_decode($appNotificationResp['result'],true);
        if($appResp['status'] == "200") {
            
        }
        /*
        $msg    = $sProductDetails[$sProductId]["subSMS"];
        $smsApi .= "&msisdn=".$sMsisdn."&msg=".urlencode($msg);
        $smsResp = curlSend($smsApi,5);
        $sLog = __FUNCTION__."|".__LINE__."|SMS_NOTIFICATION|".$smsApi."|".json_encode($smsResp);
        commonLogging($sLog, $logPath);
        */
        $msg = "Thanks for subscribing to Shilpa Shetty App. To Download go to http://onelink.to/gyvtqb .Login with the your registered mobile to start your fitness journey";
        $smsApi .= "&msisdn=".$sMsisdn."&msg=".urlencode($msg);
        $smsResp = curlSend($smsApi,5);
        $sLog = __FUNCTION__."|".__LINE__."|SMS_NOTIFICATION|".$smsApi."|".json_encode($smsResp);
        commonLogging($sLog, $logPath);
        
    }
    else if (isset($billStatus) && $billStatus == "6"){
        $msg    = $sProductDetails[$sProductId]["unsubSMS"];
        $smsApi .= "&msisdn=".$sMsisdn."&msg=".urlencode($msg);
        $smsResp = curlSend($smsApi,5);
        $sLog = __FUNCTION__."|".__LINE__."|SMS_NOTIFICATION|".$smsApi."|".json_encode($smsResp);
        commonLogging($sLog, $logPath);
    }
    return true;
}

?>
