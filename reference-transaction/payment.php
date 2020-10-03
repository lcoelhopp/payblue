<?php

//https://developer.paypal.com/docs/api/payments/v1/#payment_execute
require_once('access_token.php');
$access_token = token();

$billingAgreementID = "B-0WB578755G084694N";
$value = 100;
$term = 4;
$montly_payment = ($value / $term); //apply cost to buyer "CTB"


$paymentHeaders = array("Content-Type: application/json", "Authorization: Bearer " . $access_token);


// source: https://developer.paypal.com/docs/api/payments/v1/#payment_execute

$url = "https://api.sandbox.paypal.com/v1/payments/payment";


// JSON FORMAT SOURCE : https://developer.paypal.com/docs/subscriptions/integrate/integrate-steps/#3-create-an-agreement
$postfields = '
{
   "intent":"sale",
   "payer":{
      "payment_method":"paypal",
      "funding_instruments":[
         {
            "billing":{
               "billing_agreement_id":"' . $billingAgreementID . '",
               "selected_installment_option":{
                  "term":"' . $term . '",
                  "monthly_payment":{
                     "value":"' . $montly_payment . '",
                     "currency":"BRL"
                  },
                  "discount_percentage":"0",
                  "discount_amount":{
                     "value":"0",
                     "currency":"BRL"
                  }
               }
            }
         }
      ]
   },
   "transactions":[
      {
         "amount":{
            "currency":"BRL",
            "total":"' . $value . '"
         },
         "description":"This is the description of the transaction",
         "custom":"custom123",
         "payment_options":{
            "allowed_payment_method":"IMMEDIATE_PAY"
         },
         "item_list":{
            "shipping_address":{
               "recipient_name":"Nome Recebedor",
               "line1":"Avenida Paulista, 1048",
               "line2":"Bela Vista",
               "city":"Sao Paulo",
               "country_code":"BR",
               "postal_code":"01310-100",
               "state":"Sao Paulo",
               "phone":"911111111"
            },
            "items":[
               {
                  "name":"Item Teste",
                  "description":"Descricao Item Teste",
                  "quantity":"1",
                  "price":"' . $value . '",
                  "tax":"0",
                  "sku":"sku123",
                  "currency":"BRL"
               }
            ]
         }
      }
   ],
   "redirect_urls":{
      "return_url":"https://www.yourreturnurlhere.com",
      "cancel_url":"https://www.yourcancelurlhere.com"
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

file_put_contents("_payment.json", $run);

echo $run;
