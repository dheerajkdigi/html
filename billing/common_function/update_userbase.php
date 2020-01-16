<?php

/* To update user base for all the operators.
 * created on 17 Sep 2018.
 */
//ini_set('display_errors', 1);
require_once '/var/www/html/billing/common_function/common_functions.php';

function createDataBaseConnection() {
    $sUsername = "root";
    $sPassword = "*eltsen09*";
    $sHostname = "localhost";
    $iResourceId = null;
    try{
        $iResourceId = mysqli_connect($sHostname, $sUsername, $sPassword) or die(mysqli_error());
    } catch (Exception $e) {
	commonLogging("Mysql Eror |Mysql Connection Error |UserName = $sUsername|Password = $sPassword|HOSTNAME = $sHostname","/var/log/billing/mysql_connection_error_".date("Ymd").".log");
    }
    return $iResourceId;
}

function updateUserBase($aInputParameter)
{
    
    $iResourceId = createDataBaseConnection();
    if($iResourceId) {

        $sLogFileDb = '/var/log/billing/updatebase_'.date('YmdH').'.txt';
        $sSqlFileDb = '/var/log/billing/updatebase_sql_'.date('YmdH').'.sql';
        $iId = 0;

        $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Input Parameter = ".json_encode($aInputParameter);
        commonLogging($sLog, $sLogFileDb);

        if($aInputParameter['table_name'] && $aInputParameter['msisdn'] && $aInputParameter['event_id']) {
            $sQuerySelectCount = 'SELECT id FROM '.$aInputParameter['table_name']." WHERE msisdn = '".$aInputParameter['msisdn']."' AND event_id = '".$aInputParameter['event_id']."' ";
            $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Select Query = ".$sQuerySelectCount;
            commonLogging($sLog, $sLogFileDb);

            $rSelectCount = mysqli_query($iResourceId, $sQuerySelectCount);
            if(mysqli_errno($iResourceId)) {
                $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Mysql Error = ".mysqli_errno($iResourceId)."|Mysql Error Text = ".mysqli_error($iResourceId);
                commonLogging($sLog, $sLogFileDb);

                $aInput['sErrorFile'] = __FILE__;
                $aInput['sErrorFunction'] = __FUNCTION__;
                $aInput['sErrorCode'] = mysqli_errno($iResourceId);
                $aInput['sErrorMsg'] = mysqli_error($iResourceId);
                $aInput['sErrorQuery'] = $sQuerySelectCount;
                mysqlErrorReport($aInput);
                unset($aInput);

            } else {
                $aSelectCount = mysqli_fetch_assoc($rSelectCount);
                $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Select Query = ".json_encode($aSelectCount);
                commonLogging($sLog, $sLogFileDb);

                $iId = $aSelectCount['id'] ? $aSelectCount['id'] : 0;
            }

            $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Id = ".$iId."|Action =".$aInputParameter['action']."|Status =".$aInputParameter['status'];
            commonLogging($sLog, $sLogFileDb);

            $aInputParameter['action'] = $aInputParameter['action'] ? $aInputParameter['action'] : ($aInputParameter['type_name'] ? $aInputParameter['type_name'] : 'sub');
            $aInputParameter['deactivation_date'] = $aInputParameter['deactivation_date'] ? $aInputParameter['deactivation_date'] : '';
            $aInputParameter['deactivation_type'] = $aInputParameter['deactivation_type'] ? $aInputParameter['deactivation_type'] : '';
            $aInputParameter['sub_parking_date'] = $aInputParameter['sub_parking_date'] ? $aInputParameter['sub_parking_date'] : '';
            $aInputParameter['error_code'] = isset($aInputParameter['error_code']) ? trim($aInputParameter['error_code']) : '';
            $aInputParameter['type_name'] = strtoupper($aInputParameter['type_name']);
            if($iId) { 
                switch(strtolower($aInputParameter['action'])) {
                    case 'sub' :
                        if($aInputParameter['status'] == 2) {
                            $sQuery = 'UPDATE '.$aInputParameter['table_name']." SET expiry_date = '".$aInputParameter['expiry_date']."', last_billed_date = now(), last_successfull_billed_date = now(), status = ".$aInputParameter['status'].", type_id = '".$aInputParameter['type_id']."', type_name = '".$aInputParameter['type_name']."', rate = '".$aInputParameter['rate']."', pricepoint_id = '".$aInputParameter['pricepoint_id']."', charge_count = charge_count + 1, activation_date = now(), error_code = '".$aInputParameter['error_code']."' where id = ".$iId;

                        } else {
                            if($aInputParameter['sub_parking_date']) {
                                $sQuery = 'UPDATE '.$aInputParameter['table_name']." SET last_billed_date = now(),  status = ".$aInputParameter['status'].", type_id = '".$aInputParameter['type_id']."', type_name = '".$aInputParameter['type_name']."', rate = '".$aInputParameter['rate']."', sub_parking_date = '".$aInputParameter['sub_parking_date']."', pricepoint_id = '".$aInputParameter['pricepoint_id']."', error_code = '".$aInputParameter['error_code']."' where id = ".$iId;
                            } else {
                                $sQuery = 'UPDATE '.$aInputParameter['table_name']." SET last_billed_date = now(),  status = ".$aInputParameter['status'].", type_id = '".$aInputParameter['type_id']."', type_name = '".$aInputParameter['type_name']."', rate = '".$aInputParameter['rate']."', pricepoint_id = '".$aInputParameter['pricepoint_id']."', error_code = '".$aInputParameter['error_code']."' where id = ".$iId;
                            }
                        }
                        break;
                    case 'renew' :
                        if($aInputParameter['status'] == 2) {
                            $sQuery = 'UPDATE '.$aInputParameter['table_name']." SET expiry_date = '".$aInputParameter['expiry_date']."', last_billed_date = now(), last_successfull_billed_date = now(), status = ".$aInputParameter['status'].", type_id = '".$aInputParameter['type_id']."', type_name = '".$aInputParameter['type_name']."', rate = '".$aInputParameter['rate']."', pricepoint_id = '".$aInputParameter['pricepoint_id']."', charge_count = charge_count + 1, error_code = '".$aInputParameter['error_code']."' where id = ".$iId;

                        } else {
                            $sQuery = 'UPDATE '.$aInputParameter['table_name']." SET last_billed_date = now(), status = ".$aInputParameter['status'].", type_id = '".$aInputParameter['type_id']."', type_name = '".$aInputParameter['type_name']."', rate = '".$aInputParameter['rate']."', pricepoint_id = '".$aInputParameter['pricepoint_id']."', error_code = '".$aInputParameter['error_code']."' where id = ".$iId;
                        }
                        break;
                    case 'unsub' :
                        $sQuery = 'UPDATE '.$aInputParameter['table_name']." SET expiry_date = '".$aInputParameter['expiry_date']."', last_billed_date = now(), status = ".$aInputParameter['status'].", type_id = '".$aInputParameter['type_id']."', type_name = '".$aInputParameter['type_name']."', deactivation_date = now(), deactivation_type = '".$aInputParameter['deactivation_type']."', pricepoint_id = '".$aInputParameter['pricepoint_id']."', error_code = '".$aInputParameter['error_code']."'  where id = ".$iId;
                        break;
                    default :
                        $sQuery = 'UPDATE '.$aInputParameter['table_name']." SET last_billed_date = now(), status = ".$aInputParameter['status'].", type_id = '".$aInputParameter['type_id']."', type_name = '".$aInputParameter['type_name']."', rate = '".$aInputParameter['rate']."', pricepoint_id = '".$aInputParameter['pricepoint_id']."', error_code = '".$aInputParameter['error_code']."' where id = ".$iId;
                        break;
                }
            } else {
                if($aInputParameter['status'] == 2) {
                    $sQuery = 'INSERT INTO  '.$aInputParameter['table_name'].
                            '(msisdn, event_id, pricepoint_id, start_date, expiry_date, activation_date,last_billed_date,last_successfull_billed_date,status,type_id,type_name,rate,operator_id,operator_name,circle_id,circle_name,service_name, error_code) VALUES ( '.
                            $aInputParameter['msisdn'].",'".$aInputParameter['event_id']."','".$aInputParameter['pricepoint_id']."','".$aInputParameter['start_date']."','".$aInputParameter['expiry_date']."',now(),now(),'".$aInputParameter['last_successfull_billed_date']."','".$aInputParameter['status']."','".$aInputParameter['type_id']."','".$aInputParameter['type_name']."','".$aInputParameter['rate']."','".$aInputParameter['operator_id']."','".$aInputParameter['operator_name']."','".$aInputParameter['circle_id']."','".$aInputParameter['circle_name']."','".$aInputParameter['service_name']."', '".$aInputParameter['error_code']."')";
                } else if($aInputParameter['status'] == 6)  {
                    $sQuery = 'INSERT INTO  '.$aInputParameter['table_name'].
                            '(msisdn,event_id,pricepoint_id, start_date,last_billed_date,status,type_id,type_name,rate,operator_id,operator_name,circle_id,circle_name,service_name, deactivation_date, deactivation_type, sub_parking_date, error_code) VALUES ( '.
                            $aInputParameter['msisdn'].",'".$aInputParameter['event_id']."','".$aInputParameter['pricepoint_id']."','".$aInputParameter['start_date']."',now(),'".$aInputParameter['status']."','".$aInputParameter['type_id']."','".$aInputParameter['type_name']."','".$aInputParameter['rate']."','".$aInputParameter['operator_id']."','".$aInputParameter['operator_name']."','".$aInputParameter['circle_id']."','".$aInputParameter['circle_name']."','".$aInputParameter['service_name']."','".$aInputParameter['deactivation_date']."','".$aInputParameter['deactivation_type']."','".$aInputParameter['sub_parking_date']."', '".$aInputParameter['error_code']."')";
                } else  {
                    $sQuery = 'INSERT INTO  '.$aInputParameter['table_name'].
                            '(msisdn,event_id,pricepoint_id,start_date,last_billed_date,status,type_id,type_name,rate,operator_id,operator_name,circle_id,circle_name,service_name, deactivation_date, deactivation_type, sub_parking_date, error_code) VALUES ( '.
                            $aInputParameter['msisdn'].",'".$aInputParameter['event_id']."','".$aInputParameter['pricepoint_id']."','".$aInputParameter['start_date']."',now(),'".$aInputParameter['status']."','".$aInputParameter['type_id']."','".$aInputParameter['type_name']."','".$aInputParameter['rate']."','".$aInputParameter['operator_id']."','".$aInputParameter['operator_name']."','".$aInputParameter['circle_id']."','".$aInputParameter['circle_name']."','".$aInputParameter['service_name']."','".$aInputParameter['deactivation_date']."','".$aInputParameter['deactivation_type']."','".$aInputParameter['sub_parking_date']."', '".$aInputParameter['error_code']."')";
                    
                }
            }
            
            $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Insert/Update Query = ".$sQuery;
            commonLogging($sLog, $sLogFileDb);

            mysqli_query($iResourceId, $sQuery);
            if(mysqli_errno($iResourceId)) {
                $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Mysql Error = ".mysqli_errno($iResourceId)."|Mysql Error Text = ".mysqli_error($iResourceId);
                commonLogging($sLog, $sLogFileDb);

                $aInput['sErrorFile']       = __FILE__;
                $aInput['sErrorFunction']   = __FUNCTION__;
                $aInput['sErrorCode']       = mysqli_errno($iResourceId);
                $aInput['sErrorMsg']        = mysqli_error($iResourceId);
                $aInput['sErrorQuery']      = $sQuery;
                $aInput['sStatus']          = $aInputParameter['status'];
                mysqlErrorReport($aInput);
                $sReturnStatus = 'failed';
            } else {
                $sReturnStatus = 'success';
            }
        }
        else if($aInputParameter['table_name'] && $aInputParameter['msisdn'] && $aInputParameter['action']=='s2s' && $aInputParameter['id']){
            $iId =$aInputParameter['id'];
            if($iId) { 
                        $sQuery = 'UPDATE '.$aInputParameter['table_name']." SET s2s_senton = '".$aInputParameter['s2s_senton']."' where id = ".$iId;
            } 
            
            $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Insert/Update Query = ".$sQuery;
            commonLogging($sLog, $sLogFileDb);

            mysqli_query($iResourceId, $sQuery);
            if(mysqli_errno($iResourceId)) {
                $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Mysql Error = ".mysqli_errno($iResourceId)."|Mysql Error Text = ".mysqli_error($iResourceId);
                commonLogging($sLog, $sLogFileDb);

                $aInput['sErrorFile']       = __FILE__;
                $aInput['sErrorFunction']   = __FUNCTION__;
                $aInput['sErrorCode']       = mysqli_errno($iResourceId);
                $aInput['sErrorMsg']        = mysqli_error($iResourceId);
                $aInput['sErrorQuery']      = $sQuery;
                $aInput['sStatus']          = $aInputParameter['status'];
                mysqlErrorReport($aInput);
                $sReturnStatus = 'failed';
            } else {
                $sReturnStatus = 'success';
            }
            
        }
        else {
            $sReturnStatus = 'failed';
            $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Mandatory Parameter Table Name Not Found";
            commonLogging($sLog, $sLogFileDb);
        }
        mysqli_close($iResourceId);
    } else {
        $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Mysql Connection Not Created";
        commonLogging($sLog, $sLogFileDb);
    }
    $sLog = __FUNCTION__."|".__LINE__."|INFO|".$aInputParameter['msisdn']."|Return Status = ".$sReturnStatus;
    commonLogging($sLog, $sLogFileDb);
    return $sReturnStatus;
}

function selectDetails($sTableName, $sSelectColumn, $aWhereCondition, $sCondition = '') {
    $iResourceId = createDataBaseConnection();
    $sWhereCondition = '';
    $iConditionCount = 0;
    $aSelectReturn = array();
    $aSelectReturn['status'] = 'success';
    if($sTableName && $sSelectColumn && !empty($aWhereCondition)) {
        foreach($aWhereCondition as $key => $value) {
            if($iConditionCount == (count($aWhereCondition)-1)) {
                $sWhereCondition .= $key.' '.$value;
            } else {
                $sWhereCondition .= $key.' '.$value.' AND ';
            }
            $iConditionCount++;
        }
        $sSelectQuery = 'SELECT '.$sSelectColumn.' FROM '.$sTableName.' WHERE '.$sWhereCondition.' '.$sCondition ;
        $rSelectCount = mysqli_query($iResourceId, $sSelectQuery);
        $aSelectReturn['msg'] = 'Query = '.$sSelectQuery;
        if(mysqli_errno($iResourceId)) {
            $aSelectReturn['msg'] .= '; Mysql Error = '.mysqli_errno($iResourceId).'; Mysql Error Text = '.mysqli_error($iResourceId);
            $aInput['sErrorFile'] = __FILE__;
            $aInput['sErrorFunction'] = __FUNCTION__;
            $aInput['sErrorCode'] = mysqli_errno($iResourceId);
            $aInput['sErrorMsg'] = mysqli_error($iResourceId);
            $aInput['sErrorQuery'] = $sSelectQuery;
            mysqlErrorReport($aInput);
            unset($aInput);
            $aSelectReturn['status'] = 'failed';
        } else {
            $aSelectReturn['data'] = mysqli_fetch_assoc($rSelectCount);
        }
    } else {
        $aSelectReturn['msg'] = 'Mandatory Parameter Missing';
        $aSelectReturn['status'] = 'failed';
    }
    mysqli_close($iResourceId);
    return $aSelectReturn;
}

function insertTable($sTableName, $aInsertData) {
    $sColumnName = '';
    $sColumnValue = '';
    $iCount = 0;
    $aInsertReturn = array();
    $aInsertReturn['status'] = 'success';
    $iResourceId = createDataBaseConnection();
    if($sTableName && !empty($aInsertData)) {
        foreach ($aInsertData as $key => $value) {
            if($iCount == (count($aInsertData) - 1)) {
                $sColumnName .= $key;
                $sColumnValue .= $value;
            } else {
                $sColumnName .= $key.',';
                $sColumnValue .= $value.',';
            }
            $iCount++;
        }
        $sQuery = "INSERT INTO ".$sTableName."($sColumnName) VALUES ($sColumnValue)";
        mysqli_query($iResourceId, $sQuery);
        $aInsertReturn['msg'] = 'Query = '.$sQuery;
        $aInsertReturn['last_insert_id'] = mysqli_insert_id($iResourceId);
        if(mysqli_errno($iResourceId)) {
            $aInsertReturn['msg'] .= '; Mysql Error = '.mysqli_errno($iResourceId).'; Mysql Error Text = '.mysqli_error($iResourceId);
            $aInsertReturn['status'] = 'failed';

            $aInput['sErrorFile']       = __FILE__;
            $aInput['sErrorFunction']   = __FUNCTION__;
            $aInput['sErrorCode']       = mysqli_errno($iResourceId);
            $aInput['sErrorMsg']        = mysqli_error($iResourceId);
            $aInput['sErrorQuery']      = $sQuery;
            $aInput['sStatus']          = $aInsertData['status'];
            mysqlErrorReport($aInput);
            unset($aInput);
        }
    } else {
        $aInsertReturn['msg'] = 'Mandatory Parameter Missing';
        $aInsertReturn['status'] = 'failed';
    }
    
    mysqli_close($iResourceId);
    return $aInsertReturn;
}

function updateTable($sTableName, $aUpdateColumn, $aCondition)
{
    $sUpdate = '';
    $sCondition = '';
    $updateCount = 0;
    $iConditionCount = 0;
    $iResourceId = createDataBaseConnection();
    $aUpdateReturn = array();
    $aUpdateReturn['status'] = 'success';
    if($sTableName && !empty($aUpdateColumn) && !empty($aCondition)) {
        foreach($aUpdateColumn as $key => $value) {
            if($updateCount == (count($aUpdateColumn)-1)) {
                $sUpdate .= $key.' = '.$value;
            } else {
                $sUpdate .= $key.' = '.$value.', ';
            }
            $updateCount++;
        }
        foreach($aCondition as $key => $value) {
            if($iConditionCount == (count($aCondition)-1)) {
                $sCondition .= $key.' = '.$value;
            } else {
                $sCondition .= $key.' = '.$value.' AND ';
            }
            $iConditionCount++;
        }
        $sQuery = "UPDATE ".$sTableName." SET $sUpdate WHERE $sCondition";
        $aUpdateReturn['msg'] = 'Update Query = '.$sQuery;
        mysqli_query($iResourceId, $sQuery);
        if(mysqli_errno($iResourceId)) {
            $aUpdateReturn['msg'] .= '; Mysql Error = '.mysqli_errno($iResourceId).'; Mysql Error Text = '.mysqli_error($iResourceId);
            $aUpdateReturn['status'] = 'failed';

            $aInput['sErrorFile']       = __FILE__;
            $aInput['sErrorFunction']   = __FUNCTION__;
            $aInput['sErrorCode']       = mysqli_errno($iResourceId);
            $aInput['sErrorMsg']        = mysqli_error($iResourceId);
            $aInput['sErrorQuery']      = $sQuery;
            $aInput['sStatus']          = $aUpdateColumn['status'];
            mysqlErrorReport($aInput);
            unset($aInput);
        }
    } else {
        $aUpdateReturn['msg'] = 'Mandatory Parameter Missing';
        $aUpdateReturn['status'] = 'failed';
    }
    mysqli_close($iResourceId);
    return $aUpdateReturn;
}

?>