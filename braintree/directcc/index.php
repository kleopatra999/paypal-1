<?php

require_once '../lib/Braintree.php';

/*Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('9bdq363phkqhg8c9');
Braintree_Configuration::publicKey('n75g6jwpftxstgcf');
Braintree_Configuration::privateKey('1d98d4be75967791d6cfbb8346889eb4');*/

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('9bdq363phkqhg8c9');
Braintree_Configuration::publicKey('j2zws2n7khd3stpv');
Braintree_Configuration::privateKey('604ede8e5fa2e00a89588bc87c90fe28');

$token = Braintree_ClientToken::generate();
$result = Braintree_Transaction::sale(array(
    'amount' => '10.00',
    'creditCard' => array(
        'number' => '4111111111111111',
        'expirationMonth' => '05',
        'expirationYear' => '12'
    )
));

echo "<pre>";
print_r($result);
echo "</pre>";

if ($result->success) {
    print_r("success!: " . $result->transaction->id);
} else if ($result->transaction) {
    print_r("Error processing transaction:");
    print_r("\n  message: " . $result->message);
    print_r("\n  code: " . $result->transaction->processorResponseCode);
    print_r("\n  text: " . $result->transaction->processorResponseText);
} else {
    print_r("Message: " . $result->message);
    print_r("\nValidation errors: \n");
}