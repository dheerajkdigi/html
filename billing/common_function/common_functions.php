<?php

 /*common functions to write logs.
 * Required Log Message and Log Path
 * Author Awanish Singh
 */

if (!function_exists('checkLogPath')) {

    function checkLogPath($sPath) {
        $aPath = explode('/', $sPath);
        for ($i = 1; $i < sizeof($aPath) - 1; $i++) {
            $sTempPath = '';
            for ($j = 1; $j <= $i; $j++) {
                $sTempPath .= "/" . $aPath[$j];
            }
            if (!file_exists($sTempPath)) {
                mkdir($sTempPath, 0777, true);
                /*
                if (!@mkdir($sTempPath, 0777, true)) {
                    $error = error_get_last();
                    echo $error['message'];
                }
                */
                chmod($sTempPath, 0777);
            }
        }
        $fp = @fopen($sPath, "a+");
        chmod($sPath, 0777);
        fclose($fp);
    }
}

if (!function_exists('commonLogging')) {
    function commonLogging($message,$logPath=''){
        if(!$logPath)
            $logPath = '/var/log/billing/'.date('Y')."/".date('m')."/default_log_".date('Ymd').".txt";
                        
         if(!file_exists($logPath)){
            checkLogPath($logPath);
        }
        $message = date("Y-m-d H:i:s")."|".$message."\r\n";
        error_log($message, 3, $logPath);
    }
}

if (!function_exists('mysqlErrorReport')) {
    function mysqlErrorReport($aInput = array()) {
        $sPath = '/var/log/billing/mysql_error_'.date('YmdH').'.log';
        if(!file_exists($sPath)) {
            switch($aInput['sErrorCode']) {
                case '2006' :
                    #sendMessageVoda(919619660484, "MySql Error 80\n \tError Code = ".$aInput['sErrorCode']."\n \tError Msg = ".$aInput['sErrorMsg']);
                    break;
            }
            checkLogPath($sPath);
        } 
        commonLogging(date('Y-m-d H:i:s').' => '.$aInput['sErrorFile'].' => '.$aInput['sErrorFunction'].' => '.$aInput['sErrorCode'].' => '.$aInput['sErrorMsg'].' => Query = '.$aInput['sErrorQuery'],$sPath);
        /*
        if( isset($aInput['sStatus']) && ($aInput['sStatus'] == 6) ){
            $logFile = '/var/log/billing/mysql_error/'.date('Y').'/'.date('m').'/unsub_'.date('YmdH').'.log';
            $aLoggingArray['path']      =   $logFile;
            $aLoggingArray['message']   =   $log_message;
            commonLogging($aLoggingArray);
        }
        */
    }
}

if (!function_exists('curlSend')) {

    function curlSend($sUrl, $timeOut = 180,$fields = '',$method='',$header='') {
        $ch = curl_init();
        
        if (strtoupper($method) == 'POST')
        {   
            if($header){
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            }
            else{
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                   
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($fields))                                      
                );
            }
            curl_setopt($ch, CURLOPT_URL, $sUrl);
            curl_setopt($ch, CURLOPT_POST, 1);  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);          
        }
        else
        {
        curl_setopt($ch, CURLOPT_URL, $sUrl);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
        $result     = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $rResult = array('result' => $result,'http_code' => $httpCode, 'curl_errno' => $curl_errno, 'curl_error' => $curl_error);
        return $rResult;
    }
}

if (!function_exists('curlSendXml')) {
    function curlSendXml($sUrl, $sFields, $timeOut = 180)
    {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $sUrl );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $sFields );
        $result    = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch);
        $rResult = array('result' => $result,'http_code' => $httpCode, 'curl_errno' => $curl_errno, 'curl_error' => $curl_error);
        return $rResult;
    }
}

function debug($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function dd($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit;
}

if (!function_exists('isJSON')) {
    function isJSON($string){
       return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}
if (!function_exists('getClientIp')) {
    function getClientIp() {
          $ipaddress = '';
          if (getenv('HTTP_CLIENT_IP'))
              $ipaddress = getenv('HTTP_CLIENT_IP');
          else if(getenv('HTTP_X_FORWARDED_FOR'))
              $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
          else if(getenv('HTTP_X_FORWARDED'))
              $ipaddress = getenv('HTTP_X_FORWARDED');
          else if(getenv('HTTP_FORWARDED_FOR'))
              $ipaddress = getenv('HTTP_FORWARDED_FOR');
          else if(getenv('HTTP_FORWARDED'))
              $ipaddress = getenv('HTTP_FORWARDED');
          else if(getenv('REMOTE_ADDR'))
              $ipaddress = getenv('REMOTE_ADDR');
          else
              $ipaddress = 'UNKNOWN';
    
          return $ipaddress;
     }
 }

?>