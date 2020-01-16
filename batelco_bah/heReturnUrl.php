<?php
require_once "../billing/common_function/common_functions.php";
//require_once "../billing/virgin_saudi/Virgin_Saudi_Billing.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/batelco_bah/portal_log_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
if(isset($_REQUEST['msisdn']) && $_REQUEST['msisdn']) {
	$crypted_msisdn = $_REQUEST['msisdn'];
	$cipher_method 	= 'AES-128-CBC';
	$enc_key 		= "AwfJruE6ISEJUEX1/14J5A==";
	$token 			= openssl_decrypt($crypted_msisdn, $cipher_method, $enc_key, 0);
	unset ($crypted_msisdn, $cipher_method, $enc_key);
	echo "The MSISDN is: ".$token;
} else {
	echo "HE Error statusCode: ".$_REQUEST['statusCode'];exit;
}
$sLog = __FILE__."|token: ".$_REQUEST['token']."|MSISDN:-".$token;
commonLogging($sLog,$logFilePath);
?>