<?php

$username = 'ajl-store_api1.pp.com';
$password = 'YD5LVMJ5UM4XG78V';
$signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
$endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

// Get Data from URL
$amount = $_GET['amt'];
$ectoken = $_GET['token'];
$payerid = $_GET['PayerID'];

$api_request_params = array (
    // API Data
    'USER' => $username,
    'PWD' => $password,
    'SIGNATURE' => $signature,
    'VERSION' => '124.0',
    'METHOD' => 'GetExpressCheckoutDetails',
    'TOKEN' => $ectoken
);

// Get Express Checkout Details
// Convert API Params to NVP String
$nvp = toNVP($api_request_params);

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
/*echo "<h3>Get Express Checkout Details</h3>";
printVars($result_array);*/

$amount = $result_array['AMT'];
$payerid = $result_array['PAYERID'];

// Do Express Checkout Call
$api_request_params = array (
    // API Data
    'USER' => $username,
    'PWD' => $password,
    'SIGNATURE' => $signature,
    'METHOD' => 'DoExpressCheckoutPayment',
    'VERSION' => '124.0',
    'TOKEN' => $ectoken,
    'PAYERID' => $payerid,
);

// Get Payment Details from GetEC Call
$x = 0;
while($x < 5) {
    if(isset($result_array['PAYMENTREQUEST_' . $x . '_AMT'])) {
        $amount = $result_array['PAYMENTREQUEST_' . $x . '_AMT'];
        $email = $result_array['PAYMENTREQUEST_' . $x . '_SELLERPAYPALACCOUNTID'];
        $requestid = $result_array['PAYMENTREQUEST_' . $x . '_PAYMENTREQUESTID'];

        $api_request_params['PAYMENTREQUEST_' . $x . '_PAYMENTACTION'] = 'Sale';
        $api_request_params['PAYMENTREQUEST_' . $x . '_SELLERPAYPALACCOUNTID'] = $email;
        $api_request_params['PAYMENTREQUEST_' . $x . '_AMT'] = $amount;
        $api_request_params['PAYMENTREQUEST_' . $x . '_PAYMENTREQUESTID'] = $requestid;
    }
    $x++;
}

// Display Post Data
/*echo "<h3>Complete Payment Request</h3>";
printVars($api_request_params);*/

// Convert API Params to NVP String
$nvp = toNVP($api_request_params);

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
/*echo "<h3>Response</h3>";
printVars($result_array);*/

if($result_array['ACK'] == 'Success') {
    echo "<h3>Payment Complete!</h3>";
}
else {
    echo "Payment Failed";
}



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
?>