<?php

$partner = 'PayPal';
$vendor = '';
$user = '';
$password = '';
$endpoint = 'https://pilot-payflowpro.paypal.com';
$amount = "97.00";

// Set API Request Parameters
$api_request_params = array (
    // API Data
    'USER' => $user,
    'VENDOR' => $vendor,
    'PARTNER' => $partner,
    'PWD' => $password,
    'TRXTYPE' => 'S',
    'TENDER' => 'P',
    'ACTION' => 'S',
    'RETURNURL' => 'http://paypal.local/standalone/payflow/ec-return-recurring.php?amount=' . $amount,
    'CANCELURL' => 'http://paypal.local/standalone/payflow/ec-return-recurring.php',
    'AMT' => $amount,
    'BA_DESC' => 'Billing Agreement Description',
    'BILLINGTYPE' => 'MerchantInitiatedBilling',
    'BA_CUSTOM' => 'Billing Agreement custom details',
    'PAYMENTTYPE' => 'any',
);

// Display Post Date
echo "<h3>Data sent</h3>";
printVars($api_request_params);

// Convert API Params to NVP String
$nvp = toNVP($api_request_params);

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);
echo "<h3>Response</h3>";
printVars($result_array);

$ectoken = $result_array['TOKEN'];

echo "<h3>Checkout with PayPal</h3>";
echo "<a id='myContainer' href='https://www.sandbox.paypal.com/checkoutnow?token=$ectoken'></a>";

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