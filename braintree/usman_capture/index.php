<?php

require_once '../lib/Braintree.php';

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('9bdq363phkqhg8c9');
Braintree_Configuration::publicKey('n75g6jwpftxstgcf');
Braintree_Configuration::privateKey('1d98d4be75967791d6cfbb8346889eb4');

// Set Output file details
$output_file = 'bt_results.txt';

// Array of transaction IDs to be processed
$input_array = array('37g8vt', '4gvfcj', 'cjrct4', 'd3w9v8');

$output = "";

foreach($input_array as $input) {
    $result = Braintree_Transaction::submitForSettlement($input);

    // Get standard information from transaction (amount and datae)
    $amount = $result->transaction->_attributes['amount'];
    $date = $result->transaction->_attributes['createdAt']->date;

    // If capture is successful
    if($result->success == 1) {
        $output .= "
            Transaction ID: $input\n
            Date:           $date\n
            Amount:         \$$amount\n
            Status:         Successful\n
            \n\n
        ";
    }
    // If capture is unsuccessful
    else {
        $fail_reason = $result->_attributes['message'];
        $output .= "
            Transaction ID: $input\n
            Date:           $date\n
            Amount:         \$$amount\n
            Status:         Failed\n
            Reason:         $fail_reason\n
            \n\n
        ";
    }
}

// Write contents to file
file_put_contents($output_file, $output, FILE_APPEND | LOCK_EX);