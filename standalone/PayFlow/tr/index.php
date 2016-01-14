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

$pf = new payflow();

if(isset($_POST['continue'])){
		$amt = $_POST['AMT'];
		
		$billing_info = array(
								"BILLTOFIRSTNAME" => $_POST['BILLTOFIRSTNAME'],
								"BILLTOLASTNAME" => $_POST['BILLTOLASTNAME'],
								"BILLTOSTREET" => $_POST['BILLTOSTREET'],
								"BILLTOSTREET2" => $_POST['BILLTOSTREET2'],
								"BILLTOCITY" => $_POST['BILLTOCITY'],
								"BILLTOSTATE" => $_POST['BILLTOSTATE'],
								"BILLTOZIP" => $_POST['BILLTOZIP'],
								"BILLTOPHONENUM" => $_POST['BILLTOPHONENUM'],
								"EMAIL" => $_POST['EMAIL']
							);
		$shipping_info = array(
								"SHIPTOFIRSTNAME" => $_POST['SHIPTOFIRSTNAME'],
								"SHIPTOLASTNAME" => $_POST['SHIPTOLASTNAME'],
								"SHIPTOSTREET" => $_POST['SHIPTOSTREET'],
								"SHIPTOSTREET2" => $_POST['SHIPTOSTREET2'],
								"SHIPTOCITY" => $_POST['SHIPTOCITY'],
								"SHIPTOSTATE" => $_POST['SHIPTOSTATE'],
								"SHIPTOZIP" => $_POST['SHIPTOZIP']
							);
							
		$response = $pf->getSecureToken($amt, $billing_info, $shipping_info);
		$creditCardForm = $pf->getCreditCardForm($response);
		
	}//end check for post



?>

<html>
<head>
</head>
<body>
<?php if(isset($creditCardForm)){
		echo "<br />";
		echo "Enter Your Credit Card Details:";
		echo $creditCardForm;
		} ?>
		
<?php if(!isset($_POST['continue'])){
			$html = $pf->loadForm();
			echo $html;
			} ?>

<?php if(isset($response)){
echo "<pre>";
print_r($response);
echo "</pre>";
}
?>
		

</body>
</html>