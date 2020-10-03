<?php

//default_charset = "utf-8";

function token()
{

    $ch = curl_init();
    $clientId = "AXCV2eC0BCFG1olo6HIqpYYdvXm3Q8QKo0ZLGI1RafbEngDL1FsnOk8uzCdTKfZ8ILGovNgiWae3U6oa";
    $secret = "ECLSzbgWl3Uf52ozuGMcxr-bH5SEDHSZCE7Ntqo1DfVHiBhJPLmMRC5RQZX-w_Mq47JHbxcVn00UKhkz";
    $PAYPAL_API_URL = "https://api.paypal.com";


    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

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
//token();
