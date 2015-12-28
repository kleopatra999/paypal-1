<?php

$partner = 'PayPal';
$vendor = 'alangsdonpaypal';
$user = 'alpayflow';
$password = 'paypal1234';
$endpoint = 'https://pilot-payflowpro.paypal.com';
$ec_token = $_GET['token'];
$payerid = $_GET['PayerID'];
$amount = $_GET['amount'];

$api_request_params = array(
    'USER' => $user,
    'VENDOR' => $vendor,
    'PARTNER' => $partner,
    'PWD' => $password,
    'TRXTYPE' => 'S',
    'TENDER' => 'P',
    'ACTION' => 'G',
    'TOKEN' => $ec_token,
);

// Convert API Params to NVP String
$nvp = toNVP($api_request_params);
echo "<h3>GetExpressCheckoutDetails API Call</h3>";
printVars(nvpConvert($nvp));

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
echo "<h3>Response</h3>";
printVars($result_array);


//
// DoExpressCheckout - Complete payment and capture funds
//
$api_parameters = array(
    'USER' => $user,
    'VENDOR' => $vendor,
    'PARTNER' => $partner,
    'PWD' => $password,
    'TRXTYPE' => 'S',
    'TENDER' => 'P',
    'ACTION' => 'D',
    'TOKEN' => $ec_token,
    'PAYERID' => $payerid,
    'AMT' => $amount,
);

// Convert array to NVP string
$nvp = toNVP($api_parameters);
echo "<h3>DoExpressCheckout API Call</h3>";
printVars(nvpConvert($nvp));

// Run cURL call to post parameters to PayPal server
$result = runCurl($endpoint, $nvp);

// Convert NVP returned from cURL to array
$result_array = nvpConvert($result);

// Get Express Checkout Token from response
echo "<h3>DoExpressCheckout - Complete Payment</h3>";
printVars($result_array);

$baid = $result_array['BAID'];



//
// Create new Profile for PayPal Account
//
$api_parameters = array(
    'USER' => $user,
    'VENDOR' => $vendor,
    'PARTNER' => $partner,
    'PWD' => $password,
    'TRXTYPE' => 'R',
    'TENDER' => 'P',
    'ACTION' => 'A',
    'PROFILENAME' => 'RegularSubscription',
    'AMT' => $amount,
    'BAID' => $baid,
    'START' => '01172016',
    'PAYPERIOD' => 'WEEK',
    'TERM' => '12',
    'MAXFAILPAYMENTS' => '1',
    'RETRYNUMDAYS' => '1',
    'CURRENCY' => 'USD',
);

// Convert array to NVP string
$nvp = toNVP($api_parameters);
echo "<h3>Create Recurring Profile API Call</h3>";
printVars(nvpConvert($nvp));

// Run cURL call to post parameters to PayPal server
$result = runCurl($endpoint, $nvp);

// Convert NVP returned from cURL to array
$result_array = nvpConvert($result);

// Get Express Checkout Token from response
echo "<h3>Profile Complete</h3>";
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