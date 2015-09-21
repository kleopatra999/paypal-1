<?php

$username = 'ajl-store_api1.pp.com';
$password = 'YD5LVMJ5UM4XG78V';
$signatute = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
$endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

// Set API Request Parameters
if($payment_type == 'single') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signatute,
        'METHOD=SetExpressCheckout                   # API operation
    'RETURNURL=http://example.com/success.html   # URL displayed to buyer after authorizing transaction
'CANCELURL=http://example.com/canceled.html  # URL displayed to buyer after canceling transaction
'VERSION=93                                  # API version
    &PAYMENTREQUEST_0_CURRENCYCODE=USD
    &PAYMENTREQUEST_0_AMT=250                              # total amount of first payment
    &PAYMENTREQUEST_0_ITEMAMT=225
    &PAYMENTREQUEST_0_TAXAMT=25
    &PAYMENTREQUEST_0_PAYMENTACTION=Order
    &PAYMENTREQUEST_0_DESC=Sunset Sail for Two
                                           &PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID=<Receiver_1>   # PayPal e-mail of 1st receiver
&PAYMENTREQUEST_0_PAYMENTREQUESTID=CART286-PAYMENT0    # unique ID for 1st payment
    &PAYMENTREQUEST_1_CURRENCYCODE=USD
    &PAYMENTREQUEST_1_AMT=75                               # total amount of second payment
    &PAYMENTREQUEST_1_ITEMAMT=65
    &PAYMENTREQUEST_1_TAXAMT=10
    &PAYMENTREQUEST_1_PAYMENTACTION=Order
    &PAYMENTREQUEST_1_DESC=Sunset Wine and Cheese Plate for Two
                                                            &PAYMENTREQUEST_1_SELLERPAYPALACCOUNTID=<Receiver_2>   # PayPal e-mail of 2nd receiver
&PAYMENTREQUEST_1_PAYMENTREQUESTID=CART286-PAYMENT1    # unique ID for 1st payment
    &L_PAYMENTREQUEST_0_NAME0=Departs Santa Cruz Harbor Sunday at 3:10 PM
    &L_PAYMENTREQUEST_0_NAME1=Returns Santa Cruz Harbor 7:30 PM # begin secondary information
    &L_PAYMENTREQUEST_0_NUMBER0=Sunset Sail 22
    &L_PAYMENTREQUEST_0_QTY0=1                      # first ticket
    &L_PAYMENTREQUEST_0_QTY1=1                      # second ticket
    &L_PAYMENTREQUEST_0_AMT0=125                    # amount of first ticket
    &L_PAYMENTREQUEST_0_AMT1=100
    &L_PAYMENTREQUEST_0_TAXAMT0=15                  # tax on first ticket
    &L_PAYMENTREQUEST_0_TAXAMT1=10
    &L_PAYMENTREQUEST_0_DESC0=An amazing sail on the Monterey Bay.
&L_PAYMENTREQUEST_1_DESC0=Five cheeses, fruit, bread, and Pinot Noir"
    );
}

elseif($payment_type == 'monthly') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signatute,
        'METHOD' => 'SetExpressCheckout',
        'VERSION' => '124.0',
        'RETURNURL' => 'http://paypal.local/standalone/lavender/ec-return.php?type=monthly&frequency=10',
        'CANCELURL' => 'http://paypal.local/standalone/lavender/ec-return.php',
        'L_BILLINGTYPE0' => 'RecurringPayments',
        'BILLINGAGREEMENTDESCRIPTION' => 'Lavender monthly subscription: $' . $amount . '/mo',
        'BILLINGTYPE' => 'RecurringPayments',
        'PAYMENTREQUEST_0_AMT' => $amount,
        'PAYMENTREQUEST_0_CUSTOM' => $_GET['payments']
    );
}

elseif($payment_type == 'biweekly') {
    $api_request_params = array (
        // API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signatute,
        'METHOD' => 'SetExpressCheckout',
        'VERSION' => '124.0',
        'RETURNURL' => 'http://paypal.local/standalone/lavender/ec-return.php?type=biweekly',
        'CANCELURL' => 'http://paypal.local/standalone/lavender/ec-return.php',
        'L_BILLINGTYPE0' => 'RecurringPayments',
        'BILLINGAGREEMENTDESCRIPTION' => 'Lavender bi-weekly subscription: $' . $amount . '/2 weeks',
        'BILLINGTYPE' => 'RecurringPayments',
        'PAYMENTREQUEST_0_AMT' => $amount,
        'PAYMENTREQUEST_0_CUSTOM' => $_GET['payments']
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