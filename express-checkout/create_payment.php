<?php

//https://developer.paypal.com/docs/api/payments/v1/#payment_create


//include 'access_token.php';
require_once('access_token.php');


$access_token = token();



     $endpoint = "https://api.sandbox.paypal.com/v1/payments/payment";


      
      $paymentHeaders = array("Content-Type: application/json", "Authorization: Bearer ".$access_token);
      
      // JSON FORMAT SOURCE : https://developer.paypal.com/docs/api/overview/#make-your-first-call
      $postfields = '{
         "intent": "sale",
         "redirect_urls": {
           "return_url": "https://example.com/your_redirect_url.html",
           "cancel_url": "https://example.com/your_cancel_url.html"
         },
         "payer": {
           "payment_method": "paypal"
         },
         "transactions": [{
           "amount": {
             "total": "5.00",
             "currency": "BRL"
           }
         }]
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
        
      file_put_contents('create_payment_log.json',$run);

      echo $run;
