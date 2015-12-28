<?php
$page_title = "PayFlow Express Checkout";
include_once("../header.php");
include_once("../sidebar.php");

if(!empty($_POST)) {
    $partner = 'PayPal';
    $vendor = 'alangsdonpaypal';
    $user = 'alpayflow';
    $password = 'paypal1234';
    $endpoint = $config['payflow']['endpoint'];

    $invnum = rand(1000000, 90999999);

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
        'RETURNURL' => 'http://return.com',
        'CANCELURL' => 'http://cancel.com?AMT=10.00',
        'BA_DESC' => 'purchase Time Magazine',
        'BILLINGTYPE' => 'MerchantInitiatedBilling',
        'BA_CUSTOM' => 'add magazine subscription',
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
    echo "<a id='myContainer' href='https://www.sandbox.paypal.com/checkoutnow?token=$ectoken'><img src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png' /></a>";
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



<?php }
include_once("../footer.php");
?>