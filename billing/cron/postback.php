<?php

// script to process Etisalat UAE sdp callbacks
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';


    $logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/postback/postback_" . date('Ymd') . ".log";

    $aSelect1 = selectDetails('billing.tbl_s2s', 's2s_id,id,msisdn', array('status' => ' = 2','s2s_id' => '!=""','s2s_senton' => ' = "0000-00-00 00:00:00"'), " order by id desc");
    $sLog =   "Select |" . json_encode($aSelect1) . '|SelectReturn|' . json_encode($aSelect1);
    commonLogging($sLog, $logPath);
    
   // while ($aSelect1['s2s_id']) {
            $s2s_id=$aSelect1['data']['s2s_id'];
            $id=$aSelect1['data']['id'];
            $sMsisdn=$aSelect1['data']['msisdn'];
            $saff_id=$aSelect1['data']['aff_id'];
            
            if($saff_id==1103){
                $postBackUrl="http://wmadv.go2cloud.org/aff_lsr?transaction_id=".$s2s_id;
            }
            else if($saff_id==1104){
                $postBackUrl="http://track.mobileadsco.com/postback?cid=".$s2s_id;
            }else if($saff_id==1105){
                $postBackUrl="https://aver-leer.com/event/conversion?ydrid=".$s2s_id;
            }else if($saff_id==1106){
                $postBackUrl="https://track.alfa-serv.com/track/hash?hash=".$s2s_id;
            }else if($saff_id==1107){
                $postBackUrl="http://admobimedia.o18.click/p?mid=2217&tid=".$s2s_id;
            }
            #$postBackUrl="http://track.mobileadsco.com/postback?cid=".$s2s_id;
            $sResponse = curlSend($postBackUrl);
            $sLog   = "\nInfo :|Consumer|" . date("Y-m-d H:i:s") . "|Url = ".$postBackUrl."|Response = ".$sResponse;
            commonLogging($sLog, $logPath);
            
            $updateArray['s2s_senton']      = date("Y-m-d H:i:s");
            $updateArray['msisdn']          = $sMsisdn;
            $updateArray['action']          = "s2s";
            $updateArray['id']              = $id;
            $updateArray['table_name']      = 'billing.tbl_s2s';
            $userBaseResult = updateUserBase($updateArray);
            $sLog   = __FUNCTION__."|".__LINE__."|" . "| Update Userbase Response | " . json_encode($updateArray) . "|" . json_encode($userBaseResult);
            commonLogging($sLog, $logPath);
    //}

    function curlSend($sUrl, $timeOut=60) 
    {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sUrl);   			
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
            $rResult = curl_exec($ch);
            curl_getinfo($ch, CURLINFO_HTTP_CODE); 
            curl_close($ch);
            return $rResult;
    }

?>
