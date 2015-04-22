<?php
    $page_title = "PayPal Payments Pro";
    include_once("../header.php");
    include_once("../sidebar.php");

    if(!empty($_POST)) {
        $username = $config['paypalpro']['username'];
        $password = $config['paypalpro']['password'];
        $signature = $config['paypalpro']['signature'];
        $version = $config['version'];
        $endpoint = $config['paypalpro']['endpoint'];

        // Set API Request Parameters
        $api_request_params = array (
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
            'CREDITCARDTYPE' => $_POST['ctype'],
            'ACCT' => $_POST['cardnum'],
            'EXPDATE' => $_POST['expmonth'].$_POST['expyear'],
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
        printVars($nvp);

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
    <div>
        <h1>PayPal Payments Pro</h1>
        <!-- User Input Form -->
        <form action="" method="post" id="user-input">
            <div class="billing-info col-md-6">
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
            <div class="payment-info col-md-6">
                <h3>Payment Information</h3>
                <div class="form-group">
                    <label for="ctype">Card Type</label>
                    <select name="ctype" class="form-control">
                        <option value="Visa" selected>Visa</option>
                        <option value="Mastercard">Mastercard</option>
                        <option value="Discover">Discover</option>
                        <option value="American Express">American Express</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cardnum">Card Number</label>
                    <input type="text" class="form-control" name="cardnum" value="4532672682018796" maxlength="16"/>
                </div>
                <div class="form-group col-md-4 no-pad-left">
                    <label for="expmonth">Exp. Month</label>
                    <input type="text" class="form-control" name="expmonth" value="08" maxlength="2"/>
                </div>
                <div class="form-group col-md-4 no-pad-left">
                    <label for="expyear">Exp. Year</label>
                    <input type="text" class="form-control" name="expyear" value="2016" maxlength="4">
                </div>
                <div class="form-group col-md-4 no-pad-left no-pad-right">
                    <label for="cvv">CVV</label>
                    <input type="text" class="form-control" name="cvv" value="324" maxlength="3"/>
                </div>
                <div class="form-group">
                    <label for="paymentaction">Payment Action</label>
                    <select name="paymentaction" class="form-control">
                        <option value="Sale" selected>Sale</option>
                        <option value="Authorization">Authorization</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cardnum">Payment Amount</label>
                    <input type="text" class="form-control" name="amount" value="50.00"/>
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="submit-button center col-md-6">
                <input type="submit" class="form-control" value="Submit" />
            </div>
        </form>
    </div>
</div>


<?php }
    include_once("../footer.php");
?>