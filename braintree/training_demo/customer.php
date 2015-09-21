<?php

require_once '../lib/Braintree.php';
require_once '../credentials.php';

$nonce = $_POST["payment_method_nonce"];
echo "None is $nonce";
exit();

// Create the customer from input fields
$result = Braintree_Customer::create(array(
    'firstName' => $_POST['fname'],
    'lastName' => $_POST['lname'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'creditCard' => array(
        'number' => $_POST['cardnum'],
        'expirationMonth' => $_POST['expmonth'],
        'expirationYear' => $_POST['expyear'],
        'cvv' => $_POST['cvv'],
        'billingAddress' => array(
            'postalCode' => $_POST['zip']
        )
    )
));

// Display customer # if successful
if($result->success) {
    echo "Customer Created:" . $result->customer->id;
    $clientToken = Braintree_ClientToken::generate(array(
        "customerId" => $result->customer->id
    ));
}

// Show errors if creating customer failed
else {
    echo("Validation errors:<br/>");
    foreach (($result->errors->deepAll()) as $error) {
        echo("- " . $error->message . "<br/>");
    }
}

$result = Braintree_PaymentMethod::create(array(
    'customerId' => $result->customer->id,
    'paymentMethodNonce' => 'nonce-from-the-client'
));

$the_token = $result->paymentMethod->_attributes['token'];

// Enroll customer in plan
$result = Braintree_Subscription::create(array(
    'paymentMethodToken' => $the_token,
    'planId' => 'demo_plan1'
));





