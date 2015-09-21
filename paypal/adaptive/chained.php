<?php

$username = 'ajl-store_api1.pp.com';
$password = 'YD5LVMJ5UM4XG78V';
$signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
$appid = 'APP-80W284485P519543T';
$api_endpoint = 'api.sandbox.paypal.com';

// Run cURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_URL, $api_endpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp);

// Set HTTP Headers
curl_setopt($curl, CURLOPT_HTTPHEADER,  array(
    'X-PAYPAL-REQUEST-DATA-FORMAT: NV',
    'X-PAYPAL-RESPONSE-DATA-FORMAT: NV',
    'X-PAYPAL-SECURITY-USERID: '. $username,
    'X-PAYPAL-SECURITY-PASSWORD: '. $password,
    'X-PAYPAL-SECURITY-SIGNATURE: '. $signature,
    'X-PAYPAL-APPLICATION-ID: '. $appid
));

$api_request_params = array(
    'actionType' => 'PAY',
    'clientDetails.applicationId' => 'APP-80W284485P519543T',
    'clientDetails.ipAddress' => '127.0.0.1',
    'currencyCode' => 'USD',
    'feesPayer' => 'EACHRECEIVER',
    'memo' => 'Example',
    'receiverList.receiver(0).amount' => '20.00',
    'receiverList.receiver(0).email' => 'adaptive-primary@pp.com',
    'receiverList.receiver(0).primary' => 'true',
    'receiverList.receiver(1).amount' => '10.00',
    'receiverList.receiver(1).email' => 'adaptive-rec1@pp.com',
    'receiverList.receiver(1).primary' => 'false',
    'receiverList.receiver(2).amount' => '10.00',
    'receiverList.receiver(2).email' => 'adaptive-rec2@pp.com',
    'receiverList.receiver(2).primary' => 'false',
    'requestEnvelope.errorLanguage' => 'en_US',
    'returnUrl' => 'http://www.yourdomain.com/success.html',
    'cancelUrl' => 'http://www.yourdomain.com/cancel.html',
);

// Convert API Params to NVP String
$nvp = toNVP($api_request_params);
echo "<h3>Data sent</h3>";
$data_sent = nvpConvert($nvp);
printVars($data_sent);

// Run cURL on endpoint & NVP string
$result = runCurl($api_endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
echo "<h3>Response</h3>";
printVars($result_array);












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

function nvpConvert($myString)
{
    $ppResponse = array();
    parse_str($myString, $ppResponse);
    return $ppResponse;
}