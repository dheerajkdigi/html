<?php
$msg  = isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
if($msg == "invalid_pin"){
	$message = "Incorrect Pin : please enter correct Pin";
}
else {
	
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
<div class="bottombg otp">
	<div class="txtbtm">
		<div class="pagetop" style="bottom: 355px;">
		<p class="entmob1" style="bottom:380px;">Welcome : +971<?php echo $_REQUEST['msisdn']; ?></p>
        <p class="entmob1" style="bottom:355px;">Please enter the Pin you received to activate your subscription</p>
		</div>
		<form action="verify_otp.php" id="verifyOtp" method="post">
	        <p class="txtblock" style="bottom:310px;">
	        	<input type="hidden" name="msisdn" value="<?php echo $_REQUEST['msisdn']; ?>">
	        	<input type="text" class="otptxt" name="pin" maxlength="6" placeholder="Enter the PIN" required>
	        </p>
	        <p class="resblock" style="bottom: 200px;">
	        	<a class="resendmob" href="javascript:;">Resend Me the pin</a>
	        </p>
	        <p class="btnblk" style="bottom:265px;">
	        	<!--a href="document.getElementById('verifyOtp').submit();" class="btnconfirm">SUBMIT</a-->
	        	<input class="btnconfirm" type="submit" name="Subscribe" value="SUBMIT"style="margin: 0;vertical-align: baseline;text-decoration: none;border-style: solid;border-width: 0px;padding: 7px 20px;cursor:pointer;"></p>
	        </p>
    	</form>
		<p class="btncancel" style="bottom:220px;">
			<a href="Javascript:;" class="btncancelconfirm">Exit<br></a>
		</p>
        <!--p class="impact" style="height: 60px;">Easy Home-Based Workouts <br>Mind-Body Balance<br>Customised Nutrition Plan<br>Special Program for Women</p-->
		<div class="entmob1" style="margin-top: 460px;">
	  Terms and Conditions:<br/>
		By clicking on the above subscribe button, you will agree on the below terms and conditions:
		<ul>
		<li>You will start the paid subscription after the free period automatically</li>
		<li>No commitment, you can cancel your subscription at anytime by sending Unsub SSFD to 1111</li>
		<li>To get support , please contact support@theshilpashetty.com</li>
		</ul>
	  </div>
    </div>
</div>
</body>
</html>