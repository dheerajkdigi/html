<?php 
require_once "../billing/common_function/common_functions.php";
require_once "productConfig.php";
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);

$plan 			= strtolower($_REQUEST['plan']);
$plan 			= (isset($productConfig[$plan])) ? $plan : "daily";
$msg  			= isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
$unsubKeyword 	= $productConfig[$plan]['unsubKeyword'];
$priceText 		= $productConfig[$plan]['priceTextEN'];

if($msg == "invalid_msisdn"){
	$message = "Incorrect Number ! Please Enter Valid Ooredoo Mobile Number";
} else if($msg == "billing_error"){
	$message = "Something went wrong ! Please Enter Valid Ooredoo Mobile Number";
}
else{
	$message = "Enter Your Ooredoo Mobile Number";
}
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
	<!--div class="lang">
		<form action="/action_page.php">
		  <select id="mySelect" onchange="copy();">
			<option value="">Select a language:</option>
			<option value="English" >English</option>
			<option value="Arabic" >Arabic</option>
		  </select>
		</form>
	</div-->
<div class="bottombg page">
	<div class="txtbtm">
    	<div class="pagetop">
    		<p class="entmob1">To subscribe in Shilpa Shetty Fitness APP service, please click on the below button to send you the pin code</p>
            <p class="entmob1"><?php echo $message; ?> <br> <!--span>Shilpa Shetty Fitness APP</span> for unlimited Access to all Premium Content</p>
            <p class="entmob2">AED 3.25/Day</p-->
        </div>
        <form action="send_otp.php" id="sendOtp" method="post">
		<p class="txtblock"><input type="text" class="otptxta" placeholder="+968" disabled><input type="text" name="msisdn" class="otptxt" placeholder="**********"></p>
		<input type="hidden" name="plan" value="<?php echo $plan; ?>">
        <p class="btnblk">
        	<!--a href="Javascript:;" class="btnconfirm">Subscribe<br></a-->
        <input class="btnconfirm" type="submit" name="Subscribe" value="Subscribe"style="margin: 0;vertical-align: baseline;text-decoration: none;border-style: solid;border-width: 0px;padding: 7px 20px;cursor:pointer;"></p>
        </form>
		<!--p class="btncancel"><a href="Javascript:;" class="btncancelconfirm">Exit<br></a></p-->
      <!--p class="impact" style="height: 60px;">Easy Home-Based Workouts <br>Mind-Body Balance<br>Customised Nutrition Plan<br>Special Program for Women</p-->
	  <p class="entmob1"><?php echo $priceText; ?></p>
	  <div class="entmob1">
	  Terms and Conditions:<br/>
		By clicking on the above subscribe button, you will agree on the below terms and conditions:
		<ul>
		<li>You will start the paid subscription after the free period automatically</li>
		<li>No commitment, you can cancel your subscription at anytime by sending <?php echo $unsubKeyword;?> to 300304</li>
		<li>To get support , please contact support@theshilpashetty.com</li>
		</ul>
	  </div>
	</div>
		</div>
</body>
</html>