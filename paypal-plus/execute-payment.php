<?php

require_once('access_token.php');
$access_token = token();

$PayerID = $_POST['payer_id'];
$PaymentID = $_POST['payment_id'];

//$accessToken = "A21AAG5T6Svn-0ktLuJWBwDflt1tY7YUg6f4dC_1PcfGRVTt5BV5o4LGxCnFNJd2Ywb32k7-B60fpZPUOIbgP45tklrP7-KPQ";
// $accessToken = "A21AAG4OJAYgzjxtk9nhLjdwtKLGrQcir1qnpaLyBizAmPsXTw8hP86xNuOoBh9rFiLCtk5M_ZZhVEsHxLPu9LehUvnIQaTCA";

$url = "https://api.sandbox.paypal.com/v1/payments/payment/" . $PaymentID . "/execute";
// $url = "https://api.paypal.com/v1/payments/payment/".$PaymentID."/execute";

$paymentHeaders = array("Content-Type: application/json", "Authorization: Bearer " . $access_token);

$postfields = "{\"payer_id\":\"$PayerID\"}";

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

file_put_contents('_execute_payment_log.json', $run);

// return $run;
echo $run;
