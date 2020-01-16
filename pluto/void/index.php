<?php
session_start();
require_once '/var/www/html/billing/common_function/common_functions.php';
$logPath = "/var/log/billing/" . date('Y') . "/" . date('m') . "/pluto/void/portal_log_" . date('Ymd') . ".log";
$phpInput   = file_get_contents('php://input');
$sLog = __FILE__."|".json_encode($_REQUEST)."|".$phpInput;
commonLogging($sLog,$logPath);
if(isset($_REQUEST["Message"]) && $_REQUEST["Message"]){
	header("Location:thankyou.php?msg=".$_REQUEST["Message"]);
}
$transId = date("ymdHis").rand(100000, 999999);
$price = 15.00;

$postData  = array('UserID' => "sskapiacce", 
				"Password" => "api!1234as",
				"RequestID" => $transId,
				"Price" => $price,
				"TransactionType" => "P",
				"Product" => "Shilpa Shetty App");
$sLog = __FILE__."|postData|".json_encode($postData);
commonLogging($sLog,$logPath);
$priceText = "Shilpa Shetty App Pay Per Use :- Rs 15/Day";

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
<link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700,700i,800,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Exo:400,800,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Oswald:400,600,700" rel="stylesheet">
<title>Shilpa Shetty Fitness APP</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="bottombg page">
	<div class="txtbtm">
    	<div class="pagetop">
	    	<p class="entmob1" style=""><?php echo $priceText; ?></p>
            <p class="entmob1"><?php echo $message; ?> <br> <!--span>Shilpa Shetty Fitness APP</span> for unlimited Access to all Premium Content</p>
            <p class="entmob2">AED 3.25/Day</p-->
        </div>
        <form action="http://m.pluto-mobile.com/Subscription/merchantsubscriptionrequest.aspx" method="POST">
		<?php foreach ($postData as $key => $value) { ?>
			<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
		<?php } ?>
        <p class="btnblk">
        <input class="btnconfirm" type="submit" name="Subscribe" value="Subscribe"style="margin: 0;vertical-align: baseline;text-decoration: none;border-style: solid;border-width: 0px;padding: 7px 20px;cursor:pointer;"></p>
        </form>
	
      <p class="entmob1"><?php echo $priceText; ?></p>
      
		  <div class="entmob1">
		  	To get support contact support@theshilpashetty.com
		  </div>
	
	</div>
		</div>
</body>
</html>