<?php
// API Credentials
$username = 'ajl-store_api1.pp.com';
$password = 'YD5LVMJ5UM4XG78V';
$signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
$endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

$username = "sales_api1.thecolornine.com";
$password = "VQ6SAP5R4V6HWWBY";
$signature = "AFcWxV21C7fd0v3bYYYRCpSSRl31AQ2UAD3P08wNRW2jU8c22nn5jTZs";
$endpoint = "https://api-3t.paypal.com/nvp";

// Constants
$returnurl = 'http://paypal.local/standalone/parallel/return.php';
$cancelurl = 'http://paypal.local/standalone/parallel/cancel.php';

// Receivers Array
$receivers = array(
    array('Email' => 'info@capleswebdev.com', 'Amount' => '150.00'),
    array('Email' => 'ajl-store@pp.com', 'Amount' => '100.00'),
    array('Email' => 'ajl-buyer@pp.com', 'Amount' => '50.00'),
    array('Email' => 'ajl-buyer2@pp.com', 'Amount' => '250.00'),
    array('Email' => 'caples69_30_biz@hotmail.com', 'Amount' => '16.00')
);

$receivers = array(
    array('Email' => 'oceinvestor2@ourcommunityexchange.com', 'Amount' => '150.00'),
    array('Email' => 'oceinvestor@ourcommunityexchange.com', 'Amount' => '100.00'),
    array('Email' => 'ocecorp@ourcommunityexchange.com', 'Amount' => '50.00'),
    array('Email' => 'ocecolfund@ourcommunityexchange.com', 'Amount' => '250.00'),
    array('Email' => 'funmommyof3@gmail.com', 'Amount' => '16.00')
);

// Set API Request Parameters
$api_request_params = array (
    // API Data
    'USER' => $username,
    'PWD' => $password,
    'SIGNATURE' => $signature,
    'METHOD' => 'SetExpressCheckout',
    'VERSION' => '124.0',
    'RETURNURL' => $returnurl,
    'CANCELURL' => $cancelurl,
);

$x = 0;
foreach($receivers as $rec) {
    $api_request_params['PAYMENTREQUEST_' . $x . '_PAYMENTACTION'] = 'Sale';
    $api_request_params['PAYMENTREQUEST_' . $x . '_SELLERPAYPALACCOUNTID'] = $rec['Email'];
    $api_request_params['PAYMENTREQUEST_' . $x . '_AMT'] = $rec['Amount'];
    $api_request_params['PAYMENTREQUEST_' . $x . '_PAYMENTREQUESTID'] = $x;
    $x++;
}

// Add parameters for PayPal Credit
//$api_request_params['USERSELECTEDFUNDINGSOURCE'] = 'BML';
$api_request_params['LANDINGPAGE'] = 'BILLING';
$api_request_params['SOLUTIONTYPE'] = 'SOLE';

printVars($api_request_params);

// Display Post Data
/*echo "<h3>Data sent</h3>";
printVars($api_request_params);*/

// Convert API Params to NVP String
$nvp = toNVP($api_request_params);

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
/*echo "<h3>Response</h3>";
printVars($result_array);*/

$ectoken = $result_array['TOKEN'];

echo "<h3>Checkout with PayPal</h3>";
echo "<a href='https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=$ectoken'>PayPal Checkout</a>";

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