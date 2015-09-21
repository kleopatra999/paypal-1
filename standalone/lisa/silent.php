<?php

if($_POST) {
    // Set variables from POST dataa
    $name = $_POST['BILLTONAME'];
    $address = $_POST['BILLTOSTREET'] . ", " . $_POST['BILLTOCITY'] . ", " . $_POST['BILLTOSTATE'] . " " . $_POST['BILLTOZIP'];
    $email = $_POST['EMAIL'];
    $phone = $_POST['PHONE'];
    $amount = $_POST['AMT'];
    $pnref = $_POST['PNREF'];

    // Generate output template
    $output = "Name: $name
    Address: $address
    Email: $email
    Phone: $phone
    Amount: \$$amount
    Transaction ID: $pnref\n
    -------------------------------------\n\n
    ";
}

// Send data via email
$to      = 'alangsdon@paypal.com';
$subject = 'Order Complete';
$message = $output;
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);