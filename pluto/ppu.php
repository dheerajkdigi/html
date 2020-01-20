<?php
require_once '/var/www/html/billing/common_function/common_functions.php';
$logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/pluto/void/portal_log_" . date('Ymd') . ".log";
$phpInput   = file_get_contents('php://input');
$sLog = __FILE__."|".json_encode($_REQUEST)."|".$phpInput;
commonLogging($sLog,$logPath);
$transId = date("ymdHis").rand(100000, 999999);
$price = 15;

$postData  = array('UserID' => "sskosmosis", 
				"Password" => "osmoskss123",
				"RequestID" => $transId,
				"Price" => $price,
				"TransactionType" => "P",
				"Product" => "Shilpa Shetty App");
$sLog = __FILE__."|postData|".json_encode($postData);
commonLogging($sLog,$logPath);
?>
<form action="http://m.PLUTO-mobile.com/Subscription/merchantsubscriptionrequest.aspx" method="POST">
	<?php foreach ($postData as $key => $value) { ?>
		<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
	<?php } ?>
	<input type="submit" name="Submit" value="Subscribe">
</form>