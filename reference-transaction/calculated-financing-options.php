<?php

//https://developer.paypal.com/docs/api/payments/v1/#payment_execute
require_once('access_token.php');
$access_token = token();

$billingAgreementID = "B-0WB578755G084694N";
$value = "100.00";

$paymentHeaders = array("Content-Type: application/json", "Authorization: Bearer ".$access_token);


// source: https://developer.paypal.com/docs/api/payments/v1/#payment_execute

$url = "https://api.sandbox.paypal.com/v1/credit/calculated-financing-options";

// JSON FORMAT SOURCE : https://developer.paypal.com/docs/subscriptions/integrate/integrate-steps/#3-create-an-agreement
$postfields = '
{
  "financing_country_code": "BR",
  "transaction_amount": {
      "value": "'.$value.'",
      "currency_code": "BRL"
  },
  "funding_instrument": {
      "type": "BILLING_AGREEMENT",
      "billing_agreement": {
          "billing_agreement_id": "'.$billingAgreementID.'"
      }
  }
}
';



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

file_put_contents("_calculated-financing-options.json", $run);

echo $run;


?>
