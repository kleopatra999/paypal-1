<?php

$username = 'ajl-store_api1.pp.com';
$password = 'YD5LVMJ5UM4XG78V';
$signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
$endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

// Get Data from URL
$ectoken = $_GET['token'];

$api_request_params = array (
    // API Data
    'USER' => $username,
    'PWD' => $password,
    'SIGNATURE' => $signature,
    'METHOD' => 'CreateRecurringPaymentsProfile',
    'VERSION' => '124.0',
    'TOKEN' => $ectoken,
    'SUBSCRIBERNAME' => 'Johnny Doeson',
    'PROFILESTARTDATE' => '2016-01-22T18:00:00Z',
    'DESC' => 'Hillary Clinton Monthly Donation',
    'MAXFAILEDPAYMENTS' => '3',
    'AUTOBILLAMT' => 'AddToNextBilling',
    'BILLINGPERIOD' => 'Month',
    'BILLINGFREQUENCY' => '1',
    'AMT' => '35.00',
    'FIRSTNAME' => 'John',
    'LASTNAME' => 'Doe',
    'STREET' => '1 Anything Street',
    'CITY' => 'Topeka',
    'STATE' => 'KS',
    'COUNTRYCODE' => 'US',
    'ZIP' => '66601',
    'CURRENCYCODE' => 'USD',
    'INITAMT' => '99.99'
);

// Get Express Checkout Details
// Convert API Params to NVP String
$nvp = toNVP($api_request_params);

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
echo "<h3>Get Express Checkout Details</h3>";
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

function nvpConvert($myString) {
    $ppResponse = array();
    parse_str($myString, $ppResponse);
    return $ppResponse;
}
?>