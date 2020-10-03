<?php

require_once('access_token.php');

$access_token = access_token();

$url = "https://api.sandbox.paypal.com/v1/payments/payment";

$headers = array("Content-Type: application/json", "Authorization: Bearer " . $access_token);

$postfields = '{
"intent":"sale",
"redirect_urls":{
    "return_url":"www.sometest.com/success",
    "cancel_url":"www.sometest.com/cancel"
},
"payer":{
    "payment_method":"paypal"
},
"application_context":{
    "brand_name":"Casulo",
    "shipping_preference":"NO_SHIPPING"
},
"transactions":[
    {
        "amount":{
          "total":"112.11",
          "currency":"BRL",
          "details":{
            "subtotal":"112.11"
          }
        },
  "description":"Order From Test.com",
  "payment_options":{
  "allowed_payment_method":"IMMEDIATE_PAY"
        },
        "item_list":{
          "items":[
            {
                "name":"God Of War",
                "description":"God Of War ps4",
                "quantity":1,
                "price":"112.11",
                "sku":"#33",
                "currency":"BRL"
            }
          ]
        }
    }
]
}';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_POST, true);

$run = curl_exec($ch);

// $runObj = json_decode($run);

// $myArray = json_decode($run, 1);

// file_put_contents("_create_payment_log.json", $run);

curl_close($ch);

$runObj = json_decode($run);

$myArray = json_decode($run, 1);

file_put_contents("_create_payment_log.json", $run);

echo "<p><span id='payment_id' class='hideThisPlease'>" . $myArray['id'] . "</span></p>";
echo "<p><span id='approval_url' class='hideThisPlease'>" . $myArray['links'][1]['href'] . "</span></p>";
echo "<p><span id='execute_url' class='hideThisPlease'>" . $myArray['links'][2]['href'] . "</span></p>";
echo "<script>console.log('$run')</script>";
