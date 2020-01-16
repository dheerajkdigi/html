<?php
require_once '/var/www/html/billing/common_function/common_functions.php';
$logFilePath = '/var/log/billing/' . date('Y') . '/' . date('m') . '/app_api/app_api_log_' . date('Ymd') . '.log';

//$url = "https://appsandbox.theshilpashetty.com/api/v1/operators/create-subscription";//staging
$url = "https://app.theshilpashetty.com/api/v1/operators/create-subscription";//production
$appAccessToken = "56t4fPlQMPYOlfqC5e3hZgqrfdfiD06k";
$postData = array('user_mobile_no' => '9017836900','user_mobile_no_code' => '91','subscription_start' => '2019-10-12 19:50:00','subscription_end' => '2019-11-13 19:50:00','subscription_price' => '3.25','subscription_country_code' => 'IN','transaction_id' => '123456789','subscription_channel' => 'WAP','transaction_status' => '1');
$header = array(
    "Accept: application/json",
    "Access-Token: ".$appAccessToken
  );

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $postData,
  CURLOPT_HTTPHEADER => $header,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
} 
$logString = "URL:-".$url."|Data:-".json_encode($postData)."|Header:-".json_encode($header)."|Response:-".json_encode($response)."|Error:-".$err;

commonLogging($logString,$logFilePath);
?>