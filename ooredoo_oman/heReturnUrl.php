<?php
require_once "../billing/common_function/common_functions.php";
require_once "productConfig.php";
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
if($_REQUEST['statusCode'] == "1") {
	$crypted_msisdn = $_REQUEST['token'];
	$cipher_method 	= 'AES-128-CBC';
	$enc_key 		= "n52y3zvv08";
	$msisdn 		= openssl_decrypt($crypted_msisdn, $cipher_method, $enc_key, 0);
	unset ($crypted_msisdn, $cipher_method, $enc_key);
	//echo "The MSISDN is: ".$token;
	$rUrl = 'send_otp.php?msisdn='.substr($msisdn,-8).'&plan=daily';
	
} else {
	$rUrl = 'msisdn.php?plan=daily';
	
}
$sLog = __FILE__."|statusCode:-".$_REQUEST['statusCode']."|token:- ".$_REQUEST['token']."|MSISDN:-".$msisdn."|rUrl:-".$rUrl;
commonLogging($sLog,$logFilePath);
header('Location:'.$rUrl);
exit;
?>