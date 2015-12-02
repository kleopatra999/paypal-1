<?php
require_once '../lib/Braintree.php';
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('9bdq363phkqhg8c9');
Braintree_Configuration::publicKey('n75g6jwpftxstgcf');
Braintree_Configuration::privateKey('1d98d4be75967791d6cfbb8346889eb4');

$clientToken = Braintree_ClientToken::generate();
echo "Client Token: " . $clientToken;

$customer = Braintree_Customer::find('25069804');
echo "<br>";
echo "<pre>";
print_r($customer);
?>
