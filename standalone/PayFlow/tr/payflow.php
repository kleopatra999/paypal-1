<?php
/*****************************************************************************
 ****** DISCLAIMER ***********************************************************
 * This code is provided as-is and should only be used as an example this is *
 * NOT considered SECURE, do NOT use this code in a production environment   *
 * Do NOT use this code with LIVE credentials, this is one example of how to *
 * do this, this is not the only way to do this or the best way to do this,  *
 * nor is it recommended to do it this way, this is just an example..........*
 *****************************************************************************/
 
/*payflow class
 *
 *Implements all Payflow Actions
 *
 */

class payflow{

private $user = "SabaAPI"; //your user karthiktestpf
private $vendor = "8872147Finance"; //your vendor karthikpf
private $partner = "PayPalCA"; //your partner PayPal
private $pwd = "8872147Password"; //your password PayPal1234
private $endpoint = "https://pilot-payflowpro.paypal.com"; //remove "pilot-" for live server
private $mode = "TEST"; //value can be "TEST" or "LIVE"
private $post_url = "https://pilot-payflowlink.paypal.com";
private $base_url = "http://paypal.local/standalone/payflow/tr/"; //must end in a "/"

/*constructor for payflow
 *
 *Set's the static variables for Payflow API calls
 *
 */
public function __construct(){
						
}//end constructor



/*getSecureToken(string, array, array)
 *
 *Gets the amount, and the billing info and shipping info to build the request.
 *
 *@return array $response;
 */
public function getSecureToken($amt, $billing_info, $shipping_info){
	$credStr = $this->getCredStr();
	$constStr = $this->getConstStr();
	$billingStr = $this->getString($billing_info);
	$shippingStr = $this->getString($shipping_info);
	
	$reqStr = $credStr . $billingStr . $shippingStr . "&AMT=" . $amt . $constStr;

	$response = $this->PPHttpPost($this->endpoint, $reqStr);
	
	return $response;
	
}//end getSecureToken

/*getConstStr().
 *
 *Builds the constant String based on the variables set in the constructor above.
 *
 *@return string $string;
 */
public function getConstStr(){

						$returnURL = $this->base_url . "return.php"; //your return url
						$cancelURL = $this->base_url . "return.php"; //your cancel url
						$errorURL = $this->base_url . "return.php"; //your error url
						$silentTran = "TRUE"; //should be True with this script; it is required for Transparent Redirect
						$trxtype = "S"; //"A" = Auth, "S" = Sale
						$currency = "USD"; //Currency Code "USD", "CAD", etc.
						$verbosity = "HIGH"; //should be "HIGH" with this script
						$createsecuretoken = "Y"; //SecureToken must be used with Transparent Redirect
						$tender = "C"; //Tender should equal C with Transparent Redirect
						
		$secureTokenID = md5(time());
		$string = "&RETURNURL=" . $returnURL . "&CANCELURL=" . $cancelURL . "&ERRORURL=" . $errorURL
		          . "&TRXTYPE=" . $trxtype . "&SILENTTRAN=" . $silentTran . "&CURRENCY=" . $currency
				  . "&VERBOSITY=" . $verbosity . "&CREATESECURETOKEN=" . $createsecuretoken . "&TENDER=" . $tender . "&COMMENT1=Testing&USER1=Karthik&SECURETOKENID="
				  . $secureTokenID;
		return $string;
		}//end getConstStr

/*getCredStr()
 *
 *Builds the Credential String based on the variables set in the constructor above.
 *
 *@return string $string
 */
public function getCredStr(){
		$string = "USER=" . $this->user . "&VENDOR=" . $this->vendor . "&PARTNER=" . $this->partner . "&PWD=" . $this->pwd;
		return $string;
		}//end setCredStr()

/*getString(array)
 *
 *Takes in an array and turns it into a string:
 *    array(
 * 		['NAME'] => "Value",
 *		['NAME2'] => "Value2"
 *      );
 *
 *The above array turns into:
 * 
 * NAME=Value&NAME2=Value2
 *
 *@return string $string
 */
public function getString($array){
	$string = "";
		if(is_array($array)){
				foreach($array as $k => $v){
					$string .= "&" . $k . "=" . $v;
					}
		}
		else { $string = ""; }
	return $string;
	}//end getString

	
/*loadForm()
 *
 *This just returns the HTML for the form on the index.php page
 *Main purpose is to keep index.php clean for this demo.
 *
 *@return string $html;
 */
public function loadForm(){
$html = "<form action='' method='post'>
<h4>Amount of Transaction</h4>
<label for='AMT'>Amount: </label><input type='text' name='AMT' value='10.00' />
<br /><h4>Billing Information</h4>
<table border='0'>
<tr><td><label for='BILLTOFIRSTNAME'>First Name:</label></td><td><input type='text' name='BILLTOFIRSTNAME' value='Frank' /></td></tr>
<tr><td><label for='BILLTOLASTNAME'>Last Name:</label></td><td><input type='text' name='BILLTOLASTNAME' value='Enstien' /></td></tr>
<tr><td><label for='BILLTOSTREET'>Street Address 1:</label></td><td><input type='text' name='BILLTOSTREET' value='111 Main St' /></td></tr>
<tr><td><label for='BILLTOSTREET2'>Street Address 2:</label></td><td><input type='text' name='BILLTOSTREET2' value='Apt. 4' /></td></tr>
<tr><td><label for='BILLTOCITY'>City:</label></td><td><input type='text' name='BILLTOCITY' value='Omaha' /></td></tr>
<tr><td><label for='BILLTOSTATE'>State:</label></td><td><input type='text' name='BILLTOSTATE' value='NE' /></td></tr>
<tr><td><label for='BILLTOZIP'>Zip Code:</label></td><td><input type='text' name='BILLTOZIP' value='68112' /></td></tr>
<tr><td><label for='BILLTOPHONENUM'>Phone Number:</label></td><td><input type='text' name='BILLTOPHONENUM' value='8882211161' /></td></tr>
<tr><td><label for='EMAIL'>Email Address:</label></td><td><input type='text' name='EMAIL' value='myemail@mydomain.com' /></td></tr>
</table>
<br />

<h4>Shipping Information</h4>
<table border='0'>
<tr><td><label for='SHIPTOFIRSTNAME'>First Name:</label></td><td><input type='text' name='SHIPTOFIRSTNAME' value='Frank' /></td></tr>
<tr><td><label for='SHIPTOLASTNAME'>Last Name:</label></td><td><input type='text' name='SHIPTOLASTNAME' value='Enstien' /></td></tr>
<tr><td><label for='SHIPTOSTREET'>Street Address 1:</label></td><td><input type='text' name='SHIPTOSTREET' value='111 Main St' /></td></tr>
<tr><td><label for='SHIPTOSTREET2'>Street Address 2:</label></td><td><input type='text' name='SHIPTOSTREET2' value='Apt. 4' /></td></tr>
<tr><td><label for='SHIPTOCITY'>City:</label></td><td><input type='text' name='SHIPTOCITY' value='Omaha' /></td></tr>
<tr><td><label for='SHIPTOSTATE'>State:</label></td><td><input type='text' name='SHIPTOSTATE' value='NE' /></td></tr>
<tr><td><label for='SHIPTOZIP'>Zip Code:</label></td><td><input type='text' name='SHIPTOZIP' value='68112' /></td></tr>
</table>
<br />
<input type='submit' name='continue' value='Continue to Checkout' />
</form>";

return $html;
}

/*getCreditCardForm(array)
 *
 *Takes in an array (API Response) and uses it to generate a simple Payment form
 *
 *@return string $html;
 */
public function getCreditCardForm($response){
$parsed_resp = $this->parseResponse($response);
$secure_token = $this->getMySecureToken($response);

$html = "<form action='" . $this->post_url . "' method='POST'>
<table><tr><td>
<label for='MODE'>MODE</label><input type='text' name='MODE' value='" . $this->mode . "' /></td></tr><tr><td>
<label for='SECURETOKEN'>SecureToken</label><input type='text' name='SECURETOKEN' value='" . $parsed_resp['SECURETOKEN'] . "' /></td></tr><tr><td>
<label for='SECURETOKENID'>SecureTokenID</label><input type='text' name='SECURETOKENID' value='" . $parsed_resp['SECURETOKENID'] . "' /></td></tr><tr><td>
<label for='CARDNUM'>CC Num</label><input type='text' name='CARDNUM' value='4916743556150860' /></td></tr><tr><td>
<label for='EXPMONTH'>EXP Month</label><input type='text' name='EXPMONTH' value='12' /></td></tr><tr><td>
<label for='EXPYEAR'>EXP Year</label><input type='text' name='EXPYEAR' value='16' /></td></tr><tr><td>
<label for='CVV2'>CSC/CVV2</label><input type='text' name='CVV2' value='123' /></td></tr></table>
<input type='submit' value='Make the transaction' />
</form>";

return $html;

}//end getCreditCardForm()

/*PPHttpPost(string, string)  
 *  
 *PPHttpPost takes in two strings, and   
 *makes a curl request and returns the result.  
 *  
 *@return array $httpResponseAr  
 */ public function PPHttpPost($endpoint, $nvpstr){ 
 // setting the curl parameters. 
 $ch = curl_init(); 
 curl_setopt($ch, CURLOPT_URL, $endpoint); 
 curl_setopt($ch, CURLOPT_VERBOSE, 1); 
 // turning off the server and peer verification(TrustManager Concept). 
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
 curl_setopt($ch, CURLOPT_POST, 1); 
 // setting the NVP $my_api_str as POST FIELD to curl 
 curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpstr); 
 // getting response from server 
 $httpResponse = curl_exec($ch); 
 if(!$httpResponse) {   
		$response = "API failed: ".curl_error($ch).'('.curl_errno($ch).')';   
		return $response; 
		} 
	$httpResponseAr = explode("&", $httpResponse); 
	return $httpResponseAr;
	}//end PPHttpPost function

 /*getMySecureToken(array)  
  *  
  *This takes in the response array from the   
  *PPHttpPost call, and parses out the SecureToken  
  *  
  *This is used because the securetoken may contain  
  *an "=" sign  
  *  
  *@return string $secure_token  
  */ 
 public function getMySecureToken($response){  
	$secure_token = $response[1];  
	$secure_token = substr($secure_token, -25);  
	return $secure_token; 
}//end getMySecureToken()

 /*parseResponse(array)  
  *  
  *This function parses out the response without taking  
  *into account that the securetoken may contain an "="  
  *sign. The only thing you need from this is the   
  *SecureTokenID.  
  *  
  *@return array $parsed_response  
  */ 
  public function parseResponse($response){ 
		$parsed_response = array(); 
			foreach ($response as $i => $value)  {  
				$tmpAr = explode("=", $value);  
					if(sizeof($tmpAr) > 1) {   
					$parsed_response[$tmpAr[0]] = $tmpAr[1];  
					} 
				} 
				return $parsed_response; 
	}//end parseResponse
	
	
 /*createRecurringBillingProfile 
  *  
  *This function works from the return.php page to create a recurring Billing Profile
  *  
  *@return array $response
  */ 
 public function createRecurringBillingProfile($arrayData){
		$reqStr = $this->getRecurringString($arrayData);
		
		$response = $this->PPHttpPost($this->endpoint, $reqStr);
		
		return $response;
		
	}//end createRecurringBillingProfile
 	
 /*getRecurringString(array)
  *  
  *This function works from the return.php page to create a recurring Billing Profile API Request String.
  *  
  *@return array $data
  */
  public function getRecurringString($arrayData){
  if(isset($arrayData['BAID'])){ $myTender = "P"; } else{ $myTender = "C"; }
  
  $uniqueNum = substr(md5(time()), -6);
  
  $credString = $this->getCredStr();
  
  $startDate = $this->tomorrow();
  
	$data = array(
			"TRXTYPE" => "R", //for "RECURRING"
			"ACTION" => "A", //for "ADD"
			"TENDER" => $myTender, //Tender "P" for PayPal, "C" for Credit Card
			"ORIGID" => $arrayData['PNREF'],
			"PROFILENAME" => $arrayData['BILLTOLASTNAME'] . $uniqueNum,
			"AMT" => "10.00", //amount to recur
			"START" => $startDate,
			"TERM" => "0", //0 = never ending
			"PAYPERIOD" => "WEEK", //weekly
			"MAXFAILPAYMENTS" => "5",
			"RETRYNUMDAYS" => "1",
			"BILLTOFIRSTNAME" => $arrayData['BILLTOFIRSTNAME'],
			"BILLTOLASTNAME" => $arrayData['BILLTOLASTNAME'],
			"BILLTOSTREET" => $arrayData['BILLTOSTREET'],
			"BILLTOSTREET2" => $arrayData['BILLTOSTREET2'],
			"BILLTOCITY" => $arrayData['BILLTOCITY'],
			"BILLTOSTATE" => $arrayData['BILLTOSTATE'],
			"BILLTOZIP" => $arrayData['BILLTOZIP']
			);
	$dataString = $this->getString($data);
	
	$myString = $credString . $dataString;
	
	return $myString;
		
	}//end getRecurringString
	
	/*tomorrow()
	 * 
	 * Returns a Start Date of Tomorrow (MMDDYYYY)
	 *
	 */
	public function tomorrow(){
		date_default_timezone_set("America/Phoenix");
	$day = date("d");
	$month = date("m");
	$year = date("Y");
	
	$day = $day + 1;
	
	$tomorrow = $month . $day . $year;
	
	return $tomorrow;
	}
	
}//end class