<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


$payflow_endpoint = 'https://pilot-payflowpro.paypal.com';

$result = '';

$nvp_string = 'PARTNER=PayPal&VENDOR=cscottpayflowtest&USER=cscottpayflowtest&PWD=Godaddy247&TRXTYPE=S&TENDER=C&ACCT=4111111111111111&EXPDATE=0518&CVV2=187&AMT=88.77&FIRSTNAME=Johnny&LASTNAME=Walker&STREET=2199DewarsDr&CITY=CocoaBeach&STATE=FL&ZIP=30467&COMMENT1=Thisshouldwork&COMMENT2=Thisisonlyatest&VERBOSITY=high';


$curl = curl_init();
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_POST, 1); //data sent as POST
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_URL, $payflow_endpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

$result = curl_exec($curl);
$nvp_response_array = parse_str($result);
// curl_close($curl);

// Parse the API response

print_r($result);
echo $nvp_response_array . '<br /><br />';
echo 'This did not work!<br /><br />';
echo $nvp_string;

?>
