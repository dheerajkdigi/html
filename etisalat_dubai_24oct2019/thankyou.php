<?php
$msg  = isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';

switch($msg){
  case 'already_sub':
      $message  = "You are already subscribed to <br/><strong>Shilpa Shetty Fitness APP</strong><br/>Please login in app to boost your stemina.";
      break;
  case 'success':
      $message  = "You have successfully subscribed to <br/><strong>Shilpa Shetty Fitness APP</strong>
            <br/>We have sent you a confirmation SMS that includes your subscription details for your record.<br/>Please keep the message for future reference.";
      break;
  default:
      $message = "Uppss..Your request could not be processed. please try again later.";
      break;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Shilpa Shetty Fitness APP</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="css/styles-thankyou.css" rel="stylesheet">
  </head>

  <body>
    <div id="container">
      <div class="mobile_devices mobile">
        <img src="images/ss-400x400.jpg" alt="mobile devices">
      </div>
      <div class="right">
        <form>
          <center><h2>THANK YOU</h2>
          <br/>
          <?php echo $message; ?></center>
        </form> 
        <p class="desktop bold"></p>
        <!--p class="float-left"><b>Terms and Conditions :-</b>
        </p-->
        <div style="clear: both;"></div>
        <!--ul style="margin-left: 25px">
        	<li>The service automatically renews every Day</li>
        	<li>This special offer only for Etisalat customers</li>
        	<li>No commitment. You can cancel anytime by sending <b>C UDS</b> to <b>1110</b>.</li>
        </ul-->
        <br/>
      </div>
    </div>
    <!-- 
    <div class="footer">
    <p>Copyright Spuul 2015</p>
    </div> -->
  </body>
</html>