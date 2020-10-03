<?php

//https://developer.paypal.com/docs/api/payments/v1/#payment_execute

require_once('access_token.php');
$access_token = token();



if (isset($_POST['paymentID'])) {
  $PaymentID = $_POST['paymentID'];
  $PayerID = $_POST['payerID'];

  // }else{
  //   $PaymentID = 'PAYID-L3IA7AQ8S8605112J071020F'; //peguei do create payment
  //   $PayerID = 'AB957WQ2FTAAJ'; // criei o create payment acessei a approval url e fui buscando na URL

}



$endpoint = "https://api.sandbox.paypal.com/v1/payments/payment/" . $PaymentID . "/execute";
$paymentHeaders = array("Content-Type: application/json", "Authorization: Bearer " . $access_token);
$postfields = "{\"payer_id\":\"$PayerID\"}";



// source: https://developer.paypal.com/docs/api/payments/v1/#payment_execute



$ch = curl_init();



curl_setopt($ch, CURLOPT_URL, $endpoint);
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

file_put_contents('execute_payment_log.json', $run);


echo $run;
echo $access_token;
