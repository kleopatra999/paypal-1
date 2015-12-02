<?php

include_once('./lib/Braintree.php');

Braintree_Configuration::environment('');
Braintree_Configuration::merchantId('');
Braintree_Configuration::publicKey('');
Braintree_Configuration::privateKey('');

$nonce = $_POST['payment_method_nonce'];

$result = Braintree_Transaction::sale([
    'merchantAccountId' => 'andrew1234',
    'amount' => '50.00',
    'paymentMethodNonce' => $nonce,
    'serviceFeeAmount' => "5.99",
    'options' => array(
        'submitForSettlement' => true,
        'holdInEscrow' => true,
    )
]);

$transaction = $result->transaction;
$transactionid = $transaction->id;

echo "<h3><a href='release.php?tid=$transactionid'>Release from Escrow</a></h3>";