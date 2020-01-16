<?php 
$msg  = isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
if($msg == "invalid_msisdn"){
	$message = "Incorrect Number ! Please enter valid Etisalat Number";
}
else{
	$message = "Enter Your Etisalat Mobile Number";
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
<div class="bottombg page">
	<div class="txtbtm">
    	<div class="pagetop" style="bottom: 350px;">
    		<p class="entmob1" style="">Free for 24 hours then AED 3.25 per day</p>
            <p class="entmob1"><?php echo $message; ?> <br> <!--span>Shilpa Shetty Fitness APP</span> for unlimited Access to all Premium Content</p>
            <p class="entmob2">AED 3.25/Day</p-->
        </div>
        <form action="send_otp.php" id="sendOtp" method="post">
		<p class="txtblock" style="bottom: 300px;"><input type="text" class="otptxta" placeholder="+971" disabled><input type="text" name="msisdn" class="otptxt" placeholder="**********"></p>
        <p class="btnblk" style="bottom: 250px;">
        	<!--a href="Javascript:;" class="btnconfirm">Subscribe<br></a-->
        <input class="btnconfirm" type="submit" name="Subscribe" value="Subscribe"style="margin: 0;vertical-align: baseline;text-decoration: none;border-style: solid;border-width: 0px;padding: 7px 20px;cursor:pointer;"></p>
        </form>
		<p class="btncancel" style="bottom: 209px;"><a href="Javascript:;" class="btncancelconfirm">Exit<br></a></p>
      <!--p class="impact" style="height: 60px;">Easy Home-Based Workouts <br>Mind-Body Balance<br>Customised Nutrition Plan<br>Special Program for Women</p-->
	  <p class="entmob1" style="margin-top:110px;">Free for 24 hours then AED 3.25 per day</p>
	  <div class="entmob1">
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