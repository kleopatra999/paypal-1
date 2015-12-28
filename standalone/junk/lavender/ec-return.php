<?php

$username = 'ajl-store_api1.pp.com';
$password = 'YD5LVMJ5UM4XG78V';
$signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
$endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

/*$username = 'pierre_api1.lavendermagazine.com';
$password = 'D429H5SDMMGJJXQ7';
$signature = 'AOYOWU9BgNvyzp3DYmwREuBFY7Y0AW9DJJmEmGa0G1RSUX3.YHrhfanb';
$endpoint = 'https://api-3t.paypal.com/nvp';*/

/*$username = "sales_api1.thecolornine.com";
$password = "VQ6SAP5R4V6HWWBY";
$signature = "AFcWxV21C7fd0v3bYYYRCpSSRl31AQ2UAD3P08wNRW2jU8c22nn5jTZs";
$endpoint = 'https://api-3t.paypal.com/nvp';*/

// Get Data from URL
$payment_type = $_GET['type'];
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

// Set API Request Parameters
/*if($payment_type == 'single') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signature,
        'METHOD' => 'DoExpressCheckoutPayment',
        'VERSION' => '124.0',
        'TOKEN' => $ectoken,
        'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
        'PAYERID' => $payerid,
        'PAYMENTREQUEST_0_AMT' => $amount,
        'PAYMENTREQUEST_0_ITEMAMT' => $amount,
        'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
        'PAYMENTREQUEST_0_DESC' => 'One-Time Payment',
        'L_PAYMENTREQUEST_0_NAME0' => 'DVD',
        'L_PAYMENTREQUEST_0_AMT0' => $amount,
        'L_PAYMENTREQUEST_0_NUMBER0' => 'ABC123',
        'L_PAYMENTREQUEST_0_QTY0' => '1'
    );
}*/

// Get Express Checkout Details
// Convert API Params to NVP String
$nvp = toNVP($api_request_params);

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
echo "<h3>Get Express Checkout Details</h3>";
printVars($result_array);


$amount = $result_array['AMT'];
$payerid = $result_array['PAYERID'];
$payments = $result_array['PAYMENTREQUEST_0_CUSTOM'];
$invoicenum = $result_array['PAYMENTREQUEST_0_INVNUM'];
$date = time();
$format = "Y-m-d";
//date_format(date_create($date), $format);
$newdate = date($format, $date);


// Do Express Checkout Call
if($payment_type == 'single') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signature,
        'METHOD' => 'DoExpressCheckoutPayment',
        'VERSION' => '124.0',
        'TOKEN' => $ectoken,
        'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
        'PAYERID' => $payerid,
        'PAYMENTREQUEST_0_AMT' => $amount,
        'PAYMENTREQUEST_0_ITEMAMT' => $amount,
        'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
        'PAYMENTREQUEST_0_DESC' => 'One-Time Payment',
        'L_PAYMENTREQUEST_0_NAME0' => 'DVD',
        'L_PAYMENTREQUEST_0_AMT0' => $amount,
        'L_PAYMENTREQUEST_0_NUMBER0' => 'ABC123',
        'L_PAYMENTREQUEST_0_QTY0' => '1',
        'PAYMENTREQUEST_0_INVNUM' => $invoicenum
    );
}

elseif($payment_type == 'monthly') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signature,
        'METHOD' => 'CreateRecurringPaymentsProfile',
        'VERSION' => '124.0',
        'TOKEN' => $ectoken,
        'PAYERID' => $payerid,
        'PROFILESTARTDATE' => $newdate . 'T00:00:00Z',
        'DESC' => 'Lavender monthly subscription: $' . $amount . '/mo',
        'BILLINGPERIOD' => 'Month',
        'BILLINGFREQUENCY' => 1,
        'TOTALBILLINGCYCLES' => $payments,
        'AMT' => $amount,
        'CURRENCYCODE' => 'USD',
        'COUNTRYCODE' => 'US',
        'MAXFAILEDPAYMENTS' => '3',
        'PAYMENTREQUEST_0_INVNUM' => $invoicenum
    );
}

elseif($payment_type == 'biweekly') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signature,
        'METHOD' => 'CreateRecurringPaymentsProfile',
        'VERSION' => '124.0',
        'TOKEN' => $ectoken,
        'PAYERID' => $payerid,
        'PROFILESTARTDATE' => $newdate . 'T00:00:00Z',
        'DESC' => 'Lavender biweekly subscription: $' . $amount . '/2 weeks',
        'BILLINGPERIOD' => 'Day',
        'BILLINGFREQUENCY' => 14,
        'TOTALBILLINGCYCLES' => $payments,
        'AMT' => $amount,
        'CURRENCYCODE' => 'USD',
        'COUNTRYCODE' => 'US',
        'MAXFAILEDPAYMENTS' => '3',
        'PAYMENTREQUEST_0_INVNUM' => $invoicenum
    );
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
echo "<h3>Response</h3>";
printVars($result_array);

if($result_array['ACK'] == 'Success') {
    echo "<h3>Payment Complete!</h3>";
    echo "Amount: $" . $amount . "<br>";
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