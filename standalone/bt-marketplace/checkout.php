<?php

include_once('./lib/Braintree.php');

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('9bdq363phkqhg8c9');
Braintree_Configuration::publicKey('n75g6jwpftxstgcf');
Braintree_Configuration::privateKey('1d98d4be75967791d6cfbb8346889eb4');

$nonce = $_POST['payment_method_nonce'];

$result = Braintree_Transaction::sale([
    'merchantAccountId' => 'andrew1234',
    'amount' => '50.00',
    'paymentMethodNonce' => $nonce,
    'serviceFeeAmount' => "0.00",
    'options' => array(
        'submitForSettlement' => true,
        'holdInEscrow' => false,
    )
]);

$transaction = $result->transaction;
$transactionid = $transaction->id;

echo "<h3><a href='release.php?tid=$transactionid'>Release from Escrow</a></h3>";