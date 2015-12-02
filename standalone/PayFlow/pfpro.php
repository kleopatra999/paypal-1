<?php

if(!empty($_POST)) {
    $partner = 'PayPal';
    $vendor = 'alangsdonpaypal';
    $user = 'alpayflow';
    $password = 'paypal1234';
    $endpoint = 'https://pilot-payflowpro.paypal.com';

    // Set API Request Parameters
    $api_request_params = array (
        // API Data
        'USER' => $user,
        'VENDOR' => $vendor,
        'PARTNER' => $partner,
        'PWD' => $password,
        'TRXTYPE' => 'S',
        'TENDER' => 'C',
        'ACCT' => $_POST['cardnum'],
        'EXPDATE' => $_POST['expmonth'] . $_POST['expyear'],
        'CVV2' => $_POST['cvv'],
        'AMT' => $_POST['amount'],
        'FIRSTNAME' => $_POST['fname'],
        'LASTNAME' => $_POST['lname'],
        'STREET' => $_POST['street'],
        'CITY' => $_POST['city'],
        'STATE' => $_POST['state'],
        'ZIP' => $_POST['zip'],
        'CUSTNUM' => '38383838383',
        'COMMENT1' => '38383838383',
        'CUSTOM' => '38383838383',
        'CUSTOM1' => '38383838383',
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
}

// Show input form
else {
    ?>

    <div class="col-md-9">
        <div class="container">
            <div>
                <h1>PayPal Payments Pro</h1>
                <!-- User Input Form -->
                <form action="" method="post" id="user-input">

                    <div class="billing-info col-sm-5">
                        <h3>Billing Information</h3>
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" value="Johnny"/>
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lname" value="Walker"/>
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" name="street" value="927 N Palm Drive"/>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" value="Scottsdale"/>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" name="state" value="Arizona"/>
                        </div>
                        <div class="form-group">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="zip" value="85251"/>
                        </div>
                    </div>
                    <div class="payment-info col-sm-5">
                        <h3>Payment Information</h3>
                        <div class="form-group">
                            <label for="ctype">Card Type</label>
                            <input type="text" class="form-control" name="ctype" value="Visa"/>
                        </div>
                        <div class="form-group">
                            <label for="cardnum">Card Number</label>
                            <input type="text" class="form-control" name="cardnum" value="4716117123161472"/>
                        </div>
                        <div class="form-group">
                            <label for="expmonth">Expiration Month</label>
                            <input type="text" class="form-control" name="expmonth" value="08"/>
                        </div>
                        <div class="form-group">
                            <label for="expyear">Expiration Year</label>
                            <input type="text" class="form-control" name="expyear" value="16"/>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control" name="cvv" value="324"/>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount to Charge</label>
                            <input type="text" class="form-control" name="amount" value="29.99"/>
                        </div>
                    </div>
                    <div class="submit-button center col-sm-10">
                        <input type="submit" class="form-control" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php }

//
// Helper Functions for Processing
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