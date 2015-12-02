<?php

$headers = array(
    'X-PAYPAL-SECURITY-USERID: ajl-adaptive_api1.pp.com',
    'X-PAYPAL-SECURITY-PASSWORD: GWBYP2X6SCXF6MKF',
    'X-PAYPAL-SECURITY-SIGNATURE: AH3gwG.V2eBZv9iQOusIkMcormRRAZCdTaQi2skl1JwiTTfW4.WBRy9H',

    // Global Sandbox Application ID
    'X-PAYPAL-APPLICATION-ID: APP-80W284485P519543T',

    // Input and output formats
    'X-PAYPAL-REQUEST-DATA-FORMAT: NV',
    'X-PAYPAL-RESPONSE-DATA-FORMAT: JSON',
);
$api_params = array(
    'actionType' => 'PAY_PRIMARY',
    'senderEmail' => 'ajl-adaptive@pp.com',
    'cancelUrl' => 'http://your_cancel_url.com',
    'currencyCode' => 'USD',
    'receiverList.receiver(0).email' => 'andrew_user@paypal.com',
    'receiverList.receiver(0).amount' => '100.00',
    'receiverList.receiver(0).primary' => 'true',
    'receiverList.receiver(1).email' => 'andrew_business@paypal.com',
    'receiverList.receiver(1).amount' => '1.00',
    'receiverList.receiver(1).primary' => 'false',
    'requestEnvelope.errorLanguage' => 'en_US',
    'returnUrl' => 'http://google.com'
);

$endpoint = "https://svcs.sandbox.paypal.com/AdaptivePayments/Pay";

// Convert API Params to NVP String
echo "<h3>Data sent</h3>";
printVars($headers);
printVars($api_params);
$nvp = toNVP($api_params);

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp, $headers);

// Parse API response to NVP
//$result_array = nvpConvert($result);
echo "<h3>Response</h3>";
$result_array = json_decode($result);
printVars($result_array);

// Get PayKey and redirect
if($result_array->responseEnvelope->ack == "Success") {
    $paykey = $result_array->payKey;
    echo "Pay Key: " . $paykey;
    $redirect_link = "https://sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=$paykey";
    echo "<br><a href='$redirect_link'>$redirect_link</a>";
}
else {
    $errmsg = $result_array->error[0]->message;
    echo "<b>Error:</b> $errmsg";
}


//
// Helper Functions
//

// cURL function
function runCurl($api_endpoint, $nvp, $headers) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_URL, $api_endpoint);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp);
    curl_setopt($curl, CURLOPT_POST, 1);
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