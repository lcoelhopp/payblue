<?php

//https://developer.paypal.com/docs/api/payments/v1/#payment_execute
$token_id = $_POST["baToken"];
require_once('access_token.php');
$access_token = token();

$paymentHeaders = array("Content-Type: application/json", "Authorization: Bearer ".$access_token);


// source: https://developer.paypal.com/docs/api/payments/v1/#payment_execute

$url = "https://api.sandbox.paypal.com/v1/billing-agreements/agreements";

// JSON FORMAT SOURCE : https://developer.paypal.com/docs/subscriptions/integrate/integrate-steps/#3-create-an-agreement
$postfields = '{
  "token_id": "'.$token_id.'"
}';



$ch = curl_init();



curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $paymentHeaders);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);



curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_POST, true);



$run = curl_exec($ch);

curl_close($ch);

file_put_contents("_billing-agreement-create.json", $run);

echo $run;


?>
