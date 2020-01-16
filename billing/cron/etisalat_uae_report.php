<?php
require_once '/var/www/html/billing/common_function/update_userbase.php';
require_once '/var/www/html/billing/common_function/common_functions.php';
require_once '/var/www/html/billing/common_function/PHPMailer/SSMail.php';

$yesterday = strtotime("-1 days");
$date = date("Ymd", $yesterday);
$year = date("Y", $yesterday);
$month = date("m", $yesterday);
$attachment1 = "/tmp/etisalat_uae_hits_".$date.".txt";

$command1 = "cat /var/log/billing/".$year."/".$month."/etisalat_dubai/api_".$date.".log |grep 'verify_otp'|grep SS001 >> /tmp/etisalat_uae_hits_".$date.".txt";
$command2 = "cat /var/log/billing/".$year."/".$month."/etisalat_dubai/sdp_callback_".$date.".log >> /tmp/etisalat_uae_callback_log_".$date.".txt";
exec($command1);
exec($command2);
$iResourceId = createDataBaseConnection();
$qry = "select msisdn,event_id, type_name, rate, added_on INTO OUTFILE '/tmp/etisalat_uae_callback_".$date.".csv' FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' from billing.etisalat_dubai_txn where date(added_on) = '".date("Y-m-d", $yesterday)."'";

try {
	$res = mysqli_query($iResourceId,$qry);
	echo $res;
} catch (Exception $e) {
	print_r($e);
}

/*
$to 		= array(0 => array("name"=>"Awanish Singh","addr"=>"awanish_bhu88@yahoo.co.in"));
$from  		= array(0 => array("name"=>"Report","addr"=>"avtech.digi@gmail.com"));
//$from 		= "";
$cc 		= "";
$bcc 		= "";
$subject 	= "SS Test";
$htmlBody 	= "Test Mail";
$attachment = array($attachment1);
$SSMail 	= new SSMail();
//print_r($SSMail);
$sendMail = $SSMail->sendMail($to, $from, $subject, $htmlBody, $cc, $bcc);
print_r($sendMail);
echo "sent";
*/
?>