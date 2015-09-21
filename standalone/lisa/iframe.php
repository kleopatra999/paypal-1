<?php

$endpoint = "https://pilot-payflowpro.paypal.com";
$securetokenid = time();
// Set API Request Parameters
$partner = 'PayPal';
$vendor = 'alangsdonpaypal';
$user = 'alpayflow';
$password = 'paypal1234';

$api_request_params = array (
    // API Data
    'PARTNER' => $partner,
    'VENDOR' => $vendor,
    'USER' => $user,
    'PWD' => $password,
    'TRXTYPE' => 'S',
    'AMT' => $_POST['amount'],
    'CREATESECURETOKEN' => 'Y',
    'SECURETOKENID' => $securetokenid,

    'BILLTOFIRSTNAME' => $_POST['first_name'],
    'BILLTOLASTNAME' => $_POST['last_name'],
    'BILLTOSTREET' => $_POST['street'],
    'BILLTOCITY' => $_POST['city'],
    'BILLTOSTATE' => $_POST['state'],
    'BILLTOZIP' => $_POST['zip'],
    'BILLTOCOUNTRY' => $_POST['country'],
    'BILLTOEMAIL' => $_POST['email'],
    'BILLTOPHONENUM' => $_POST['phone'],

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