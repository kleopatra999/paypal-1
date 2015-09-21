<?php
$page_title = "PayFlow Express Checkout";

if(!empty($_POST)) {
    $partner = 'PayPal';
    $vendor = 'alangsdonpaypal';
    $user = 'alpayflow';
    $password = 'paypal1234';
    $endpoint = 'https://pilot-payflowpro.paypal.com';

    $invnum = rand(1000000, 90999999);

    // Set API Request Parameters
    $api_request_params = array (
        // API Data
        'USER' => $user,
        'VENDOR' => $vendor,
        'PARTNER' => $partner,
        'PWD' => $password,
        'TRXTYPE' => 'A',
        'TENDER' => 'P',
        'ACTION' => 'S',
        'AMT' => $_POST['amount'],
        'CURRENCY' => 'USD',
        'RETURNURL' => 'http://paypal.local/standalone/drhyman/return.php',
        'CANCELURL' => 'http://paypal.local/standalone/drhyman/cancel.php',
        'ORDERDESC' => 'Test Order for Express Checkout',
        'L_NAME0' => 'Burton Lucky Pant',
        'L_DESC0' => 'Womens Pants',
        'L_ITEMNUMBER0' => '123456',
        'L_COST0' => '14.00',
        'L_TAXAMT0' => '1.00',
        'L_QTY0' => '1',
        'INVNUM' => $invnum,
        'VERBOSITY' => 'high'
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




<?php }

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