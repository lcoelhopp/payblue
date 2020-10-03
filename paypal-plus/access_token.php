<?php

function access_token()
{
  $clientId = 'AXCV2eC0BCFG1olo6HIqpYYdvXm3Q8QKo0ZLGI1RafbEngDL1FsnOk8uzCdTKfZ8ILGovNgiWae3U6oa';
  $secret = 'ECLSzbgWl3Uf52ozuGMcxr-bH5SEDHSZCE7Ntqo1DfVHiBhJPLmMRC5RQZX-w_Mq47JHbxcVn00UKhkz';
  $url = "https://api.sandbox.paypal.com/v1/oauth2/token";


  $headers = array(
    "Accept" => "application/json",
    "Accept-Language" => "en_US",
    "Content-Type" => "application/x-www-form-urlencoded",
  );
  $postfields = "grant_type=client_credentials";
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);

  curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_POST, true);

  // $run = curl_exec($ch);

  $result = curl_exec($ch);

  if (empty($result)) die("Error: No response.");
  else {
    $json = json_decode($result);
    //print_r($json->access_token);
    file_put_contents('_access_token_log.json', $result);
    return $json->access_token;
  }

  curl_close($ch);
}

access_token();
