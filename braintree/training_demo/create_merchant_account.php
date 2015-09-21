<?php

$page_title = "Braintree Create Sub Merchant Accountr";
include_once("../../header.php");
include_once("../../sidebar.php");

require_once '../lib/Braintree.php';
require_once '../credentials.php';

$result = Braintree_MerchantAccount::create(
    array(
        'individual' => array(
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane@14ladders.com',
            'phone' => '5553334444',
            'dateOfBirth' => '1981-11-19',
            'ssn' => '456-45-4567',
            'address' => array(
                'streetAddress' => '111 Main St',
                'locality' => 'Chicago',
                'region' => 'IL',
                'postalCode' => '60622'
            )
        ),
        'business' => array(
            'legalName' => 'Jane\'s Ladders',
            'dbaName' => 'Jane\'s Ladders',
            'taxId' => '98-7654321',
            'address' => array(
                'streetAddress' => '111 Main St',
                'locality' => 'Chicago',
                'region' => 'IL',
                'postalCode' => '60622'
            )
        ),
        'funding' => array(
            'descriptor' => 'Blue Ladders',
            'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
            'accountNumber' => '1123581321',
            'routingNumber' => '071101307'
        ),
        'tosAccepted' => true,
        'masterMerchantAccountId' => "mkthsp5fmqyhyn5b",

    )
);

if($result->success) {
    echo "Account created successfully.<br>";
    echo "Status  : " . $result->merchantAccount->status . "<br>";
    echo "ID      : " . $result->merchantAccount->id . "<br>";
    echo "MasterID: " . $result->merchantAccount->masterMerchantAccount->id . "<br>";
    echo "MStatus : " . $result->merchantAccount->masterMerchantAccount->status . "<br>";
}

else {
    echo("Validation errors:<br/>");
    foreach (($result->errors->deepAll()) as $error) {
        echo("- " . $error->message . "<br/>");
    }
}