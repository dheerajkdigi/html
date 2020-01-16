<?php
session_start();
//echo $promo_id;die;
require_once "productConfig.php";
require_once "../billing/common_function/common_functions.php";
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/etisalat_dubai/portal_' . date('Ymd') . '.log';
$sLog = __FILE__."|".json_encode($_REQUEST);
commonLogging($sLog,$logFilePath);
$plan 		= strtolower($_REQUEST['plan']);
$promo_id 	= $_REQUEST['promo_id'];
$plan 		= (isset($productConfig[$plan])) ? $plan : "daily";
$msg  		= isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
$unsubKeyword = $productConfig[$plan]['unsubKeyword'];
if($msg == "invalid_msisdn"){
	if($_SESSION['lang']=="arabic"){
		$message = "رقم غير صحيح ! الرجاء إدخال رقم اتصالات صالح ";
	}
	else{
		$message = "Incorrect Number ! Please enter valid Etisalat Number";
	}
}
else{
	if($_SESSION['lang']=="arabic"){
		$message = "  أدخل رقم هاتفك المحمول من اتصالات  ";
	}
	else{
		$message = "Enter Your Etisalat Mobile Number";
	}
}

if($_SESSION['lang']=="arabic"){
	$priceText 		= $productConfig[$plan]['priceTextAR'];
	$sub_text 		= " اشتراك  ";
	$exit_text 		= " خروج  ";
	$lang_option 	= "english";
	$lang_option_text = "English";
}
else {
	$priceText 		= $productConfig[$plan]['priceTextEN'];
	$sub_text 		= "Subscribe";
	$exit_text 		= "Exit";
	$lang_option 	= "arabic";
	$lang_option_text = " عربي  ";
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
	<div class="lang">
		
		<form action="/action_page.php">
			<p><a href="lang.php?lang=<?php echo $lang_option;?>" style="color: white"><?php echo $lang_option_text; ?></a></p>
			<!--select id="mySelect" onchange="location = this.value;">
				<option value="">Select a language:</option>
				<option value="index.php?lang=<?php echo $lang_option;?>" ><?php echo $lang_option_text; ?></option>
			</select-->
		  <!--select id="mySelect" onchange="location = this.value;">
			<option value="">Select a language:</option>
			<option value="index.php?lang=english" >English</option>
			<option value="index.php?lang=arabic" >Arabic</option>
		  </select-->
		</form>
	</div>
<div class="bottombg page">
	<div class="txtbtm">
    	<div class="pagetop">
	    	<p class="entmob1" style=""><?php echo $priceText; ?></p>
            <p class="entmob1"><?php echo $message; ?> <br> <!--span>Shilpa Shetty Fitness APP</span> for unlimited Access to all Premium Content</p>
            <p class="entmob2">AED 3.25/Day</p-->
        </div>
        <form action="send_otp.php" id="sendOtp" method="post">
		<p class="txtblock"><input type="text" class="otptxta" placeholder="+971" disabled><input type="text" name="msisdn" class="otptxt" placeholder="**********"></p>
		<input type="hidden" name="plan" value="<?php echo $plan; ?>">
		<input type="hidden" name="promo_id" value="<?php echo $promo_id; ?>">
        <p class="btnblk">
        	<!--a href="Javascript:;" class="btnconfirm">Subscribe<br></a-->
        <input class="btnconfirm" type="submit" name="Subscribe" value="<?php echo $sub_text; ?>"style="margin: 0;vertical-align: baseline;text-decoration: none;border-style: solid;border-width: 0px;padding: 7px 20px;cursor:pointer;"></p>
        </form>
		<p class="btncancel"><a href="./" class="btncancelconfirm"><?php echo $exit_text; ?><br></a></p>
      <!--p class="impact" style="height: 60px;">Easy Home-Based Workouts <br>Mind-Body Balance<br>Customised Nutrition Plan<br>Special Program for Women</p-->
      <p class="entmob1"><?php echo $priceText; ?></p>
      <?php if($_SESSION['lang'] == "arabic") { ?>
		  <div class="entmob1">
		  	الأحكام والشروط:
		  <br/>
			بالنقر على زر الاشتراك أعلاه ، فإنك توافق على الشروط والأحكام التالية:
			<ul>
			<li>ستبدأ الاشتراك المدفوع بعد الفترة المجانية تلقائيًا</li>
			<li>لا يوجد التزام ، يمكنك إلغاء اشتراكك في أي وقت عن طريق إرسال  <?php echo $unsubKeyword;?> إلى 1111</li>
			<li>للحصول على الدعم ، يرجى الاتصال suppot@theshilpashetty</li>
			</ul>
		  </div>
      <?php } else { ?>
		  <div class="entmob1">
		  Terms and Conditions:<br/>
			By clicking on the above subscribe button, you will agree on the below terms and conditions:
			<ul>
			<li>You will start the paid subscription after the free period automatically</li>
			<li>No commitment, you can cancel your subscription at anytime by sending <?php echo $unsubKeyword;?> to 1111</li>
			<li>To get support , please contact support@theshilpashetty.com</li>
			</ul>
		  </div>
	<?php } ?>
	</div>
		</div>
</body>
</html>