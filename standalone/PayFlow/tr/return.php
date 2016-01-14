<?php
/*****************************************************************************
 ****** DISCLAIMER ***********************************************************
 * This code is provided as-is and should only be used as an example this is *
 * NOT considered SECURE, do NOT use this code in a production environment   *
 * Do NOT use this code with LIVE credentials, this is one example of how to *
 * do this, this is not the only way to do this or the best way to do this,  *
 * nor is it recommended to do it this way, this is just an example..........*
 *****************************************************************************/
require('payflow.php');

$pf_return = new payflow();

 
echo "Raw POST/GET Data:";
if(isset($_GET['PNREF'])){
echo "<h2>Get Data</h2><pre>";
print_r($_GET);
echo "</pre>";

if($_GET['RESULT'] == "0"){

echo "<h2>Recurring Billing Request:</h2>";
$string = $pf_return->getRecurringString($_GET);
echo "<pre>";
echo $string;
echo "</pre>";


$response = $pf_return->createRecurringBillingProfile($_GET);
echo "<h2>Recurring Billing Response:</h2>";
echo "<pre>";
print_r($response);
echo "</pre>";
}

}
if(isset($_POST['PNREF'])){
echo "<h2>Post Data</h2><pre>";
print_r($_POST);
echo "</pre>";

if($_POST['RESULT'] == "0"){
echo "<h2>Recurring Billing Request:</h2>";
$string = $pf_return->getRecurringString($_POST);
echo "<pre>";
echo $string;
echo "</pre>";

$response = $pf_return->createRecurringBillingProfile($_POST);
echo "<h2>Recurring Billing Response:</h2>";
echo "<pre>";
print_r($response);
echo "</pre>";
}

}



?>
