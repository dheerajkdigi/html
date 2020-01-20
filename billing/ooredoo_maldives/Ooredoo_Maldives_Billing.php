<?php

/*
Aggregator Timwe
*/
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';

class Ooredoo_Maldives_Billing {

    function __construct() {
        //Subscription Table
        $this->subTableName = 'billing.ooredoo_maldives_subscription';
        $this->otpTableName = 'billing.ooredoo_maldives_otp';
        $this->operatorName = 'ooredoo_maldives';

        $this->sMicroLogFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_maldives/ooredoo_maldives_micro_billing_' . date('Ymd') . '.log';

        $this->aProductDetails['daily']     = array('productId'=>'10207', 'planId'=>'480355', 'validity' => '+1 day', 'rate' => '2', 'planName' => 'Shilpa Shetty Fitness App Daily', 'subKeyword'=>'SUB SSD', 'unsubKeyword'=> 'UNSUB SSD', 'subSMS' => 'You have successfully subscribed to Shilpa Shetty App for 2 MVR/Day.To download click http://bit.ly/344pMbr . Kindly login with your registered mobile no.', 'unsubSMS'=>'Dear Customer,We are sorry to see you leave! Your daily subscription to Shilpa Shetty App has been cancelled. Plz do share us your experience to serve u better');
        $this->aProductDetails['weekly']    = array('productId'=>'10209', 'planId'=>'480365', 'validity' => '+7 day', 'rate' => '15', 'planName' => 'Shilpa Shetty Fitness App Weekly', 'subKeyword'=>'SUB SSW', 'unsubKeyword'=> 'UNSUB SSW', 'subSMS' => 'You have successfully subscribed to Shilpa Shetty App for 15 MVR/Week.To download click http://bit.ly/344pMbr . Kindly login with your registered mobile no.', 'unsubSMS'=>'Dear Customer,We are sorry to see you leave! Your weekly subscription to Shilpa Shetty App has been cancelled.Plz do share us your experience to serve u better');
        $this->aProductDetails['monthly']   = array('productId'=>'10211', 'planId'=>'480375', 'validity' => '+30 day', 'rate' => '40', 'planName' => 'Shilpa Shetty Fitness App Monthly', 'subKeyword'=>'SUB SSM', 'unsubKeyword'=> 'UNSUB SSM', 'subSMS' => 'You have successfully subscribed to Shilpa Shetty App for 40 MVR/Month.To download click http://bit.ly/344pMbr . Kindly login with your registered mobile no.', 'unsubSMS'=>'Dear Customer,We are sorry to see you leave! Your monthly subscription to Shilpa Shetty App has been cancelled.Plz do share us your experience to serve u better');

        $this->shortCode        = '4356';
        $this->currency         = 'MVR';
        $this->Password         = 'ssktim1';
        $this->PartnerRoleId    = '2055';
        $this->mtFreePricePoint = '480345';

        checkLogPath($this->sMicroLogFilePath);
    }

    function charge($paramArray) {
        //Default Values
        $this->sStartTime           = microtime(true);
        $this->transactionId        = date("YmdHis") . rand(1000, 9999);
        $this->errorCode            = 'SS999';
        $this->sErrorMessage        = 'Unknown Error';
        $this->sErrorDescription    = '';
        $this->sOperatorErrorCode   = '';
        $this->updateUserBase       = false;
        //
        $this->sMsisdn          = ($paramArray['msisdn']) ? "960".$paramArray['msisdn'] : "";
        $this->sPlanId          = trim($paramArray['plan']);
        $this->sRate            = trim($paramArray['rate']);
        $this->sAction          = strtoupper(trim($paramArray['action']));
        $this->sOther1          = strtolower(trim($paramArray['other1']));
        $this->sOther2          = strtolower(trim($paramArray['other2']));
        //
        $this->aProductDetail   = $this->aProductDetails[$this->sPlanId];
        $this->sProductId       = $this->aProductDetail['productId'];
        $this->sPricePointId    = $this->aProductDetail['planId'];
        $this->sRate            = $this->aProductDetail['rate'];
        $this->sValidity        = $this->aProductDetail['validity'];
        $this->sPlanName        = $this->aProductDetail['planName'];
        
        $jsonParam  = json_encode($paramArray);
        $sLog       = "Input Parameter : " . json_encode($paramArray);
        commonLogging($sLog,$this->sMicroLogFilePath);

        $this->sTnb = (strtolower($paramArray['other1']) == 'tnb' || strtolower($paramArray['other1']) == 'tnbsms') ? true : false;

        if (strtolower($paramArray['action'] == 'renew')) {
            list($this->sSubscriptionId, $this->sUserCurrentStatus, $this->sUserStatus, $pricepointId) = $paramArray['other2'] ? explode('|', $paramArray['other2']) : array('', '');
            $paramArray['opt_event_id'] = $pricepointId;
        }

        if ($this->sMsisdn == '' || $this->sPlanId == '') {
            $this->errorCode        = 'SS400';
            $this->sErrorMessage    = 'Bad Request';
            /*
            $sFinalResponse = array(
                'msisdn' => $this->sMsisdn,
                'amount' => $paramArray['rate'],
                'trans_id' => date('YmdHis'),
                'result' => array('status' => 'FAIL', 'code' => 'SS400', 'message' => 'Bad Request'),
                'operator' => array('name' => 'ooredoo_maldives', 'circle' => 'others'),
            );
            */
        } else {

            switch ($this->sAction) {
                case 'SUB' :
                    if($this->isBlacklisted()) {
                        $this->errorCode        = 'SSH403';
                        $this->sErrorMessage    = 'MSISDN Blocked.';
                        break;
                    }
                    if ($this->subUnderLimit($sProductId)) {
                        if($this->sOther1 == "send_otp"){
                            $this->send_otp();
                        }
                        else if($this->sOther1 == "verify_otp"){
                            $this->verify_otp();
                        }
                        else{
                            //$sFinalResponse = $this->subscription();
                        }
                        
                    }
                    else {
                        $this->errorCode        = 'SS234';
                        $this->sErrorMessage    = 'Max Subscription Limit Reached.';
                        /*
                        $sFinalResponse = array(
                        'msisdn' => $this->sMsisdn,
                        'amount' => $paramArray['rate'],
                        'trans_id' => date('YmdHis'),
                        'result' => array('status' => 'FAIL', 'code' => 'SS234', 'message' => 'Max Subscription Limit Reached.'),
                        'operator' => array('name' => 'ooredoo_maldives', 'circle' => 'others'),
                        );
                        */
                    }
                    break;
                case 'RENEW':
                    $sFinalResponse = $this->renewal();
                    break;
                case 'UNSUB' :
                    $sFinalResponse = $this->unsubscription();
                    break;
                case 'STATUS':
                    if($this->isAlreadySubscribed() == 1){
                        $this->errorCode    = "SS101";
                        $this->sErrorMessage= "Already Subscribed";
                    }
                    else{
                        $this->errorCode    = "SS999";
                        $this->sErrorMessage= "InActive";
                    }
                    break;
            }
            /*
            if ($paramArray['action'] == 'sub') {
                if ($this->subUnderLimit($sProductId)) {
                    $sFinalResponse = $this->subscription($paramArray);
                }
                else {
                    $sFinalResponse = array(
                    'msisdn' => $this->sMsisdn,
                    'amount' => $paramArray['rate'],
                    'trans_id' => date('YmdHis'),
                    'result' => array('status' => 'FAIL', 'code' => 'SS234', 'message' => 'Max Subscription Limit Reached.'),
                    'operator' => array('name' => 'ooredoo_maldives', 'circle' => 'others'),
                    );
                }
            } elseif ($paramArray['action'] == 'unsub') {
                $sFinalResponse = $this->unsubscription($paramArray);
            } elseif ($paramArray['action'] == 'renew' || $paramArray['action'] == 'parking') {
                $sFinalResponse = $this->renewal($paramArray);
            }
            */
            
            if ($this->updateUserBase) {
                $this->callDBEntry($paramArray, $sFinalResponse);
            }
            
        }
        if($this->isInvalidPin){
            $this->errorCode        = "SS199";
            $this->sErrorMessage    = "invalidpin";
        }

        $this->sStatus = in_array($this->errorCode, array('SS000','SS101','SS001')) ? 'OK' : 'FAIL';
        $aData = array('msisdn' => $this->sMsisdn, 'amount' => $this->sRate, 'trans_id' => $this->transactionId, 'result' => array('status' => $this->sStatus, 'code' => $this->errorCode, 'message' => $this->sErrorMessage), 'url' => $this->sUrl, 'operator' => array('name' => $this->operatorName, 'circle' => 'others'));
        $json_data = json_encode($aData);

        $sLog = "Final Response|Json Data = " . $json_data;
        commonLogging($sLog,$this->sMicroLogFilePath);

        return $json_data;
    }

    private function send_otp() {
        $otp            = rand(1111,9999);
        $otpText        = "Your OTP for Shilpa Shetty Fitness APP is: ".$otp;
        $smsResponse    = $this->sendSMS($otpText);
        $sLog = __FUNCTION__."|".__LINE__."|".$this->sMsisdn."|".$this->sProductId.'|insertTable => ' . $otpText . '| Response =>' . $smsResponse;

        commonLogging($sLog, $this->sMicroLogFilePath);
        
        if ($smsResponse) {
            
            $this->errorCode    = $this->status = 'SS001';
            $this->sErrorMessage= $this->response = $this->sDescription = "OTP Sent Successfullly.";
            $this->bUpadateBase = false;
            
            $aInputValue['msisdn']  = "'".$this->sMsisdn."'";
            $aInputValue['plan']    = "'".$this->sPlanId."'";
            $aInputValue['otp']     = "'".$otp."'";
            $aDBInsertReturn        = insertTable($this->otpTableName, $aInputValue);

            $sInsertLog = __FUNCTION__."|".__LINE__.'|Insert OTP => ' . json_encode($aDBInsertReturn);
            
            //commonLogging($aLoggingArray);
            commonLogging($sInsertLog,$this->sMicroLogFilePath);
            
        } else {
            $this->errorCode    = $this->status = 'SS199';
            $this->sErrorMessage = $this->response = $this->sDescription = "OTP not sent.";
        }
    }

    private function verify_otp() {
       
        $aSelect = selectDetails($this->otpTableName, 'id, created_at', array('plan' => " = '" . $this->sPlanId . "'", 'msisdn' => " = '" . $this->sMsisdn . "'", 'otp' => " = '" . $this->sOther2 . "'"), 'order by id desc');

        $sLog = __FUNCTION__ . "|" . __LINE__ . "|" . 'Select OTP => ' . json_encode($aSelect);

        commonLogging($sLog, $this->sMicroLogFilePath);

        $otpMatched = ($aSelect['data']['id']) ? true : false;
        if($otpMatched){
            $sLog = __FUNCTION__ . "|" . __LINE__ . "|" . 'OTP_VERIFIED';
            commonLogging($sLog, $this->sMicroLogFilePath);
            $this->subscription();
        }
        else{
            $this->errorCode        = "SS199";
            $this->sErrorMessage    = "invalidpin";
            $this->isInvalidPin = true;
            $this->subscription();
        }

    }

    function subscription() {
        $aResponse = $this->subscribeUser();
        $sLog = __FUNCTION__."|".__LINE__."|".json_encode($aResponse);
        commonLogging($sLog, $this->sMicroLogFilePath);

        if (($this->errorCode == "SS000" || $this->errorCode == "SS101") && !$this->sTnb) {
            $isSubscribed = $this->isAlreadySubscribed();
            //$isSubscribed = 3;
            if ($isSubscribed == 3) {
                $response = $this->chargeUser();
                if($this->errorCode == 'SS000'){
                    $this->sendSMS($this->aProductDetail['subSMS']);
                }
            } else if ($isSubscribed == 2) {
                $this->errorCode    = 'SS199';
                $this->sErrorMessage= 'Failed at Operator';
            } else {
                $this->errorCode    = 'SS101';
                $this->sErrorMessage= 'Already Subscribed';
            }
        } elseif ($this->sTnb && ($this->errorCode == "SS000" || $this->errorCode == "SS101")) {
            $this->errorCode    = 'SS000';
            $this->sErrorMessage= 'Success';
        } else {
            $this->errorCode    = 'SS199';
            $this->sErrorMessage= 'Failed at Operator (Unknown Error)';
        }

        return $returnArray;
    }

    function unsubscription() {
        
        if ($this->isNumExist($paramArray)) {
            if ($this->isAlreadyUnsubscribed($paramArray)) {
                $this->errorCode = 'SS102';
                $this->sErrorMessage = 'Already Unsubscribed';
                $this->updateUserBase = false;
                $returnArray = array(
                    'msisdn' => $this->sMsisdn,
                    'amount' => $paramArray['rate'],
                    'trans_id' => $this->transactionId,
                    'result' => array('status' => 'FAIL', 'code' => 'SS102', 'message' => 'Already Unsubscribed'),
                    'operator' => array('name' => 'ooredoo_maldives', 'circle' => 'others'),
                );

                return $returnArray;
            }
        } else {
            $this->updateUserBase = false;
            $this->errorCode = 'SS403';
            $this->sErrorMessage = 'Forbidden';
            $returnArray = array(
                'msisdn' => $this->sMsisdn,
                'amount' => $paramArray['rate'],
                'trans_id' => $this->transactionId,
                'result' => array('status' => 'FAIL', 'code' => 'SS403', 'message' => 'Forbidden'),
                'operator' => array('name' => 'ooredoo_maldives', 'circle' => 'others'),
            );

            return $returnArray;
        }
        
        if($this->sOther1 == "callback") {
            $this->errorCode        = 'SS000';
            $this->sErrorMessage    = 'Success';
            $this->updateUserBase   = true;
            $this->sendSMS($this->aProductDetail['unsubSMS']);
            return true; 
        }
        $sLog = __FUNCTION__."|".__LINE__."|unsubscription Url = " . $unsubUrl . '; fileds = ' . $sUnsubscribeField . ';  response = ' . $sCurlResponse;
        commonLogging($sLog,$this->sMicroLogFilePath);
        $oResponse = simplexml_load_string($sCurlResponse['result']);

        $sStartTime = microtime(true);
        $unsubUrl = "http://mb.timwe.com/neo-mb-sub-facade/moma/unsubscribe?";
        $sUnsubscribeField = 'PartnerRoleId='.$this->PartnerRoleId.'&Password='.$this->Password.'&CountryId=960&Msisdn=' . $this->sMsisdn . '&OpId=1040&ProductId=' . $this->sProductId . '&Keyword=stop';
        $sStartTimelog = date('Y-m-d H:i:s');
        $sCurlResponse = curlSend($unsubUrl . $sUnsubscribeField, '180');
        $sEndTime = date('Y-m-d H:i:s');

        $sLog = __FUNCTION__."|".__LINE__."|unsubscription Url = " . $unsubUrl . '; fileds = ' . $sUnsubscribeField . ';  response = ' . json_encode($sCurlResponse);
        commonLogging($sLog,$this->sMicroLogFilePath);
        $oResponse = simplexml_load_string($sCurlResponse['result']);

        if ($oResponse && $oResponse->response->responsestatus->code && $oResponse->response->responsestatus->code === '1') {//success
            $this->errorCode = 'SS000';
            $this->sErrorMessage = 'Success';
            $errorCode = 'SS000';
            $aLoggingArray['path'] = $this->sBillingSuccessLog;
            $this->updateUserBase       = true;
            $this->sendSMS($this->aProductDetail['unsubSMS']);
        } else if ($oResponse && $oResponse->response->responsestatus->description && strtolower($oResponse->response->responsestatus->description) == 'success') {//success
            $this->errorCode = 'SS000';
            $this->sErrorMessage = 'Success';
            $errorCode = 'SS000';
            $billStatus = "OK";
            $billMessage = "Success";
            $aLoggingArray['path'] = $this->sBillingSuccessLog;
            $this->updateUserBase       = true;
            $this->sendSMS($this->aProductDetail['unsubSMS']);
        } else if ($oResponse && $oResponse->response->responsestatus->code && $oResponse->response->responsestatus->code == '-77') {
            $this->errorCode = 'SS102';
            $this->sErrorMessage = 'Already Unsubscribed';
            $errorCode = "SS102";
            $billStatus = "OK";
            $billMessage = "Success";
            $aLoggingArray['path'] = $this->sBillingSuccessLog;
            $sErrorMessage = $oResponse->response->responsestatus->description;
            $this->updateUserBase       = true;
        } else {
            $this->errorCode = 'SS199';
            $this->sErrorMessage = 'Failed at Operator';
            $errorCode = "SS199";
            $billStatus = "FAIL";
            $billMessage = "Failed at Operator";
            $sErrorMessage = $oResponse->response->responsestatus->description;
            $aLoggingArray['path'] = $this->sBillingFailureLog;
        }
        $returnArray = array(
            'msisdn' => $this->sMsisdn,
            'amount' => $paramArray['rate'],
            'trans_id' => $this->transactionId,
            'result' => array('status' => $billStatus, 'code' => $errorCode, 'message' => $billMessage),
            'operator' => array('name' => 'ooredoo_maldives', 'circle' => 'others'),
        );

        return $returnArray;
    }

    function renewal() {

        $response = $this->chargeUser();
        $this->errorCode = $response['error_code'];
        $returnArray = array(
            'msisdn' => $this->sMsisdn,
            'amount' => $paramArray['rate'],
            'trans_id' => $this->transactionId,
            'result' => array('status' => $response['status'], 'code' => $response['error_code'], 'message' => $response['error_msg']),
            'operator' => array('name' => 'ooredoo_maldives', 'circle' => 'others'),
        );
        $sLog = __FUNCTION__."|".__LINE__.'Id = ' . $this->sSubscriptionId . '; $this->sUserCurrentStatus = ' . $this->sUserCurrentStatus."|".$response['status'];
        commonLogging($sLog,$this->sMicroLogFilePath);
        return $returnArray;
    }

    function chargeUser() {
        $sStartTime = microtime(true);
        $aErrorCodeDescription = array();
        $aErrorCodeDescription['1']     = 'Success';
        $aErrorCodeDescription['0']     = 'General Error';
        $aErrorCodeDescription['-10']   = 'Duplicate ExtTxId';
        $aErrorCodeDescription['10']    = 'Duplicate ExtTxId';
        $aErrorCodeDescription['-81']   = 'User not subscribed for your service/club';
        $aErrorCodeDescription['81']    = 'User not subscribed for your service/club';
        $aErrorCodeDescription['-1101'] = 'Charging operation failed, the charge was not applied';
        $aErrorCodeDescription['1101']  = 'Charging operation failed, the charge was not applied';
        $aErrorCodeDescription['-1102'] = 'User profile not found';
        $aErrorCodeDescription['1102']  = 'Charging operation failed, the charge was not applied';
        $aErrorCodeDescription['-1106'] = 'Ticket not consumed';
        $aErrorCodeDescription['1106']  = 'Ticket not consumed';
        $aErrorCodeDescription['-1108'] = 'Billing Failed at operator end';
        $aErrorCodeDescription['1108']  = 'Billing Failed at operator end';
        $aErrorCodeDescription['-1122'] = 'Insufficient amount';
        $aErrorCodeDescription['1122']  = 'Insufficient amount';
        $aErrorCodeDescription['-1124'] = 'Invalid MSISDN';
        $aErrorCodeDescription['1124']  = 'Invalid MSISDN';
        $aErrorCodeDescription['-1125'] = 'Unknown Error';
        $aErrorCodeDescription['1125']  = 'Unknown Error';

        $sBillingUrl    = 'http://mb.timwe.com/neo-billing/moma/doCharge';
        $sBillingFields = "PartnerRoleId=".$this->PartnerRoleId."&Password=".$this->Password."&ProductId=" . $this->sProductId . "&PricePointId=" . $this->sPricePointId . "&Destination=" . $this->sMsisdn . "&OpId=1040&ExtTxId=" . $this->transactionId;
        $sStartTimelog  = date('Y-m-d H:i:s');
        $url = $sBillingUrl . '?' . $sBillingFields;
        $sBillingCurlResponse = curlSend($url, '180');
        $sEndTime       = date('Y-m-d H:i:s');

        $sLog = __FUNCTION__."|".__LINE__."|Billing Url = " . $url . '|Response = ' . json_encode($sBillingCurlResponse);
        commonLogging($sLog,$this->sMicroLogFilePath);
        $sBillingCurlResponse = $sBillingCurlResponse['result'];
        if (stristr($sBillingCurlResponse, ",")) {
            list($iTid, $iErrorCode) = explode(",", $sBillingCurlResponse);
        } else {
            $iErrorCode = $sBillingCurlResponse;
            $iTid       = '';
        }
        $iTid = trim($iTid);
        $iErrorCode = trim($iErrorCode);

        $this->operatorErrorCode = $iErrorCode;

        if ($iErrorCode && $iErrorCode == 1) {
            $this->errorCode = 'SS000';
            $this->sErrorMessage = 'Success';
            $errorCode = 'SS000';
            $status = 'OK';
            $sErrorMessage = 'Success';
            $aLoggingArray['path'] = $this->sBillingSuccessLog;
            $this->updateUserBase       = true;
            $this->notifyApp();
        } else if ($iErrorCode && $iErrorCode == '-1106') {
            $this->errorCode = 'SS100';
            $this->sErrorMessage = 'Ticket Not Consumed';
            $errorCode = 'SS100';
            $status = 'FAIL';
            $sErrorMessage = 'Ticket Not Consumed';
            $aLoggingArray['path'] = $this->sBillingFailureLog;
        } else if ($iErrorCode && ($iErrorCode == -1122 || $iErrorCode == 1122)) {
            $this->errorCode    = 'SS100';
            $this->sErrorMessage = 'Insufficient Fund';
            $errorCode = 'SS100';
            $status = 'FAIL';
            $sErrorMessage = 'Insufficient Fund';
            $aLoggingArray['path'] = $this->sBillingFailureLog;
        } else {
            $this->errorCode        = 'SS199';
            $this->sErrorMessage    = $aErrorCodeDescription[$iErrorCode] ? $aErrorCodeDescription[$iErrorCode] : 'Failed At Operator (Unknown Error)';
            $errorCode = 'SS199';
            $status = 'FAIL';
            $sErrorMessage = $aErrorCodeDescription[$iErrorCode] ? $aErrorCodeDescription[$iErrorCode] : 'Failed At Operator (Unknown Error)';
            $aLoggingArray['path'] = $this->sBillingFailureLog;
        }
        //Hit UNSUB API in case of charging failed
        if($this->errorCode != 'SS000') {
            $unsubUrl = "http://mb.timwe.com/neo-mb-sub-facade/moma/unsubscribe?";
            $sUnsubscribeField = 'PartnerRoleId='.$this->PartnerRoleId.'&Password='.$this->Password.'&CountryId=960&Msisdn=' . $this->sMsisdn . '&OpId=1040&ProductId=' . $this->sProductId . '&Keyword=stop';
            $sStartTimelog = date('Y-m-d H:i:s');
            $sCurlResponse = curlSend($unsubUrl . $sUnsubscribeField, '180');
            $sEndTime = date('Y-m-d H:i:s');

            $sLog = __FUNCTION__."|".__LINE__."|unsubscription Url = " . $unsubUrl . '; fileds = ' . $sUnsubscribeField . ';  response = ' . json_encode($sCurlResponse);
            commonLogging($sLog,$this->sMicroLogFilePath);
        }

        $aReturnArray['error_code'] = $errorCode;
        $aReturnArray['error_msg'] = $sErrorMessage;
        $aReturnArray['status'] = $status;

        return $aReturnArray;
    }

    private function subscribeUser() {
        $sStartTime = microtime(true);
        $subUrl = "http://mb.timwe.com/neo-mb-sub-facade/moma/subscribe?";
        $sSubscribeField = 'PartnerRoleId='.$this->PartnerRoleId.'&Password='.$this->Password.'&Msisdn=' . $this->sMsisdn . '&OpId=1040&BuyChannel=WAP&ProductId=' . $this->sProductId . '&CountryId=960&TextVariant=8&TrackingId=9&Ip=1.2.3.4';
        $url = $subUrl . $sSubscribeField;
        $sStartTimelog = date('Y-m-d H:i:s');
        $sCurlResponse = curlSend($subUrl . $sSubscribeField, '180');
        $sEndTime = date('Y-m-d H:i:s');

        $sLog = __FUNCTION__."|".__LINE__."|Url = " . $url . '; fields = ' . $sSubscribeField . ';  response = ' . json_encode($sCurlResponse);
        commonLogging($sLog,$this->sMicroLogFilePath);

        $oResponse = simplexml_load_string($sCurlResponse['result']);
        if ($oResponse && $oResponse->response->responsestatus->code && $oResponse->response->responsestatus->code === '1') {//success
            $this->errorCode = 'SS000';
            $this->sErrorMessage = 'Success';
            $errorCode = 'SS000';
            $aLoggingArray['path'] = $this->sBillingSuccessLog;
        } else if ($oResponse && $oResponse->response->responsestatus->description && strtolower($oResponse->response->responsestatus->description) == 'success') {//success
            $this->errorCode = 'SS000';
            $this->sErrorMessage = 'Success';
            $errorCode = 'SS000';
            $aLoggingArray['path'] = $this->sBillingSuccessLog;
        } else if ($oResponse && $oResponse->response->responsestatus->code && $oResponse->response->responsestatus->code == '-72') {
            $this->errorCode = 'SS101';
            $this->sErrorMessage = $oResponse->response->responsestatus->description;
            $errorCode = "SS101";
            $aLoggingArray['path'] = $this->sBillingSuccessLog;
            $sErrorMessage = $oResponse->response->responsestatus->description;
        } else if ($oResponse && $oResponse->response->responsestatus->code && $oResponse->response->responsestatus->code == '-12') {
            $this->errorCode = 'SS104';
            $this->sErrorMessage = $oResponse->response->responsestatus->description;
            $errorCode = "SS104";
            $sErrorMessage = $oResponse->response->responsestatus->description;
            $aLoggingArray['path'] = $this->sBillingFailureLog;
        } else {
            $this->errorCode = 'SS199';
            $this->sErrorMessage = $oResponse->response->responsestatus->description;
            $errorCode = "SS199";
            $sErrorMessage = $oResponse->response->responsestatus->description;
            $aLoggingArray['path'] = $this->sBillingFailureLog;
        }
        $this->operatorErrorCode = $oResponse->response->responsestatus->code;

        $aReturnArray['error_code'] = $errorCode;
        $aReturnArray['error_msg'] = $sErrorMessage;

        return $aReturnArray;
    }

    private function isAlreadySubscribed() {
        $sStartTime = microtime(true);
        $isSubscribed = 3;

        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'", 'status' => " = '2'", 'expiry_date' => "> now()"));

        $sLog = __FUNCTION__."|".__LINE__."Select  = " . json_encode($aSelect);
        commonLogging($sLog,$this->sMicroLogFilePath);

        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isSubscribed = 1;
        } else if ($aSelect['status'] == 'failed' || !isset($aSelect) || empty($aSelect)) {
            $isSubscribed = 2;
        }

        return $isSubscribed;
    }

    private function isNumExist($paramArray) {
        //return true;
        $isNumExist = false;

        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'"));

        $sLog = __FUNCTION__."|".__LINE__."|Select  = " . json_encode($aSelect);
        commonLogging($sLog,$this->sMicroLogFilePath);

        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isNumExist = true;
        }

        return $isNumExist;
    }

    private function isAlreadyUnsubscribed($paramArray) {
        //return $isAlreadyUnsubscribed = false;
        
        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'", 'status' => " = '6'", 'pricepoint_id' => " = '".$this->sPlanId."'"));

        $sLog = __FUNCTION__."|".__LINE__."|Select  = " . json_encode($aSelect);
        commonLogging($sLog,$this->sMicroLogFilePath);

        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isAlreadyUnsubscribed = true;
        }

        return $isAlreadyUnsubscribed;
    }

    private function callDBEntry($paramArray, $aResponseArray) {

        $sStartTime = microtime(true);
        $updateArray = array();
        $billingExpDate = '';

        if ($paramArray['action'] == 'sub') {
            $tableFinalAction = 'sub';

            
            $sTableStatus = 1;
            if ($this->errorCode == 'SS000') {
                $typeId = 21;
                $successFulBill = date('Y-m-d H:i:s');
                $sTableStatus = 2;
                $billingExpDate = date('Y-m-d H:i:s', strtotime($this->sValidity));

                if ($this->sTnb) {
                    $billingExpDate = date('Y-m-d H:i:s', strtotime('+2 day'));
                }
                else{
                    $updateArray['start_date'] = date('Y-m-d H:i:s');
                }
            }
        } elseif ($paramArray['action'] == 'renew') {
            $tableFinalAction = 'renew';

            $typeId = 36;
            $sTableStatus = 5;
            if ($this->errorCode == 'SS000') {
                $sTableStatus = 2;
                $successFulBill = date('Y-m-d H:i:s');
                $billingExpDate = date('Y-m-d H:i:s', strtotime($this->sValidity));
            }
        } elseif ($paramArray['action'] == 'unsub' && ($this->errorCode == 'SS000' || ($this->errorCode == 'SS102' && $aResponseArray['result']['status'] == "OK") )) {
            $tableFinalAction = 'unsub';
            $typeId = 99;
            $sTableStatus = 6;
            $updateArray['deactivation_date'] = date('Y-m-d H:i:s');
        }

        if(!$typeId){
            return false;
        }
        $eventId = $this->sPlanId;

        $updateArray['msisdn'] = $this->sMsisdn;
        $updateArray['event_id'] = $eventId;
        $updateArray['pricepoint_id'] = $this->sPlanId;
        
        $updateArray['expiry_date'] = $billingExpDate;
        $updateArray['last_successfull_billed_date'] = $successFulBill;
        $updateArray['status'] = $sTableStatus;
        $updateArray['type_id'] = $typeId;
        $updateArray['type_name'] = ($this->sTnb) ? 'TNBSUB' : $tableFinalAction;
        $updateArray['rate'] = $this->sRate;
        $updateArray['operator_id'] = '154';
        $updateArray['operator_name'] = 'ooredoo_maldives';
        $updateArray['circle_id'] = '30';
        $updateArray['circle_name'] = 'others';
        $updateArray['service_name'] = '';
        $updateArray['merchant_id'] = $paramArray['merchant_id'];
        $updateArray['error_code'] = $this->operatorErrorCode;
        $updateArray['billing_response_code'] = $this->errorCode;
        $updateArray['client_type'] = $paramArray['client_type'];
        $updateArray['action'] = $tableFinalAction;
        $updateArray['table_name'] = $this->subTableName;

        if ($sTableStatus == 1) {
            $sSubParkDate = date('Y-m-d H:i:s', strtotime("+ 30 days"));
            $updateArray['sub_parking_date'] = $sSubParkDate;
        }

        $userbaseResult = updateUserBase($updateArray);

        $aLoggingArray['path'] = $this->sMicroLogFilePath;
        $aLoggingArray['message'] = date('Y-m-d H:i:s') . "|" . $this->sMsisdn . "| PT " . substr(microtime(true) - $sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' | Update Base Parameters ' . json_encode($updateArray) . " | " . $userbaseResult . "\n";
        //commonLogging($aLoggingArray);
        $sLog = __FUNCTION__."|".__LINE__."|Update Base Parameters " . json_encode($updateArray) . "|" . $userbaseResult;
        commonLogging($sLog,$this->sMicroLogFilePath);

        //insert into txn table
        $txnInsertData['msisdn']        = "'" . $updateArray['msisdn'] . "'";
        $txnInsertData['event_id']      = "'" . $updateArray['event_id'] . "'";        
        $txnInsertData['plan_id']       = "'" . $updateArray['plan_id'] . "'";
        $txnInsertData['trans_id']      = "'" . $this->transactionId . "'";
        $txnInsertData['status']        = "'" . $updateArray['status'] . "'";
        $txnInsertData['type_id']       = "'" . $updateArray['type_id'] . "'";
        $txnInsertData['type_name']     = "'" . $updateArray['type_name'] . "'";
        $txnInsertData['rate']          = "'" . $updateArray['rate'] . "'";
        $txnInsertData['error_code']    = "'" . $updateArray["error_code"] . "'";
        //$txnInsertData['error_desc']    = "'".addslashes($aParam['result'])."'";

        $txnDBReturn  =   insertTable('billing.ooredoo_maldives_txn', $txnInsertData);
        $sLog       =   "Insert Txn Query|Insert Input  = " . json_encode($txnInsertData) . '; Insert Table Return = ' . json_encode($txnDBReturn);
        commonLogging($sLog, $this->sMicroLogFilePath);

        return TRUE;
    }

    private function subUnderLimit() {
        return true;
        if ($this->sProductId != "GAMES") {
            return true;
        }
        $subLimit = 100;
        $sub_count = 0;
        $result = true;
        $currentDateStart = date('Y-m-d') . ' 00:00:00';

        $aSelect = selectDetails($this->subTableName, 'count(id) as sub_count', array('event_id' => " = '" . $this->sProductId . "'", 'last_successfull_billed_date' => " >= '" . $currentDateStart . "'", 'type_id' => '=21', 'status' => '=2'));

        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $sub_count = $aSelect['data']['sub_count'];
        }

        if ($sub_count > $subLimit) {
            $result = false;
        }
        $sLog = __FUNCTION__."|".__LINE__."|Select  = " . json_encode($aSelect);
        commonLogging($sLog,$this->sMicroLogFilePath);

        //ends here
        return $result;
    }

    private function notifyApp(){
        $transId    = date("YmdHis") . rand(1000, 9999);
        $subStart   = date("Y-m-d H:i:s");
        $subEnd     = date("Y-m-d H:i:s", strtotime($this->sValidity));

        $appApi = "https://app.theshilpashetty.com/api/v1/operators/create-subscription";
        $header = array(
            "Accept: application/json",
            "Access-Token: vnJRE6CDPQM2602UHScEKkVd43d7DJih"
        );
        $postData = array('user_mobile_no' => substr($this->sMsisdn,3), 'user_mobile_no_code' => '960', 'subscription_start' => $subStart, 'subscription_end' => $subEnd, 'subscription_price' => $this->sRate, 'subscription_country_code' => 'MV', 'transaction_id' => $transId, 'subscription_channel' => 'WAP', 'transaction_status' => '1');
        $appNotificationResp = curlSend($appApi,5,$postData,'POST',$header);
        $sLog = __FUNCTION__."|".__LINE__."|APP_NOTIFICATION|".$appApi."|".json_encode($postData)."|".json_encode($header)."|".json_encode($appNotificationResp);
        commonLogging($sLog, $this->sMicroLogFilePath);
    }
    private function sendSMS($text_message) {
        $sStartTime = microtime(true);
        $smsApi = "http://mb.timwe.com/moma/sendMT?PartnerRoleId=".$this->PartnerRoleId."&Password=".$this->Password."&ProductId=".$this->sProductId."&PricePointId=".$this->mtFreePricePoint."&SenderId=SHILPASHETY&OpId=1040&Destination=".$this->sMsisdn."&Text=".rawurlencode($text_message)."&ExtTxId=".rand(111111111,999999999);
        $apiResponse = curlSend($smsApi, '30');
        $sLog = __FUNCTION__."|".__LINE__."| SMS API => " . $smsApi . " | Response => " . json_encode($apiResponse)."|".$apiResponse["result"] ;
        commonLogging($sLog,$this->sMicroLogFilePath);
        //$apiResponseArr = json_decode($apiResponse,true);
        if($apiResponse["result"]){
            return true;
        }
        else{
            return false;
        }
    }
    private function isBlacklisted(){
        $isBlacklisted = false;
        if(in_array($this->sMsisdn,array("9609922371","9609459202","9609951534"))) {
            $isBlacklisted  = true;
        }
        return $isBlacklisted;
    }
}
