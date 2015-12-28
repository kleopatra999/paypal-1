<?php

$username = 'ajl-store_api1.pp.com';
$password = 'YD5LVMJ5UM4XG78V';
$signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
$endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
$version = '120';

// Set API Request Parameters
$api_request_params = array(
    // API Data
    'USER' => $username,
    'PWD' => $password,
    'SIGNATURE' => $signature,
    'VERSION' => $version,

    // API Transaction Data
    'METHOD' => 'SetExpressCheckout',
    'RETURNURL' => 'http://paypal.local/standalone/PayPal/ec-return.php',
    'CANCELURL' => 'http://paypal.local/standalone/PayPal/ec-cancel.php',
    'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
    'PAYMENTREQUEST_0_AMT' => '450.00',
    'PAYMENTREQUEST_0_ITEMAMT' => '400.00',
    'PAYMENTREQUEST_0_SHIPPINGAMT' => '20.00',
    'PAYMENTREQUEST_0_TAXAMT' => '30.00',
    'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
    'PAYMENTREQUEST_0_DESC' => 'Express Checkout Testing',
    'L_PAYMENTREQUEST_0_NAME0' => 'Laptop Computer',
    'L_PAYMENTREQUEST_0_AMT0' => '300.00',
    'L_PAYMENTREQUEST_0_NUMBER0' => 'LAPPY',
    'L_PAYMENTREQUEST_0_QTY0' => '1',
    'L_PAYMENTREQUEST_0_NAME1' => 'Speakers',
    'L_PAYMENTREQUEST_0_AMT1' => '50.00',
    'L_PAYMENTREQUEST_0_NUMBER1' => 'SPEAK-248',
    'L_PAYMENTREQUEST_0_QTY1' => '2'
);

// Convert API Params to NVP String
$nvp = toNVP($api_request_params);
echo "<h3>Data sent</h3>";
printVars(nvpConvert($nvp));

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
echo "<h3>Response</h3>";
printVars($result_array);

$ectoken = $result_array['TOKEN'];

echo "Checkout with PayPal\n\n";
$link = "https://sandbox.paypal.com/checkoutnow?token=$ectoken";
echo "<a href='$link' id='myContainer'></a>"; // Image will get generated automatically by JS below

// Include JavaScript for In-Context Flow
?>

<script>
    window.paypalCheckoutReady = function () {
        paypal.checkout.setup('<Your-Merchant-ID>', {
            environment: 'sandbox',
            container: 'myContainer'
        });
    };
</script>

<script src="//www.paypalobjects.com/api/checkout.js" async></script>


<?php
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