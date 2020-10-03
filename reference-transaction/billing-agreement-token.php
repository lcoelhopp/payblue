<?php

//https://developer.paypal.com/docs/api/payments/v1/#payment_create



//include 'access_token.php';
require_once('access_token.php');


$access_token = token();



     $endpoint = "https://api.sandbox.paypal.com/v1/billing-agreements/agreement-tokens";

     
      $paymentHeaders = array("Content-Type: application/json", "Authorization: Bearer ".$access_token);
     
      // JSON FORMAT SOURCE : https://developer.paypal.com/docs/api/overview/#make-your-first-call
      $postfields = '{
        "description": "Billing Agreement",
        "shipping_address":
        {
          "line1": "1350 North First Street",
          "city": "San Jose",
          "state": "CA",
          "postal_code": "95112",
          "country_code": "US",
          "recipient_name": "John Doe"
        },
        "payer":
        {
          "payment_method": "PAYPAL"
        },
        "plan":
        {
          "type": "MERCHANT_INITIATED_BILLING",
          "merchant_preferences":
          {
            "return_url": "https://example.com/return",
            "cancel_url": "https://example.com/cancel",
            "notify_url": "https://example.com/notify",
              "accepted_pymt_type": "INSTANT",
              "skip_shipping_address": false,
              "immutable_shipping_address": true
            }
          }
        }';

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

          
      file_put_contents('_billing-agreement-token-log.json',$run);

      echo $run;
