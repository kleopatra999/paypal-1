<?php

$andrew = array(
    'USER' => "joseq-facilitator_api1.tailoredservers.com",
    'PWD' => "VWWWGF74NPHH7JZR",
    'SIGNATURE' => "ACL1SAT9sw5SCkY2tv.AdrnY.JFPAbO98kz3xoYU7TBOn.jHV4e51Jma",
    'METHOD' => 'SetExpressCheckout',
    'VERSION' => '86',
    'BILLINGTYPE' => 'RecurringPayments',
    'BILLINGAGREEMENTDESCRIPTION' => 'ServerSubscription',
    'cancelUrl' => 'http://www.tailormadeservers.com/cancel.php',
    'returnUrl' => 'http://www.tailormadeservers.com/complete.php'
);


$newandrew = toNVP($andrew);

echo $newandrew;

function toNVP($array) {
    $i = 0;
    $nvp = "";
    foreach($array as $key => $val) {
        if($i != 0) {
            $nvp .= "<br>";
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