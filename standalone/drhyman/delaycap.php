<?php
// Store API Credentials
$partner = 'PayPal';
$vendor = 'alangsdonpaypal';
$user = 'alpayflow';
$password = 'paypal1234';
$api_endpoint = 'https://pilot-payflowpro.paypal.com';

// ##############################
// This section would get handled by the fulfillment team
// ##############################
$pnref = $_GET['pnref'];

//
// Do the delayed Capture and get the funds
// The PNREF should be sent over to fulfillment
// team to capture the funds on the authorization
//
$api_parameters = array(
    'USER' => $user,
    'VENDOR' => $vendor,
    'PARTNER' => $partner,
    'PWD' => $password,
    'TRXTYPE' => 'D', // Delayed Capture
    'TENDER' => 'P',
    'ORIGID' => $pnref
);

// Convert array to NVP string
$nvp = toNVP($api_parameters);

// Run cURL call to post parameters to PayPal server
$result = runCurl($api_endpoint, $nvp);

// Convert NVP returned from cURL to array
$result_array = nvpConvert($result);

// Get Express Checkout Token from response
echo "<h3>Delayed Capture - Complete Payment</h3>";
printVars($result_array);


// Helper Functions
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
function nvpConvert($myString) {
    $ppResponse = array();
    parse_str($myString, $ppResponse);
    return $ppResponse;
}