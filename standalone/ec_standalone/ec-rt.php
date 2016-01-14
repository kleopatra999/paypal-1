<?php

if(!empty($_POST)) {
    $username = 'ajl-store_api1.pp.com';
    $password = 'YD5LVMJ5UM4XG78V';
    $signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31An2lKOUMq2vaAfb7ZG-4Zz5VPPBt';
    $endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

    $amount = $_POST['amount'];

    // Set API Request Parameters
    $api_request_params = array(// API Data
        'USER' => $username,
        'PWD' => $password,
        'SIGNATURE' => $signature,
        'METHOD' => 'SetExpressCheckout',
        'VERSION' => '124.0',
        'RETURNURL' => 'http://paypal.local/standalone/ec_standalone/ec-rt-return.php',
        'CANCELURL' => 'http://paypal.local/standalone/ec_standalone/ec-cancel.php',
        'BILLINGAGREEMENTDESCRIPTION' => 'EC Reference Billing Agreement',
        'BILLINGTYPE' => 'MerchantInitiatedBilling',
        'AMT' => '20.00'
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
}


// Show input form
else {
    ?>

    <div class="col-md-9">
        <div class="container">
            <div>
                <h1>PayFlow Express Checkout</h1>
                <!-- User Input Form -->
                <form action="" method="post" id="user-input">
                    <div class="billing-info col-sm-5">
                        <h3>Billing Information</h3>
                        <div class="form-group">
                            <label for="fname">Payment Amount</label>
                            <input type="text" class="form-control" name="amount" value="15.00"/>
                        </div>
                        <div class="submit-button center col-sm-5">
                            <input type="submit" class="form-control" value="Submit" />
                        </div>
                </form>
            </div>
        </div>
    </div>



<?php } ?>

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
?>