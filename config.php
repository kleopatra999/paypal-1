<?php

$config = array(
    'paypalpro' => array(
        'username' => 'ajl-store_api1.pp.com',
        'password' => 'YD5LVMJ5UM4XG78V',
        'signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt',
        'endpoint' => 'https://api-3t.sandbox.paypal.com/nvp'
    ),
    'payflow' => array(
        'partner' => 'PayPal',
        'vendor' => 'alangsdonpaypal',
        'user' => 'alpayflow',
        'pwd' => 'paypal1234',
        'endpoint' => 'https://pilot-payflowpro.paypal.com'
    ),
    'braintree' => array(

    ),
    'version' => '117'
);

//
// Helper Functions
//

// cURL function
function runCurl($api_endpoint, $nvp) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_URL, $api_endpoint);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp);
    $result = curl_exec($curl);

    return $result;
}

// Print Array in Preformat
function printVars($array) {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

// Convert Parameters Array to NVP
function toNVP($array) {
    $i = 0;
    $nvp = "";
    foreach($array as $key => $val) {
        if($i != 0) {
            $nvp .= "&";
        }
        $nvp .= $key . '=' . $val;
        $i++;
    }
    return $nvp;
}

function ppResponse($myString) {
    $ppResponse = array();
    parse_str($myString, $ppResponse);
    return $ppResponse;
}

function nvpConvert($myString) {
    $ppResponse = array();
    parse_str($myString, $ppResponse);
    return $ppResponse;
}