<?php
session_start();
require_once "productConfig.php";
$plan 		= strtolower($_REQUEST['plan']);
$plan 		= (isset($productConfig[$plan])) ? $plan : "daily";
$promo_id	= isset($_REQUEST['promo_id']) ? $_REQUEST['promo_id'] : '';
$msg  		= isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
$unsubKeyword = $productConfig[$plan]['unsubKeyword'];
if($msg == "invalid_pin"){
	$message = "Incorrect Pin : please enter correct Pin";
}
else {
	$message = "Please enter the Pin you received to activate your subscription";
}

$priceText 		= $productConfig[$plan]['priceTextEN'];
$sub_text 		= "Submit";
$exit_text 		= "Exit";
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
<div class="bottombg otp">
	<div class="txtbtm otg-col">
	<div class="no-padding">
		<div class="pagetop pagetop-col">
        	<p class="entmob1">Welcome : +960<?php echo $_REQUEST['msisdn']; ?></p>
        	<p class="entmob1"><?php echo $message; ?></p>
		</div>
		<form action="verify_otp.php" id="verifyOtp" method="post">
	        <p class="txtblock">
	        	<input type="hidden" name="msisdn" value="<?php echo $_REQUEST['msisdn']; ?>">
	        	<input type="hidden" name="plan" value="<?php echo $plan; ?>">
	        	<input type="hidden" name="promo_id" value="<?php echo $promo_id; ?>">
	        	<input type="text" class="otptxt" name="pin" maxlength="6" placeholder="Enter the PIN" required>
	        	
	        </p>
	        <!--p class="resblock">
	        	<a class="resendmob" href="javascript:;">Resend Me the pin</a>
	        </p-->
	        <p class="btnblk">
	        	<!--a href="document.getElementById('verifyOtp').submit();" class="btnconfirm">SUBMIT</a-->
	        	<input class="btnconfirm" type="submit" name="Subscribe" value="<?php echo $sub_text; ?>"style="margin: 0;vertical-align: baseline;text-decoration: none;border-style: solid;border-width: 0px;padding: 7px 20px;cursor:pointer;"></p>
	        </p>
    	</form>
		<p class="btncancel">
			<a href="Javascript:;" class="btncancelconfirm"><?php echo $exit_text; ?><br></a>
		</p>
        <!--p class="impact" style="height: 60px;">Easy Home-Based Workouts <br>Mind-Body Balance<br>Customised Nutrition Plan<br>Special Program for Women</p-->
        <p class="entmob1" style=""><?php echo $priceText; ?></p>
		<div class="entmob1 pagetop-col">
		  	Terms and Conditions:<br/>
			By clicking on the above subscribe button, you will agree on the below terms and conditions:
			<ul>
			<li>You will be renewed once validity over.</li>
			<li>To get support , please contact support@theshilpashetty.com</li>
			</ul>
	  	</div>
	  
	  </div>
    </div>
</div>
</body>
</html>