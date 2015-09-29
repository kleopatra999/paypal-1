<?php

$username = 'ajl-store_api1.pp.com';
$password = 'YD5LVMJ5UM4XG78V';
$signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
$endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

/*$username = 'pierre_api1.lavendermagazine.com';
$password = 'D429H5SDMMGJJXQ7';
$signature = 'AOYOWU9BgNvyzp3DYmwREuBFY7Y0AW9DJJmEmGa0G1RSUX3.YHrhfanb';
$endpoint = 'https://api-3t.paypal.com/nvp';*/

// Get Data from URL
$payment_type = $_GET['type'];
$amount = $_GET['amt'];
$invoicenum = $_GET['invoice'];

// Set API Request Parameters
if($payment_type == 'single') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signature,
        'METHOD' => 'SetExpressCheckout',
        'VERSION' => '124.0',
        'RETURNURL' => 'http://paypal.local/standalone/lavender/ec-return.php?type=single',
        'CANCELURL' => 'http://paypal.local/standalone/lavender/ec-cancel.php',
        'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
        'PAYMENTREQUEST_0_AMT' => $amount,
        'PAYMENTREQUEST_0_ITEMAMT' => $amount,
        'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
        'PAYMENTREQUEST_0_DESC' => 'One-Time Payment',
        'L_PAYMENTREQUEST_0_NAME0' => 'DVD',
        'L_PAYMENTREQUEST_0_AMT0' => $amount,
        'L_PAYMENTREQUEST_0_NUMBER0' => 'ABC123',
        'L_PAYMENTREQUEST_0_QTY0' => '1',
        'LANDINGPAGE' => 'Billing',
        'SOLUTIONTYPE' => 'Sole',
        'PAYMENTREQUEST_0_INVNUM' => $invoicenum
    );
}

elseif($payment_type == 'monthly') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signature,
        'METHOD' => 'SetExpressCheckout',
        'VERSION' => '124.0',
        'RETURNURL' => 'http://lavendermedia.com/lavender/ec-return.php?type=monthly&frequency=10',
        'CANCELURL' => 'http://lavendermedia.com/lavender/ec-cancel.php',
        'L_BILLINGTYPE0' => 'RecurringPayments',
        'BILLINGAGREEMENTDESCRIPTION' => 'Lavender monthly subscription: $' . $amount . '/mo',
        'BILLINGTYPE' => 'RecurringPayments',
        'PAYMENTREQUEST_0_AMT' => $amount,
        'PAYMENTREQUEST_0_CUSTOM' => $_GET['payments'],
        'PAYMENTREQUEST_0_INVNUM' => $invoicenum
    );
}

elseif($payment_type == 'biweekly') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signature,
        'METHOD' => 'SetExpressCheckout',
        'VERSION' => '124.0',
        'RETURNURL' => 'http://lavendermedia.com/lavender/ec-return.php?type=biweekly',
        'CANCELURL' => 'http://lavendermedia.com/lavender/ec-cancel.php',
        'L_BILLINGTYPE0' => 'RecurringPayments',
        'BILLINGAGREEMENTDESCRIPTION' => 'Lavender biweekly subscription: $' . $amount . '/2 weeks',
        'BILLINGTYPE' => 'RecurringPayments',
        'PAYMENTREQUEST_0_AMT' => $amount,
        'PAYMENTREQUEST_0_CUSTOM' => $_GET['payments'],
        'PAYMENTREQUEST_0_INVNUM' => $invoicenum
    );
}


// Display Post Date
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
echo "<a id='myContainer' href='https://www.sandbox.paypal.com/checkoutnow?token=$ectoken'></a>";

https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-4J9023936P402911S&force_sa=true

?>

    <!-- In-Context Checkout JS Code -->
    <script type="text/javascript">
        window.paypalCheckoutReady = function () {
            paypal.checkout.setup('ajl-seller@pp.com', {
                container: 'myContainer',
                environment: 'sandbox'
            });
        };
    </script>
    <script src="//www.paypalobjects.com/api/checkout.js" async></script>

<?


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