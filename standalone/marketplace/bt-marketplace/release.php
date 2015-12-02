<?php

include_once('./lib/Braintree.php');

Braintree_Configuration::environment('');
Braintree_Configuration::merchantId('');
Braintree_Configuration::publicKey('');
Braintree_Configuration::privateKey('');

$transactionid = $_GET['tid'];

$result = Braintree_Transaction::releaseFromEscrow($transactionid);

echo "<pre>";
print_r($result);