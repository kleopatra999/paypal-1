<?php

$endpoint = "https://pilot-payflowpro.paypal.com";
$securetokenid = time();
// Set API Request Parameters
$partner = 'PayPal';
$vendor = 'ajlangsdondev';
$user = 'apiUser';
$password = 'paypal1234';

$api_request_params = array (
    // API Data
    'PARTNER' => $partner,
    'VENDOR' => $vendor,
    'USER' => $user,
    'PWD' => $password,
    'TRXTYPE' => 'S',
    'AMT' => 15.00,
    'CREATESECURETOKEN' => 'Y',
    'SECURETOKENID' => $securetokenid,
    'BILLTOFIRSTNAME' => "Timmy",
    'BILLTOLASTNAME' => "Johnson",
    'BILLTOSTREET' => "123 E Mesa Dr",
    'BILLTOCITY' => "Mesa",
    'BILLTOSTATE' => "AZ",
    'BILLTOZIP' => "85256",
    'BILLTOCOUNTRY' => "USA",
    'BILLTOEMAIL' => "Timmy@kljsadf.com",
    'BILLTOPHONENUM' => "9197487411",
    'SHIPTOSTREET' => '123 W Chase Way',
    'SHIPTOCITY' => 'Mesa',
    'SHIPTOSTATE' => 'AZ',
    'SHIPTOZIP' => '85257',
    'VERBOSITY' => 'high'
);

/// Convert API Params to NVP String
$nvp = toNVP($api_request_params);

// Run cURL on endpoint & NVP string
$result = runCurl($endpoint, $nvp);

// Parse API response to NVP
$result_array = nvpConvert($result);

printVars($result_array);

$securetoken = $result_array['SECURETOKEN'];

//echo "SecureTokenID: $securetokenid<br>";
//echo "SecureToken  : $securetoken<br><br>";

?>

<iframe src="https://payflowlink.paypal.com?MODE=TEST&SECURETOKENID=<?php echo $securetokenid; ?>&SECURETOKEN=<?php echo $securetoken; ?>" name="test_iframe" scrolling="no" width="570px" height="1000px"></iframe>

<?php
// Helper functions

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

function nvpConvert($myString) {
    $ppResponse = array();
    parse_str($myString, $ppResponse);
    return $ppResponse;
}

// Print Array in Preformat
function printVars($array) {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

?>


<form action="iframe.php" method="post">
    <h3>Sales Information</h3>
    <div class="form-item">
        Please select your service:
        <select name="service">
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
    </div>
    <div class="form-item">
        Type of service:
        <select name="service_type">
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
    </div>
    <div class="form-item">
        Name of Sales Rep
        <select name="sales_rep">
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
    </div>

    <h3>Billing Information</h3>
    <div class="form-item">
        First Name: <input type="text" name="first_name" value="John"/>
    </div>
    <div class="form-item">
        Last Name: <input type="text" name="last_name" value="Doe"/>
    </div>
    <div class="form-item">
        Address: <input type="text" name="street" value="123 Doe Street"/>
    </div>
    <div class="form-item">
        City: <input type="text" name="city" value="Doeville"/>
    </div>
    <div class="form-item">
        State: <input type="text" name="state" value="Iowa"/>
    </div>
    <div class="form-item">
        Country: <input type="text" name="country" value="USA"/>
    </div>
    <div class="form-item">
        Zip: <input type="text" name="zip" value="54741"/>
    </div>
    <div class="form-item">
        Email: <input type="text" name="email" value="johndoe@doefarms.com"/>
    </div>
    <div class="form-item">
        Phone: <input type="text" name="phone" value="457-874-5544"/>
    </div>
    <div class="form-item">
        Mobile: <input type="text" name="mobile" value="458-874-4411"/>
    </div>

    <h3>Payment</h3>
    <div class="form-item">
        Amount to Pay: <input type="text" name="amount" value="10.00"/>
    </div>
    </br>
    <div class="form-item submit">
        <input type="submit" value="submit" />
    </div>
</form>