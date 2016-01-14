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
    'VERBOSITY' => 'high',
    'SILENTTRAN' => 'TRUE'
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

<!--<iframe src="https://payflowlink.paypal.com?MODE=TEST&SECURETOKENID=<?php echo $securetokenid; ?>&SECURETOKEN=<?php echo $securetoken; ?>" name="test_iframe" scrolling="no" width="570px" height="1000px"></iframe>-->

<a href="https://payflowlink.paypal.com?MODE=TEST&SECURETOKENID=<?php echo $securetokenid; ?>&SECURETOKEN=<?php echo $securetoken; ?>">Load Page</a>

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
