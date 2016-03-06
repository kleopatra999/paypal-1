<?

$username = '';
$password = '';
$signature = '';
$endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
$version = '120';


if(!empty($_POST)) {
    if($_POST['transtype'] == 'authorization') {
        // Set API Request Parameters
        $invnum = rand(111111, 999999);
        $api_request_params = array(
            // API Data
            'USER' => $username,
            'PWD' => $password,
            'SIGNATURE' => $signature,
            'VERSION' => $version,

            // API Transaction Data
            'METHOD' => 'DoCapture',
            'AUTHORIZATIONID' => $_POST['authorizationid'],
            'AMT' => $_POST['payamt'],
            'CURRENCYCODE' => 'USD',
            'COMPLETETYPE' => 'Complete',
            'INVNUM' => $invnum
        );


        // Convert API Params to NVP String
        $nvp = toNVP($api_request_params);
        echo "<h3>Data sent</h3>";
        printVars($api_request_params);

        // Run cURL on endpoint & NVP string
        $result = runCurl($endpoint, $nvp);

        // Parse API response to NVP
        $result_array = nvpConvert($result);
        echo "<h3>Response</h3>";
        echo printVars($result_array);
    }
    else {

        // Set API Request Parameters
        $api_request_params = array(
            // API Data
            'USER' => $username,
            'PWD' => $password,
            'SIGNATURE' => $signature,
            'VERSION' => $version,

            // API Transaction Data
            'METHOD' => 'DoDirectPayment',
            'PAYMENTACTION' => $_POST['paymentaction'],
            'IPADDRESS' => $_SERVER['REMOTE_ADDR'],

            // Credit Card Data
            'ACCT' => $_POST['cardnum'],
            'EXPDATE' => $_POST['expmonth'] . $_POST['expyear'],
            'CVV2' => $_POST['cvv'],

            // Customer Information
            'FIRSTNAME' => $_POST['fname'],
            'LASTNAME' => $_POST['lname'],

            // Address Fields
            'STREET' => $_POST['street'],
            'CITY' => $_POST['city'],
            'STATE' => $_POST['state'],
            'COUNTRYCODE' => 'US',
            'ZIP' => $_POST['zip'],

            // Payment Details
            'AMT' => $_POST['amount'],
            'CURRENCYCODE' => 'USD',
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

        if ($api_request_params['PAYMENTACTION'] == "Authorization") {
            $payamt = $result_array['AMT'];
            $authorizationid = $result_array['TRANSACTIONID'];
            ?>
            <form method="post">
                <label for="payamt">Capture Amount: </label><input type="text" name="payamt" value="<?php echo $payamt; ?>">
                <input type="hidden" name="authorizationid" value="<?php echo $authorizationid; ?>"/>
                <input type="hidden" name="transtype" value="authorization"/>
                <input type="submit" name="submit" value="Capture"/>
            </form>
            <?
        }
    }
}

// Show input form
else {
    ?>
    <h1>PayPal Payments Pro</h1>
    <!-- User Input Form -->
    <form action="" method="post" id="user-input">
        <div class="billing-info">
            <h3>Billing Information</h3>
            <div>
                <label for="fname">First Name</label>
                <input type="text" name="fname" value="Johnny"/>
            </div>
            <div>
                <label for="lname">Last Name</label>
                <input type="text" name="lname" value="Walker"/>
            </div>
            <div>
                <label for="street">Street</label>
                <input type="text" name="street" value="927 N Palm Drive"/>
            </div>
            <div>
                <label for="city">City</label>
                <input type="text" name="city" value="Scottsdale"/>
            </div>
            <div>
                <label for="state">State</label>
                <input type="text" name="state" value="Arizona"/>
            </div>
            <div>
                <label for="zip">Zip</label>
                <input type="text" name="zip" value="85251"/>
            </div>
        </div>
        <div class="payment-info">
            <h3>Payment Information</h3>
            <div>
                <label for="cardnum">Card Number</label>
                <input type="text" name="cardnum" value="4532672682018796" maxlength="16"/>
            </div>
            <div class="form-group col-md-4 no-pad-left">
                <label for="expmonth">Exp. Month</label>
                <input type="text" name="expmonth" value="08" maxlength="2"/>
            </div>
            <div class="form-group col-md-4 no-pad-left">
                <label for="expyear">Exp. Year</label>
                <input type="text" name="expyear" value="2016" maxlength="4">
            </div>
            <div class="form-group col-md-4 no-pad-left no-pad-right">
                <label for="cvv">CVV</label>
                <input type="text" name="cvv" value="324" maxlength="3"/>
            </div>
            <div>
                <label for="paymentaction">Payment Action</label>
                <select name="paymentaction">
                    <option value="Sale" selected>Sale</option>
                    <option value="Authorization">Authorization</option>
                </select>
            </div>
            <div>
                <label for="cardnum">Payment Amount</label>
                <input type="text" name="amount" value="50.00"/>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="submit-button center col-md-6">
            <input type="submit" value="Submit" />
        </div>
    </form>


<?php }

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