<?php
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';

class Etisalat_Dubai_Billing {

    function __construct() {
        //Subscription Table
        $this->subTableName     = 'billing.etisalat_dubai_subscription';
        $this->transTableName   = 'billing.etisalat_dubai_transaction';
        $this->operatorName     = 'etisalat_dubai';
        $this->mpgOperatorId    = 144;
        $this->currency         = 'AED';

        $this->aProductDetails['daily']     = array('productId'=>'1543', 'planId'=>'', 'validity' => '+1 day', 'rate' => '325');
        $this->aProductDetails['weekly']    = array('productId'=>'1544', 'planId'=>'', 'validity' => '+7 day', 'rate' => '1100');
        $this->aProductDetails['monthly']   = array('productId'=>'1545', 'planId'=>'', 'validity' => '+30 day', 'rate' => '3000');
        
        $this->spId            = "DigiOsmosis";
        $this->spPassword      = "DigiOsmo897";
        $this->secreteKey      = "DHDUFYlinsGDDSSs";

        $this->sSendPinUrl      = "https://pt5.etisalat.ae/Moneta/pushPOSTPin.htm";
        $this->sVerifyPinUrl    = "https://pt5.etisalat.ae/Moneta/confirmPOSTPin.htm?";
        $this->sUnSubscribeUrl  = "http://pt5.etisalat.ae/Moneta/getUnsub.htm?";

        $this->billingLogFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/etisalat_dubai/etisalat_dubai_billing_' . date('Ymd') . '.log';

        checkLogPath($this->billingLogFilePath);
    }

    public function charge($paramArray) {
        $this->sStartTime       = microtime(true);
        $this->sMsisdn          = ($paramArray['msisdn']) ? "971".$paramArray['msisdn'] : "";
        $this->errorCode        = 'SS999';
        $this->sErrorMessage    = 'Unknown Error';
        $this->sErrorDescription = '';
        $this->sOperatorErrorCode = '';
        $this->sPlanId          = trim($paramArray['plan']);
        $this->sRate            = trim($paramArray['rate']);
        $this->transactionId    = date("YmdHis") . $this->sMsisdn . rand(1000, 9999);
        $this->aProductDetail   = $this->aProductDetails[$this->sPlanId];
        $this->sProductId       = trim($this->aProductDetail['productId']);
        $this->sAction          = strtoupper(trim($paramArray['action']));
        $this->sOther1          = strtolower(trim($paramArray['other1']));
        $this->sOther2          = strtolower(trim($paramArray['other2']));
        $this->sngPreId         = $paramArray['pre_id'];
        $this->sSubId           = $paramArray['content_id'] ? trim($paramArray['content_id']) : '';
        $this->sRate            = $this->aProductDetail['rate'];
        $this->sValidity        = $this->aProductDetail['validity'];
        $this->sPlanName        = $this->aProductDetail['planName'];
        $this->sServiceId       = $this->aProductDetail['serviceId'];
        $this->sngProductId     = $this->aProductDetail['sngProductId'];
        $this->sOpStatus        = "";
        $this->bUpadateBase     = FALSE;

        $sLog = "Input Parameter : " . json_encode($paramArray);
        $aLoggingArray['path'] = $this->billingLogFilePath;
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        //commonLogging($aLoggingArray);
        commonLogging($sLog,$this->billingLogFilePath);
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
                    if (strtolower($this->sOther1) == "send_otp") {
                       $this->send_otp();
                    } elseif (strtolower($this->sOther1) == "verify_otp") {
                        $this->verify_otp();
                    }
                    break;
                case 'UNSUB' :
                    $this->unSubscription();
                    break;
                case 'STATUS':
                    if($this->isAlreadySubscribed()){
                        $this->sStatus      = "OK";
                        $this->errorCode    = "SS101";
                        $this->sErrorMessage= "Already Subscribed";
                    }
                    else{
                        $this->sStatus      = "FAIL";
                        $this->errorCode    = "SS999";
                        $this->sErrorMessage= "InActive";
                    }
                    break;
            }
        }
        /*
        if ($this->bUpadateBase) {
            $this->callDBEntry();
        }
        */
        $this->sStatus = in_array($this->errorCode, array('SS000','SS001','SS002')) ? 'OK' : 'FAIL';

        $aData = array('msisdn' => $this->sMsisdn, 'acr' => $this->sMsisdn, 'amount' => $this->sRate, 'trans_id' => $this->transactionId, 'result' => array('status' => $this->sStatus, 'code' => $this->errorCode, 'message' => $this->sErrorMessage), 'operator' => array('name' => 'etisalat_dubai', 'circle' => $paramArray['circle']));

        $json_data = json_encode($aData);
        $sLog = 'Json Data = ' . $json_data;
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        $aLoggingArray['path'] = $this->billingLogFilePath;
        //commonLogging($aLoggingArray);
        commonLogging($sLog,$this->billingLogFilePath);

        return $json_data;
    }

    private function send_otp() {
        $sSendPinRawUrl = $this->sSendPinUrl . "user=" . $this->spId . "&password=" . $this->spPassword . "&msisdn=" . $this->sMsisdn . "&packageid=" . $this->sProductId."&txnid=".$this->transactionId."&channel=web&sourceIP=49.50.68.17&adPartnerName=test&pubId=test";
        $sSendPinUrl = $this->sSendPinUrl . "user=" . urlencode($this->aes128Encrypt($this->spId)) . "&password=" . urlencode($this->aes128Encrypt($this->spPassword)) . "&msisdn=" . urlencode($this->aes128Encrypt($this->sMsisdn)) . "&packageid=" . urlencode($this->aes128Encrypt($this->sProductId))."&txnid=".$this->transactionId."&channel=web&sourceIP=49.50.68.17&adPartnerName=test&pubId=test";

        $rawData = array("user"     => $this->spId,
                    "password"      => $this->spPassword,
                    "msisdn"        => $this->sMsisdn,
                    "packageId"     => $this->sProductId,
                    "txnid"         => $this->transactionId,
                    "channel"       => "web",
                    "sourceIP"      => "49.50.68.17",
                    "pubId"         => "test",
                    "adPartnerName" => "test",
                    );
        $data = array("user"        => $this->aes128Encrypt($this->spId),
                    "password"      => $this->aes128Encrypt($this->spPassword),
                    "msisdn"        => $this->aes128Encrypt($this->sMsisdn),
                    "packageId"     => $this->aes128Encrypt($this->sProductId),
                    "txnid"         => $this->transactionId,
                    "channel"       => "web",
                    "sourceIP"      => "49.50.68.17",
                    "pubId"         => "test",
                    "adPartnerName" => "test",
                    );
        $jsonData       = json_encode($data,JSON_UNESCAPED_SLASHES);
        $sApiResponse   = curlSend($this->sSendPinUrl, 5, $jsonData, 'POST');
        $aApiResponse   = explode("|", $sApiResponse['result']);

        $sLog = __FUNCTION__."|".__LINE__."|".$this->sMsisdn."|".$this->sProductId.'|URL => ' . $this->sSendPinUrl . "|" . $jsonData . '| Response =>' . json_encode($sApiResponse)."|".json_encode($rawData);
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        $aLoggingArray['path'] = $this->billingLogFilePath;
        //commonLogging($aLoggingArray);

        commonLogging($sLog, $this->billingLogFilePath);

        if ($aApiResponse[0] == "pin_sent") {
            $this->sToken = $aApiResponse[1];
            $this->errorCode = $this->status = 'SS001';
            $this->sErrorMessage = $this->response = $this->sDescription = $aApiResponse[0];
            $this->bUpadateBase = false;
            
            $aInputValue['msisdn'] = "'".$this->sMsisdn."'";
            $aInputValue['service_id'] = "'".$this->sServiceId."'";
            $aInputValue['unique_token'] = "'".$aApiResponse[1]."'";
            $aDBInsertReturn = insertTable($this->transTableName, $aInputValue);

            $sInsertLog = 'Insert Transaction Token => ' . json_encode($aDBInsertReturn);
            $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sInsertLog;
            $aLoggingArray['path'] = $this->billingLogFilePath;
            //commonLogging($aLoggingArray);
            commonLogging($sInsertLog,$this->billingLogFilePath);
            
        } else {
            $this->errorCode = $this->status = 'SS199';
            $this->sErrorMessage = $this->response = $this->sDescription = $aApiResponse[0];
        }
    }

    private function verify_otp() {
        /*
        if ($this->isAlreadySubscribed()) {
            $this->errorCode = "SS101";
            $this->sErrorMessage = "Already Subscribed.";
            return false;
        }
        */
        $aSelect = selectDetails($this->transTableName, 'unique_token', array('service_id' => " = '" . $this->sServiceId . "'", 'msisdn' => " = '" . $this->sMsisdn . "'"), 'order by id desc');

        $sLog = 'Select Token => ' . json_encode($aSelect);
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        $aLoggingArray['path'] = $this->billingLogFilePath;
        //commonLogging($aLoggingArray);
        commonLogging($sLog, $this->billingLogFilePath);

        $sToken = $aSelect['data']['unique_token'];

        //$sToken = "8IfxUjdu8B+Zuycn6X7jR6dlUN6T2HG7xGNK23I508Y=";
        $sVerifyPinUrl = $this->sVerifyPinUrl . "user=" . urlencode($this->aes128Encrypt($this->spId)) . "&password=" . urlencode($this->aes128Encrypt($this->spPassword)) . "&msisdn=" . urlencode($this->aes128Encrypt($this->sMsisdn)) . "&packageid=" . urlencode($this->aes128Encrypt($this->sProductId)) . "&pin=" . urlencode($this->aes128Encrypt($this->sOther2)) . "&token=" . $sToken."&txnid=".$this->transactionId."&channel=web&sourceIP=49.50.68.17&adPartnerName=test&pubId=test";

        $rawData = array("user"     => $this->spId,
                    "password"      => $this->spPassword,
                    "msisdn"        => $this->sMsisdn,
                    "packageId"     => $this->sProductId,
                    "pin"           => $this->sOther2,
                    "token"         => $sToken,
                    "txnid"         => $this->transactionId,
                    "channel"       => "web",
                    "sourceIP"      => "49.50.68.17",
                    "adPartnerName" => "test",
                    "pubId"         => "test");
        $data = array("user"        => $this->aes128Encrypt($this->spId),
                    "password"      => $this->aes128Encrypt($this->spPassword),
                    "msisdn"        => $this->aes128Encrypt($this->sMsisdn),
                    "packageId"     => $this->aes128Encrypt($this->sProductId),
                    "pin"           => $this->aes128Encrypt($this->sOther2),
                    "token"         => $sToken,
                    "txnid"         => $this->transactionId,
                    "channel"       => "web",
                    "sourceIP"      => "49.50.68.17",
                    "adPartnerName" => "test",
                    "pubId"         => "test");
        $jsonData       = json_encode($data,JSON_UNESCAPED_SLASHES);
        $sApiResponse   = curlSend($sVerifyPinUrl, 5,$jsonData,'POST');
        $aApiResponse   = explode("|", $sApiResponse['result']);

        if ($aApiResponse[0] == "success") {
            $this->errorCode = $this->status = 'SS001';
            $this->sErrorMessage = $this->response = $this->sDescription = $aApiResponse[0];
            
        } else {
            $this->errorCode = $this->status = 'SS199';
            $this->sErrorMessage = $this->response = $this->sDescription = $aApiResponse[0];
        }

        $sLog = __FUNCTION__."|".__LINE__."|".$this->sMsisdn."|".$this->sProductId.'|URL => ' . $this->sVerifyPinUrl . "|".$jsonData. '| Response =>' . json_encode($sApiResponse)."|".json_encode($rawData);
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        $aLoggingArray['path'] = $this->billingLogFilePath;
        //commonLogging($aLoggingArray);
        commonLogging($sLog, $this->billingLogFilePath);
    }

    private function unSubscription() {
        if ($this->isNumExist()) {
            if ($this->isAlreadyUnsubscribed()) {
                $this->errorCode = "SS102";
                $this->sErrorMessage = "Already Unsubscribed";
                return false;
            }
        } else {
            $this->errorCode = "SS201";
            $this->sErrorMessage = "Forbidden";
            return false;
        }

        $sUnsubUrl = $this->sUnSubscribeUrl . "user=" . urlencode($this->aes128Encrypt($this->spId)) . "&password=" . urlencode($this->aes128Encrypt($this->spPassword)) . "&msisdn=" . urlencode($this->aes128Encrypt($this->sMsisdn)) . "&packageid=" . urlencode($this->aes128Encrypt($this->sProductId));

        $sApiResponse = curlSend($sUnsubUrl, 5);

        if (trim($sApiResponse) == "Deactivation_Success") {
            $this->errorCode = $this->status = 'SS001';
            $this->sErrorMessage = $this->response = $this->sDescription = $sApiResponse;
        } else {
            $this->errorCode = $this->status = 'SS199';
            $this->sErrorMessage = $this->response = $this->sDescription = $sApiResponse;
        }

        $sLog = 'URL => ' . $sUnsubUrl . '| Response =>' . $sApiResponse;
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        $aLoggingArray['path'] = $this->billingLogFilePath;
        commonLogging($aLoggingArray);

        $billingLoggingArray['operator'] = $this->operatorName;
        $billingLoggingArray['logType'] = "Billing";
        $billingLoggingArray['logMessage'] = __FUNCTION__ . "|" . $this->sMsisdn . "|" . $this->sProductId . "|" . $this->sRate . "|" . $sLog;
        commonBillingLogging($billingLoggingArray);
    }

    private function callDBEntry() {
        $aInputValue = array();
        $aInputValue['rate'] = $this->sRate;
        $aInputValue['last_billed_date'] = 'now()';
        $aInputValue['error_code'] = $this->sOperatorErrorCode ? "'" . $this->sOperatorErrorCode . "'" : "' '";
        $sExpiryDate = date("Y-m-d H:i:s", strtotime($this->sValidity));
        switch ($this->sAction) {
            case 'SUB' :
                $aInputValue['type_id'] = "'21'";
                $aInputValue['type_name'] = "'SUB'";
                if ($this->errorCode && $this->errorCode == 'SS001') {
                    $aInputValue['pre_id'] = "'" . $this->sngPreId . "'";
                    $aInputValue['status'] = "'1'";
                    $aInputValue['charge_count'] = 'charge_count + 0';
                    $aInputValue['sub_parking_date'] = "'" . date("Y-m-d H:i:s", strtotime($this->aProductDetails[$this->sProductId]['parkingValidity'])) . "'";
                } else {
                    $aInputValue['status'] = "'5'";
                    $aInputValue['charge_count'] = 'charge_count + 0';
                    $aInputValue['sub_parking_date'] = "'" . date("Y-m-d H:i:s", strtotime($this->aProductDetails[$this->sProductId]['parkingValidity'])) . "'";
                }
                break;
        }
        if (!$this->sSubscriptionId) {
            $aSelect = selectDetails($this->subTableName, 'id, charge_count', array('msisdn' => " = '" . $this->sMsisdn . "'", 'event_id' => " = '" . $this->sProductId . "'"));
            $sLog = "Select  = " . json_encode($aSelect);
            $aLoggingArray['path'] = $this->billingLogFilePath;
            $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
            commonLogging($aLoggingArray);
            if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
                $this->sSubscriptionId = $aSelect['data']['id'];
            }

            $billingLoggingArray['operator'] = $this->operatorName;
            $billingLoggingArray['logType'] = "Query";
            $billingLoggingArray['logMessage'] = __FUNCTION__ . "|" . $this->sMsisdn . "|" . $this->sProductId . "|" . $this->sRate . "|SELECT|" . json_encode($aSelect) . "|" . $this->sSubscriptionId;
            commonBillingLogging($billingLoggingArray);
        }
        if ($this->sSubscriptionId) {
            $aDBReturn = updateTable($this->subTableName, $aInputValue, array('id' => $this->sSubscriptionId));
            $sLog = "UpdateUserbaseInput = " . json_encode($aInputValue) . '; Update Userbase Return = ' . json_encode($aDBReturn);
            $aLoggingArray['path'] = $this->billingLogFilePath;
            $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
            commonLogging($aLoggingArray);
        } else {
            $aInputValue['msisdn'] = "'" . $this->sMsisdn . "'";
            $aInputValue['event_id'] = "'" . $this->sProductId . "'";
            $aInputValue['start_date'] = 'now()';
            $aInputValue['operator_id'] = $this->mpgOperatorId;
            $aInputValue['circle_id'] = 30;
            $aInputValue['circle_name'] = "'OTHERS'";
            $aInputValue['service_name'] = "'" . $this->aProductDetail['planName'] . "'";
            $aInputValue['merchant_id'] = "'" . $this->sMerchantId . "'";
            $aInputValue['client_type'] = "'" . $this->sClientType . "'";
            $aInputValue['charge_count'] = ($this->errorCode == 'SS000') ? "'1'" : "'0'";
            $aDBReturn = insertTable($this->subTableName, $aInputValue);
            $sLog = "Insert Input  = " . json_encode($aInputValue) . '; Insert Database Return = ' . json_encode($aDBReturn);
            $aLoggingArray['path'] = $this->billingLogFilePath;
            $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $this->sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
            commonLogging($aLoggingArray);
        }

        $billingLoggingArray['operator'] = $this->operatorName;
        $billingLoggingArray['logType'] = "Query";
        $billingLoggingArray['logMessage'] = __FUNCTION__ . "|" . $this->sMsisdn . "|" . $this->sProductId . "|" . $this->sRate . "|UpdateUserbase|" . json_encode($aInputValue) . "|" . json_encode($aDBReturn);
        commonBillingLogging($billingLoggingArray);

        unset($aInputValue);
    }

    private function isAlreadySubscribed() {
        $isSubscribed = false;
        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'", 'event_id' => " = '" . $this->sProductId . "'", 'status' => " = 2", 'expiry_date' => "> now()"));

        $sLog = __FUNCTION__."|".__LINE__."|".$this->sMsisdn."|".$this->sProductId."Select  = " . json_encode($aSelect);

        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isSubscribed = true;
        }

        $sLog = __FUNCTION__."|".__LINE__."|".$this->sMsisdn."|".$this->sProductId."Select  = " . json_encode($aSelect)."|".$isSubscribed;
        commonLogging($sLog, $this->billingLogFilePath);

        return $isSubscribed;
    }

    private function isNumExist() {
        $isNumExist = false;
        $sStartTime = microtime(true);
        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'", 'event_id' => " = '" . $this->sProductId . "'"));

        $sLog = "Select  = " . json_encode($aSelect);
        $aLoggingArray['path'] = $this->billingLogFilePath;
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $sMsisdn . ' => ' . $sLog;
        commonLogging($aLoggingArray);

        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isNumExist = true;
        }

        $billingLoggingArray['operator'] = $this->operatorName;
        $billingLoggingArray['logType'] = "Query";
        $billingLoggingArray['logMessage'] = __FUNCTION__ . "|" . $this->sMsisdn . "|" . $this->sProductId . "|" . $this->sRate . "|SELECT|" . json_encode($aSelect) . "|" . $isNumExist;
        commonBillingLogging($billingLoggingArray);

        return $isNumExist;
    }

    private function isAlreadyUnsubscribed() {
        $isAlreadyUnsubscribed = false;
        $sStartTime = microtime(true);

        $aSelect = selectDetails($this->subTableName, 'id', array('msisdn' => " = '" . $this->sMsisdn . "'", 'event_id' => " = '" . $this->sProductId . "'", 'status' => " = 6"));

        $sLog = "Select  = " . json_encode($aSelect);
        $aLoggingArray['path'] = $this->billingLogFilePath;
        $aLoggingArray['message'] = "\n" . date('Y-m-d H:i:s') . " PT " . substr(microtime(true) - $sStartTime, 0, 5) . " => " . __FUNCTION__ . ' => ' . __LINE__ . ' => ' . $this->sMsisdn . ' => ' . $sLog;
        commonLogging($aLoggingArray);

        if ($aSelect['status'] == 'success' && $aSelect['data'] && !empty($aSelect['data'])) {
            $isAlreadyUnsubscribed = true;
        }

        $billingLoggingArray['operator'] = $this->operatorName;
        $billingLoggingArray['logType'] = "Query";
        $billingLoggingArray['logMessage'] = __FUNCTION__ . "|" . $this->sMsisdn . "|" . $this->sProductId . "|" . $this->sRate . "|SELECT|" . json_encode($aSelect) . "|" . $isAlreadyUnsubscribed;
        commonBillingLogging($billingLoggingArray);

        return $isAlreadyUnsubscribed;
    }

    private function aes128Encrypt($data) {

        $key = $this->secreteKey;
        if (16 !== strlen($key))
            $key = hash('MD5', $key, true);
        $padding = 16 - (strlen($data) % 16);
        $data .= str_repeat(chr($padding), $padding);
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16)));
    }

    private function aes128Decrypt($data) {
        $key = $this->secreteKey;
        $data = base64_decode($data);
        if (16 !== strlen($key))
            $key = hash('MD5', $key, true);
        $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
        $padding = ord($data[strlen($data) - 1]);
        return substr($data, 0, -$padding);
    }

}

?>