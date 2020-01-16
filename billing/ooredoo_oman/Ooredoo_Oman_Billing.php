<?php

require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';

class Ooredoo_Oman_Billing {

    function __construct() {

        $this->subTableName = 'sngmpg.ooredoo_oman_subscription';
        $this->operatorName = 'ooredoo_oman';

        #Store
        //pricePoint=>39123 'shortCode' => '80106'
        $this->aProductDetails['daily'] = array('productId'=>'23498', 'planId'=>'51882', 'validity' => '+1 day', 'rate' => '250');

        //Yet to configure
        //pricePoint=>39122 'shortCode' => '80106'
        $this->aProductDetails['weekly'] = array('productId'=>'23496', 'planId'=>'51872', 'validity' => '+7 day', 'rate' => '1250');

        #Music
        $this->aProductDetails['monthly'] = array('productId'=>'17492', 'planId'=>'51832', 'validity' => '+30 day', 'rate' => '3000');

        $this->billingLogFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/ooredoo_oman/ooredoo_oman_billing_' . date('Ymd') . '.log';

        checkLogPath($this->billingLogFilePath);
        
        $this->CountryId        = '968';
        $this->OperatorId       = '253';
        $this->PartnerRoleId    = "24212";
        $this->Password         = "9276f98dd";
        $this->sBillingUrl      = 'http://mb.timwe.com/neo-mb-sub-facade/';
        $this->sendPinUrl       = $this->sBillingUrl . 'subscribe/';
        $this->confirmPinUrl    = $this->sBillingUrl . 'validate/';
        $this->unsubUrl         = $this->sBillingUrl . 'unsubscribe/';
        
    }

    public function charge($paramArray) {

        $this->updateBase           = false;
        $this->sStartTime           = microtime(true);
        $this->errorCode            = 'SS999';
        $this->sErrorMessage        = 'Fail';
        $this->sErrorDescription    = '';
        $this->operatorErrorCode    = '';

        $this->sMsisdn          = "968" . substr($paramArray['msisdn'],-8);
        $this->sPlanId          = trim($paramArray['plan']);
        $this->sRate            = trim($paramArray['rate']);
        $this->transactionId    = rand(100000000, 999999999);
        $this->aProductDetail   = $this->aProductDetails[$this->sPlanId];
        $this->sProductId       = trim($this->aProductDetail['productId']);

        $this->mode         = $paramArray['mode'] ? $paramArray['mode'] : '';
        $this->sAction      = strtoupper(trim($paramArray['action']));
        $this->sOther1      = strtolower(trim($paramArray['other1']));
        $this->sOther2      = strtolower(trim($paramArray['other2']));
        
        $this->sRate        = $this->aProductDetail['rate'];
        $this->sValidity    = $this->aProductDetail['validity'];
        $this->sBillingPricePoint = $this->aProductDetail['pricePoint'];
        $this->largeAccount = $this->aProductDetail['shortCode'];

        $sLog = "Input Parameter : " . json_encode($paramArray);
        $aLoggingArray['path']      = $this->billingLogFilePath;
        $aLoggingArray['message']   = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        //commonLogging($aLoggingArray);
        commonLogging($sLog,$this->billingLogFilePath);

        switch ($this->sAction) {
            case 'SUB' :
                if ($this->sOther1 == "send_otp") {
                    $this->sendPin();
                }
                else if ($this->sOther1 == "verify_otp") {
                    $this->confirmPin();
                }
                break;
            case 'UNSUB' :
                $this->unSubscription();
                break;
        }
        /*
        if ($this->updateBase) {
            $this->callDBEntry();
        }
        */
        $aData      = array('msisdn' => $this->sMsisdn, 'amount' => $this->sRate, 'trans_id' => $this->transactionId, 'result' => array('status' => $this->sStatus, 'code' => $this->errorCode, 'message' => $this->sErrorMessage), 'operator' => array('name' => 'Ooredoo Oman', 'circle' => $paramArray['circle']), 'error_description' => $this->sErrorDescription, 'url' => $this->sUrl);
        $json_data  = json_encode($aData);
        $sLog       = 'Json Data = ' . $json_data;
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        $aLoggingArray['path'] = $this->billingLogFilePath;
        //commonLogging($aLoggingArray);
        commonLogging($sLog,$this->billingLogFilePath);

        return $json_data;
    }

    private function sendPin() {
        /*
        if ($this->isAlreadySubscribed()) {
            $this->updateBase   = false;
            $this->errorCode    = "SS101";
            $this->sErrorMessage= "Already Subscribed.";
            return false;
        }
        */
        $sendPinUrl     = $this->sendPinUrl."?PartnerRoleId=".$this->PartnerRoleId."&Password=".$this->Password."&Msisdn=".$this->sMsisdn."&OpId=".$this->OperatorId."&BuyChannel=WEB&ProductId=".$this->sProductId."&CountryId=".$this->CountryId."&TrackingId=".$this->transactionId."&Ip=1.2.3.4";
        $sStartTime     = date('Y-m-d H:i:s');
        $sApiResponse   = curlSend($sendPinUrl);
        $sEndTime       = date('Y-m-d H:i:s');

        $sResponse          =  $sApiResponse['result'];
        $sResponseString    = str_replace("\n", "", $sResponse);
        $sResponseString    = str_replace("\t", "", $sResponseString);
        $oResponse          = simplexml_load_string($sResponseString);

        $this->operatorErrorCode= $oResponse->response->responsestatus->code;

        if ($this->operatorErrorCode == "1") {//success
            $this->errorCode    = 'SS001';
            $this->sErrorMessage= 'Accepted.';
        } else {
            $this->errorCode    = "SS199";
            $this->sErrorMessage= 'Failed at Operator';
        }
        
        $sLog = "sendPin Url = " . $sendPinUrl . '|response = ' . json_encode($sApiResponse) . '|' . json_encode($oResponse) . '|' . $oResponse->response->responsestatus->code;
        commonLogging($sLog,$this->billingLogFilePath);
    }

    private function confirmPin() {
        /*
        if ($this->isAlreadySubscribed()) {
            $this->updateBase   = false;
            $this->errorCode    = "SS101";
            $this->sErrorMessage= "Already Subscribed.";
            return false;
        }
        */
        $sVerifyPinUrl = $this->confirmPinUrl."?PartnerRoleId=".$this->PartnerRoleId."&Password=".$this->Password."&Pin=".$this->sOther2."&Msisdn=".$this->sMsisdn."&OpId=".$this->OperatorId."&ProductId=".$this->sProductId."&CountryId=".$this->CountryId;
        $sStartTime     = date('Y-m-d H:i:s');
        $sApiResponse   = curlSend($sVerifyPinUrl);
        $sEndTime       = date('Y-m-d H:i:s');
        
        $sResponse          =  $sApiResponse['result'];
        $sResponseString    = str_replace("\n", "", $sResponse);
        $sResponseString    = str_replace("\t", "", $sResponseString);
        $oResponse          = simplexml_load_string($sResponseString);

        $this->operatorErrorCode= $oResponse->response->responsestatus->code;

        if ($this->operatorErrorCode == "1") {//success
            $this->errorCode        = 'SS001';
            $this->sErrorMessage    = 'Accepted.';
        } else if($this->operatorErrorCode == "-72") {
            $this->errorCode        = "SS101";
            $this->sErrorMessage    = "Already Subscribed.";
        } else {
            $this->errorCode        = "SS199";
            $this->sErrorMessage    = 'Failed at Operator';
        }
        
        $sLog = "confirmPin Url = " . $sVerifyPinUrl . '|response = ' . json_encode($sApiResponse) . '|' . json_encode($oResponse) . '|' . $this->operatorErrorCode;
        commonLogging($sLog,$this->billingLogFilePath);
    }

    private function unSubscription() {
        /*
        if ($this->isNumExist()) {
            if ($this->isAlreadyUnsubscribed()) {
                $this->updateBase   = false;
                $this->errorCode    = "SS102";
                $this->sErrorMessage= "Already Unsubscribed";
                return false;
            }
        } else {
            $this->updateBase   = false;
            $this->errorCode    = "SS201";
            $this->sErrorMessage= "Forbidden";
            return false;
        }
        */
        $unsubUrl = $this->unsubUrl."?PartnerRoleId=".$this->PartnerRoleId."&Password=".$this->Password."&CountryId=".$this->CountryId."&Msisdn=".$this->sMsisdn."&OpId=".$this->OperatorId."&ProductId=".$this->sProductId."&Keyword=stop";
        $sStartTime     = date('Y-m-d H:i:s');
        $sApiResponse  = curlSend($unsubUrl);
        $sEndTime       = date('Y-m-d H:i:s');

        $sResponse          =  $sApiResponse['result'];
        $sResponseString    = str_replace("\n", "", $sResponse);
        $sResponseString    = str_replace("\t", "", $sResponseString);
        $oResponse          = simplexml_load_string($sResponseString);

        $this->operatorErrorCode= $oResponse->response->responsestatus->code;

        $oResponse = json_decode($sCurlResponse, true);
        if ($this->operatorErrorCode == "1") {//success
            $this->errorCode        = 'SS000';
            $aLoggingArray['path']  = $this->sBillingSuccessLog;
        } else if($this->operatorErrorCode == "-77") {
            $this->errorCode    = "SS102";
            $this->sErrorMessage= "Already Unsubscribed";
        } else {
            $this->errorCode        = "SS199";
            $this->sErrorMessage    = 'Failed at Operator';
            $aLoggingArray['path']  = $this->sBillingFailureLog;
        }
        $this->operatorErrorCode = $oResponse['code'];
        $sLog = "unsub Url = " . $unsubUrl . '|response = ' . json_encode($sApiResponse) . '|' . json_encode($oResponse) . '|' . $this->operatorErrorCode;
        commonLogging($sLog,$this->billingLogFilePath);
    }

    private function callDBEntry() {
        $aInputValue = array();
        $aInputValue['pricepoint_id']   = "'" . $this->sBillingPricePoint . "'";
        $aInputValue['rate']            = "'" . $this->sRate . "'";
        $aInputValue['last_billed_date']= 'now()';

        $aInputValue['error_code']      = "'" . $this->operatorErrorCode . "'";

        switch ($this->sAction) {
            case 'DO_BILLING' :
                $aInputValue['type_id']     = "'21'";
                $aInputValue['type_name']   = "'SUB'";
                if ($this->errorCode && ($this->errorCode == 'SS000' || ($this->errorCode == 'SS101' && in_array($this->sTnb, array('tnb'))))) {
                    $aInputValue['last_successfull_billed_date'] = 'now()';
                    $aInputValue['charge_count']    = $this->sTnb == 'tnb' ? "'0'" : 'charge_count + 1';
                    $aInputValue['expiry_date']     = in_array($this->sTnb, array('tnb')) ? "'" . date("Y-m-d H:i:s", strtotime($this->aProductDetail['tnbValidity'])) . "'" : "'" . date("Y-m-d H:i:s", strtotime($this->sValidity)) . "'";
                    $aInputValue['activation_date'] = 'now()';
                    $aInputValue['status']          = "'2'";
                } else if ($this->sOther2 && in_array($this->sOther2, array('1', '72', '-72'))) {
                    $aInputValue['status']          = "'1'";
                    $aInputValue['charge_count']    = 'charge_count + 0';
                    $aInputValue['sub_parking_date']= "'" . date("Y-m-d H:i:s", strtotime($this->aProductDetail['parkingValidity'])) . "'";
                } else {
                    $aInputValue['status']          = "'1'";
                    $aInputValue['charge_count']    = 'charge_count + 0';
                    $aInputValue['sub_parking_date']= "'0000-00-00 00:00:00'";
                }
                break;
            case 'SUB' :
                $aInputValue['type_id']     = "'21'";
                $aInputValue['type_name']   = "'SUB'";
                if ($this->errorCode && ($this->errorCode == 'SS000' || ($this->errorCode == 'SS101' && in_array($this->sTnb, array('tnb', 'tnbsms'))))) {
                    $aInputValue['last_successfull_billed_date'] = 'now()';
                    $aInputValue['charge_count']    = 'charge_count + 1';
                    $aInputValue['expiry_date']     = in_array($this->sTnb, array('tnb', 'tnbsms')) ? "'" . date("Y-m-d H:i:s", strtotime($this->aProductDetail['tnbValidity'])) . "'" : "'" . date("Y-m-d H:i:s", strtotime($this->sValidity)) . "'";
                    $aInputValue['activation_date'] = 'now()';
                    $aInputValue['status']          = "'2'";
                    #$aInputValue['sub_parking_date'] = "'0000-00-00 00:00:00'";
                } else {
                    $aInputValue['status']          = "'1'";
                    $aInputValue['charge_count']    = 'charge_count + 0';
                    $aInputValue['sub_parking_date']= "'" . date("Y-m-d H:i:s", strtotime($this->aProductDetail['parkingValidity'])) . "'";
                }
                break;
            case 'UNSUB' :
                $aInputValue['type_name']           = "'" . strtoupper($this->sAction) . "'";
                $aInputValue['deactivation_date']   = "now()";
                $aInputValue['deactivation_type']   = "'User Deactivated'";
                $aInputValue['status']              = "'6'";
                $aInputValue['type_id']             = "'99'";
                break;
            case 'RENEW' : //USER STATUS = 2
                $aInputValue['type_id'] = "'36'";
                if ($this->errorCode && $this->errorCode == 'SS000') {
                    $aInputValue['type_name'] = in_array(strtoupper($this->sUserCurrentStatus), array('TNBSUB', 'TNBRENEW')) ? "'TNBRENEW'" : (in_array(strtoupper($this->sUserCurrentStatus), array('TNBSUBSMS', 'SUBSMS')) ? "'SMSRENEW'" : "'RENEW'");
                    $aInputValue['last_successfull_billed_date'] = 'now()';
                    $aInputValue['charge_count']    = 'charge_count + 1';
                    $aInputValue['expiry_date']     = "'" . date("Y-m-d H:i:s", strtotime($this->sValidity)) . "'";
                    #$aInputValue['activation_date'] = 'now()';
                    $aInputValue['status']          = "'2'";
                    if ($this->sUserStatus && $this->sUserStatus == '1') {
                        $aInputValue['sub_parking_date']= "'0000-00-00 00:00:00'";
                        $aInputValue['activation_date'] = 'now()';
                    }
                } else if ($this->sUserStatus && $this->sUserStatus == '1') {
                    $aInputValue['status']  = "'1'";
                } else {
                    $aInputValue['status']  = "'3'";
                }
                break;
            case 'SUBPARKING' : //USER STATUS = 1
                $aInputValue['type_id']     = "'36'";
                if ($this->errorCode && $this->errorCode == 'SS000') {
                    $aInputValue['type_name'] = in_array($this->sUserCurrentStatus, array('TNBSUB', 'TNBRENEW')) ? "'TNBRENEW'" : (in_array($this->sUserCurrentStatus, array('TNBSUBSMS', 'SUBSMS')) ? "'SMSRENEW'" : "'RENEW'");
                    $aInputValue['last_successfull_billed_date'] = 'now()';
                    $aInputValue['charge_count']    = 'charge_count + 1';
                    $aInputValue['expiry_date']     = "'" . date("Y-m-d H:i:s", strtotime($this->sValidity)) . "'";
                    $aInputValue['activation_date'] = 'now()';
                    $aInputValue['status']          = "'2'";
                } else {
                    $aInputValue['status']          = "'1'";
                }
                break;
            case 'GRACE' : //USER STATUS = 3
                $aInputValue['type_id'] = "'36'";
                if ($this->errorCode && $this->errorCode == 'SS000') {
                    $aInputValue['type_name'] = in_array($this->sUserCurrentStatus, array('TNBSUB', 'TNBRENEW')) ? "'TNBRENEW'" : (in_array($this->sUserCurrentStatus, array('TNBSUBSMS', 'SUBSMS')) ? "'SMSRENEW'" : "'RENEW'");
                    $aInputValue['last_successfull_billed_date'] = 'now()';
                    $aInputValue['charge_count']    = 'charge_count + 1';
                    $aInputValue['expiry_date']     = "'" . date("Y-m-d H:i:s", strtotime($this->sValidity)) . "'";
                    $aInputValue['activation_date'] = 'now()';
                    $aInputValue['status']          = "'2'";
                } else {
                    $aInputValue['status']          = "'3'";
                }
                break;
        }
        $sCurrentStatus = '';
        $sLastBilledDate = '';
        if (!$this->sSubscriptionId) {
            $aSelect = selectDetails($this->subTableName, 'id, status, date(last_successfull_billed_date) last_successfull_billed_date, charge_count', array('msisdn' => " = '" . $this->sMsisdn . "'", 'event_id' => " = '" . $this->sProductId . "'"));
            $sLog = "Select  = " . json_encode($aSelect);
            $aLoggingArray['path']      = $this->billingLogFilePath;
            $aLoggingArray['message']   = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
            //commonLogging($aLoggingArray);
            commonLogging($sLog,$this->billingLogFilePath);

            if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
                $this->sSubscriptionId  = $aSelect['data']['id'];
                $sCurrentStatus         = $aSelect['data']['status'];
                $sLastBilledDate        = $aSelect['data']['last_successfull_billed_date'];
            }
        }
        if ($this->sSubscriptionId) {
            if ($sCurrentStatus == '2' && date('Y-m-d') == $sLastBilledDate && $this->sAction == 'DO_BILLING') {
                $sLog = "User Is Already Charged For This Service So Skipping Other DB Entry For Subscrption And Billing";
            } else {
                $aDBReturn = updateTable($this->subTableName, $aInputValue, array('id' => $this->sSubscriptionId));
                $sLog = "UpdateUserbaseInput = " . json_encode($aInputValue) . '; Update Userbase Return = ' . json_encode($aDBReturn);
            }
            $aLoggingArray['path']      = $this->billingLogFilePath;
            $aLoggingArray['message']   = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
            //commonLogging($aLoggingArray);
            commonLogging($sLog,$this->billingLogFilePath);
        } else {
            $aInputValue['msisdn']          = "'" . $this->sMsisdn . "'";
            $aInputValue['event_id']        = "'" . $this->sProductId . "'";
            $aInputValue['start_date']      = 'now()';
            $aInputValue['operator_id']     = 148;
            $aInputValue['operator_name']   = "'OOREDOO_OMAN'";
            $aInputValue['circle_id']       = 30;
            $aInputValue['circle_name']     = "'OTHERS'";
            $aInputValue['service_name']    = "'" . $this->aProductDetail['planName'] . "'";
            $aInputValue['merchant_id']     = "''";
            $aInputValue['charge_count']    = ($this->errorCode == 'SS000' || ($this->sTnb == 'tnb' && $this->errorCode == 'SS101')) ? "'1'" : "'0'";

            $aDBReturn = insertTable($this->subTableName, $aInputValue);
            $sLog = "Insert Input  = " . json_encode($aInputValue) . '; Insert Database Return = ' . json_encode($aDBReturn);
            $aLoggingArray['path']      = $this->billingLogFilePath;
            $aLoggingArray['message']   = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
            //commonLogging($aLoggingArray);
            commonLogging($sLog,$this->billingLogFilePath);
        }

        unset($aInputValue);
    }

    private function isAlreadySubscribed() {
        $isSubscribed = false;

        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'", 'event_id' => " = '" . $this->sProductId . "'", 'status' => " = 2", 'expiry_date' => "> now()"));
        $sLog = "Select  = " . json_encode($aSelect);
        $aLoggingArray['path']      = $this->billingLogFilePath;
        $aLoggingArray['message']   = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        //commonLogging($aLoggingArray);
        commonLogging($sLog,$this->billingLogFilePath);
        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isSubscribed = true;
        }

        return $isSubscribed;
    }

    private function isNumExist() {
        $isNumExist = false;

        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'", 'event_id' => " = '" . $this->sProductId . "'"));
        $sLog = "Select  = " . json_encode($aSelect);
        $aLoggingArray['path']      = $this->billingLogFilePath;
        $aLoggingArray['message']   = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        //commonLogging($aLoggingArray);
        commonLogging($sLog,$this->billingLogFilePath);
        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isNumExist = true;
        }

        return $isNumExist;
    }

    private function isAlreadyUnsubscribed() {
        $isAlreadyUnsubscribed = false;

        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'", 'event_id' => " = '" . $this->sProductId . "'", 'status' => " = 6"));
        $sLog = "Select  = " . json_encode($aSelect);
        $aLoggingArray['path']      = $this->billingLogFilePath;
        $aLoggingArray['message']   = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        //commonLogging($aLoggingArray);
        commonLogging($sLog,$this->billingLogFilePath);
        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isAlreadyUnsubscribed = true;
        }

        return $isAlreadyUnsubscribed;
    }

}

?>